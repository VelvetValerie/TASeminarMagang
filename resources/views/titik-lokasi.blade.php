@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        
        <!-- KOTAK ATAS: LOKASI YANG SEDANG DIGUNAKAN -->
        <section class="border-2 border-black bg-white p-4 md:p-5 shadow-sm">
            <h2 class="text-sm font-semibold text-gray-900 pb-2 border-b-2 border-black">
                Lokasi yang sedang digunakan
            </h2>
            
            <div class="mt-3 border-2 border-black p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-white">
                <p class="font-bold text-gray-900 text-sm md:text-base">
                    Lokasi : Gedung A
                </p>
                <p class="font-medium text-gray-800 text-sm md:text-base">
                    Jumlah Peserta : 140
                </p>
            </div>
        </section>

        <!-- KOTAK BAWAH: DAFTAR TITIK LOKASI -->
        <section class="border-2 border-black bg-white p-4 md:p-5 shadow-sm flex flex-col">
            <h2 class="text-sm md:text-base font-bold text-gray-900 pb-2 border-b-2 border-black">
                Titik lokasi
            </h2>

            <!-- Kontainer List Item Lokasi (Scrollable jika data bertambah) -->
            <div class="mt-4 border-2 border-black p-3 md:p-4 max-h-[460px] overflow-y-auto space-y-3">
                
                <!-- Item Lokasi 1 -->
                <div class="border-2 border-black p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-white hover:bg-gray-50 transition">
                    <p class="font-bold text-gray-900 text-sm md:text-base">
                        Gedung A
                    </p>
                    <p class="text-sm md:text-base text-gray-800">
                        Alamat : JL. Bhayangkara 1
                    </p>
                </div>

                <!-- Item Lokasi 2 -->
                <div class="border-2 border-black p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-white hover:bg-gray-50 transition">
                    <p class="font-bold text-gray-900 text-sm md:text-base">
                        Gedung B
                    </p>
                    <p class="text-sm md:text-base text-gray-800">
                        Alamat : JL. Bhayangkara 1
                    </p>
                </div>

                <!-- Item Lokasi 3 -->
                <div class="border-2 border-black p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-white hover:bg-gray-50 transition">
                    <p class="font-bold text-gray-900 text-sm md:text-base">
                        Gedung C
                    </p>
                    <p class="text-sm md:text-base text-gray-800">
                        Alamat : JL. Flamboyan 2
                    </p>
                </div>

                <!-- Item Lokasi 4 -->
                <div class="border-2 border-black p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-white hover:bg-gray-50 transition">
                    <p class="font-bold text-gray-900 text-sm md:text-base">
                        Gedung D
                    </p>
                    <p class="text-sm md:text-base text-gray-800">
                        Alamat : JL. Trisakti
                    </p>
                </div>

            </div>

            <!-- Panah Penunjuk Bawah (Sesuai Wireframe) -->
            <div class="flex justify-center pt-4">
                <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </section>

    </div>
@endsection