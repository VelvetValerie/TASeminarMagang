<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AdminBeritaController extends Controller
{
    /**
     * Menampilkan daftar semua berita di dashboard admin
     */
    public function index()
    {
        // Menampilkan semua berita (termasuk Draft)
        $berita = Berita::latest()->get();
        return view('admin.berita.index', compact('berita'));
    }

    /**
     * Menampilkan form tambah berita
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Menyimpan berita baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_berita' => 'required|string|max:255',
            'konten'       => 'required',
            'status'       => 'required|in:Terbit,Draft',
            'lampiran_url' => 'nullable|url',
        ]);

        // Membuat slug unik (judul + random string agar tidak bentrok)
        $slug = Str::slug($request->judul_berita) . '-' . Str::random(5);

        Berita::create([
            'judul_berita' => $request->judul_berita,
            'slug'         => $slug,
            'konten'       => $request->konten,
            'status'       => $request->status,
            'lampiran_url' => $request->lampiran_url,
            'id_penulis' => Auth::id(),
        ]);

        return redirect()->route('admin.berita.index')
                         ->with('success', 'Berita berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit berita
     */
    public function edit($slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();
        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Memperbarui data berita di database
     */
    public function update(Request $request, $slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();

        $request->validate([
            'judul_berita' => 'required|string|max:255',
            'konten'       => 'required',
            'status'       => 'required|in:Terbit,Draft',
            'lampiran_url' => 'nullable|url',
        ]);

        // Update data
        $berita->judul_berita = $request->judul_berita;
        $berita->konten = $request->konten;
        $berita->status = $request->status;
        $berita->lampiran_url = $request->lampiran_url;
        
        // Jika judul berubah, Anda bisa mengupdate slug atau membiarkannya tetap
        // $berita->slug = Str::slug($request->judul_berita) . '-' . Str::random(5);

        $berita->save();

        return redirect()->route('admin.berita.index')
                         ->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Menghapus berita
     */
    public function destroy($id)
    {
        // Sesuaikan parameter $id dengan primary key Anda (id atau id_berita)
        $berita = Berita::findOrFail($id);
        $berita->delete();

        return redirect()->route('admin.berita.index')
                         ->with('success', 'Berita berhasil dihapus!');
    }
}