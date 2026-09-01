@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- LOKASI YANG SEDANG DIGUNAKAN -->
        <section class="border-2 border-black bg-white p-4 md:p-5 shadow-sm">
            <h2 class="text-sm font-semibold text-gray-900 pb-2 border-b-2 border-black">
                Lokasi yang sedang digunakan
            </h2>
            @if($kegiatanBerjalan)
                <div class="mt-3 border-2 border-black p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-gray-50">
                    <p class="font-bold text-gray-900 text-sm md:text-base">
                        Lokasi : {{ $kegiatanBerjalan->lokasi->nm_lokasi ?? '-' }} ({{ $kegiatanBerjalan->nama_keg }})
                    </p>
                    <p class="font-medium text-gray-800 text-sm md:text-base">
                        Jumlah Peserta : {{ number_format($kegiatanBerjalan->jmlh_peserta) }} Orang
                    </p>
                </div>
            @else
                <p class="text-sm text-gray-500 mt-2">Saat ini tidak ada lokasi yang sedang aktif digunakan.</p>
            @endif
        </section>

        <!-- DAFTAR TITIK LOKASI DARI DATABASE -->
        <section class="border-2 border-black bg-white p-4 md:p-5 shadow-sm flex flex-col min-h-[420px]">
            <h2 class="text-sm md:text-base font-bold text-gray-900 pb-2 border-b-2 border-black">
                Titik Lokasi
            </h2>

            <div class="mt-4 border-2 border-black p-3 md:p-4 max-h-[460px] overflow-y-auto space-y-3">
                @forelse($lokasi as $item)
                    <div class="border-2 border-black p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-white hover:bg-gray-50 transition">
                        <p class="font-bold text-gray-900 text-sm md:text-base">
                            {{ $item->nm_lokasi }}
                        </p>
                        <p class="text-sm md:text-base text-gray-800">
                            Alamat : {{ $item->alamat }}
                        </p>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-6 text-sm">Belum ada titik lokasi yang terdaftar.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection