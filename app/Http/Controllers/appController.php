<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kegiatan;
use App\Models\JenisKeg;
use App\Models\Instansi;
use App\Models\TitikLokasi;
use App\Models\Karyawan;
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
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    // 10. Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}