<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Kegiatan;
use App\Models\JenisKeg;
use App\Models\Instansi;
use App\Models\TitikLokasi;
use App\Models\Karyawan;
use App\Models\LaporanKegiatan;
use App\Models\User;
use Carbon\Carbon;

class AppController extends Controller
{
    /**
     * Fungsi Helper untuk memperbarui status kegiatan yang telah lewat menjadi 'Selesai'
     */
    private function autoUpdateStatusSelesai()
    {
        $today = Carbon::today()->toDateString();

        Kegiatan::whereNotIn('status', ['Selesai', 'Dibatalkan'])
            ->where(function ($query) use ($today) {
                $query->whereRaw("IFNULL(tanggal_selesai, tanggal_mulai) < ?", [$today]);
            })
            ->update(['status' => 'Selesai']);
    }

    // 1. Dashboard Utama
    public function dashboard()
    {
        $this->autoUpdateStatusSelesai();
        
        $today = Carbon::today()->toDateString();
        $user = Auth::user();

        $notifTugas = collect();

        if ($user) {
            $username = strtolower(trim($user->username ?? ''));
            
            $notifTugas = Kegiatan::with(['jenis', 'lokasi', 'instansi', 'koordinator'])
                ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
                ->whereDate('tanggal_mulai', '<=', $today)
                ->whereRaw("IFNULL(tanggal_selesai, tanggal_mulai) >= ?", [$today])
                ->get()
                ->filter(function($keg) use ($user, $username) {
                    if (!empty($user->id_karyawan) && $keg->id_karyawan_koor == $user->id_karyawan) {
                        return true;
                    }

                    $namaKoor = strtolower($keg->koordinator->nama_karyawan ?? '');
                    if (!empty($username) && !empty($namaKoor)) {
                        return str_contains($namaKoor, $username) || str_contains($username, $namaKoor);
                    }

                    return false;
                })->values();
        }

        $kegiatan = Kegiatan::with(['jenis', 'lokasi', 'instansi', 'koordinator'])
            ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
            ->whereRaw("IFNULL(tanggal_selesai, tanggal_mulai) >= ?", [$today])
            ->orderByRaw("
                CASE 
                    WHEN ? BETWEEN tanggal_mulai AND IFNULL(tanggal_selesai, tanggal_mulai) THEN 0
                    ELSE 1
                END ASC
            ", [$today])
            ->orderBy('tanggal_mulai', 'asc')
            ->take(7)
            ->get();

        $jadwalTerdekat = Kegiatan::with(['jenis', 'lokasi', 'koordinator'])
            ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
            ->where('tanggal_mulai', '>', $today)
            ->orderBy('tanggal_mulai', 'asc')
            ->take(3)
            ->get();

        if ($jadwalTerdekat->isEmpty()) {
            $jadwalTerdekat = Kegiatan::with(['jenis', 'lokasi', 'koordinator'])
                ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
                ->whereRaw("IFNULL(tanggal_selesai, tanggal_mulai) >= ?", [$today])
                ->orderBy('tanggal_mulai', 'asc')
                ->take(3)
                ->get();
        }

        $stats = [
            'instansi' => Instansi::count(),
            'peserta'  => Kegiatan::sum('jmlh_peserta'),
            'kegiatan' => Kegiatan::count(),
        ];

        return view('dashboard', compact('kegiatan', 'jadwalTerdekat', 'stats', 'notifTugas'));
    }

    // 2. Halaman Daftar / Perencanaan Kegiatan (DENGAN RESTRIKSI PEGAWAI)
    public function kegiatan(Request $request)
    {
        $user = Auth::user();
        $query = Kegiatan::with(['jenis', 'koordinator', 'lokasi', 'instansi']);

        // RESTRIKSI PEGAWAI: Hanya tampilkan kegiatan yang diampu olehnya
        if ($user && $user->role === 'pegawai') {
            $query->where('id_karyawan_koor', $user->id_karyawan);
        }

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where('nama_keg', 'LIKE', '%' . $search . '%');
        }

        $sort = $request->input('sort', 'terbaru');
        switch ($sort) {
            case 'az':
                $query->orderBy('nama_keg', 'asc');
                break;
            case 'terlama':
                $query->orderBy('tanggal_mulai', 'asc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('tanggal_mulai', 'desc');
                break;
        }

        $kegiatan = $query->paginate(5);
        $kegiatan->appends($request->all());

        $jenisList = \App\Models\JenisKeg::all();
        $karyawanList = \App\Models\Karyawan::all();
        $lokasiList = \App\Models\TitikLokasi::all();
        $instansiList = \App\Models\Instansi::all();

        return view('kegiatan', compact(
            'kegiatan', 
            'sort', 
            'jenisList', 
            'karyawanList', 
            'lokasiList', 
            'instansiList'
        ));
    }

    // Simpan Kegiatan Baru (Khusus Admin)
    public function storeKegiatan(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'pegawai') {
            return redirect()->back()->with('error', 'Akses ditolak! Pegawai tidak diizinkan menambahkan kegiatan baru.');
        }

        $validated = $request->validate([
            'nama_keg'         => 'required|string|max:150',
            'id_jeniskeg'      => 'required|integer',
            'id_tklokasi'      => 'required|integer',
            'id_instansi'      => 'required|integer',
            'id_karyawan_koor' => 'required|integer',
            'jmlh_peserta'     => 'required|numeric|min:1',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'nullable|date|after_or_equal:tanggal_mulai',
            'status'           => 'required|string',
            'lampiran'         => 'nullable|string|max:255',
        ]);

        if (empty($validated['tanggal_selesai'])) {
            $validated['tanggal_selesai'] = $validated['tanggal_mulai'];
        }

        Kegiatan::create($validated);

        return redirect()->back()->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    // Update / Edit Data Kegiatan (Admin & Koordinator Terpilih)
    public function updateKegiatan(Request $request, $id)
    {
        $user = Auth::user();
        $kegiatan = Kegiatan::findOrFail($id);

        // RESTRIKSI OTORISASI: Pegawai hanya boleh update kegiatan yang diampunya
        if ($user->role === 'pegawai' && $kegiatan->id_karyawan_koor != $user->id_karyawan) {
            return redirect()->back()->with('error', 'Akses ditolak! Anda bukan koordinator terpilih untuk kegiatan ini.');
        }

        $validated = $request->validate([
            'nama_keg'         => 'required|string|max:150',
            'id_jeniskeg'      => 'required|integer',
            'id_tklokasi'      => 'required|integer',
            'id_instansi'      => 'required|integer',
            'id_karyawan_koor' => 'required|integer',
            'jmlh_peserta'     => 'required|numeric|min:1',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'nullable|date|after_or_equal:tanggal_mulai',
            'status'           => 'required|string',
            'lampiran'         => 'nullable|string|max:255',
        ]);

        if (empty($validated['tanggal_selesai'])) {
            $validated['tanggal_selesai'] = $validated['tanggal_mulai'];
        }

        $kegiatan->update($validated);

        return redirect()->back()->with('success', 'Data kegiatan berhasil diperbarui!');
    }

    // Hapus Kegiatan dari Database (Khusus Admin)
    public function destroyKegiatan($id)
    {
        $user = Auth::user();

        if ($user->role === 'pegawai') {
            return redirect()->back()->with('error', 'Akses ditolak! Pegawai tidak diizinkan menghapus data kegiatan.');
        }

        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();

        return redirect()->back()->with('success', 'Kegiatan berhasil dihapus!');
    }

    // 3. Kalender
    public function kalender() {
        $kegiatan = Kegiatan::with(['lokasi', 'jenis', 'koordinator'])->get();
        return view('kalender', compact('kegiatan'));
    }

    // 4. Titik Lokasi
    public function titikLokasi(Request $request)
    {
        $today = Carbon::today()->toDateString();

        $kegiatanBerjalan = Kegiatan::with(['lokasi', 'instansi'])
            ->where('status', 'Terkonfirmasi')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->where(function ($q) use ($today) {
                $q->whereDate('tanggal_selesai', '>=', $today)
                  ->orWhereNull('tanggal_selesai');
            })
            ->first();

        if (!$kegiatanBerjalan) {
            $kegiatanBerjalan = Kegiatan::with(['lokasi', 'instansi'])
                ->where('status', 'Terkonfirmasi')
                ->orderBy('tanggal_mulai', 'asc')
                ->first();
        }

        $lokasi = TitikLokasi::all();

        return view('titik-lokasi', compact('kegiatanBerjalan', 'lokasi'));
    }

    // 5. Instansi
    public function instansi()
    {
        $instansi = Instansi::all();
        return view('instansi', compact('instansi'));
    }

    // 6. Jenis Kegiatan
    public function jenisKegiatan()
    {
        $jenis = JenisKeg::all();
        return view('jenis-kegiatan', compact('jenis'));
    }

    // 7. Riwayat Kerja Karyawan
    public function riwayatKerja()
    {
        $semuaKegiatan = Kegiatan::with(['lokasi', 'jenis', 'koordinator'])->get();
        $karyawan = Karyawan::all();

        $karyawan->each(function ($kar) use ($semuaKegiatan) {
            $kar->daftar_kegiatan = $semuaKegiatan->filter(function ($keg) use ($kar) {
                return $keg->id_karyawan_koor == $kar->id_karyawan 
                    || ($keg->koordinator && $keg->koordinator->id_karyawan == $kar->id_karyawan);
            })->values();
        });

        return view('riwayat-kerja', compact('karyawan'));
    }

    // 8. Riwayat Kegiatan
    public function riwayatKegiatan(Request $request)
    {
        $query = Kegiatan::with(['lokasi', 'koordinator', 'jenis']);

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where('nama_keg', 'LIKE', '%' . $search . '%');
        }

        $sort = $request->input('sort', 'terbaru');
        
        switch ($sort) {
            case 'az':
                $query->orderBy('nama_keg', 'asc');
                break;
            case 'terlama':
                $query->orderBy('tanggal_mulai', 'asc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('tanggal_mulai', 'desc');
                break;
        }

        $kegiatan = $query->paginate(5);
        $kegiatan->appends($request->all());

        return view('riwayat-kegiatan', compact('kegiatan', 'sort'));
    }

    // 9. Autentikasi Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required'    => 'NIP atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $fieldType = is_numeric($request->login) ? 'nip' : 'username';

        if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'login' => 'NIP/Username atau Password yang Anda masukkan salah.',
        ])->onlyInput('login');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Alamat email tidak terdaftar dalam sistem kepegawaian.',
        ]);

        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        session([
            'reset_email' => $request->email,
            'reset_otp'   => $otpCode
        ]);

        return redirect()->route('password.verify.form')->with('success', 'Kode konfirmasi OTP telah dikirimkan ke email Anda.');
    }

    public function showVerifyOtpForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.verify-otp');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'otp'                   => 'required',
            'password'              => 'required|min:6|confirmed',
        ], [
            'password.confirmed'    => 'Konfirmasi password baru tidak cocok.',
            'password.min'          => 'Password minimal 6 karakter.'
        ]);

        if ($request->otp != session('reset_otp')) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
        }

        $user = User::where('email', session('reset_email'))->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            session()->forget(['reset_email', 'reset_otp']);

            return redirect()->route('login')->with('success', 'Password berhasil diperbarui! Silakan login kembali.');
        }

        return back()->withErrors(['email' => 'Terjadi kesalahan sistem.']);
    }

    // 10. Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function landing()
    {
        // Ambil data kegiatan aktif/terjadwal beserta relasi jenis dan lokasi
        $kegiatan = Kegiatan::with(['jenis', 'lokasi', 'koordinator'])
            ->whereNotIn('status', ['Dibatalkan'])
            ->get();

        return view('landing', compact('kegiatan'));
    }
    public function masterUser(Request $request)
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('master-user', compact('users'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->withErrors(['admin' => 'Data pengguna dengan Role Admin dilindungi dan tidak dapat diubah.']);
        }

        $request->validate([
            'username' => 'required|string|max:50|unique:users,username,'.$id.',id_user',
            'nip'      => 'nullable|string|max:18|unique:users,nip,'.$id.',id_user',
            'email'    => 'required|email|max:150|unique:users,email,'.$id.',id_user',
            'role'     => 'required|in:pegawai,pimpinan',
        ]);

        $user->username = $request->username;
        $user->nip      = $request->nip;
        $user->email    = $request->email;
        $user->role     = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Data user '.$user->username.' berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jika user terhubung dengan data karyawan
        if ($user->id_karyawan) {
            $idKaryawan = $user->id_karyawan;

            // 1. Hapus seluruh rekam kerja karyawan tersebut
            \App\Models\RekamKj::where('id_karyawan', $idKaryawan)->delete();

            // 2. Hapus data user terlebih dahulu
            $user->delete();

            // 3. Hapus data profil karyawan
            \App\Models\Karyawan::where('id_karyawan', $idKaryawan)->delete();
        } else {
            $user->delete();
        }

        return redirect()->back()->with('success', 'User beserta seluruh riwayat rekam kerjanya berhasil dihapus.');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'nip'      => 'nullable|string|max:18|unique:users,nip',
            'email'    => 'required|email|max:150|unique:users,email',
            'role'     => 'required|in:pegawai,pimpinan', 
            'password' => 'required|min:6',
        ], [
            'username.unique' => 'Username sudah digunakan oleh akun lain.',
            'nip.unique'      => 'NIP sudah terdaftar dalam sistem.',
            'email.unique'    => 'Email sudah digunakan.',
            'role.in'         => 'Penambahan akun dengan Role Admin tidak diizinkan.',
            'password.min'    => 'Password minimal terdiri dari 6 karakter.',
        ]);

        User::create([
            'username' => $request->username,
            'nip'      => $request->nip,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'User baru berhasil ditambahkan.');
    }

    public function index(Request $request)
    {
        $query = Kegiatan::with(['lokasi', 'koordinator', 'jenis']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nama_keg', 'LIKE', '%' . $search . '%');
        }

        $sort = $request->input('sort', 'terbaru');
        if ($sort === 'az') {
            $query->orderBy('nama_keg', 'asc');
        } elseif ($sort === 'terlama') {
            $query->orderBy('tanggal_mulai', 'asc');
        } else {
            $query->orderBy('tanggal_mulai', 'desc');
        }

        $kegiatan = $query->paginate(5);

        return view('riwayat-kegiatan', compact('kegiatan', 'sort'));
    }

    public function exportCsv(Request $request)
    {
        $loggedUser = Auth::user();
        $fileName = 'Laporan_Kegiatan_BKN_' . date('Y-m-d_H-i') . '.csv';

        return response()->streamDownload(function () use ($request, $loggedUser) {
            $file = fopen('php://output', 'w');

            // Menambahkan UTF-8 BOM agar tulisan rapi saat dibuka di Microsoft Excel
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header Kolom CSV
            fputcsv($file, [
                'No Laporan',
                'Nama Kegiatan',
                'Jenis Kegiatan',
                'Koordinator',
                'Lokasi',
                'Instansi',
                'Peserta Hadir',
                'Peserta Absen',
                'Nilai Tertinggi',
                'Nilai Terendah',
                'Catatan Evaluasi',
                'Tanggal Pelaporan',
            ]);

            // Query Dasar Laporan
            $query = LaporanKegiatan::query();

            // 1. FILTER KHUSUS ROLE PEGAWAI: Hanya ambil data yang diampu pegawai login
            if ($loggedUser && $loggedUser->role === 'pegawai' && $loggedUser->id_karyawan) {
                $query->whereHas('kegiatan', function ($q) use ($loggedUser) {
                    $q->where('id_karyawan_koor', $loggedUser->id_karyawan);
                });
            }

            // 2. Filter dari Form UI (Jenis Kegiatan, Search, Range Tanggal)
            if ($request->filled('id_jeniskeg')) {
                $query->whereHas('kegiatan', function ($q) use ($request) {
                    $q->where('id_jeniskeg', $request->id_jeniskeg);
                });
            }

            if ($request->filled('search')) {
                $query->whereHas('kegiatan', function ($q) use ($request) {
                    $q->where('nama_keg', 'like', '%' . $request->search . '%');
                });
            }

            if ($request->filled('range')) {
                if ($request->range === '7_days') {
                    $query->whereHas('kegiatan', fn($q) => $q->where('tanggal_mulai', '>=', now()->subDays(7)));
                } elseif ($request->range === '1_month') {
                    $query->whereHas('kegiatan', fn($q) => $q->where('tanggal_mulai', '>=', now()->subMonth()));
                } elseif ($request->range === '3_months') {
                    $query->whereHas('kegiatan', fn($q) => $q->where('tanggal_mulai', '>=', now()->subMonths(3)));
                }
            } elseif ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
                $query->whereHas('kegiatan', function ($q) use ($request) {
                    $q->whereBetween('tanggal_mulai', [$request->tgl_mulai, $request->tgl_selesai]);
                });
            }

            // 3. Tulis Data ke File (Aman dari null pointer & crash)
            $laporans = $query->orderBy('id_laporan', 'desc')->get();

            foreach ($laporans as $item) {
                $keg = $item->kegiatan;

                fputcsv($file, [
                    $item->id_laporan,
                    $keg->nama_keg ?? '-',
                    optional($keg)->jenisKegiatan->nama_jeniskeg ?? optional($keg)->jenisKeg->nama_jeniskeg ?? '-',
                    optional($keg)->koordinator->nama_karyawan ?? '-',
                    optional($keg)->lokasi->nm_lokasi ?? '-',
                    optional($keg)->instansi->nm_instansi ?? '-',
                    $item->peserta_hadir ?? 0,
                    $item->peserta_tidak_hadir ?? 0,
                    $item->nilai_tertinggi ?? '-',
                    $item->nilai_terendah ?? '-',
                    $item->catatan_evaluasi ?? '-',
                    $item->created_at ? date('d-m-Y H:i', strtotime($item->created_at)) : '-',
                ]);
            }

            fclose($file);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }

    /**
     * Halaman Utama Laporan Kegiatan
     */
    public function laporanKegiatan(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'terbaru');
        $range = $request->input('range');
        $tglMulai = $request->input('tgl_mulai');
        $tglSelesai = $request->input('tgl_selesai');
        $user = Auth::user();

        $query = LaporanKegiatan::with(['kegiatan.jenis', 'kegiatan.lokasi', 'kegiatan.instansi', 'kegiatan.koordinator']);

        // 1. FILTER BERDASARKAN ROLE (PEGAWAI)
        // Pegawai hanya dapat melihat laporan dari kegiatan yang mereka koordinatori
        if ($user->role === 'pegawai') {
            $query->whereHas('kegiatan', function ($q) use ($user) {
                $q->where('id_karyawan_koor', $user->id_karyawan);
            });
        }

        // 2. FILTER PENCARIAN
        if ($search) {
            $query->whereHas('kegiatan', function ($q) use ($search) {
                $q->where('nama_keg', 'like', "%{$search}%");
            });
        }

        // 3. Filter berdasarkan Jenis Kegiatan (BARU)
        if ($request->filled('id_jeniskeg')) {
            $query->whereHas('kegiatan', function($q) use ($request) {
                $q->where('id_jeniskeg', $request->id_jeniskeg);
            });
        }

        // 4. FILTER TANGGAL (PERIODE CEPAT ATAU RENTANG KUSTOM)
        if ($range) {
            switch ($range) {
                case '7_days':
                    $query->where('created_at', '>=', \Carbon\Carbon::now()->subDays(7));
                    break;
                case '1_month':
                    $query->where('created_at', '>=', \Carbon\Carbon::now()->subMonth());
                    break;
                case '3_months':
                    $query->where('created_at', '>=', \Carbon\Carbon::now()->subMonths(3));
                    break;
            }
        } elseif ($tglMulai && $tglSelesai) {
            $query->whereBetween('created_at', [
                $tglMulai . ' 00:00:00',
                $tglSelesai . ' 23:59:59'
            ]);
        }

        // 5. PENGURUTAN (SORTING)
        if ($sort === 'terlama') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'az') {
            $query->join('kegiatan', 'laporan_kegiatan.id_kegiatan', '=', 'kegiatan.id_keg')
                ->orderBy('kegiatan.nama_keg', 'asc')
                ->select('laporan_kegiatan.*');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Mengamankan parameter query string di pagination (search, sort, range, dll)
        $laporan = $query->paginate(10)->withQueryString();

        // 6. QUERY KEGIATAN SELESAI YANG BELUM ADA LAPORAN
        $kegiatanSelesaiQuery = Kegiatan::where('status', 'Selesai')
            ->whereDoesntHave('laporan')
            ->orderBy('nama_keg', 'asc');

        if ($user->role === 'pegawai') {
            $kegiatanSelesaiQuery->where('id_karyawan_koor', $user->id_karyawan);
        }

        $kegiatanSelesai = $kegiatanSelesaiQuery->get();

        // Ambil master data jenis kegiatan untuk dropdown filter
        $jenisKegiatan = JenisKeg::all();

        return view('laporan-kegiatan', compact('laporan', 'kegiatanSelesai', 'jenisKegiatan', 'sort', 'range', 'tglMulai', 'tglSelesai'));
    }

    // METHOD BARU UNTUK CETAK PDF INDIVIDUAL LAPORAN
    public function cetakPdfLaporan($id)
    {
        $laporan = LaporanKegiatan::with(['kegiatan.jenis', 'kegiatan.lokasi', 'kegiatan.instansi', 'kegiatan.koordinator'])
            ->findOrFail($id);

        return view('pdf.laporan-detail', compact('laporan'));
    }

    /**
     * Simpan Laporan Kegiatan Baru
     */
    public function storeLaporanKegiatan(Request $request)
    {
        $user = Auth::user();
        $kegiatan = Kegiatan::findOrFail($request->id_keg);

        if ($user->role === 'pegawai' && $kegiatan->id_karyawan_koor != $user->id_karyawan) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak akses untuk menginput laporan kegiatan ini karena Anda bukan koordinator terpilih.');
        }

        $totalPeserta = $kegiatan->jmlh_peserta;

        $validated = $request->validate([
            'id_keg'              => 'required|exists:kegiatan,id_keg|unique:laporan_kegiatan,id_keg',
            'peserta_hadir'       => 'required|integer|min:0',
            'peserta_tidak_hadir' => [
                'required',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) use ($request, $totalPeserta) {
                    $hadir = (int) $request->peserta_hadir;
                    $absen = (int) $value;
                    if (($hadir + $absen) !== (int) $totalPeserta) {
                        $fail("Total peserta hadir ({$hadir}) + absen ({$absen}) harus bernilai persis sama dengan Total Peserta Terdaftar ({$totalPeserta}).");
                    }
                },
            ],
            'nilai_tertinggi'     => 'nullable|numeric|min:0|max:1000',
            'nilai_terendah'      => 'nullable|numeric|min:0|max:1000',
            'lampiran_laporan'    => 'nullable|string|max:255',
            'catatan_evaluasi'    => 'nullable|string',
        ]);

        LaporanKegiatan::create($validated);

        return redirect()->back()->with('success', 'Laporan kegiatan berhasil disimpan!');
    }

    /**
     * Update Laporan Kegiatan
     */
    public function updateLaporanKegiatan(Request $request, $id)
    {
        $user = Auth::user();
        $laporan = LaporanKegiatan::findOrFail($id);
        $kegiatan = Kegiatan::findOrFail($laporan->id_keg);

        if ($user->role === 'pegawai' && $kegiatan->id_karyawan_koor != $user->id_karyawan) {
            return redirect()->back()->with('error', 'Anda tidak diizinkan mengubah laporan kegiatan ini.');
        }

        $totalPeserta = $kegiatan->jmlh_peserta;

        $validated = $request->validate([
            'peserta_hadir'       => 'required|integer|min:0',
            'peserta_tidak_hadir' => [
                'required',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) use ($request, $totalPeserta) {
                    $hadir = (int) $request->peserta_hadir;
                    $absen = (int) $value;
                    if (($hadir + $absen) !== (int) $totalPeserta) {
                        $fail("Total peserta hadir ({$hadir}) + absen ({$absen}) harus bernilai persis sama dengan Total Peserta Terdaftar ({$totalPeserta}).");
                    }
                },
            ],
            'nilai_tertinggi'     => 'nullable|numeric|min:0|max:1000',
            'nilai_terendah'      => 'nullable|numeric|min:0|max:1000',
            'lampiran_laporan'    => 'nullable|string|max:255',
            'catatan_evaluasi'    => 'nullable|string',
        ]);

        $laporan->update($validated);

        return redirect()->back()->with('success', 'Laporan kegiatan berhasil diperbarui!');
    }

    /**
     * Hapus Laporan Kegiatan
     */
    public function destroyLaporanKegiatan($id)
    {
        $user = Auth::user();
        $laporan = LaporanKegiatan::findOrFail($id);
        $kegiatan = Kegiatan::findOrFail($laporan->id_keg);

        if ($user->role === 'pegawai' && $kegiatan->id_karyawan_koor != $user->id_karyawan) {
            return redirect()->back()->with('error', 'Anda tidak diizinkan menghapus laporan kegiatan ini.');
        }

        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan kegiatan berhasil dihapus!');
    }
    
}