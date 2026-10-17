<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kegiatan;
use App\Models\JenisKeg;
use App\Models\LaporanKegiatan;

class LaporanKegiatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'terbaru');
        $range = $request->input('range');
        $tglMulai = $request->input('tgl_mulai');
        $tglSelesai = $request->input('tgl_selesai');
        $user = Auth::user();

        $query = LaporanKegiatan::with(['kegiatan.jenis', 'kegiatan.lokasi', 'kegiatan.instansi', 'kegiatan.koordinator']);

        // Filter laporan hanya untuk kegiatan yang dikoordinasikan jika role pegawai_koordinasi
        if ($user->role === 'pegawai_koordinasi') {
            $query->whereHas('kegiatan', function ($q) use ($user) {
                $q->where('id_karyawan_koor', $user->id_karyawan);
            });
        }

        if ($search) {
            $query->whereHas('kegiatan', function ($q) use ($search) {
                $q->where('nama_keg', 'like', "%{$search}%");
            });
        }

        if ($request->filled('id_jeniskeg')) {
            $query->whereHas('kegiatan', function($q) use ($request) {
                $q->where('id_jeniskeg', $request->id_jeniskeg);
            });
        }

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

        if ($sort === 'terlama') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'az') {
            $query->join('kegiatan', 'laporan_kegiatan.id_kegiatan', '=', 'kegiatan.id_keg')
                ->orderBy('kegiatan.nama_keg', 'asc')
                ->select('laporan_kegiatan.*');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $laporan = $query->paginate(10)->withQueryString();

        $kegiatanSelesaiQuery = Kegiatan::where('status', 'Selesai')
            ->whereDoesntHave('laporan')
            ->orderBy('nama_keg', 'asc');

        if ($user->role === 'pegawai_koordinasi') {
            $kegiatanSelesaiQuery->where('id_karyawan_koor', $user->id_karyawan);
        }

        $kegiatanSelesai = $kegiatanSelesaiQuery->get();
        $jenisKegiatan = JenisKeg::all();

        return view('laporan-kegiatan', compact('laporan', 'kegiatanSelesai', 'jenisKegiatan', 'sort', 'range', 'tglMulai', 'tglSelesai'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $kegiatan = Kegiatan::findOrFail($request->id_keg);

        if ($user->role === 'pegawai_koordinasi' && $kegiatan->id_karyawan_koor != $user->id_karyawan) {
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
            'peserta_lulus'       => 'nullable|integer|min:0|max:' . $totalPeserta,
            'peserta_tidak_lulus' => 'nullable|integer|min:0|max:' . $totalPeserta,
            'nilai_tertinggi'     => 'nullable|numeric|min:0|max:1000',
            'nilai_terendah'      => 'nullable|numeric|min:0|max:1000',
            'lampiran_laporan'    => 'nullable|string|max:255',
            'catatan_evaluasi'    => 'nullable|string',
        ]);

        LaporanKegiatan::create($validated);

        return redirect()->back()->with('success', 'Laporan kegiatan berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $laporan = LaporanKegiatan::findOrFail($id);
        $kegiatan = Kegiatan::findOrFail($laporan->id_keg);

        if ($user->role === 'pegawai_koordinasi' && $kegiatan->id_karyawan_koor != $user->id_karyawan) {
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
            'peserta_lulus'       => 'nullable|integer|min:0|max:' . $totalPeserta,
            'peserta_tidak_lulus' => 'nullable|integer|min:0|max:' . $totalPeserta,
            'nilai_tertinggi'     => 'nullable|numeric|min:0|max:1000',
            'nilai_terendah'      => 'nullable|numeric|min:0|max:1000',
            'lampiran_laporan'    => 'nullable|string|max:255',
            'catatan_evaluasi'    => 'nullable|string',
        ]);

        $laporan->update($validated);

        return redirect()->back()->with('success', 'Laporan kegiatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $laporan = LaporanKegiatan::findOrFail($id);
        $kegiatan = Kegiatan::findOrFail($laporan->id_keg);

        if ($user->role === 'pegawai_koordinasi' && $kegiatan->id_karyawan_koor != $user->id_karyawan) {
            return redirect()->back()->with('error', 'Anda tidak diizinkan menghapus laporan kegiatan ini.');
        }

        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan kegiatan berhasil dihapus!');
    }

    public function cetakPdfLaporan($id)
    {
        $laporan = LaporanKegiatan::with(['kegiatan.jenis', 'kegiatan.lokasi', 'kegiatan.instansi', 'kegiatan.koordinator'])
            ->findOrFail($id);

        return view('pdf.laporan-detail', compact('laporan'));
    }

    public function exportCsv(Request $request)
    {
        $loggedUser = Auth::user();
        $fileName = 'Laporan_Kegiatan_BKN_' . date('Y-m-d_H-i') . '.csv';

        return response()->streamDownload(function () use ($request, $loggedUser) {
            $file = fopen('php://output', 'w');

            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'No',
                'Nama Kegiatan',
                'Jenis Kegiatan',
                'Koordinator',
                'Lokasi',
                'Instansi',
                'Peserta Hadir',
                'Peserta Absen',
                'Peserta Lulus',
                'Peserta Tidak Lulus',
                'Nilai Tertinggi',
                'Nilai Terendah',
                'Catatan Evaluasi',
            ]);

            $query = LaporanKegiatan::with([
                'kegiatan.jenis', 
                'kegiatan.koordinator', 
                'kegiatan.lokasi', 
                'kegiatan.instansi'
            ]);

            if ($loggedUser && $loggedUser->role === 'pegawai_koordinasi' && $loggedUser->id_karyawan) {
                $query->whereHas('kegiatan', function ($q) use ($loggedUser) {
                    $q->where('id_karyawan_koor', $loggedUser->id_karyawan);
                });
            }

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

            $laporans = $query->orderBy('id_laporan', 'desc')->get();
            $no = 1;

            foreach ($laporans as $item) {
                $keg = $item->kegiatan;

                $namaJenis = $keg->jenis->nama_jeniskeg 
                    ?? $keg->jenisKegiatan->nama_jeniskeg 
                    ?? $keg->jenisKeg->nama_jeniskeg 
                    ?? '-';

                fputcsv($file, [
                    $no++,
                    $keg->nama_keg ?? '-',
                    $namaJenis,
                    $keg->koordinator->nama_karyawan ?? '-',
                    $keg->lokasi->nm_lokasi ?? '-',
                    $keg->instansi->nm_instansi ?? '-',
                    $item->peserta_hadir ?? 0,
                    $item->peserta_tidak_hadir ?? 0,
                    $item->peserta_lulus ?? '-',
                    $item->peserta_tidak_lulus ?? '-',  
                    $item->nilai_tertinggi ?? '-',
                    $item->nilai_terendah ?? '-',
                    $item->catatan_evaluasi ?? '-',
                ]);
            }

            fclose($file);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ]);
    }
}