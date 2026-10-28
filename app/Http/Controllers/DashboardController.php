<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kegiatan;
use App\Models\Instansi;
use App\Models\LaporanKegiatan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Memperbarui status kegiatan yang telah melewati tanggal selesai secara otomatis.
     */
    private function autoUpdateStatusSelesai()
    {
        $today = Carbon::today()->toDateString();

        // Hanya jalankan update jika ada kegiatan yang memang belum berstatus Selesai/Dibatalkan
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

        return view('dashboard', compact('kegiatan', 'jadwalTerdekat', 'stats', 'notifTugas', 'laporanPendingCount'));
    }

    public function kalender() 
    {
        $kegiatan = Kegiatan::with(['lokasi', 'jenis', 'koordinator'])->get();
        return view('kalender', compact('kegiatan'));
    }
}