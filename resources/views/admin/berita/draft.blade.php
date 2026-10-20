@extends('layouts.app')

@section('title', 'Peninjauan Draft Publikasi - Kanreg VIII BKN')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-7xl space-y-6">

    <!-- HEADER LAMAN -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b-2 border-black pb-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 uppercase tracking-tight">
                Peninjauan Draft Publikasi
            </h1>
            <p class="text-xs sm:text-sm font-semibold text-gray-600">
                Laman khusus Administrator untuk memeriksa, menyetujui, dan menerbitkan konten berita & informasi dari Pegawai Humas
            </p>
        </div>
    </div>

    <!-- NOTIFIKASI SUKSES / ERROR -->
    @if(session('success'))
        <div class="border-2 border-black bg-emerald-100 p-3 text-xs font-bold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- KOTAK UTAMA -->
    <div class="border-2 border-black bg-white p-4 md:p-6 relative shadow-sm space-y-4">

        <!-- KONTROL PENCARIAN & URUTAN -->
        <form method="GET" action="{{ route('admin.berita.draft') }}" class="flex flex-wrap items-center justify-between gap-4 pb-4 border-b-2 border-black">
            <div class="w-full sm:w-80">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul draft berita / informasi..." 
                       class="w-full border-2 border-black px-3 py-1.5 text-xs sm:text-sm font-semibold focus:outline-none bg-gray-50 focus:bg-white">
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs font-bold uppercase text-gray-700">Urutkan:</span>
                <select name="sort" onchange="this.form.submit()" class="border-2 border-black px-3 py-1.5 text-xs sm:text-sm font-bold bg-white focus:outline-none">
                    <option value="terbaru" {{ ($sort ?? '') == 'terbaru' ? 'selected' : '' }}>Terbaru Dibuat</option>
                    <option value="terlama" {{ ($sort ?? '') == 'terlama' ? 'selected' : '' }}>Terlama Dibuat</option>
                    <option value="az" {{ ($sort ?? '') == 'az' ? 'selected' : '' }}>Judul A - Z</option>
                </select>
            </div>
        </form>

        <!-- TABEL DAFTAR DRAFT -->
        <div class="border-2 border-black overflow-x-auto">
            <table class="w-full border-collapse border-black min-w-[700px] text-left">
                <thead>
                    <tr class="border-b-2 border-black bg-gray-100 font-bold text-xs uppercase tracking-wider text-gray-900">
                        <th class="border-r-2 border-black p-3 text-center w-12">No</th>
                        <th class="border-r-2 border-black p-3">Judul Draf Konten</th>
                        <th class="border-r-2 border-black p-3 text-center w-40">Kategori Publikasi</th>
                        <th class="border-r-2 border-black p-3 text-center w-32">Status</th>
                        <th class="p-3 text-center w-44">Tindakan Persetujuan</th>
                    </tr>
                </thead>
                <tbody class="text-xs sm:text-sm font-semibold divide-y-2 divide-black">
                    <?php if (count($drafts) > 0): ?>
                        <?php for ($i = 0; $i < count($drafts); $i++): ?>
                            <?php $item = $drafts[$i]; ?>
                            <tr class="border-b-2 border-black hover:bg-amber-50/50 transition">
                                <td class="border-r-2 border-black p-3 text-center font-bold text-gray-600">
                                    {{ $i + 1 }}
                                </td>
                                <td class="border-r-2 border-black p-3">
                                    <div class="font-black text-gray-900 text-sm sm:text-base leading-snug">
                                        {{ $item->judul_berita }}
                                    </div>
                                    <div class="text-xs text-gray-500 font-medium mt-1 flex items-center gap-2">
                                        <span>📅 Dibuat: <b>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }} WITA</b></span>
                                    </div>
                                </td>
                                <td class="border-r-2 border-black p-3 text-center">
                                    <?php if (($item->kategori_publikasi ?? 'Berita') === 'Informasi Resmi'): ?>
                                        <span class="inline-block border-2 border-black bg-sky-200 text-sky-950 px-2.5 py-0.5 text-[11px] font-black uppercase rounded-full">
                                            Informasi Resmi
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-block border-2 border-black bg-slate-200 text-slate-900 px-2.5 py-0.5 text-[11px] font-black uppercase rounded-full">
                                            Berita
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="border-r-2 border-black p-3 text-center">
                                    <span class="inline-block border-2 border-black bg-amber-200 text-amber-950 px-2.5 py-0.5 text-[11px] font-black uppercase rounded-full">
                                        Menunggu Review
                                    </span>
                                </td>
                                <td class="p-3 text-center">
                                    <?php if (($item->kategori_publikasi ?? 'Berita') === 'Informasi Resmi'): ?>
                                        <a href="{{ route('admin.informasi.edit', $item->slug) }}" 
                                           class="inline-flex items-center gap-1.5 border-2 border-black bg-amber-400 hover:bg-amber-500 text-black font-extrabold px-3 py-1.5 text-xs uppercase transition cursor-pointer shadow-xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            <span>Tinjau & Terbitkan</span>
                                        </a>
                                    <?php else: ?>
                                        <a href="{{ route('admin.berita.edit', $item->slug) }}" 
                                           class="inline-flex items-center gap-1.5 border-2 border-black bg-amber-400 hover:bg-amber-500 text-black font-extrabold px-3 py-1.5 text-xs uppercase transition cursor-pointer shadow-xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            <span>Tinjau & Terbitkan</span>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500 font-bold">
                                🎉 Tidak ada draft berita atau informasi resmi yang perlu ditinjau saat ini.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINASI -->
        <div class="pt-2">
            {{ $drafts->links() }}
        </div>

    </div>
</div>
@endsection