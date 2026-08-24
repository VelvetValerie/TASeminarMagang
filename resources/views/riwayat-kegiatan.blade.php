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
            <a href="{{ url('/dashboard') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Menu Dasboard
            </a>
            <a href="{{ url('/kalender') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Kalender
            </a>
        </div>

        <!-- Grup 2: Kegiatan & Riwayat Kerja -->
        <div class="space-y-2 pt-2">
            <a href="#" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Kegiatan
            </a>
            <a href="#" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Riwayat Kerja
            </a>
        </div>

        <!-- Grup 3: Dropdown Manajemen Data Kegiatan (Terbuka & Riwayat Kegiatan Terarsir) -->
        <div class="space-y-2 pt-2">
            <details class="group border-2 border-black bg-white" open>
                <summary class="list-none py-2 px-3 bg-gray-300 font-semibold text-gray-900 flex items-center justify-between text-xs sm:text-sm cursor-pointer hover:bg-gray-400 transition">
                    <span class="text-center leading-tight">Manajemen<br>Data Kegiatan</span>
                    <svg class="w-4 h-4 transition-transform duration-200 group-open:rotate-180 shrink-0 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                
                <!-- Submenu Dropdown -->
                <div class="border-t-2 border-black bg-white">
                    <a href="#" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 border-b-2 border-black hover:bg-gray-100 transition">
                        Jenis Kegiatan
                    </a>
                    <a href="{{ url('/titik-lokasi') }}" 
                    class="block py-2 px-4 text-center text-sm font-semibold transition {{ request()->is('titik-lokasi') ? 'bg-gray-400 text-gray-900' : 'text-gray-800 hover:bg-gray-100' }}">
                        Titik Lokasi
                    </a>
                    <a href="#" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 border-b-2 border-black hover:bg-gray-100 transition">
                        Instansi
                    </a>
                    <a href="{{ url('/riwayat-kegiatan') }}" class="block py-2 px-4 text-center text-sm font-semibold bg-gray-400 text-gray-900 transition">
                        Riwayat Kegiatan
                    </a>
                </div>
            </details>
        </div>
    </div>
@endsection

@section('navbar-left')
    <div class="border-2 border-black bg-white px-6 py-1.5 font-bold text-gray-900">
        Text Dashboard
    </div>
@endsection

@section('navbar-right')
    <div class="border-2 border-black bg-white px-8 py-1.5 font-semibold text-gray-900">
        Username
    </div>
@endsection

@section('content')
    <!-- AREA KONTEN UTAMA: DAFTAR KEGIATAN -->
    <div class="border-2 border-black bg-white p-4 md:p-6 flex flex-col min-h-[500px]">
        
        <!-- Header Kotak: Judul + Icon Filter -->
        <div class="flex items-center justify-between pb-3 border-b-2 border-black">
            <h2 class="text-base md:text-lg font-bold text-gray-900">
                Daftar Kegiatan
            </h2>
            <!-- Icon Filter Corong -->
            <button class="p-1 hover:bg-gray-100 rounded text-gray-900 transition" title="Filter Data">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
            </button>
        </div>

        <!-- Kontainer List Item Riwayat Kegiatan (Dengan Scroll Otomatis jika melebihi 5) -->
        <div class="mt-4 border-2 border-black p-3 md:p-4 max-h-[480px] overflow-y-auto space-y-4">
            
            <!-- Item Riwayat 1 -->
            <div class="border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <p class="font-medium text-gray-900 text-sm md:text-base">
                    Rekaman Riwayat 03 ... 20xx ~ 05 ... 20xx
                </p>
                <button class="self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-gray-500 text-gray-900 font-semibold px-6 py-1.5 text-sm transition">
                    Selengkapnya
                </button>
            </div>

            <!-- Item Riwayat 2 -->
            <div class="border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <p class="font-medium text-gray-900 text-sm md:text-base">
                    Rekaman Riwayat 09 ... 20xx ~ 11 ... 20xx
                </p>
                <button class="self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-gray-500 text-gray-900 font-semibold px-6 py-1.5 text-sm transition">
                    Selengkapnya
                </button>
            </div>

            <!-- Item Riwayat 3 -->
            <div class="border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <p class="font-medium text-gray-900 text-sm md:text-base">
                    Rekaman Riwayat 15 ... 20xx ~ 17 ... 20xx
                </p>
                <button class="self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-gray-500 text-gray-900 font-semibold px-6 py-1.5 text-sm transition">
                    Selengkapnya
                </button>
            </div>

        </div>
    </div>
@endsection