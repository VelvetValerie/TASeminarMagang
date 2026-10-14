@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-end border-b-2 border-black pb-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Informasi</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola publikasi berita, pengumuman, dan edaran untuk publik.</p>
    </div>
    <a href="{{ route('admin.berita.create') }}" class="border-2 border-black bg-amber-400 text-black font-bold px-4 py-2 hover:bg-amber-500 transition shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
        + Tambah Berita
    </a>
</div>

<!-- KOTAK UTAMA -->
<div class="bg-white border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
    <table class="w-full text-left text-sm text-gray-900 border-collapse">
        <thead class="bg-gray-200 border-b-2 border-black">
            <tr>
                <th class="p-4 border-r-2 border-black font-bold">Judul Berita</th>
                <th class="p-4 border-r-2 border-black font-bold text-center">Status</th>
                <th class="p-4 border-r-2 border-black font-bold">Tanggal Dibuat</th>
                <th class="p-4 font-bold text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y-2 divide-black">
            <!-- Penambahan spasi yang benar -->
            @forelse ($berita as $item)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-4 border-r-2 border-black">
                    <p class="font-bold text-gray-900">{{ $item->judul_berita }}</p>
                    @if($item->status === 'Terbit')
                        <a href="{{ route('berita.show', $item->slug) }}" target="_blank" class="text-xs font-semibold text-blue-600 hover:underline">Lihat di portal ↗</a>
                    @else
                        <span class="text-xs text-gray-500 italic">Pratinjau tersedia di menu Edit</span>
                    @endif
                </td>
                <td class="p-4 border-r-2 border-black text-center">
                    <span class="px-2 py-1 text-[11px] font-extrabold uppercase border border-black {{ $item->status == 'Terbit' ? 'bg-green-400' : 'bg-gray-300' }}">
                        {{ $item->status }}
                    </span>
                </td>
                <td class="p-4 border-r-2 border-black">
                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                </td>
                <td class="p-4 text-center space-x-2">
                    <a href="{{ route('admin.berita.edit', $item->slug) }}" class="inline-block border-2 border-black bg-blue-400 px-3 py-1 font-bold text-xs hover:bg-blue-500">Edit</a>
                    <button type="button" onclick="openDeleteBeritaModal('{{ $item->id ?? $item->id_berita }}', '{{ addslashes($item->judul_berita) }}')" class="border-2 border-black bg-red-400 px-3 py-1 font-bold text-xs hover:bg-red-500 cursor-pointer">
                        Hapus
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="p-6 text-center text-gray-500 font-semibold">Belum ada berita yang ditulis.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection