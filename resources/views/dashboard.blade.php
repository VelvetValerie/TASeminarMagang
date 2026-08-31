@extends('layouts.app')

<title>Kantor Regional BKN - Dashboard</title>

@section('sidebar-header')
    <div class="border-2 border-black bg-white p-2.5 text-center font-bold text-gray-900">
        Kantor Regional BKN
    </div>
@endsection

@section('sidebar-menu')
    <div class="space-y-4">
        <!-- Grup 1: Menu Utama -->
        <div class="space-y-2">
            <a href="{{ url('/dashboard') }}" class="block border-2 border-black bg-gray-500 text-white font-semibold py-2 px-4 text-center hover:bg-gray-600 transition">
                Menu Dasboardd
            </a>
            <a href="{{ url('/kalender') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Kalender
            </a>
        </div>

        <!-- Grup 2: Operasional -->
        <div class="space-y-2 pt-2">
            <a href="#" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Kegiatan
            </a>
            <a href="#" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Rekam Kerja
            </a>
        </div>

        <!-- Grup 3: Master Data & Dropdown -->
        <div class="space-y-2 pt-2">
            <a href="#" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center text-sm hover:bg-gray-100 transition">
                Jenis Kegiatan
            </a>
            <a href="{{ url('/titik-lokasi') }}" 
            class="block py-2 px-4 text-center text-sm font-semibold transition {{ request()->is('titik-lokasi') ? 'bg-gray-400 text-gray-900' : 'text-gray-800 hover:bg-gray-100' }}">
                Titik Lokasi
            </a>
            <a href="#" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center text-sm hover:bg-gray-100 transition">
                Instansi
            </a>
            <a href="#" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center text-sm hover:bg-gray-100 transition">
                Status
            </a>

            <!-- Dropdown Manajemen -->
            <details class="group border-2 border-black bg-white">
                <summary class="list-none py-2 px-4 font-semibold text-gray-900 flex items-center justify-between text-sm cursor-pointer hover:bg-gray-100 transition">
                    <span>Manajemen</span>
                    <svg class="w-4 h-4 transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <div class="border-t-2 border-black bg-white">
                    <a href="#" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 border-b-2 border-black hover:bg-gray-100 transition">
                        User
                    </a>
                    <a href="#" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 border-b-2 border-black hover:bg-gray-100 transition">
                        Kegiatan
                    </a>
                    <a href="#" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 hover:bg-gray-100 transition">
                        Lokasi
                    </a>
                </div>
            </details>
        </div>
    </div>
@endsection

@section('navbar-left')
    <div class="border-2 border-black bg-white px-6 py-1.5 font-bold text-gray-900">
        Dashboard User
    </div>
@endsection

@section('navbar-right')
    <div class="border-2 border-black bg-white px-8 py-1.5 font-semibold text-gray-900">
        Username
    </div>
@endsection

@section('content')
    <!-- STATISTIC CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
        
        <div class="relative overflow-hidden bg-white border-2 border-black rounded-xl p-5 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-0.5 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Jumlah Instansi</span>
                    <div class="flex items-baseline space-x-2">
                        <span id="statInstansi" class="text-3xl font-extrabold text-gray-900 tracking-tight">
                            {{ $stats['instansi'] ?? 14 }}
                        </span>
                        <span class="text-xs font-semibold text-gray-500">Mitra Terdaftar</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-lg bg-blue-50 border-2 border-black flex items-center justify-center text-blue-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-200 flex items-center justify-between text-xs text-gray-600">
                <span class="flex items-center text-emerald-700 font-semibold">
                    <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                    Instansi Aktif
                </span>
                <span class="font-medium text-gray-500">Regional BKN</span>
            </div>
        </div>

        <div class="relative overflow-hidden bg-white border-2 border-black rounded-xl p-5 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-0.5 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Jumlah Peserta</span>
                    <div class="flex items-baseline space-x-2">
                        <span id="statPeserta" class="text-3xl font-extrabold text-gray-900 tracking-tight">
                            {{ number_format($stats['peserta'] ?? 1250) }}
                        </span>
                        <span class="text-xs font-semibold text-gray-500">Orang</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-lg bg-emerald-50 border-2 border-black flex items-center justify-center text-emerald-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-200 flex items-center justify-between text-xs text-gray-600">
                <span class="text-gray-700 font-semibold">Peserta aktif</span>
                <span class="font-medium text-gray-500">Periode 2026</span>
            </div>
        </div>

        <div class="relative overflow-hidden bg-white border-2 border-black rounded-xl p-5 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-0.5 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Jumlah Kegiatan</span>
                    <div class="flex items-baseline space-x-2">
                        <span id="statKegiatan" class="text-3xl font-extrabold text-gray-900 tracking-tight">
                            {{ $stats['kegiatan'] ?? 8 }}
                        </span>
                        <span class="text-xs font-semibold text-gray-500">Agenda</span>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-lg bg-rose-50 border-2 border-black flex items-center justify-center text-rose-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-200 flex items-center justify-between text-xs text-gray-600">
                <span class="text-gray-700 font-semibold">CASN & Kedinasan</span>
                <span class="font-medium text-gray-500">Terjadwal</span>
            </div>
        </div>

    </div>

    <!-- AREA KONTEN UTAMA -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <!-- KOTAK TENGAH UTAMA DENGAN FILTER & SEARCH -->
        <div class="lg:col-span-2 border-2 border-black bg-white p-4 md:p-6 flex flex-col">
            
            <!-- Header Kotak: Judul + Input Search + Tombol Menu List -->
            <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b-2 border-black relative">
                <h2 class="text-base md:text-lg font-bold text-gray-900">
                    Pelaksanaan Berjalan
                </h2>

                <!-- Area Pencarian & Tombol List -->
                <div class="flex items-center space-x-2">
                    <!-- Search Input Box -->
                    <div class="flex items-center border-2 border-black bg-gray-100 px-2 py-1">
                        <svg class="w-4 h-4 text-gray-700 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" id="searchInput" placeholder="cari nama" class="bg-transparent text-sm focus:outline-none w-28 sm:w-40 text-gray-900">
                    </div>

                    <!-- Dropdown Sort (Icon 3 Garis + Titik) -->
                    <div class="relative">
                        <button id="sortDropdownBtn" class="border-2 border-black p-1.5 hover:bg-gray-100 block transition">
                            <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <!-- Menu Pilihan: Terbaru / Terlama -->
                        <div id="sortMenu" class="hidden absolute right-0 top-full mt-1 w-36 border-2 border-black bg-white shadow-md z-20">
                            <button onclick="sortItems('terbaru')" class="w-full text-center py-2 text-sm font-semibold text-gray-900 border-b-2 border-black hover:bg-gray-100 block">
                                Terbaru
                            </button>
                            <button onclick="sortItems('terlama')" class="w-full text-center py-2 text-sm font-semibold text-gray-900 hover:bg-gray-100 block">
                                Terlama
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kontainer Daftar Kegiatan -->
            <div id="kegiatanList" class="mt-4 border-2 border-black p-3 md:p-4 max-h-[460px] overflow-y-auto space-y-3">
                
                <!-- Data order 1 (Lama) -->
                <div class="kegiatan-item border-2 border-black bg-white p-3 md:p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3" data-order="1">
                    <div>
                        <h3 class="item-title text-base md:text-lg font-bold text-gray-900">Kegiatan A</h3>
                        <p class="text-sm text-gray-700">Seleksi CPNS</p>
                        <p class="text-xs md:text-sm text-gray-700 mt-1">Koordinator: Pegawai A</p>
                    </div>
                    <button class="self-end sm:self-center border-2 border-black bg-gray-500 hover:bg-gray-600 text-white font-semibold px-5 py-1 text-sm transition">
                        Detail
                    </button>
                </div>

                <!-- Data order 2 (Lama) -->
                <div class="kegiatan-item border-2 border-black bg-white p-3 md:p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3" data-order="2">
                    <div>
                        <h3 class="item-title text-base md:text-lg font-bold text-gray-900">Kegiatan B</h3>
                        <p class="text-sm text-gray-700">Seleksi CPNS</p>
                        <p class="text-xs md:text-sm text-gray-700 mt-1">Koordinator: Pegawai B</p>
                    </div>
                    <button class="self-end sm:self-center border-2 border-black bg-gray-500 hover:bg-gray-600 text-white font-semibold px-5 py-1 text-sm transition">
                        Detail
                    </button>
                </div>

                <!-- Data order 3 (Lama) -->
                <div class="kegiatan-item border-2 border-black bg-white p-3 md:p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3" data-order="3">
                    <div>
                        <h3 class="item-title text-base md:text-lg font-bold text-gray-900">Kegiatan C</h3>
                        <p class="text-sm text-gray-700">Seleksi CAT</p>
                        <p class="text-xs md:text-sm text-gray-700 mt-1">Koordinator: Pegawai C</p>
                    </div>
                    <button class="self-end sm:self-center border-2 border-black bg-gray-500 hover:bg-gray-600 text-white font-semibold px-5 py-1 text-sm transition">
                        Detail
                    </button>
                </div>

                <!-- Data order baru 4 -->
                <div class="kegiatan-item border-2 border-black bg-white p-3 md:p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3" data-order="4">
                    <div>
                        <h3 class="item-title text-base md:text-lg font-bold text-gray-900">Kegiatan D</h3>
                        <p class="text-sm text-gray-700">Seleksi PPPK</p>
                        <p class="text-xs md:text-sm text-gray-700 mt-1">Koordinator: Pegawai D</p>
                    </div>
                    <button class="self-end sm:self-center border-2 border-black bg-gray-500 hover:bg-gray-600 text-white font-semibold px-5 py-1 text-sm transition">
                        Detail
                    </button>
                </div>

                <!-- Data order baru 5 -->
                <div class="kegiatan-item border-2 border-black bg-white p-3 md:p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3" data-order="5">
                    <div>
                        <h3 class="item-title text-base md:text-lg font-bold text-gray-900">Kegiatan E</h3>
                        <p class="text-sm text-gray-700">Wawancara Teknis</p>
                        <p class="text-xs md:text-sm text-gray-700 mt-1">Koordinator: Pegawai E</p>
                    </div>
                    <button class="self-end sm:self-center border-2 border-black bg-gray-500 hover:bg-gray-600 text-white font-semibold px-5 py-1 text-sm transition">
                        Detail
                    </button>
                </div>

                <!-- Data order baru 6 -->
                <div class="kegiatan-item border-2 border-black bg-white p-3 md:p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3" data-order="6">
                    <div>
                        <h3 class="item-title text-base md:text-lg font-bold text-gray-900">Kegiatan F</h3>
                        <p class="text-sm text-gray-700">Ujian Praktik</p>
                        <p class="text-xs md:text-sm text-gray-700 mt-1">Koordinator: Pegawai F</p>
                    </div>
                    <button class="self-end sm:self-center border-2 border-black bg-gray-500 hover:bg-gray-600 text-white font-semibold px-5 py-1 text-sm transition">
                        Detail
                    </button>
                </div>

            </div>
        </div>

        <!-- KOTAK JADWAL TERDEKAT -->
        <div class="border-2 border-black bg-white p-4 md:p-6 flex flex-col">
            <h2 class="text-base md:text-lg font-bold text-gray-900 pb-3 border-b-2 border-black">
                Jadwal Terdekat
            </h2>
            <div class="mt-4 space-y-3">
                <div class="border-2 border-black p-3 bg-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-bold text-gray-900 text-sm">Kegiatan D</p>
                            <p class="text-xs text-gray-600">Seleksi PPPK</p>
                        </div>
                        <p class="text-[11px] font-semibold text-gray-700">Kamis, 05 ... 20xx</p>
                    </div>
                    <p class="text-[11px] text-gray-600 mt-2">Koordinator: Pegawai D</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Script JavaScript untuk Fitur Interaktif Search & Sort -->
    <script>
    const searchInput = document.getElementById('searchInput');
    const sortDropdownBtn = document.getElementById('sortDropdownBtn');
    const sortMenu = document.getElementById('sortMenu');
    const kegiatanList = document.getElementById('kegiatanList');

    // Toggle menu sort
    sortDropdownBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        sortMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', () => {
        if (!sortMenu.classList.contains('hidden')) {
            sortMenu.classList.add('hidden');
        }
    });

    // Pencarian realtime (mencari ke seluruh teks di dalam kartu)
    searchInput.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        const items = kegiatanList.querySelectorAll('.kegiatan-item');
        
        items.forEach(item => {
            const text = item.innerText.toLowerCase();
            if (text.includes(query)) {
                item.classList.remove('hidden');
                item.classList.add('flex');
            } else {
                item.classList.add('hidden');
                item.classList.remove('flex');
            }
        });
    });

    // Pengurutan Terbaru / Terlama
    function sortItems(type) {
        const items = Array.from(kegiatanList.querySelectorAll('.kegiatan-item'));
        
        items.sort((a, b) => {
            const orderA = parseInt(a.getAttribute('data-order')) || 0;
            const orderB = parseInt(b.getAttribute('data-order')) || 0;
            return type === 'terbaru' ? orderB - orderA : orderA - orderB;
        });

        items.forEach(item => kegiatanList.appendChild(item));
        sortMenu.classList.add('hidden');
    }
    </script>
@endsection