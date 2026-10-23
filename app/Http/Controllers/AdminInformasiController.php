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
    /**
     * Menampilkan daftar semua informasi resmi di dashboard admin
     */
    public function index(Request $request)
    {
        $query = Berita::where('kategori_publikasi', 'Informasi Resmi');

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

        $informasi = $query->paginate(10);
        return view('admin.informasi.index', compact('informasi', 'sort'));
    }

    /**
     * Menampilkan form tambah informasi
     */
    public function create()
    {
        return view('admin.informasi.create');
    }

    /**
     * Menyimpan informasi baru ke database beserta file thumbnail
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
            $thumbnailPath = $request->file('thumbnail')->store('informasi_thumbnails', 'public');
        }

        $konten = $request->konten;

        $folderPath = "informasi/{$slug}";

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
            'judul_berita'       => $request->judul_berita,
            'slug'               => $slug,
            'konten'             => $request->konten,
            'status'             => $request->status,
            'thumbnail'          => $thumbnailPath,
            'caption_thumbnail'  => $request->caption_thumbnail,
            'lampiran_url'       => $request->lampiran_url,
            'multi_images'       => !empty($multiImagesPaths) ? array_values($multiImagesPaths) : null,
            'id_penulis'         => Auth::id(),
            'kategori_publikasi' => 'Informasi Resmi', // Set paten untuk controller ini
        ]);

        return redirect()->route('admin.informasi.index')
                         ->with('success', 'Informasi resmi berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit informasi berdasarkan slug
     */
    public function edit($slug)
    {
        $informasi = Berita::where('slug', $slug)
                           ->where('kategori_publikasi', 'Informasi Resmi')
                           ->firstOrFail();
                           
        return view('admin.informasi.edit', compact('informasi'));
    }

    /**
     * Memperbarui data informasi resmi
     */
    public function update(Request $request, $slug)
    {
        // 1. Cari data berdasarkan slug
        $informasi = Berita::where('slug', $slug)
                           ->where('kategori_publikasi', 'Informasi Resmi')
                           ->firstOrFail();

        // 2. Validasi input
        $request->validate([
            'judul_berita'      => 'required|string|max:255',
            'konten'            => 'required',
            'status'            => 'required|in:Draft,Terbit',
            'caption_thumbnail' => 'nullable|string|max:75',
            'lampiran_url'      => 'nullable|url',
            'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'multi_images.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $folderPath = "informasi/{$informasi->slug}";
        $konten = $request->konten;

        // 3. Siapkan data yang akan diupdate
        $dataUpdate = [
            'judul_berita'      => $request->judul_berita,
            'konten'            => $request->konten,
            'status'            => $request->status,
            'caption_thumbnail' => $request->caption_thumbnail,
            'lampiran_url'      => $request->lampiran_url,
        ];

        // 4. Cek apakah ada file thumbnail BARU yang diunggah
        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama dari storage JIKA ada
            if ($informasi->thumbnail && Storage::disk('public')->exists($informasi->thumbnail)) {
                Storage::disk('public')->delete($informasi->thumbnail);
            }

            // Simpan thumbnail baru
            $path = $request->file('thumbnail')->store('informasi_thumbnails', 'public');
            $dataUpdate['thumbnail'] = $path;
        }

        $existingMultiImages = $informasi->multi_images;
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
        $informasi->update($dataUpdate);

        // 6. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.informasi.index')
                         ->with('success', 'Informasi resmi berhasil diperbarui!');
    }

    /**
     * Menghapus data informasi berdasarkan ID, termasuk file fisiknya
     */
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
}