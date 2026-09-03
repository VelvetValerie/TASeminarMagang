<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        // 1. PELAKSANAAN BERJALAN:
        // - Abaikan kegiatan yang statusnya 'Selesai' atau 'Dibatalkan'
        // - Hanya ambil kegiatan aktif hari ini yang belum selesai, atau kegiatan mendatang
        $kegiatan = \App\Models\Kegiatan::with(['jenis', 'lokasi', 'instansi', 'koordinator'])
            ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
            ->whereRaw("IFNULL(tanggal_selesai, tanggal_mulai) >= ?", [$today])
            ->orderByRaw("
                CASE 
                    -- Prioritas 1: Sedang Berjalan HARI INI
                    WHEN ? BETWEEN tanggal_mulai AND IFNULL(tanggal_selesai, tanggal_mulai) THEN 0
                    -- Prioritas 2: Jadwal Mendatang
                    ELSE 1
                END ASC
            ", [$today])
            ->orderBy('tanggal_mulai', 'asc')
            ->take(7)
            ->get();

        // 2. JADWAL TERDEKAT (3 Agenda Mendatang yang Belum Selesai):
        $jadwalTerdekat = Kegiatan::with(['jenis', 'lokasi', 'koordinator'])
            ->whereNotIn('status', ['Selesai', 'Dibatalkan'])
            ->where('tanggal_mulai', '>', $today)
            ->orderBy('tanggal_mulai', 'asc')
            ->take(3)
            ->get();

        // Fallback jika tidak ada kegiatan di masa depan
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

    /**
     * Halaman Daftar Kegiatan
     */
    public function kegiatan()
    {
        // 1. Data utama kegiatan
        $kegiatan = Kegiatan::with(['jenis', 'lokasi', 'instansi', 'koordinator'])
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        // 2. Data master pendukung untuk filter & modal form kegiatan
        $jenisList = JenisKeg::all();
        $lokasiList = TitikLokasi::all();
        $instansiList = Instansi::all();
        $karyawanList = Karyawan::all();

        return view('kegiatan', compact(
            'kegiatan', 
            'jenisList', 
            'lokasiList', 
            'instansiList', 
            'karyawanList'
        ));
    }

    // Simpan Kegiatan Baru ke Database
    public function storeKegiatan(Request $request)
    {
        $request->validate([
            'nama_keg'          => 'required|string|max:150',
            'id_jeniskeg'       => 'required|integer',
            'id_karyawan_koor'  => 'required|integer',
            'tanggal_mulai'     => 'required|date',
            'id_tklokasi'       => 'required|integer',
            'id_instansi'       => 'required|integer',
            'jmlh_peserta'      => 'required|numeric',
        ]);

        Kegiatan::create([
            'nama_keg'         => $request->nama_keg,
            'id_jeniskeg'      => $request->id_jeniskeg,
            'id_karyawan_koor' => $request->id_karyawan_koor,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_selesai'  => $request->tanggal_selesai ?? $request->tanggal_mulai,
            'id_tklokasi'      => $request->id_tklokasi,
            'id_instansi'      => $request->id_instansi,
            'jmlh_peserta'     => $request->jmlh_peserta,
            'status'           => 'Belum Konfirmasi',
            'lampiran'         => $request->lampiran ?? 'https://drive.google.com/...'
        ]);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan');
    }

    // Hapus Kegiatan dari Database
    public function destroyKegiatan($id)
    {
        Kegiatan::where('id_keg', $id)->delete();
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus');
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
        // 1. Ambil semua kegiatan beserta relasi koordinator/lokasi/jenis yang sudah berjalan
        $semuaKegiatan = Kegiatan::with(['lokasi', 'jenis', 'koordinator'])->get();

        // 2. Ambil semua karyawan
        $karyawan = Karyawan::all();

        // 3. Pasangkan daftar kegiatan ke tiap karyawan secara dinamis
        $karyawan->each(function ($kar) use ($semuaKegiatan) {
            // Cocokkan kegiatan di mana koordinatornya adalah karyawan ini
            $kar->daftar_kegiatan = $semuaKegiatan->filter(function ($keg) use ($kar) {
                return $keg->id_karyawan_koor == $kar->id_karyawan 
                    || ($keg->koordinator && $keg->koordinator->id_karyawan == $kar->id_karyawan);
            })->values();
        });

        return view('riwayat-kerja', compact('karyawan'));
    }

    // 8. Riwayat Kegiatan
    public function riwayatKegiatan()
    {
        $kegiatan = Kegiatan::with(['jenis', 'lokasi'])->get();
        return view('riwayat-kegiatan', compact('kegiatan'));
    }
}