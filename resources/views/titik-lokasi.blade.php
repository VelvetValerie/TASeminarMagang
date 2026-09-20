@extends('layouts.app')

<title>Kantor Regional BKN - Titik Lokasi</title>

@section('sidebar-header')
    <div class="border-2 border-black bg-white p-2.5 text-center font-bold text-gray-900">
        Kantor Regional BKN
    </div>
@endsection

@section('sidebar-menu')
    <div class="space-y-4">
        <!-- Grup 1: Menu Utama -->
        <div class="space-y-2">
            <a href="{{ url('/dashboard') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Menu Dasboard
            </a>
            <a href="{{ url('/kalender') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Kalender
            </a>
        </div>

        <!-- Grup 2: Operasional -->
        <div class="space-y-2 pt-2">
            <a href="{{ url('/kegiatan') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Kegiatan
            </a>
            <a href="{{ url('/riwayat-kerja') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Rekam Kerja
            </a>
        </div>

        <!-- Grup 3: Master Data & Dropdown -->
        <div class="space-y-2 pt-2">
            <a href="{{ url('/jenis-kegiatan') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center text-sm hover:bg-gray-100 transition">
                Jenis Kegiatan
            </a>
            <a href="{{ url('/titik-lokasi') }}" class="block border-2 border-black bg-gray-500 text-white font-semibold py-2 px-4 text-center text-sm transition">
                Titik Lokasi
            </a>
            <a href="{{ url('/instansi') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center text-sm hover:bg-gray-100 transition">
                Instansi
            </a>
            <a href="{{ url('/riwayat-kegiatan') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center text-sm hover:bg-gray-100 transition">
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
                    <a href="{{ url('/master-user') }}" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 border-b-2 border-black hover:bg-gray-100 transition">
                        User
                    </a>
                    <a href="{{ url('/master-kegiatan') }}" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 border-b-2 border-black hover:bg-gray-100 transition">
                        Kegiatan
                    </a>
                    <a href="{{ url('/master-lokasi') }}" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 hover:bg-gray-100 transition">
                        Lokasi
                    </a>
                </div>
            </details>
        </div>
    </div>
@endsection

@section('navbar-left')
    <div class="border-2 border-black bg-white px-6 py-1.5 font-bold text-gray-900">
        Titik Lokasi
    </div>
@endsection

@section('navbar-right')
    <div class="border-2 border-black bg-white px-8 py-1.5 font-semibold text-gray-900">
        {{ Auth::user()->username ?? 'Username' }}
    </div>
@endsection

@section('content')
    <div class="space-y-6">
        
        <!-- SECTION 1: LOKASI YANG SEDANG DIGUNAKAN (REALTIME TRACKING) -->
        <section class="border-2 border-black bg-white p-4 md:p-5 shadow-sm">
            <div class="flex items-center justify-between pb-2 border-b-2 border-black">
                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                    Lokasi yang sedang digunakan
                </h2>
                <span class="text-xs font-semibold px-2 py-0.5 border border-black bg-emerald-100 text-emerald-800">
                    Active Tracking
                </span>
            </div>

            @if(isset($kegiatanBerjalan) && $kegiatanBerjalan)
                <div class="mt-3 border-2 border-black p-4 flex flex-col md:flex-row md:items-center justify-between gap-3 bg-[#d1d5db]">
                    <div class="space-y-1">
                        <p class="font-bold text-gray-900 text-base md:text-lg">
                            Lokasi : {{ $kegiatanBerjalan->lokasi->nm_lokasi ?? '-' }} 
                            <span class="font-normal text-sm text-gray-700">({{ $kegiatanBerjalan->nama_keg }})</span>
                        </p>
                        <p class="text-xs text-gray-700 font-medium">
                            Alamat: {{ $kegiatanBerjalan->lokasi->alamat ?? '-' }}
                        </p>
                    </div>

                    <div class="shrink-0 text-left md:text-right border-t md:border-t-0 pt-2 md:pt-0 border-black/20">
                        <p class="font-bold text-gray-900 text-sm md:text-base">
                            Jumlah Peserta : <span class="bg-white px-2 py-0.5 border border-black">{{ number_format($kegiatanBerjalan->jmlh_peserta) }} Orang</span>
                        </p>
                        <p class="text-xs text-gray-700 font-medium mt-1">
                            Status: <span class="font-bold text-blue-900">{{ $kegiatanBerjalan->status }}</span>
                        </p>
                    </div>
                </div>
            @else
                <div class="mt-3 border-2 border-black p-4 text-center bg-gray-50">
                    <p class="text-sm text-gray-600 font-semibold">Saat ini tidak ada lokasi yang sedang aktif digunakan untuk kegiatan terkonfirmasi.</p>
                </div>
            @endif
        </section>

        <!-- SECTION 2: DAFTAR TITIK LOKASI DARI DATABASE -->
        <section class="border-2 border-black bg-white p-4 md:p-5 shadow-sm flex flex-col min-h-[420px]">
            
            <!-- Header Kotak: Judul + Search Realtime & Sort Dropdown -->
            <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b-2 border-black relative">
                <h2 class="text-base md:text-lg font-bold text-gray-900">
                    Daftar Titik Lokasi
                </h2>

                <!-- Kontrol Filter & Search Realtime -->
                <div class="flex items-center space-x-2">
                    <!-- Search Input Box -->
                    <div class="flex items-center border-2 border-black bg-gray-100 px-2 py-1">
                        <svg class="w-4 h-4 text-gray-700 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" id="searchInput" placeholder="cari titik lokasi" class="bg-transparent text-sm focus:outline-none w-32 sm:w-48 text-gray-900">
                    </div>

                    <!-- Tombol Menu Sort List -->
                    <div class="relative">
                        <button id="sortDropdownBtn" class="border-2 border-black p-1.5 hover:bg-gray-100 block transition cursor-pointer" title="Urutkan Lokasi">
                            <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <!-- Popover Pilihan: A - Z & Z - A -->
                        <div id="sortMenu" class="hidden absolute right-0 top-full mt-1 w-32 border-2 border-black bg-white shadow-md z-20">
                            <button onclick="sortItems('az')" class="w-full text-center py-1.5 text-xs sm:text-sm font-medium text-gray-900 border-b-2 border-black hover:bg-gray-100 block cursor-pointer">
                                A - Z
                            </button>
                            <button onclick="sortItems('za')" class="w-full text-center py-1.5 text-xs sm:text-sm font-medium text-gray-900 hover:bg-gray-100 block cursor-pointer">
                                Z - A
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kontainer Daftar Lokasi -->
            <div id="lokasiList" class="mt-4 border-2 border-black p-3 md:p-4 max-h-[460px] overflow-y-auto space-y-3">
                @forelse($lokasi as $item)
                    <div class="lokasi-item border-2 border-black p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-white hover:bg-gray-50 transition"
                         data-name="{{ $item->nm_lokasi }}"
                         data-alamat="{{ $item->alamat }}">
                        <p class="font-bold text-gray-900 text-sm md:text-base">
                            {{ $item->nm_lokasi }}
                        </p>
                        <p class="text-sm md:text-base text-gray-800 font-medium">
                            Alamat : {{ $item->alamat }}
                        </p>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-6 text-sm font-semibold">Belum ada titik lokasi yang terdaftar di database.</p>
                @endforelse
            </div>
        </section>

    </div>

    <!-- LOGIKA JAVASCRIPT: SEARCH REALTIME & SORTING -->
    <script>
        const searchInput = document.getElementById('searchInput');
        const sortDropdownBtn = document.getElementById('sortDropdownBtn');
        const sortMenu = document.getElementById('sortMenu');
        const lokasiList = document.getElementById('lokasiList');

        // Toggle Dropdown Menu Sort
        sortDropdownBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sortMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            if (!sortMenu.classList.contains('hidden')) {
                sortMenu.classList.add('hidden');
            }
        });

        // Fitur Pencarian Realtime (Client-Side)
        searchInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            const items = lokasiList.querySelectorAll('.lokasi-item');
            
            items.forEach(item => {
                const name = item.getAttribute('data-name').toLowerCase();
                const alamat = item.getAttribute('data-alamat').toLowerCase();
                
                if (name.includes(query) || alamat.includes(query)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Fitur Pengurutan Realtime (A-Z dan Z-A)
        function sortItems(type) {
            const items = Array.from(lokasiList.querySelectorAll('.lokasi-item'));
            
            items.sort((a, b) => {
                const nameA = a.getAttribute('data-name').toLowerCase();
                const nameB = b.getAttribute('data-name').toLowerCase();

                if (type === 'az') {
                    return nameA.localeCompare(nameB);
                } else if (type === 'za') {
                    return nameB.localeCompare(nameA);
                }
            });

            items.forEach(item => lokasiList.appendChild(item));
            sortMenu.classList.add('hidden');
        }
    </script>
@endsection