@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-end border-b border-gray-200 pb-4 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Berita</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola data publikasi berita untuk portal depan.</p>
    </div>
    <a href="{{ route('admin.berita.create') }}" class="bg-blue-600 text-white font-medium px-4 py-2 rounded hover:bg-blue-700 transition shadow-sm text-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Berita
    </a>
</div>

<!-- ALERT FEEDBACK NOTIFIKASI BERHASIL / GAGAL -->
@if (session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm font-semibold flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 font-bold ml-2">&times;</button>
    </div>
@endif

@if (session('error'))
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm font-semibold flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900 font-bold ml-2">&times;</button>
    </div>
@endif

<!-- KOTAK PENCARIAN & FILTER -->
<div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-4 p-4 flex flex-wrap items-center justify-between gap-3">
    <h2 class="text-sm font-semibold text-gray-700">Daftar Publikasi Berita</h2>
    
    <div class="flex items-center space-x-2">
        <!-- Form Search -->
        <form id="searchBeritaForm" method="GET" action="{{ route('admin.berita.index') }}" class="m-0 p-0 flex items-center relative">
            @if(request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
            <div class="flex items-center border border-gray-300 rounded overflow-hidden bg-gray-50 relative">
                <svg class="w-4 h-4 text-gray-500 ml-3 mr-2 shrink-0 cursor-pointer" onclick="document.getElementById('searchBeritaForm').submit()" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul berita..." 
                       class="bg-transparent text-sm p-2 w-48 sm:w-64 focus:outline-none text-gray-700">
                @if(request('search'))
                    <a href="{{ route('admin.berita.index') }}{{ request('sort') ? '?sort='.request('sort') : '' }}" class="absolute right-3 text-gray-400 hover:text-red-500 font-bold" title="Reset">✕</a>
                @endif
            </div>
        </form>

        <!-- Dropdown Filter -->
        <div class="relative">
            <button type="button" id="filterBeritaBtn" class="border border-gray-300 bg-white p-2 rounded hover:bg-gray-50 transition cursor-pointer text-gray-600" title="Urutkan Data">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                </svg>
            </button>
            <div id="filterBeritaMenu" class="hidden absolute right-0 top-full mt-2 w-40 border border-gray-200 bg-white shadow-lg rounded z-30 overflow-hidden">
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'terbaru', 'page' => 1]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 {{ ($sort ?? 'terbaru') === 'terbaru' ? 'bg-blue-50 font-bold' : '' }}">Terbaru</a>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'terlama', 'page' => 1]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 {{ ($sort ?? '') === 'terlama' ? 'bg-blue-50 font-bold' : '' }}">Terlama</a>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'az', 'page' => 1]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 {{ ($sort ?? '') === 'az' ? 'bg-blue-50 font-bold' : '' }}">A - Z</a>
            </div>
        </div>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-700 border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-600">
                <tr>
                    <th class="p-4 font-semibold text-center w-16">No</th>
                    <th class="p-4 font-semibold">Judul Berita</th>
                    <th class="p-4 font-semibold text-center w-32">Status</th>
                    <th class="p-4 font-semibold text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($berita as $index =>$item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 text-center font-medium">{{ $berita->firstItem() +$index }}</td>
                    <td class="p-4 font-medium text-gray-900">{{ $item->judul_berita }}</td>
                    <td class="p-4 text-center">
                        <span class="inline-block px-2.5 py-1 text-[11px] font-bold uppercase rounded-full {{ $item->status == 'Terbit' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="p-4 text-center space-x-2 flex items-center justify-center">
                        @if($item->status == 'Terbit')
                            <a href="{{ route('berita.show', $item->slug) }}" target="_blank" class="inline-flex text-gray-500 hover:text-green-600 transition" title="Lihat Halaman Publik">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        @else
                            <button type="button" disabled class="inline-flex text-gray-300 cursor-not-allowed" title="Belum Terbit (Draft)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        @endif

                        <a href="{{ route('admin.berita.edit', $item->slug) }}" class="inline-flex text-blue-600 hover:text-blue-800 transition" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>

                        <button onclick="openDeleteBeritaModal('{{ $item->id_berita }}', '{{ addslashes($item->judul_berita) }}')" class="inline-flex text-red-500 hover:text-red-700 transition" title="Hapus">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-8 text-center text-gray-500 text-sm">Data berita tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($berita->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50 text-sm">
        {{ $berita->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection

@push('modals')
<div id="deleteBeritaModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm">
    <div class="relative w-full max-w-sm bg-white rounded-lg shadow-xl p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Berita</h3>
        <p class="text-sm text-gray-600 mb-6">Yakin ingin menghapus berita <strong id="delete_berita_text" class="text-gray-900"></strong>?</p>
        <form id="deleteBeritaForm" method="POST" class="flex justify-end gap-3">
            @csrf @method('DELETE')
            <button type="button" onclick="closeDeleteBeritaModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded hover:bg-gray-200 transition">Batal</button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700 transition">Ya, Hapus</button>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    document.getElementById('filterBeritaBtn').addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('filterBeritaMenu').classList.toggle('hidden');
    });
    document.addEventListener('click', function() {
        document.getElementById('filterBeritaMenu').classList.add('hidden');
    });

    function openDeleteBeritaModal(id, judul) {
        document.getElementById('delete_berita_text').innerText = judul;
        document.getElementById('deleteBeritaForm').action = `/admin/berita/${id}`; 
        document.getElementById('deleteBeritaModal').classList.remove('hidden');
    }
    function closeDeleteBeritaModal() { document.getElementById('deleteBeritaModal').classList.add('hidden'); }
</script>
@endpush