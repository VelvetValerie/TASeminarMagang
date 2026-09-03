<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\JenisKeg;
use App\Models\Instansi;
use App\Models\TitikLokasi;
use App\Models\Karyawan;

class AppController extends Controller
{
    // 1. Dashboard
    public function dashboard()
    {
        $kegiatan = Kegiatan::with(['jenis', 'lokasi', 'instansi', 'koordinator'])
            ->orderBy('id_keg', 'desc')
            ->get();

        $stats = [
            'instansi' => Instansi::count(),
            'peserta'  => Kegiatan::sum('jmlh_peserta'),
            'kegiatan' => Kegiatan::count()
        ];

        return view('dashboard', compact('kegiatan', 'stats'));
    }

    // 2. Kegiatan (Daftar & Form Tambah)
    public function kegiatan()
    {
        $kegiatan = Kegiatan::with(['jenis', 'lokasi', 'instansi', 'koordinator'])
            ->orderBy('id_keg', 'desc')
            ->get();

        // Data dropdown untuk modal Tambah Kegiatan
        $jenisList     = JenisKeg::all();
        $instansiList  = Instansi::all();
        $lokasiList    = TitikLokasi::all();
        $karyawanList  = Karyawan::all();

        return view('kegiatan', compact('kegiatan', 'jenisList', 'instansiList', 'lokasiList', 'karyawanList'));
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
        $kegiatan = \App\Models\Kegiatan::with(['lokasi', 'jenis', 'koordinator'])->get();
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
        $semuaKegiatan = \App\Models\Kegiatan::with(['lokasi', 'jenis', 'koordinator'])->get();

        // 2. Ambil semua karyawan
        $karyawan = \App\Models\Karyawan::all();

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