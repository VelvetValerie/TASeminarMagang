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
     * Menampilkan daftar semua berita di dashboard admin
     */
    public function index(Request $request)
    {
        $query = Berita::where('kategori_publikasi', 'Berita');

        // Pencarian
        if ($request->filled('search')) {
            $query->where('judul_berita', 'like', '%' . $request->search . '%');
        }

        // Urutan
        $sort = $request->input('sort', 'terbaru');
        if ($sort === 'terlama') {
            $query->oldest();
        } elseif ($sort === 'az') {
            $query->orderBy('judul_berita', 'asc');
        } else {
            $query->latest();
        }

        $berita = $query->paginate(10);
        return view('admin.berita.index', compact('berita', 'sort'));
    }

    /**
     * Menampilkan form tambah berita
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Menyimpan berita baru ke database beserta file thumbnail
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_berita' => 'required|string|max:255',
            'konten'       => 'required|string',
            'status'       => 'required|in:Terbit,Draft',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'lampiran_url' => 'nullable|url|max:255',
        ]);

        $slug = Str::slug($request->judul_berita) . '-' . Str::random(5);
        $thumbnailPath = null;

        // Proses Upload Thumbnail
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $konten = $request->konten;

        $folderPath = "berita/{$slug}";

        $multiImagesPaths = [];

        if ($request->hasFile('multi_images')) {
            foreach ($request->file('multi_images') as $file) {
                $originalName = $file->getClientOriginalName();
                $fileName = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs("{$folderPath}/gallery", $fileName, 'public');

                $multiImagesPaths[] = $path;

                $publicUrl = asset('storage/' . $path);
                $konten = str_replace($originalName, $publicUrl, $konten);
            }
        }

        Berita::create([
            'judul_berita' => $request->judul_berita,
            'slug'         => $slug,
            'konten'       => $request->konten,
            'status'       => $request->status,
            'thumbnail'    => $thumbnailPath,
            'caption_thumbnail'  => $request->caption_thumbnail,
            'multi_images'       => !empty($multiImagesPaths) ? array_values($multiImagesPaths) : null,
            'lampiran_url' => $request->lampiran_url,
            'id_penulis'   => Auth::id(),
        ]);

        return redirect()->route('admin.berita.index')
                         ->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit berita berdasarkan slug
     */
    public function edit($slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, $slug)
    {
        // 1. Cari data berita berdasarkan slug
        $berita = Berita::where('slug', $slug)->firstOrFail();

        // 2. Validasi input
        $request->validate([
            'judul_berita'   => 'required|string|max:255',
            'konten'         => 'required',
            'status'         => 'required|in:Draft,Terbit',
            'caption_thumbnail' => 'nullable|string|max:75', // Batas caption yang sudah kita sepakati
            'lampiran_url'   => 'nullable|url',
            // Thumbnail dibuat NULLABLE atau SOMETIMES (hanya divalidasi jika ada isinya)
            'thumbnail'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'multi_images.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $folderPath = "berita/{$berita->slug}";
        $konten = $request->konten;

        // 3. Siapkan data yang akan diupdate
        $dataUpdate = [
            'judul_berita'   => $request->judul_berita,
            'konten'         => $request->konten,
            'status'         => $request->status,
            'caption_thumbnail' => $request->caption_thumbnail,
            'lampiran_url'   => $request->lampiran_url,
        ];

        // 4. Cek apakah ada file thumbnail BARU yang diunggah
        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama dari storage JIKA ada (opsional tapi disarankan agar storage tidak penuh)
            if ($berita->thumbnail && \Illuminate\Support\Facades\Storage::disk('public')->exists($berita->thumbnail)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($berita->thumbnail);
            }

            // Simpan thumbnail baru dan masukkan path-nya ke array dataUpdate
            $path = $request->file('thumbnail')->store('berita_thumbnails', 'public');
            $dataUpdate['thumbnail'] = $path;
        }
        // JIKA TIDAK ADA file yang diunggah, key 'thumbnail' tidak dimasukkan ke $dataUpdate,
        // sehingga thumbnail lama di database tetap aman dan tidak tertimpa/hilang.

        $existingMultiImages = $berita->multi_images;
        if (is_string($existingMultiImages)) {
            $existingMultiImages = json_decode($existingMultiImages, true) ?? [];
        }
        if (!is_array($existingMultiImages)) {
            $existingMultiImages = [];
        }

        // 5. Lakukan update ke database
        // Upload Multi-Images Baru
        if ($request->hasFile('multi_images')) {
            foreach ($request->file('multi_images') as $file) {
                $originalName = $file->getClientOriginalName();
                $fileName = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs("{$folderPath}/gallery", $fileName, 'public');

                $existingMultiImages[] = $path;

                $publicUrl = asset('storage/' . $path);
                $konten = str_replace($originalName, $publicUrl, $konten);
            }
        }

        // Simpan sebagai array murni (dikarenakan Eloquent $casts = ['multi_images' => 'array'])
        $dataUpdate['multi_images'] = !empty($existingMultiImages) ? array_values($existingMultiImages) : null;
        $dataUpdate['konten'] = $konten;

        // 5. Lakukan update ke database
        $berita->update($dataUpdate);

        // 6. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Menghapus data berita berdasarkan ID atau primary key, termasuk file fisiknya
     */
    public function destroy($id)
    {
        $berita = Berita::where('id_berita', $id)->firstOrFail();

        $folderPath = "berita/{$berita->slug}";
        if (Storage::disk('public')->exists($folderPath)) {
            Storage::disk('public')->deleteDirectory($folderPath);
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')
                         ->with('success', 'Berita berhasil dihapus!');
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

    public function deleteImage(Request $request, $id)
    {
        $berita = Berita::where('id_berita', $id)
                           ->where('kategori_publikasi', 'Informasi Resmi')
                           ->firstOrFail();

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
}