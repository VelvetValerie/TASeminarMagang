<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kegiatan;
use App\Models\JenisKeg;
use App\Models\Instansi;
use App\Models\TitikLokasi;
use App\Models\Karyawan;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Kegiatan::with(['jenis', 'koordinator', 'lokasi', 'instansi']);

        // Jika user adalah Pegawai Koordinator, tampilkan kegiatan yang ditugaskan kepadanya
        if ($user && $user->role === 'pegawai_koordinasi') {
            $query->where('id_karyawan_koor', $user->id_karyawan);
        }

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

        $jenisList = JenisKeg::all();
        $karyawanList = Karyawan::all();
        $lokasiList = TitikLokasi::all();
        $instansiList = Instansi::all();

        return view('kegiatan', compact(
            'kegiatan', 
            'sort', 
            'jenisList', 
            'karyawanList', 
            'lokasiList', 
            'instansiList'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Pimpinan dan Pegawai Humas tidak diizinkan membuat kegiatan
        if (in_array($user->role, ['pimpinan', 'pegawai_humas'])) {
            return redirect()->back()->with('error', 'Akses ditolak! Anda tidak diizinkan menambahkan kegiatan baru.');
        }

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

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $kegiatan = Kegiatan::findOrFail($id);

        // Jika Pegawai Koordinator, pastikan dia adalah koordinator untuk kegiatan tersebut
        if ($user->role === 'pegawai_koordinasi' && $kegiatan->id_karyawan_koor != $user->id_karyawan) {
            return redirect()->back()->with('error', 'Akses ditolak! Anda bukan koordinator terpilih untuk kegiatan ini.');
        }

        // Pimpinan & Pegawai Humas tidak boleh mengubah data kegiatan
        if (in_array($user->role, ['pimpinan', 'pegawai_humas'])) {
            return redirect()->back()->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk mengubah kegiatan.');
        }

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

        return redirect()->back()->with('success', 'Data kegiatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        // Hanya Admin yang diizinkan menghapus kegiatan
        if ($user->role !== 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak! Hanya Admin yang diizinkan menghapus data kegiatan.');
        }

        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->delete();

        return redirect()->back()->with('success', 'Kegiatan berhasil dihapus!');
    }

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
}