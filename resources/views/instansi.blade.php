@extends('layouts.app')

@section('content')
    <section class="border-2 border-black bg-white p-4 md:p-6 flex flex-col min-h-[520px] shadow-sm">
        <h2 class="text-base md:text-lg font-bold text-gray-900 pb-3 border-b-2 border-black">
            Daftar Instansi
        </h2>

        <div class="mt-4 border-2 border-black p-3 md:p-4 max-h-[460px] overflow-y-auto space-y-4">
            @forelse($instansi as $item)
                <div class="border-2 border-black bg-white p-5 flex items-center min-h-[75px] hover:bg-gray-50 transition">
                    <p class="font-bold text-gray-900 text-sm md:text-base">
                        {{ $item->nm_instansi }}
                    </p>
                </div>
            @empty
                <p class="text-center text-gray-500 py-8 text-sm">Belum ada instansi mitra terdaftar.</p>
            @endforelse
        </div>
    </section>
@endsection