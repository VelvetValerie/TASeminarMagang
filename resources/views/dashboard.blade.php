@extends('layouts.app')

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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="border-2 border-black bg-white p-5 flex items-center justify-center font-semibold text-gray-900 text-center min-h-[80px]">
            Jumlah Instansi
        </div>
        <div class="border-2 border-black bg-white p-5 flex items-center justify-center font-semibold text-gray-900 text-center min-h-[80px]">
            Titik Lokasi
        </div>
        <div class="border-2 border-black bg-white p-5 flex items-center justify-center font-semibold text-gray-900 text-center min-h-[80px]">
            Jumlah Peserta
        </div>
        <div class="border-2 border-black bg-white p-5 flex items-center justify-center font-semibold text-gray-900 text-center min-h-[80px]">
            Jumlah Kegiatan
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