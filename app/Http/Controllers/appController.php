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
    // 1. Dashboard
    public function dashboard()
    {
        $today = Carbon::today()->toDateString();

        // 1. PELAKSANAAN BERJALAN
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

        // 2. JADWAL TERDEKAT
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

        // 3. STATISTIK KARTU
        $stats = [
            'instansi' => Instansi::count(),
            'peserta'  => Kegiatan::sum('jmlh_peserta'),
            'kegiatan' => Kegiatan::count(),
        ];

        return view('dashboard', compact('kegiatan', 'jadwalTerdekat', 'stats'));
    }

    // 2. Halaman Daftar / Perencanaan Kegiatan
    public function kegiatan(Request $request)
    {
        // Tangkap parameter filter urutan (default: 'terbaru')
        $sort = $request->query('sort', 'terbaru');
        $direction = ($sort === 'terlama') ? 'asc' : 'desc';

        // 1. Data utama kegiatan dengan pagination 5 baris & filter urutan
        $kegiatan = Kegiatan::with(['jenis', 'lokasi', 'instansi', 'koordinator'])
            ->orderBy('tanggal_mulai', $direction)
            ->paginate(5)
            ->withQueryString();

        // 2. Data master pendukung untuk dropdown modal form kegiatan
        $jenisList    = JenisKeg::all();
        $lokasiList   = TitikLokasi::all();
        $instansiList = Instansi::all();
        $karyawanList = Karyawan::all();

        return view('kegiatan', compact(
            'kegiatan', 
            'jenisList', 
            'lokasiList', 
            'instansiList', 
            'karyawanList',
            'sort'
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

        // Fallback nilai default tanggal selesai jika kosong
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
    public function titikLokasi()
    {
        $lokasi = TitikLokasi::all();
        $kegiatanBerjalan = Kegiatan::with('lokasi')->first();
        return view('titik-lokasi', compact('lokasi', 'kegiatanBerjalan'));
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
        $sort = $request->query('sort', 'terbaru');
        $direction = ($sort === 'terlama') ? 'asc' : 'desc';

        $kegiatan = Kegiatan::with(['jenis', 'lokasi', 'koordinator'])
            ->orderBy('tanggal_mulai', $direction)
            ->paginate(5)
            ->withQueryString();

        return view('riwayat-kegiatan', compact('kegiatan', 'sort'));
    }

    /**
     * 9. Menampilkan Form Login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses Autentikasi Login
     */
// --- DUAL LOGIN (NIP ATAU USERNAME) ---
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required'    => 'NIP atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Deteksi otomatis input: angka = NIP, string = Username
        $fieldType = is_numeric($request->login) ? 'nip' : 'username';

        if (Auth::attempt([$fieldType => $credentials['login'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'login' => 'NIP/Username atau Password yang Anda masukkan salah.',
        ])->onlyInput('login');
    }

    // --- ALUR LUPA PASSWORD & VERIFIKASI OTP ---
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

        // Generasi Kode OTP 6 Digit Acak Dinamis
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Simpan email & OTP acak ke dalam session
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
        // Ambil seluruh data kegiatan beserta relasi jenis, lokasi, dan koordinator
        $kegiatan = Kegiatan::with(['jenis', 'lokasi', 'koordinator'])
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        return view('landing', compact('kegiatan')); // Ganti 'landing' ke 'welcome' jika nama file blade Anda welcome.blade.php
    }

    public function masterUser(Request $request)
    {
        // Ambil data user dari database (termasuk NIP & Email baru)
        $users = User::orderBy('created_at', 'desc')->get();

        return view('master-user', compact('users'));
    }

    // --- UPDATE DATA USER ---
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Proteksi Server-Side: Mencegah perubahan pada akun Admin
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

    // --- HAPUS DATA USER ---
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        // Proteksi Server-Side: Mencegah penghapusan akun Admin
        if ($user->role === 'admin') {
            return back()->withErrors(['admin' => 'Akun dengan Role Admin tidak dapat dihapus.']);
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus dari sistem.');
    }

    // --- SIMPAN USER BARU ---
    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'nip'      => 'nullable|string|max:18|unique:users,nip',
            'email'    => 'required|email|max:150|unique:users,email',
            // Pembatasan Server-side: Hanya boleh memilih pegawai atau pimpinan
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
}