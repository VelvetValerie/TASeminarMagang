@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-end border-b border-gray-200 pb-4 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pusat Informasi Resmi</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola data pengumuman, panduan, dan kebijakan resmi.</p>
    </div>
    <a href="{{ route('admin.informasi.create') }}" class="bg-blue-600 text-white font-medium px-4 py-2 rounded hover:bg-blue-700 transition shadow-sm text-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Informasi
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

<!-- FILTER STATUS PILLS -->
@php
    $activeStatus = $statusFilter ?? request('status', 'semua');
    $counts = $statusCounts ?? ['semua' => $informasi->total(), 'Terbit' => 0, 'Pending' => 0, 'Revisi' => 0, 'Draft' => 0];
    $statusPills = [
        'semua'   => ['label' => 'Semua', 'active' => 'bg-slate-800 text-white border-slate-800'],
        'Terbit'  => ['label' => 'Terbit', 'active' => 'bg-emerald-600 text-white border-emerald-600'],
        'Pending' => ['label' => 'Pending (Review)', 'active' => 'bg-amber-500 text-white border-amber-500'],
        'Revisi'  => ['label' => 'Revisi', 'active' => 'bg-rose-600 text-white border-rose-600'],
        'Draft'   => ['label' => 'Draft', 'active' => 'bg-gray-600 text-white border-gray-600'],
    ];
@endphp
<div class="flex flex-wrap items-center gap-2 mb-4">
    @foreach($statusPills as $key => $pill)
        <a href="{{ request()->fullUrlWithQuery(['status' => $key, 'page' => 1]) }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold border transition {{ $activeStatus === $key ? $pill['active'] : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
            <span>{{ $pill['label'] }}</span>
            <span class="px-1.5 py-0.5 text-[10px] rounded-full {{ $activeStatus === $key ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-700' }}">{{ $counts[$key] ?? 0 }}</span>
        </a>
    @endforeach
</div>

<!-- KOTAK PENCARIAN & FILTER -->
<div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-4 p-4 flex flex-wrap items-center justify-between gap-3">
    <h2 class="text-sm font-semibold text-gray-700">Daftar Informasi Resmi</h2>
    
    <div class="flex items-center space-x-2">
        <!-- Form Search -->
        <form id="searchInfoForm" method="GET" action="{{ route('admin.informasi.index') }}" class="m-0 p-0 flex items-center relative">
            @if(request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="flex items-center border border-gray-300 rounded overflow-hidden bg-gray-50 relative">
                <svg class="w-4 h-4 text-gray-500 ml-3 mr-2 shrink-0 cursor-pointer" onclick="document.getElementById('searchInfoForm').submit()" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul informasi..." 
                       class="bg-transparent text-sm p-2 w-48 sm:w-64 focus:outline-none text-gray-700">
                @if(request('search'))
                    <a href="{{ route('admin.informasi.index', array_filter(['sort' => request('sort'), 'status' => request('status')])) }}" class="absolute right-3 text-gray-400 hover:text-red-500 font-bold" title="Reset">✕</a>
                @endif
            </div>
        </form>

        <!-- Dropdown Filter -->
        <div class="relative">
            <button type="button" id="filterInfoBtn" class="border border-gray-300 bg-white p-2 rounded hover:bg-gray-50 transition cursor-pointer text-gray-600" title="Urutkan Data">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                </svg>
            </button>
            <div id="filterInfoMenu" class="hidden absolute right-0 top-full mt-2 w-40 border border-gray-200 bg-white shadow-lg rounded z-30 overflow-hidden">
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
                    <th class="p-4 font-semibold">Judul Informasi</th>
                    <th class="p-4 font-semibold text-center w-40">Status</th>
                    <th class="p-4 font-semibold text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($informasi as $index =>$item)
                @php
                    $isLockedHumas = (Auth::user()->role === 'pegawai_humas' && $item->status === 'Pending');
                    $badgeClass = match($item->status) {
                        'Terbit'  => 'bg-emerald-100 text-emerald-800 border border-emerald-200',
                        'Pending' => 'bg-amber-100 text-amber-800 border border-amber-300',
                        'Revisi'  => 'bg-rose-100 text-rose-800 border border-rose-300',
                        default   => 'bg-gray-100 text-gray-700 border border-gray-200',
                    };
                @endphp
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 text-center font-medium">{{ $informasi->firstItem() +$index }}</td>
                    <td class="p-4">
                        <div class="font-medium text-gray-900 flex flex-wrap items-center gap-2">
                            <span>{{ $item->judul_berita }}</span>
                            @if($item->komentar_revisi === 'TELAH DIREVISI')
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">TELAH DIREVISI</span>
                            @endif
                        </div>
                        @if($item->status === 'Revisi' && !empty($item->komentar_revisi) && $item->komentar_revisi !== 'TELAH DIREVISI')
                            <div class="mt-1.5 text-xs text-rose-700 bg-rose-50 border border-rose-200 rounded px-2.5 py-1.5">
                                <span class="font-bold">Catatan Revisi:</span> {{ \Illuminate\Support\Str::limit($item->komentar_revisi, 120) }}
                            </div>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        <span class="inline-block px-2.5 py-1 text-[11px] font-bold uppercase rounded-full {{ $badgeClass }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="p-4 text-center space-x-2 flex items-center justify-center">
                        @if($item->status == 'Terbit')
                            <a href="{{ route('informasi.show', $item->slug) }}" target="_blank" class="inline-flex text-gray-500 hover:text-green-600 transition" title="Lihat Halaman Publik">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        @else
                            <button type="button" disabled class="inline-flex text-gray-300 cursor-not-allowed" title="Belum Terbit ({{ $item->status }})">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        @endif

                        @if($isLockedHumas)
                            <a href="{{ route('admin.informasi.edit', $item->slug) }}" class="inline-flex text-amber-500 hover:text-amber-700 transition" title="Terkunci (Menunggu Review Admin) - Lihat Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </a>
                        @else
                            <a href="{{ route('admin.informasi.edit', $item->slug) }}" class="inline-flex text-blue-600 hover:text-blue-800 transition" title="{{ $item->status === 'Revisi' ? 'Perbaiki Revisi' : 'Edit' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                        @endif

                        @if(!$isLockedHumas)
                            <button onclick="openDeleteInfoModal('{{ $item->id_berita }}', '{{ addslashes($item->judul_berita) }}')" class="inline-flex text-red-500 hover:text-red-700 transition" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-8 text-center text-gray-500 text-sm">Data informasi tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($informasi->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50 text-sm">
        {{ $informasi->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection

@push('modals')
<div id="deleteInfoModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm">
    <div class="relative w-full max-w-sm bg-white rounded-lg shadow-xl p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Informasi</h3>
        <p class="text-sm text-gray-600 mb-6">Yakin ingin menghapus informasi <strong id="delete_info_text" class="text-gray-900"></strong>?</p>
        <form id="deleteInfoForm" method="POST" class="flex justify-end gap-3">
            @csrf @method('DELETE')
            <button type="button" onclick="closeDeleteInfoModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded hover:bg-gray-200 transition">Batal</button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700 transition">Ya, Hapus</button>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    document.getElementById('filterInfoBtn').addEventListener('click', function(e) {
        e.stopPropagation();
        document.getElementById('filterInfoMenu').classList.toggle('hidden');
    });
    document.addEventListener('click', function() {
        document.getElementById('filterInfoMenu').classList.add('hidden');
    });

    function openDeleteInfoModal(id, judul) {
        document.getElementById('delete_info_text').innerText = judul;
        document.getElementById('deleteInfoForm').action = `/admin/informasi/${id}`; 
        document.getElementById('deleteInfoModal').classList.remove('hidden');
    }
    function closeDeleteInfoModal() { document.getElementById('deleteInfoModal').classList.add('hidden'); }
</script>
@endpush