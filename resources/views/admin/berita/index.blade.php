@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-end border-b-2 border-black pb-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Informasi</h1>
        <p class="text-sm text-gray-600 mt-1">Kelola publikasi berita, pengumuman, dan edaran untuk publik.</p>
    </div>
    <a href="{{ route('admin.berita.create') }}" class="border-2 border-black bg-amber-400 text-black font-bold px-4 py-2 hover:bg-amber-500 transition">
        + Tambah Berita
    </a>
</div>

<!-- KOTAK UTAMA -->
<div class="bg-white border-2 border-black overflow-hidden">
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
            <!-- Perbaikan: Menambahkan spasi pada directive forelse -->
            @forelse ($berita as $item)
            <tr class="hover:bg-gray-50 transition">
                <td class="p-4 border-r-2 border-black">
                    <p class="font-bold text-gray-900">{{ $item->judul_berita }}</p>
                    <a href="{{ route('berita.show', $item->slug) }}" target="_blank" class="text-xs text-blue-600 hover:underline">Lihat di portal ↗</a>
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
                    <!-- Tombol Hapus memicu Modal -->
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

@endsection <!-- Tutup section content di sini -->

<!-- Dorong modal ke luar struktur layout agar fullscreen sempurna -->
@push('modals')
<!-- ================= MODAL HAPUS BERITA ================= -->
<div id="deleteBeritaModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
    <div class="relative w-full max-w-md bg-white border-2 border-black p-6 shadow-2xl space-y-4">
        <!-- (Isi form modal tetap sama seperti sebelumnya) -->
        <div class="border-b-2 border-black pb-2">
            <h3 class="text-base sm:text-lg font-black uppercase text-rose-600">
                Konfirmasi Hapus Berita
            </h3>
        </div>
        <p class="text-xs sm:text-sm font-semibold text-gray-800">
            Apakah Anda yakin ingin menghapus berita <strong id="delete_berita_text" class="text-black"></strong>? Tindakan ini tidak dapat dibatalkan.
        </p>
        <form id="deleteBeritaForm" method="POST" action="" class="flex justify-end gap-2 border-t-2 border-black pt-4">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteBeritaModal()" class="border-2 border-black bg-gray-200 hover:bg-gray-300 font-bold px-4 py-1.5 text-xs uppercase cursor-pointer">
                Batal
            </button>
            <button type="submit" class="border-2 border-black bg-rose-600 hover:bg-rose-700 text-white font-bold px-4 py-1.5 text-xs uppercase cursor-pointer">
                Ya, Hapus
            </button>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function openDeleteBeritaModal(id, judul) {
        document.getElementById('delete_berita_text').innerText = judul;
        document.getElementById('deleteBeritaForm').action = `/admin/berita/${id}`; 
        document.getElementById('deleteBeritaModal').classList.remove('hidden');
    }

    function closeDeleteBeritaModal() {
        document.getElementById('deleteBeritaModal').classList.add('hidden');
    }
</script>
@endpush