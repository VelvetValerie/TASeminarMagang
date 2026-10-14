<?php

namespace App\Http\Controllers\Api\Public;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Http\Controllers\Controller;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        // Hanya ambil yang berkategori 'Berita'
        $query = Berita::where('kategori_publikasi', 'Berita')
                       ->where('status', 'Terbit')
                       ->latest();

        if ($request->has('q') && $request->q != '') {
            $keyword = $request->q;
            $query->where(function($q) use ($keyword) {
                $q->where('judul_berita', 'like', '%' . $keyword . '%')
                  ->orWhere('konten', 'like', '%' . $keyword . '%');
            });
        }

        $berita = $query->paginate(9)->withQueryString();

        return view('news', compact('berita'));
    }

    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)
                        ->where('kategori_publikasi', 'Berita')
                        ->where('status', 'Terbit')
                        ->firstOrFail();

        $beritaTerbaru = Berita::where('kategori_publikasi', 'Berita')
                               ->where('status', 'Terbit')
                               ->where('id_berita', '!=', $berita->id_berita ?? $berita->id)
                               ->latest()
                               ->take(5)
                               ->get();

        $beritaLainnya = Berita::where('kategori_publikasi', 'Berita')
                               ->where('status', 'Terbit')
                               ->where('id_berita', '!=', $berita->id_berita ?? $berita->id)
                               ->inRandomOrder()
                               ->take(3)
                               ->get();

        return view('news_detail', compact('berita', 'beritaTerbaru', 'beritaLainnya'));
    }
}