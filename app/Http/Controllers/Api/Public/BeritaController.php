<?php

namespace App\Http\Controllers\Api\Public;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Http\Controllers\Controller;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::where('status', 'Terbit')->latest();

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
                        ->where('status', 'Terbit')
                        ->firstOrFail();

        // Mengambil 5 berita terbaru untuk sidebar
        $beritaTerbaru = Berita::where('status', 'Terbit')
                               ->where('id_berita', '!=', $berita->id_berita ?? $berita->id)
                               ->latest()
                               ->take(5)
                               ->get();

        // Mengambil 3 berita lainnya untuk section bawah
        $beritaLainnya = Berita::where('status', 'Terbit')
                               ->where('id_berita', '!=', $berita->id_berita ?? $berita->id)
                               ->inRandomOrder() // Diacak agar lebih variatif, atau ganti latest()
                               ->take(3)
                               ->get();

        return view('news_detail', compact('berita', 'beritaTerbaru', 'beritaLainnya'));
    }
}