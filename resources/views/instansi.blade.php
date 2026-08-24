@extends('layouts.app')

@section('content')
    <!-- AREA UTAMA: DAFTAR INSTANSI -->
    <section class="border-2 border-black bg-white p-4 md:p-6 flex flex-col min-h-[520px] shadow-sm">
        
        <!-- Header Judul -->
        <h2 class="text-base md:text-lg font-bold text-gray-900 pb-3 border-b-2 border-black">
            Daftar Instansi
        </h2>

        <!-- Kontainer Daftar Instansi (Scrollable jika data bertambah) -->
        <div class="mt-4 border-2 border-black p-3 md:p-4 max-h-[460px] overflow-y-auto space-y-4">
            
            <!-- Item Instansi A -->
            <div class="border-2 border-black bg-white p-5 flex items-center min-h-[75px] hover:bg-gray-50 transition">
                <p class="font-bold text-gray-900 text-sm md:text-base">
                    Instansi A
                </p>
            </div>

            <!-- Item Instansi B -->
            <div class="border-2 border-black bg-white p-5 flex items-center min-h-[75px] hover:bg-gray-50 transition">
                <p class="font-bold text-gray-900 text-sm md:text-base">
                    Instansi B
                </p>
            </div>

            <!-- Item Instansi C -->
            <div class="border-2 border-black bg-white p-5 flex items-center min-h-[75px] hover:bg-gray-50 transition">
                <p class="font-bold text-gray-900 text-sm md:text-base">
                    Instansi C
                </p>
            </div>

            <!-- Item Instansi D -->
            <div class="border-2 border-black bg-white p-5 flex items-center min-h-[75px] hover:bg-gray-50 transition">
                <p class="font-bold text-gray-900 text-sm md:text-base">
                    Instansi D
                </p>
            </div>

        </div>

        <!-- Panah Penunjuk Bawah (Sesuai Wireframe) -->
        <div class="flex justify-center pt-5">
            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>
@endsection