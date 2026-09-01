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
    <!-- 1. STATISTIC CARDS (DINAMIS DARI DATABASE) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
        
        <!-- Kartu Jumlah Instansi -->
        <div class="relative overflow-hidden bg-white border-2 border-black rounded-xl p-5 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-0.5 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Jumlah Instansi</span>
                    <div class="flex items-baseline space-x-2">
                        <span class="text-3xl font-extrabold text-gray-900 tracking-tight">
                            {{ $stats['instansi'] ?? 0 }}
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

        <!-- Kartu Jumlah Peserta -->
        <div class="relative overflow-hidden bg-white border-2 border-black rounded-xl p-5 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-0.5 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Jumlah Peserta</span>
                    <div class="flex items-baseline space-x-2">
                        <span class="text-3xl font-extrabold text-gray-900 tracking-tight">
                            {{ number_format($stats['peserta'] ?? 0) }}
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
                <span class="text-gray-700 font-semibold">Total Terfasilitasi</span>
                <span class="font-medium text-gray-500">Tahun Berjalan</span>
            </div>
        </div>

        <!-- Kartu Jumlah Kegiatan -->
        <div class="relative overflow-hidden bg-white border-2 border-black rounded-xl p-5 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:-translate-y-0.5 transition duration-200">
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Jumlah Kegiatan</span>
                    <div class="flex items-baseline space-x-2">
                        <span class="text-3xl font-extrabold text-gray-900 tracking-tight">
                            {{ $stats['kegiatan'] ?? 0 }}
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

    <!-- 2. AREA UTAMA KONTEN -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <!-- KOTAK TENGAH: PELAKSANAAN BERJALAN -->
        <div class="lg:col-span-2 border-2 border-black bg-white p-4 md:p-6 flex flex-col shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b-2 border-black relative">
                <h2 class="text-base md:text-lg font-bold text-gray-900">
                    Pelaksanaan Berjalan
                </h2>

                <div class="flex items-center space-x-2">
                    <div class="flex items-center border-2 border-black bg-gray-100 px-2 py-1">
                        <svg class="w-4 h-4 text-gray-700 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" id="searchInput" placeholder="cari nama kegiatan" class="bg-transparent text-sm focus:outline-none w-28 sm:w-44 text-gray-900">
                    </div>

                    <div class="relative">
                        <button id="sortDropdownBtn" class="border-2 border-black p-1.5 hover:bg-gray-100 block transition" title="Urutkan">
                            <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <div id="sortMenu" class="hidden absolute right-0 top-full mt-1 w-32 border-2 border-black bg-white shadow-md z-20">
                            <button onclick="sortDashboardItems('terbaru')" class="w-full text-center py-1.5 text-xs sm:text-sm font-semibold text-gray-900 border-b-2 border-black hover:bg-gray-100 block">
                                Terbaru
                            </button>
                            <button onclick="sortDashboardItems('terlama')" class="w-full text-center py-1.5 text-xs sm:text-sm font-semibold text-gray-900 hover:bg-gray-100 block">
                                Terlama
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- List Kegiatan SQL -->
            <div id="dashboardKegiatanList" class="mt-4 border-2 border-black p-3 md:p-4 max-h-[460px] overflow-y-auto space-y-3">
                @forelse($kegiatan as $item)
                    <div class="kegiatan-dash-item border-2 border-black bg-white p-3 md:p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-gray-50 transition" data-id="{{ $item->id_keg }}">
                        <div>
                            <h3 class="text-base md:text-lg font-bold text-gray-900">{{ $item->nama_keg }}</h3>
                            <p class="text-sm font-medium text-gray-600">{{ $item->jenis->nama_jeniskeg ?? '-' }} &bull; {{ $item->lokasi->nm_lokasi ?? '-' }}</p>
                            <p class="text-xs md:text-sm text-gray-700 mt-1">Koordinator: <span class="font-semibold">{{ $item->koordinator->nama_karyawan ?? '-' }}</span></p>
                        </div>
                        <a href="{{ route('kegiatan.index') }}" class="self-end sm:self-center border-2 border-black bg-gray-500 hover:bg-gray-600 text-white font-semibold px-5 py-1 text-sm transition">
                            Detail
                        </a>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-6 text-sm font-medium">Belum ada kegiatan yang terdaftar di database.</p>
                @endforelse
            </div>
        </div>

        <!-- KOTAK KANAN: JADWAL TERDEKAT -->
        <div class="border-2 border-black bg-white p-4 md:p-6 flex flex-col shadow-sm">
            <h2 class="text-base md:text-lg font-bold text-gray-900 pb-3 border-b-2 border-black">
                Jadwal Terdekat
            </h2>
            <div class="mt-4 space-y-3">
                @forelse($kegiatan->take(3) as $first)
                    <div class="border-2 border-black p-3 bg-white hover:bg-gray-50 transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-bold text-gray-900 text-sm">{{ $first->nama_keg }}</p>
                                <p class="text-xs text-gray-600">{{ $first->jenis->nama_jeniskeg ?? '-' }}</p>
                            </div>
                            <p class="text-[11px] font-semibold text-gray-700">{{ \Carbon\Carbon::parse($first->tanggal_mulai)->translatedFormat('d M Y') }}</p>
                        </div>
                        <p class="text-[11px] text-gray-600 mt-2">Koordinator: {{ $first->koordinator->nama_karyawan ?? '-' }}</p>
                    </div>
                @empty
                    <p class="text-xs text-gray-500">Tidak ada jadwal dalam waktu dekat.</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- SCRIPT DASHBOARD PENCARIAN & SORT -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const val = this.value.toLowerCase().trim();
            document.querySelectorAll('.kegiatan-dash-item').forEach(item => {
                item.style.display = item.innerText.toLowerCase().includes(val) ? 'flex' : 'none';
            });
        });

        const sortBtn = document.getElementById('sortDropdownBtn');
        const sortMenu = document.getElementById('sortMenu');
        sortBtn.addEventListener('click', (e) => { e.stopPropagation(); sortMenu.classList.toggle('hidden'); });
        document.addEventListener('click', () => { if (!sortMenu.classList.contains('hidden')) sortMenu.classList.add('hidden'); });

        function sortDashboardItems(type) {
            const container = document.getElementById('dashboardKegiatanList');
            const items = Array.from(container.querySelectorAll('.kegiatan-dash-item'));
            items.sort((a, b) => {
                const idA = parseInt(a.getAttribute('data-id'));
                const idB = parseInt(b.getAttribute('data-id'));
                return type === 'terbaru' ? idB - idA : idA - idB;
            });
            items.forEach(el => container.appendChild(el));
            sortMenu.classList.add('hidden');
        }
    </script>
@endsection