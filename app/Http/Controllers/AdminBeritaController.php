<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminBeritaController extends Controller
{
    public function __construct()
    {
        // Jika user belum login atau role-nya bukan admin/pegawai_humas, langsung hentikan akses (403 Forbidden)
        if (Auth::check() && !in_array(Auth::user()->role, ['admin', 'pegawai_humas'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
        }
    }

    /**
     * Menampilkan daftar publikasi untuk peninjauan Admin (Tab utama: Pending, serta Revisi & Draft)
     */
    public function draftIndex(Request $request)
    {
        $tab = $request->input('tab', 'Pending');
        $allowedTabs = ['Pending', 'Revisi', 'Draft', 'Semua'];
        if (!in_array($tab, $allowedTabs)) {
            $tab = 'Pending';
        }

        $query = Berita::with('penulis');

        if ($tab === 'Semua') {
            $query->whereIn('status', ['Pending', 'Revisi', 'Draft']);
        } else {
            $query->where('status', $tab);
        }

        if ($request->filled('search')) {
            $query->where('judul_berita', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori') && in_array($request->kategori, ['Berita', 'Informasi Resmi'])) {
            $query->where('kategori_publikasi', $request->kategori);
        }

        $sort = $request->input('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->oldest();
        } elseif ($sort === 'az') {
            $query->orderBy('judul_berita', 'asc');
        } else {
            $query->latest('updated_at');
        }

        $drafts = $query->paginate(10);

        $countPending = Berita::where('status', 'Pending')->count();
        $countRevisi  = Berita::where('status', 'Revisi')->count();
        $countDraft   = Berita::where('status', 'Draft')->count();

        return view('admin.berita.draft', compact('drafts', 'sort', 'tab', 'countPending', 'countRevisi', 'countDraft'));
    }

    /**
     * Admin menyetujui & menerbitkan publikasi (Berita / Informasi Resmi)
     */
    public function approve($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya Admin yang dapat menyetujui publikasi.');
        }

        $item = Berita::where('id_berita', $id)->firstOrFail();

        $updateData = ['status' => 'Terbit'];
        if (!empty($item->komentar_revisi) && $item->komentar_revisi !== 'TELAH DIREVISI') {
            $updateData['komentar_revisi'] = 'TELAH DIREVISI';
        }

        $item->update($updateData);

        return redirect()->back()
                         ->with('success', "Publikasi \"{$item->judul_berita}\" berhasil disetujui dan diterbitkan!");
    }

    /**
     * Admin menolak & mengembalikan publikasi untuk revisi beserta alasan (komentar_revisi)
     */
    public function reject(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya Admin yang dapat menolak publikasi.');
        }

        $request->validate([
            'komentar_revisi' => 'required|string|min:3|max:2000',
        ], [
            'komentar_revisi.required' => 'Alasan revisi wajib diisi saat mengembalikan publikasi.',
            'komentar_revisi.min'      => 'Alasan revisi minimal 3 karakter.',
        ]);

        $item = Berita::where('id_berita', $id)->firstOrFail();
        $item->update([
            'status'          => 'Revisi',
            'komentar_revisi' => trim($request->komentar_revisi),
        ]);

        return redirect()->back()
                         ->with('success', "Publikasi \"{$item->judul_berita}\" dikembalikan ke Humas untuk revisi.");
    }
    
    public function index(Request $request)
    {
        $query = Berita::with('penulis')->where('kategori_publikasi', 'Berita');

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

        $berita = $query->paginate(10);

        $statusCounts = [
            'semua'   => Berita::where('kategori_publikasi', 'Berita')->count(),
            'Terbit'  => Berita::where('kategori_publikasi', 'Berita')->where('status', 'Terbit')->count(),
            'Pending' => Berita::where('kategori_publikasi', 'Berita')->where('status', 'Pending')->count(),
            'Revisi'  => Berita::where('kategori_publikasi', 'Berita')->where('status', 'Revisi')->count(),
            'Draft'   => Berita::where('kategori_publikasi', 'Berita')->where('status', 'Draft')->count(),
        ];

        return view('admin.berita.index', compact('berita', 'sort', 'statusFilter', 'statusCounts'));
    }

    public function create()
    {
        return view('admin.berita.create');
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

        // Pegawai Humas hanya boleh menyimpan Draft atau mengajukan Pending
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
        $folderPath = "berita/{$slug}";

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
            'judul_berita'      => $request->judul_berita,
            'slug'              => $slug,
            'kategori_publikasi'=> 'Berita',
            'konten'            => $konten,
            'status'            => $targetStatus,
            'thumbnail'         => $thumbnailPath,
            'caption_thumbnail' => $request->caption_thumbnail,
            'lampiran_url'      => $request->lampiran_url,
            'multi_images'      => !empty($multiImagesPaths) ? array_values($multiImagesPaths) : null,
            'komentar_revisi'   => null,
            'id_penulis'        => Auth::id(),
        ]);

        $msg = $targetStatus === 'Pending'
            ? 'Berita berhasil diajukan (Pending) dan menunggu peninjauan Admin!'
            : ($targetStatus === 'Terbit' ? 'Berita berhasil diterbitkan!' : 'Berita berhasil disimpan sebagai Draft!');

        return redirect()->route('admin.berita.index')->with('success', $msg);
    }

    public function edit($slug)
    {
        $berita = Berita::with('penulis')
                        ->where('slug', $slug)
                        ->where('kategori_publikasi', 'Berita')
                        ->firstOrFail();

        $isLockedForHumas = (Auth::user()->role === 'pegawai_humas' && $berita->status === 'Pending');

        return view('admin.berita.edit', compact('berita', 'isLockedForHumas'));
    }

    public function update(Request $request, $slug)
    {
        $berita = Berita::where('slug', $slug)
                        ->where('kategori_publikasi', 'Berita')
                        ->firstOrFail();

        $isAdmin = Auth::user()->role === 'admin';

        // Kunci edit bagi Pegawai Humas saat status sedang Pending (menunggu review Admin)
        if (!$isAdmin && $berita->status === 'Pending') {
            return redirect()->route('admin.berita.edit', $berita->slug)
                             ->with('error', 'Publikasi sedang menunggu peninjauan (Pending) oleh Admin dan tidak dapat diubah hingga peninjauan selesai.');
        }

        $actionType = $request->input('action_type');
        $targetStatus = $request->input('status', $berita->status);

        if ($actionType === 'submit_review') {
            $targetStatus = 'Pending';
        } elseif ($actionType === 'save_draft') {
            $targetStatus = $berita->status === 'Revisi' ? 'Revisi' : 'Draft';
        } elseif ($actionType === 'approve_publish' && $isAdmin) {
            $targetStatus = 'Terbit';
        } elseif ($actionType === 'reject_revisi' && $isAdmin) {
            $targetStatus = 'Revisi';
        }

        // Batasan role untuk Pegawai Humas
        if (!$isAdmin) {
            if ($berita->status === 'Terbit') {
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

        $folderPath = "berita/{$berita->slug}";
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
        } elseif ($berita->status === 'Revisi' && in_array($targetStatus, ['Pending', 'Terbit'])) {
            $dataUpdate['komentar_revisi'] = 'TELAH DIREVISI';
        }

        // Update Thumbnail jika ada file baru
        if ($request->hasFile('thumbnail')) {
            if ($berita->thumbnail && Storage::disk('public')->exists($berita->thumbnail)) {
                Storage::disk('public')->delete($berita->thumbnail);
            }
            $dataUpdate['thumbnail'] = $request->file('thumbnail')->store($folderPath, 'public');
        }

        // Ambil array galeri
        $existingMultiImages = $berita->multi_images;
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

        $wasRevisi = ($berita->status === 'Revisi');
        $berita->update($dataUpdate);

        $msg = 'Berita berhasil diperbarui!';
        if ($targetStatus === 'Pending') {
            $msg = $wasRevisi
                ? 'Revisi berita berhasil dikirim ulang ke Admin (Status: Pending, Komentar: TELAH DIREVISI)!'
                : 'Berita berhasil diajukan ke Admin (Status: Pending)!';
        } elseif ($targetStatus === 'Revisi' && $isAdmin) {
            $msg = 'Berita dikembalikan ke Humas untuk revisi beserta catatan revisi.';
        } elseif ($targetStatus === 'Terbit' && $isAdmin) {
            $msg = 'Berita berhasil disetujui dan diterbitkan!';
        }

        if ($isAdmin && ($request->input('from_page') === 'draft' || str_contains(url()->previous(), 'draft'))) {
            return redirect()->route('admin.berita.draft')->with('success', $msg);
        }

        return redirect()->route('admin.berita.index')->with('success', $msg);
    }

    public function deleteImage(Request $request, $id)
    {
        $berita = Berita::where('id_berita', $id)->firstOrFail();
        $filePath = $request->input('file_path');

        $images = $berita->multi_images;
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
            $berita->multi_images = !empty($remainingImages) ? $remainingImages : null;
            $berita->save();

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
        $berita = Berita::where('id_berita', $id)->firstOrFail();

        $folderPath = "berita/{$berita->slug}";
        if (Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->deleteDirectory($folderPath);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}