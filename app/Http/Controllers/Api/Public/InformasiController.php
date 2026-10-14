<?php

namespace App\Http\Controllers\Api\Public;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Http\Controllers\Controller;

class InformasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::where('kategori_publikasi', 'Informasi Resmi')
                       ->where('status', 'Terbit')
                       ->latest();

        // Fallback pencarian server-side (meskipun pencarian utama menggunakan JS di view)
        if ($request->has('q') && $request->q != '') {
            $keyword = $request->q;
            $query->where(function($q) use ($keyword) {
                $q->where('judul_berita', 'like', '%' . $keyword . '%')
                  ->orWhere('konten', 'like', '%' . $keyword . '%');
            });
        }

        // Menggunakan get() karena data digabungkan (merge) dengan data hardcode (Timeline)
        // dan dipaginasi menggunakan JavaScript di information.blade.php
        $informasiDB = $query->get();

        return view('information', compact('informasiDB'));
    }

    public function show($slug)
    {
        // 1. Ambil data utama berdasarkan slug
        $informasi = Berita::where('slug', $slug)
                           ->where('kategori_publikasi', 'Informasi Resmi')
                           ->where('status', 'Terbit')
                           ->firstOrFail();

        // 2. Ambil 5 informasi terbaru untuk sidebar (Mengecualikan informasi yang sedang dibaca)
        $informasiTerbaru = Berita::where('kategori_publikasi', 'Informasi Resmi')
                                  ->where('status', 'Terbit')
                                  ->where('id_berita', '!=', $informasi->id_berita ?? $informasi->id)
                                  ->latest()
                                  ->take(5)
                                  ->get();

        // 3. Ambil 3 informasi lainnya (Acak/Terbaru) untuk bagian rekomendasi bawah
        $informasiLainnya = Berita::where('kategori_publikasi', 'Informasi Resmi')
                                  ->where('status', 'Terbit')
                                  ->where('id_berita', '!=', $informasi->id_berita ?? $informasi->id)
                                  ->inRandomOrder()
                                  ->take(3)
                                  ->get();

        return view('information_detail', compact('informasi', 'informasiTerbaru', 'informasiLainnya'));
    }
}