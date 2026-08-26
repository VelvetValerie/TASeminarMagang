<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppController extends Controller
{
    private $jsonPath = 'kegiatan.json';

    // Helper: Baca data JSON
    private function getData()
    {
        if (!Storage::exists($this->jsonPath)) {
            Storage::put($this->jsonPath, json_encode([]));
        }
        return json_decode(Storage::get($this->jsonPath), true) ?? [];
    }

    // Helper: Simpan data JSON
    private function saveData($data)
    {
        Storage::put($this->jsonPath, json_encode(array_values($data), JSON_PRETTY_PRINT));
    }

    // 1. Dashboard
    public function dashboard()
    {
        $kegiatan = $this->getData();

        // Hitung metrik dinamis
        $instansiList = array_unique(array_column($kegiatan, 'instansi'));
        $lokasiList = array_unique(array_column($kegiatan, 'lokasi'));
        $totalPeserta = array_sum(array_column($kegiatan, 'peserta'));

        $stats = [
            'instansi' => count($instansiList),
            'lokasi' => count($lokasiList),
            'peserta' => $totalPeserta,
            'kegiatan' => count($kegiatan)
        ];

        return view('dashboard', compact('kegiatan', 'stats'));
    }

    // 2. Kegiatan (CRUD)
    public function kegiatan()
    {
        $kegiatan = $this->getData();
        return view('kegiatan', compact('kegiatan'));
    }

    public function storeKegiatan(Request $request)
    {
        $data = $this->getData();

        $newItem = [
            'id' => time(),
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'koordinator' => $request->koordinator,
            'tanggal' => $request->tanggal,
            'tanggal_selesai' => $request->tanggal,
            'lokasi' => $request->lokasi,
            'alamat' => 'JL. Bhayangkara ' . rand(1, 10),
            'instansi' => $request->instansi,
            'peserta' => (int) $request->peserta,
            'status' => 'Belum Konfirmasi',
            'lampiran' => $request->lampiran ?? 'https://drive.google.com/sample'
        ];

        $data[] = $newItem;
        $this->saveData($data);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function destroyKegiatan($id)
    {
        $data = $this->getData();
        $filtered = array_filter($data, fn($item) => $item['id'] != $id);
        $this->saveData($filtered);

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus');
    }

    // 3. Kalender
    public function kalender()
    {
        $kegiatan = $this->getData();
        return view('kalender', compact('kegiatan'));
    }

    // 4. Titik Lokasi
    public function titikLokasi()
    {
        $kegiatan = $this->getData();
        return view('titik-lokasi', compact('kegiatan'));
    }

    // 5. Instansi
    public function instansi()
    {
        $kegiatan = $this->getData();
        $instansiList = array_unique(array_column($kegiatan, 'instansi'));
        return view('instansi', compact('instansiList'));
    }

    // 6. Jenis Kegiatan
    public function jenisKegiatan()
    {
        $kegiatan = $this->getData();
        return view('jenis-kegiatan', compact('kegiatan'));
    }

    // 7. Riwayat Kerja
    public function riwayatKerja()
    {
        $kegiatan = $this->getData();
        return view('riwayat-kerja', compact('kegiatan'));
    }

    // 8. Riwayat Kegiatan
    public function riwayatKegiatan()
    {
        $kegiatan = $this->getData();
        return view('riwayat-kegiatan', compact('kegiatan'));
    }
}