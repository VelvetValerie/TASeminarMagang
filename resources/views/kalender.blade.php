@extends('layouts.app')

@section('sidebar-header')
    <div class="border-2 border-black bg-white p-2.5 text-center font-bold text-gray-900">
        Kantor Regional BKN
    </div>
@endsection

@section('sidebar-menu')
    <!-- Grup 1: Menu Utama (Kalender Aktif) -->
        <div class="space-y-2">
            <a href="{{ url('/dashboard') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Menu Dasboard
            </a>
            <a href="{{ url('/kalender') }}" class="block border-2 border-black bg-gray-500 text-white font-semibold py-2 px-4 text-center shadow-sm">
                Kalender
            </a>
        </div>

        <!-- Grup 2: Kegiatan & Rekam Kerja -->
        <div class="space-y-2 pt-2">
            <a href="#" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Kegiatan
            </a>
            <a href="#" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Rekam Kerja
            </a>
        </div>

        <!-- Grup 3: Master Data & Manajemen -->
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
        Kalender Kegiatan
    </div>
@endsection

@section('navbar-right')
    <div class="border-2 border-black bg-white px-8 py-1.5 font-semibold text-gray-900">
        Username
    </div>
@endsection

@section('content')
    <!-- 1. DUA KOTAK ATAS (Legenda & Kegiatan Hari Ini) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="border-2 border-black bg-white p-6 flex items-center justify-center font-semibold text-gray-900 text-center min-h-[90px]">
            Legenda Indikator Kalender
        </div>
        <div class="border-2 border-black bg-white p-6 flex items-center justify-center font-semibold text-gray-900 text-center min-h-[90px]">
            Kegiatan yang sedang berlangsung pada hari saat ini
        </div>
    </div>

    <!-- 2. KOTAK KALENDER UTAMA -->
    <div class="border-2 border-black bg-white p-4 md:p-6 mt-6">
        
        <!-- Header Kontrol Kalender: Bulan, Tahun, Filter -->
        <div class="flex flex-wrap items-center justify-between gap-4 pb-4 border-b-2 border-black">
            <!-- Navigasi Bulan -->
            <div class="flex items-center space-x-2">
                <button class="border-2 border-black p-1 hover:bg-gray-100 font-bold px-2.5">
                    &lt;
                </button>
                <div class="border-2 border-black px-4 py-1 font-semibold text-sm">
                    (Bulan)
                </div>
                <button class="border-2 border-black p-1 hover:bg-gray-100 font-bold px-2.5">
                    &gt;
                </button>
            </div>

            <!-- Teks Tengah: Kalender (Tahun) -->
            <div class="bg-gray-200 border-2 border-black px-8 py-1 font-bold text-sm text-center grow max-w-sm hidden sm:block">
                Kalender (Tahun)
            </div>

            <!-- Icon Filter -->
            <button class="p-1 hover:bg-gray-100 rounded text-gray-900" title="Filter Kalender">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
            </button>
        </div>

        <!-- Tabel Grid Kalender (7 Kolom: Minggu s/d Sabtu) -->
        <div class="mt-4 border-2 border-black overflow-x-auto">
            <table class="w-full border-collapse border-black min-w-[650px]">
                <!-- Header Hari -->
                <thead>
                    <tr class="border-b-2 border-black bg-gray-50 text-center font-bold text-sm">
                        <th class="border-r-2 border-black py-2 w-[14.28%]">Minggu</th>
                        <th class="border-r-2 border-black py-2 w-[14.28%]">Senin</th>
                        <th class="border-r-2 border-black py-2 w-[14.28%]">Selasa</th>
                        <th class="border-r-2 border-black py-2 w-[14.28%]">Rabu</th>
                        <th class="border-r-2 border-black py-2 w-[14.28%]">Kamis</th>
                        <th class="border-r-2 border-black py-2 w-[14.28%]">Jumat</th>
                        <th class="py-2 w-[14.28%]">Sabtu</th>
                    </tr>
                </thead>
                <!-- Baris Tanggal -->
                <tbody class="text-sm font-semibold">
                    <!-- Baris 1 -->
                    <tr class="border-b-2 border-black h-20">
                        <td class="border-r-2 border-black p-1.5 align-top">1</td>
                        <td class="border-r-2 border-black p-1.5 align-top">2</td>
                        <td class="border-r-2 border-black p-1.5 align-top">3</td>
                        <td class="border-r-2 border-black p-1.5 align-top">4</td>
                        <td class="border-r-2 border-black p-1.5 align-top">5</td>
                        <td class="border-r-2 border-black p-1.5 align-top">6</td>
                        <td class="p-1.5 align-top">7</td>
                    </tr>
                    <!-- Baris 2 -->
                    <tr class="border-b-2 border-black h-20">
                        <td class="border-r-2 border-black p-1.5 align-top">8</td>
                        <td class="border-r-2 border-black p-1.5 align-top">9</td>
                        <td class="border-r-2 border-black p-1.5 align-top">10</td>
                        <td class="border-r-2 border-black p-1.5 align-top">11</td>
                        <td class="border-r-2 border-black p-1.5 align-top">12</td>
                        <td class="border-r-2 border-black p-1.5 align-top">13</td>
                        <td class="p-1.5 align-top">14</td>
                    </tr>
                    <!-- Baris 3 -->
                    <tr class="border-b-2 border-black h-20">
                        <td class="border-r-2 border-black p-1.5 align-top">15</td>
                        <td class="border-r-2 border-black p-1.5 align-top">16</td>
                        <td class="border-r-2 border-black p-1.5 align-top">17</td>
                        <td class="border-r-2 border-black p-1.5 align-top">18</td>
                        <td class="border-r-2 border-black p-1.5 align-top">19</td>
                        <td class="border-r-2 border-black p-1.5 align-top">20</td>
                        <td class="p-1.5 align-top">21</td>
                    </tr>
                    <!-- Baris 4 -->
                    <tr class="border-b-2 border-black h-20">
                        <td class="border-r-2 border-black p-1.5 align-top">22</td>
                        <td class="border-r-2 border-black p-1.5 align-top">23</td>
                        <td class="border-r-2 border-black p-1.5 align-top">24</td>
                        <td class="border-r-2 border-black p-1.5 align-top">25</td>
                        <td class="border-r-2 border-black p-1.5 align-top">26</td>
                        <td class="border-r-2 border-black p-1.5 align-top">27</td>
                        <td class="p-1.5 align-top">28</td>
                    </tr>
                    <!-- Baris 5 -->
                    <tr class="border-b-2 border-black h-20">
                        <td class="border-r-2 border-black p-1.5 align-top">29</td>
                        <td class="border-r-2 border-black p-1.5 align-top">30</td>
                        <td class="border-r-2 border-black p-1.5 align-top">31</td>
                        <td class="border-r-2 border-black p-1.5 align-top text-gray-400">1</td>
                        <td class="border-r-2 border-black p-1.5 align-top text-gray-400">2</td>
                        <td class="border-r-2 border-black p-1.5 align-top text-gray-400">3</td>
                        <td class="p-1.5 align-top text-gray-400">4</td>
                    </tr>
                    <!-- Baris 6 -->
                    <tr class="h-20 text-gray-400">
                        <td class="border-r-2 border-black p-1.5 align-top">5</td>
                        <td class="border-r-2 border-black p-1.5 align-top">6</td>
                        <td class="border-r-2 border-black p-1.5 align-top">7</td>
                        <td class="border-r-2 border-black p-1.5 align-top">8</td>
                        <td class="border-r-2 border-black p-1.5 align-top">9</td>
                        <td class="border-r-2 border-black p-1.5 align-top">10</td>
                        <td class="p-1.5 align-top">11</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection