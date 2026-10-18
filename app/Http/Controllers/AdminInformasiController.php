<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminInformasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::where('kategori_publikasi', 'Informasi Resmi');

        if ($request->filled('search')) {
            $query->where('judul_berita', 'like', '%' . $request->search . '%');
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
        return view('admin.informasi.index', compact('informasi', 'sort'));
    }

    public function create()
    {
        return view('admin.informasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_berita'      => 'required|string|max:255',
            'konten'            => 'required|string',
            'status'            => 'required|in:Terbit,Draft',
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
                $konten = str_replace($originalName, $publicUrl, $konten);
            }
        }

        // Karena Model menggunakan $casts array, kirimkan array murni (bukan json_encode)
        Berita::create([
            'judul_berita'       => $request->judul_berita,
            'slug'               => $slug,
            'kategori_publikasi' => 'Informasi Resmi',
            'konten'             => $konten,
            'status'             => $request->status,
            'thumbnail'          => $thumbnailPath,
            'caption_thumbnail'  => $request->caption_thumbnail,
            'lampiran_url'       => $request->lampiran_url,
            'multi_images'       => !empty($multiImagesPaths) ? array_values($multiImagesPaths) : null,
            'id_penulis'         => Auth::id(),
        ]);

        return redirect()->route('admin.informasi.index')
                         ->with('success', 'Informasi resmi berhasil ditambahkan!');
    }

    public function edit($slug)
    {
        $informasi = Berita::where('slug', $slug)
                           ->where('kategori_publikasi', 'Informasi Resmi')
                           ->firstOrFail();

        return view('admin.informasi.edit', compact('informasi'));
    }

    public function update(Request $request, $slug)
    {
        $informasi = Berita::where('slug', $slug)
                           ->where('kategori_publikasi', 'Informasi Resmi')
                           ->firstOrFail();

        $request->validate([
            'judul_berita'      => 'required|string|max:255',
            'konten'            => 'required|string',
            'status'            => 'required|in:Draft,Terbit',
            'caption_thumbnail' => 'nullable|string|max:150',
            'lampiran_url'      => 'nullable|url',
            'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240', 
            'multi_images.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $folderPath = "informasi/{$informasi->slug}";
        $konten = $request->konten;

        $dataUpdate = [
            'judul_berita'      => $request->judul_berita,
            'status'            => $request->status,
            'caption_thumbnail' => $request->caption_thumbnail,
            'lampiran_url'      => $request->lampiran_url,
        ];

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
                $konten = str_replace($originalName, $publicUrl, $konten);
            }
        }

        // Simpan sebagai array murni (dikarenakan Eloquent $casts = ['multi_images' => 'array'])
        $dataUpdate['multi_images'] = !empty($existingMultiImages) ? array_values($existingMultiImages) : null;
        $dataUpdate['konten'] = $konten;

        $informasi->update($dataUpdate);

        return redirect()->route('admin.informasi.index')
                         ->with('success', 'Informasi resmi berhasil diperbarui!');
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