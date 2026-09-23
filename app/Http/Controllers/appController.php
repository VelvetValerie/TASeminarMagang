<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Kegiatan;
use App\Models\JenisKeg;
use App\Models\Instansi;
use App\Models\TitikLokasi;
use App\Models\Karyawan;
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

        // Update kegiatan yang berstatus 'Terkonfirmasi' atau 'Belum Konfirmasi' 
        // tetapi tanggal_selesai (atau tanggal_mulai) sudah < HARI INI
        Kegiatan::whereNotIn('status', ['Selesai', 'Dibatalkan'])
            ->where(function ($query) use ($today) {
                $query->whereRaw("IFNULL(tanggal_selesai, tanggal_mulai) < ?", [$today]);
            })
            ->update(['status' => 'Selesai']);
    }

    // 1. Dashboard Utama dengan Banner Pengingat Koordinator
    public function dashboard()
    {
        // 1. Jalankan auto update status terlebih dahulu
        $this->autoUpdateStatusSelesai();
        
        $today = Carbon::today()->toDateString();
        $user = Auth::user();

        // Ambil Notifikasi Tugas Koordinator Hari Ini
        $notifTugas = collect();

        if ($user) {
            $username = strtolower(trim($user->username ?? ''));
            
            $notifTugas = Kegiatan::with(['jenis', 'lokasi', 'instansi', 'koordinator'])
                ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
                ->whereDate('tanggal_mulai', '<=', $today)
                ->whereRaw("IFNULL(tanggal_selesai, tanggal_mulai) >= ?", [$today])
                ->get()
                ->filter(function($keg) use ($user, $username) {
                    // A. Cek berdasarkan id_karyawan jika tersambung
                    if (!empty($user->id_karyawan) && $keg->id_karyawan_koor == $user->id_karyawan) {
                        return true;
                    }

                    // B. Cek pencocokan kata (username vs nama_karyawan)
                    $namaKoor = strtolower($keg->koordinator->nama_karyawan ?? '');
                    if (!empty($username) && !empty($namaKoor)) {
                        return str_contains($namaKoor, $username) || str_contains($username, $namaKoor);
                    }

                    return false;
                })->values();
        }

        // Data Pelaksanaan Berjalan
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

        // Jadwal Terdekat
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

        // Statistik
        $stats = [
            'instansi' => Instansi::count(),
            'peserta'  => Kegiatan::sum('jmlh_peserta'),
            'kegiatan' => Kegiatan::count(),
        ];

        return view('dashboard', compact('kegiatan', 'jadwalTerdekat', 'stats', 'notifTugas'));
    }

    // 2. Halaman Daftar / Perencanaan Kegiatan
    public function kegiatan(Request $request)
    {
        $query = Kegiatan::with(['jenis', 'koordinator', 'lokasi', 'instansi']);

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

    // Simpan Kegiatan Baru
    public function storeKegiatan(Request $request)
    {
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

    // Update / Edit Data Kegiatan
    public function updateKegiatan(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

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

        return redirect()->back()->with('success', 'Kegiatan berhasil diperbarui!');
    }

    // Hapus Kegiatan dari Database
    public function destroyKegiatan($id)
    {
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
        $kegiatan = Kegiatan::with(['jenis', 'lokasi', 'koordinator'])
            ->orderBy('tanggal_mulai', 'asc')
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

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->withErrors(['admin' => 'Akun dengan Role Admin tidak dapat dihapus.']);
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus dari sistem.');
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
}