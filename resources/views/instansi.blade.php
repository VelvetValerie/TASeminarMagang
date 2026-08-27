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
    </section>
@endsection