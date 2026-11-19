<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminInformasiController extends Controller
{
    public function __construct()
    {
        // Jika user belum login atau role-nya bukan admin/pegawai_humas, langsung hentikan akses (403 Forbidden)
        if (Auth::check() && !in_array(Auth::user()->role, ['admin', 'pegawai_humas'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
        }
    }

    public function index(Request $request)
    {
        $query = Berita::with('penulis')->where('kategori_publikasi', 'Informasi Resmi');

        if ($request->filled('search')) {
            $query->where('judul_berita', 'like', '%' . $request->search . '%');
        }

        $statusFilter = $request->input('status', 'semua');
        if (in_array($statusFilter, ['Terbit', 'Pending', 'Revisi', 'Draft'])) {
            $query->where('status', $statusFilter);
        }

        $sort = $request->input('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->oldest();
        } elseif ($sort === 'az') {
            $query->orderBy('judul_berita', 'asc');
        } else {
            $query->latest();
        }

        $informasi = $query->paginate(10);

        $statusCounts = [
            'semua'   => Berita::where('kategori_publikasi', 'Informasi Resmi')->count(),
            'Terbit'  => Berita::where('kategori_publikasi', 'Informasi Resmi')->where('status', 'Terbit')->count(),
            'Pending' => Berita::where('kategori_publikasi', 'Informasi Resmi')->where('status', 'Pending')->count(),
            'Revisi'  => Berita::where('kategori_publikasi', 'Informasi Resmi')->where('status', 'Revisi')->count(),
            'Draft'   => Berita::where('kategori_publikasi', 'Informasi Resmi')->where('status', 'Draft')->count(),
        ];

        return view('admin.informasi.index', compact('informasi', 'sort', 'statusFilter', 'statusCounts'));
    }

    public function create()
    {
        return view('admin.informasi.create');
    }

    public function store(Request $request)
    {
        $isAdmin = Auth::user()->role === 'admin';
        $actionType = $request->input('action_type');

        $targetStatus = $request->input('status', 'Draft');
        if ($actionType === 'submit_review') {
            $targetStatus = 'Pending';
        } elseif ($actionType === 'save_draft') {
            $targetStatus = 'Draft';
        } elseif ($actionType === 'publish' && $isAdmin) {
            $targetStatus = 'Terbit';
        }

        if (!$isAdmin && !in_array($targetStatus, ['Draft', 'Pending'])) {
            $targetStatus = 'Draft';
        }

        $request->merge(['status' => $targetStatus]);

        $request->validate([
            'judul_berita'      => 'required|string|max:255',
            'konten'            => 'required|string',
            'status'            => $isAdmin ? 'required|in:Terbit,Draft,Pending,Revisi' : 'required|in:Draft,Pending',
            'thumbnail'         => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
            'caption_thumbnail' => 'required|string|max:150',
            'lampiran_url'      => 'nullable|url|max:255',
            'multi_images.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $slug = Str::slug($request->judul_berita) . '-' . Str::random(5);
        $folderPath = "informasi/{$slug}";

        // 1. Upload Thumbnail Utama
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store($folderPath, 'public');
        }

        // 2. Upload Multi-Images & Replace String Nama File di Dalam Konten
        $konten = $request->konten;
        $multiImagesPaths = [];

        if ($request->hasFile('multi_images')) {
            foreach ($request->file('multi_images') as $file) {
                $originalName = $file->getClientOriginalName();
                $fileName = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs("{$folderPath}/gallery", $fileName, 'public');

                $multiImagesPaths[] = $path;

                $publicUrl = asset('storage/' . $path);
                $encodedName = rawurlencode($originalName);
                $konten = str_replace(
                    ['src="' . $originalName . '"', 'src="' . $encodedName . '"', "src='" . $originalName . "'", "src='" . $encodedName . "'"],
                    'src="' . $publicUrl . '"',
                    $konten
                );
            }
        }

        Berita::create([
            'judul_berita'       => $request->judul_berita,
            'slug'               => $slug,
            'kategori_publikasi' => 'Informasi Resmi',
            'konten'             => $konten,
            'status'             => $targetStatus,
            'thumbnail'          => $thumbnailPath,
            'caption_thumbnail'  => $request->caption_thumbnail,
            'lampiran_url'       => $request->lampiran_url,
            'multi_images'       => !empty($multiImagesPaths) ? array_values($multiImagesPaths) : null,
            'komentar_revisi'    => null,
            'id_penulis'         => Auth::id(),
        ]);

        $msg = $targetStatus === 'Pending'
            ? 'Informasi resmi berhasil diajukan (Pending) dan menunggu peninjauan Admin!'
            : ($targetStatus === 'Terbit' ? 'Informasi resmi berhasil diterbitkan!' : 'Informasi resmi berhasil disimpan sebagai Draft!');

        return redirect()->route('admin.informasi.index')->with('success', $msg);
    }

    public function edit($slug)
    {
        $informasi = Berita::with('penulis')
                           ->where('slug', $slug)
                           ->where('kategori_publikasi', 'Informasi Resmi')
                           ->firstOrFail();

        $isLockedForHumas = (Auth::user()->role === 'pegawai_humas' && $informasi->status === 'Pending');

        return view('admin.informasi.edit', compact('informasi', 'isLockedForHumas'));
    }

    public function update(Request $request, $slug)
    {
        $informasi = Berita::where('slug', $slug)
                           ->where('kategori_publikasi', 'Informasi Resmi')
                           ->firstOrFail();

        $isAdmin = Auth::user()->role === 'admin';

        // Kunci edit bagi Pegawai Humas saat status sedang Pending (menunggu review Admin)
        if (!$isAdmin && $informasi->status === 'Pending') {
            return redirect()->route('admin.informasi.edit', $informasi->slug)
                             ->with('error', 'Informasi resmi sedang menunggu peninjauan (Pending) oleh Admin dan tidak dapat diubah hingga peninjauan selesai.');
        }

        $actionType = $request->input('action_type');
        $targetStatus = $request->input('status', $informasi->status);

        if ($actionType === 'submit_review') {
            $targetStatus = 'Pending';
        } elseif ($actionType === 'save_draft') {
            $targetStatus = $informasi->status === 'Revisi' ? 'Revisi' : 'Draft';
        } elseif ($actionType === 'approve_publish' && $isAdmin) {
            $targetStatus = 'Terbit';
        } elseif ($actionType === 'reject_revisi' && $isAdmin) {
            $targetStatus = 'Revisi';
        }

        if (!$isAdmin) {
            if ($informasi->status === 'Terbit') {
                $targetStatus = 'Terbit';
            } elseif (!in_array($targetStatus, ['Draft', 'Pending', 'Revisi'])) {
                $targetStatus = 'Pending';
            }
        }

        $request->merge(['status' => $targetStatus]);

        $rules = [
            'judul_berita'      => 'required|string|max:255',
            'konten'            => 'required|string',
            'status'            => $isAdmin ? 'required|in:Draft,Pending,Revisi,Terbit' : 'required|in:Draft,Pending,Revisi',
            'caption_thumbnail' => 'nullable|string|max:150',
            'lampiran_url'      => 'nullable|url',
            'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240', 
            'multi_images.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ];

        if ($isAdmin && $targetStatus === 'Revisi') {
            $rules['komentar_revisi'] = 'required|string|min:3|max:2000';
        }

        $request->validate($rules, [
            'komentar_revisi.required' => 'Alasan revisi wajib diisi saat mengembalikan publikasi ke status Revisi.',
        ]);

        $folderPath = "informasi/{$informasi->slug}";
        $konten = $request->konten;

        $dataUpdate = [
            'judul_berita'      => $request->judul_berita,
            'status'            => $targetStatus,
            'caption_thumbnail' => $request->caption_thumbnail,
            'lampiran_url'      => $request->lampiran_url,
        ];

        // Logika komentar_revisi:
        // 1. Jika Admin menolak -> simpan alasan revisi baru
        // 2. Jika sebelumnya berstatus Revisi dan sekarang diajukan ulang (Pending) atau Terbit -> ubah komentar_revisi menjadi "TELAH DIREVISI"
        if ($isAdmin && $targetStatus === 'Revisi') {
            $dataUpdate['komentar_revisi'] = trim($request->komentar_revisi);
        } elseif ($informasi->status === 'Revisi' && in_array($targetStatus, ['Pending', 'Terbit'])) {
            $dataUpdate['komentar_revisi'] = 'TELAH DIREVISI';
        }

        // Update Thumbnail jika ada file baru
        if ($request->hasFile('thumbnail')) {
            if ($informasi->thumbnail && Storage::disk('public')->exists($informasi->thumbnail)) {
                Storage::disk('public')->delete($informasi->thumbnail);
            }
            $dataUpdate['thumbnail'] = $request->file('thumbnail')->store($folderPath, 'public');
        }

        // Ambil array galeri
        $existingMultiImages = $informasi->multi_images;
        if (is_string($existingMultiImages)) {
            $existingMultiImages = json_decode($existingMultiImages, true) ?? [];
        }
        if (!is_array($existingMultiImages)) {
            $existingMultiImages = [];
        }

        // Upload Multi-Images Baru
        if ($request->hasFile('multi_images')) {
            foreach ($request->file('multi_images') as $file) {
                $originalName = $file->getClientOriginalName();
                $fileName = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs("{$folderPath}/gallery", $fileName, 'public');

                $existingMultiImages[] = $path;

                $publicUrl = asset('storage/' . $path);
                $encodedName = rawurlencode($originalName);
                $konten = str_replace(
                    ['src="' . $originalName . '"', 'src="' . $encodedName . '"', "src='" . $originalName . "'", "src='" . $encodedName . "'"],
                    'src="' . $publicUrl . '"',
                    $konten
                );
            }
        }

        $dataUpdate['multi_images'] = !empty($existingMultiImages) ? array_values($existingMultiImages) : null;
        $dataUpdate['konten'] = $konten;

        $wasRevisi = ($informasi->status === 'Revisi');
        $informasi->update($dataUpdate);

        $msg = 'Informasi resmi berhasil diperbarui!';
        if ($targetStatus === 'Pending') {
            $msg = $wasRevisi
                ? 'Revisi informasi resmi berhasil dikirim ulang ke Admin (Status: Pending, Komentar: TELAH DIREVISI)!'
                : 'Informasi resmi berhasil diajukan ke Admin (Status: Pending)!';
        } elseif ($targetStatus === 'Revisi' && $isAdmin) {
            $msg = 'Informasi resmi dikembalikan ke Humas untuk revisi beserta catatan revisi.';
        } elseif ($targetStatus === 'Terbit' && $isAdmin) {
            $msg = 'Informasi resmi berhasil disetujui dan diterbitkan!';
        }

        if ($isAdmin && ($request->input('from_page') === 'draft' || str_contains(url()->previous(), 'draft'))) {
            return redirect()->route('admin.berita.draft')->with('success', $msg);
        }

        return redirect()->route('admin.informasi.index')->with('success', $msg);
    }

    public function deleteImage(Request $request, $id)
    {
        $informasi = Berita::where('id_berita', $id)
                           ->where('kategori_publikasi', 'Informasi Resmi')
                           ->firstOrFail();

        $filePath = $request->input('file_path');

        $images = $informasi->multi_images;
        if (is_string($images)) {
            $images = json_decode($images, true) ?? [];
        }
        if (!is_array($images)) {
            $images = [];
        }

        $targetPath = str_replace('\\', '/', $filePath);
        $foundKey = null;

        foreach ($images as $key => $img) {
            if (str_replace('\\', '/', $img) === $targetPath) {
                $foundKey = $key;
                break;
            }
        }

        if ($foundKey !== null) {
            unset($images[$foundKey]);

            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            $remainingImages = array_values($images);
            $informasi->multi_images = !empty($remainingImages) ? $remainingImages : null;
            $informasi->save();

            return response()->json([
                'success' => true, 
                'message' => 'Gambar berhasil dihapus dari galeri!'
            ]);
        }

        return response()->json([
            'success' => false, 
            'message' => 'Gambar tidak ditemukan di basis data!'
        ], 404);
    }

    public function destroy($id)
    {
        $informasi = Berita::where('id_berita', $id)
                           ->where('kategori_publikasi', 'Informasi Resmi')
                           ->firstOrFail();

        $folderPath = "informasi/{$informasi->slug}";
        if (Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->deleteDirectory($folderPath);
        }

        $informasi->delete();

        return redirect()->route('admin.informasi.index')
                         ->with('success', 'Informasi resmi berhasil dihapus!');
    }

    public function draftIndex(Request $request)
    {
        $query = Berita::where('status', 'Draft');

        // Filter Pencarian
        if ($request->filled('search')) {
            $query->where('judul_berita', 'like', '%' . $request->search . '%');
        }

        // Urutan Data
        $sort = $request->input('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->oldest();
        } elseif ($sort === 'az') {
            $query->orderBy('judul_berita', 'asc');
        } else {
            $query->latest();
        }

        $drafts = $query->paginate(10);

        return view('admin.berita.draft', compact('drafts', 'sort'));
    }

    public function show($slug)
    {
        $informasi = Berita::where('slug', $slug)
                           ->where('kategori_publikasi', 'Informasi Resmi')
                           ->where('status', 'Terbit')
                           ->firstOrFail();

        // Data untuk Sidebar (5 informasi terbaru)
        $informasiTerbaru = Berita::where('kategori_publikasi', 'Informasi Resmi')
                                  ->where('status', 'Terbit')
                                  ->where('id_berita', '!=', $informasi->id_berita)
                                  ->latest()
                                  ->take(5)
                                  ->get();

        // Data untuk Seksi Bawah (3 kartu informasi lainnya)
        $informasiLainnya = Berita::where('kategori_publikasi', 'Informasi Resmi')
                                  ->where('status', 'Terbit')
                                  ->where('id_berita', '!=', $informasi->id_berita)
                                  ->latest()
                                  ->take(3)
                                  ->get();

        return view('informasi.show', compact('informasi', 'informasiTerbaru', 'informasiLainnya'));
    }
}