<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\JenisKeg;
use App\Models\Instansi;
use App\Models\TitikLokasi;
use App\Models\Karyawan;
use Carbon\Carbon;

class MasterDataController extends Controller
{
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

    public function instansi()
    {
        $instansi = Instansi::all();
        return view('instansi', compact('instansi'));
    }

    public function jenisKegiatan()
    {
        $jenis = JenisKeg::all();
        return view('jenis-kegiatan', compact('jenis'));
    }

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
}