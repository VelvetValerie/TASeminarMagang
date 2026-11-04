<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kegiatan;
use App\Models\Instansi;
use App\Models\LaporanKegiatan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Memperbarui status kegiatan yang telah melewati tanggal selesai secara otomatis.
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

    public function dashboard()
    {
        $this->autoUpdateStatusSelesai();
        
        $today = Carbon::today()->toDateString();
        $user = Auth::user();

        $notifTugas = collect();
        $laporanPendingCount = 0;

        if ($user) {
            $username = strtolower(trim($user->username ?? ''));
            
            // Pengingat kegiatan berjalan hari ini khusus koordinator
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

            // Hitung jumlah laporan yang belum diisi jika user adalah pegawai koordinasi
            if ($user->role === 'pegawai_koordinasi' && !empty($user->id_karyawan)) {
                $kegiatanSelesaiIds = Kegiatan::where('id_karyawan_koor', $user->id_karyawan)
                    ->where('status', 'Selesai')
                    ->pluck('id_keg');
                
                $laporanAda = LaporanKegiatan::whereIn('id_keg', $kegiatanSelesaiIds)->pluck('id_keg');
                $laporanPendingCount = $kegiatanSelesaiIds->diff($laporanAda)->count();
            }
        }

        // Pelaksanaan Berjalan
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

        // Penyesuaian Statistik Berdasarkan Role
        if ($user && $user->role === 'pegawai_koordinasi' && !empty($user->id_karyawan)) {
            $stats = [
                'instansi' => Instansi::count(),
                'peserta'  => Kegiatan::where('id_karyawan_koor', $user->id_karyawan)->sum('jmlh_peserta'),
                'kegiatan' => Kegiatan::where('id_karyawan_koor', $user->id_karyawan)->count(),
            ];
        } else {
            $stats = [
                'instansi' => Instansi::count(),
                'peserta'  => Kegiatan::sum('jmlh_peserta'),
                'kegiatan' => Kegiatan::count(),
            ];
        }

        // Carbon instances untuk Bulan Ini & Bulan Lalu
        $now          = Carbon::now();
        $currentMonth = $now->month;
        $currentYear  = $now->year;

        $subMonth     = Carbon::now()->subMonth();
        $prevMonth    = $subMonth->month;
        $prevYear     = $subMonth->year;

        // 1. DATA STATUS KEGIATAN (RING DALAM: BULAN INI, RING LUAR: BULAN LALU)
        $chartStatusCurrent = Kegiatan::whereMonth('tanggal_mulai', $currentMonth)
            ->whereYear('tanggal_mulai', $currentYear)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $chartStatusPrev = Kegiatan::whereMonth('tanggal_mulai', $prevMonth)
            ->whereYear('tanggal_mulai', $prevYear)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // 2. DATA JENIS KEGIATAN TOP 5 (BULAN INI VS BULAN LALU)
        $chartJenisCurrent = Kegiatan::join('jenis_keg', 'kegiatan.id_jeniskeg', '=', 'jenis_keg.id_jeniskeg')
            ->whereMonth('tanggal_mulai', $currentMonth)
            ->whereYear('tanggal_mulai', $currentYear)
            ->select('jenis_keg.nama_jeniskeg', DB::raw('count(*) as total'))
            ->groupBy('jenis_keg.nama_jeniskeg')
            ->pluck('total', 'jenis_keg.nama_jeniskeg')
            ->toArray();

        $chartJenisPrev = Kegiatan::join('jenis_keg', 'kegiatan.id_jeniskeg', '=', 'jenis_keg.id_jeniskeg')
            ->whereMonth('tanggal_mulai', $prevMonth)
            ->whereYear('tanggal_mulai', $prevYear)
            ->select('jenis_keg.nama_jeniskeg', DB::raw('count(*) as total'))
            ->groupBy('jenis_keg.nama_jeniskeg')
            ->pluck('total', 'jenis_keg.nama_jeniskeg')
            ->toArray();

        // 3. DATA INSTANSI TERAKTIF TOP 5 (BULAN INI VS BULAN LALU)
        $chartInstansiCurrent = Kegiatan::join('instansi', 'kegiatan.id_instansi', '=', 'instansi.id_instansi')
            ->whereMonth('tanggal_mulai', $currentMonth)
            ->whereYear('tanggal_mulai', $currentYear)
            ->select('instansi.nm_instansi', DB::raw('count(*) as total'))
            ->groupBy('instansi.nm_instansi')
            ->pluck('total', 'instansi.nm_instansi')
            ->toArray();

        $chartInstansiPrev = Kegiatan::join('instansi', 'kegiatan.id_instansi', '=', 'instansi.id_instansi')
            ->whereMonth('tanggal_mulai', $prevMonth)
            ->whereYear('tanggal_mulai', $prevYear)
            ->select('instansi.nm_instansi', DB::raw('count(*) as total'))
            ->groupBy('instansi.nm_instansi')
            ->pluck('total', 'instansi.nm_instansi')
            ->toArray();

        // 4. DATA TOP 5 KEGIATAN PESERTA TERBANYAK
        $chartPesertaKeg = Kegiatan::select('nama_keg', 'jmlh_peserta')
            ->orderBy('jmlh_peserta', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'kegiatan', 'jadwalTerdekat', 'stats', 'notifTugas', 
            'laporanPendingCount', 'chartStatusCurrent', 'chartStatusPrev',
            'chartJenisCurrent', 'chartJenisPrev', 'chartInstansiCurrent',
            'chartInstansiPrev', 'chartPesertaKeg'
        ));
    }

    public function kalender() 
    {
        $kegiatan = Kegiatan::with(['lokasi', 'jenis', 'koordinator'])->get();
        return view('kalender', compact('kegiatan'));
    }
}