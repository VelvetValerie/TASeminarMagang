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
            <a href="{{ url('/kegiatan') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Kegiatan
            </a>
            <a href="{{ url('/riwayat-kerja') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
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
                    <a href="{{ url('/jenis-kegiatan') }}" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 border-b-2 border-black hover:bg-gray-100 transition">
                        Jenis Kegiatan
                    </a>
                    <a href="{{ url('/titik-lokasi') }}" 
                    class="block py-2 px-4 text-center text-sm font-semibold transition {{ request()->is('titik-lokasi') ? 'bg-gray-400 text-gray-900' : 'text-gray-800 hover:bg-gray-100' }}">
                        Titik Lokasi
                    </a>
                    <a href="{{ url('/instansi') }}" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 border-b-2 border-black hover:bg-gray-100 transition">
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
            <button class="p-1 hover:bg-gray-100 rounded text-gray-900 transition" title="Filter Data">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
            </button>
        </div>

        <!-- Kontainer List Riwayat Kegiatan (Dinamis dari Database) -->
        <div class="mt-4 border-2 border-black p-3 md:p-4 max-h-[480px] overflow-y-auto space-y-4">
            
            @forelse($kegiatan as $item)
                @php
                    $tglMulai = \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y');
                    $tglSelesai = $item->tanggal_selesai 
                        ? \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d F Y') 
                        : $tglMulai;
                    $rentangLabel = "Rekaman Riwayat {$tglMulai}" . ($tglMulai !== $tglSelesai ? " ~ {$tglSelesai}" : "");
                    $modalTitleText = "Daftar Kegiatan {$tglMulai}" . ($tglMulai !== $tglSelesai ? " ~ {$tglSelesai}" : "");
                @endphp

                <div class="border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <p class="font-medium text-gray-900 text-sm md:text-base">
                        {{ $rentangLabel }} : <span class="font-bold">{{ $item->nama_keg }}</span>
                    </p>
                    <button onclick="openModal(this, '{{ $modalTitleText }}', '{{ $item->nama_keg }}', '{{ $item->lokasi->nm_lokasi ?? '-' }}', '{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('l, d F Y') }}', '{{ route('kegiatan.index') }}')" 
                            class="selengkapnya-btn self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-blue-600 hover:text-white text-gray-900 font-semibold px-6 py-1.5 text-sm transition">
                        Selengkapnya
                    </button>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 font-semibold text-sm">
                    Belum ada rekaman riwayat kegiatan di database.
                </div>
            @endforelse

        </div>
    </div>

    <!-- POPUP MODAL STATUS KEGIATAN -->
    <div id="detailModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40">
        <div class="relative w-full max-w-2xl bg-white border-2 border-black p-5 shadow-2xl">
            
            <!-- Tombol Close Silang Merah -->
            <button onclick="closeModal()" class="absolute top-2 right-2 p-1 text-red-600 hover:text-red-800 transition" title="Tutup">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- Judul Popup -->
            <h3 id="modalTitle" class="text-base sm:text-lg font-bold text-gray-900 pr-8 pb-3">
                Daftar Kegiatan
            </h3>

            <!-- Kontainer Box Abu-abu Dalam Popup -->
            <div class="border-2 border-black bg-[#d1d5db] p-4 max-h-[380px] overflow-y-auto space-y-3">
                
                <div class="border-2 border-black bg-white p-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h4 id="modalNamaKeg" class="font-bold text-gray-900 text-base">Kegiatan</h4>
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-1 text-xs sm:text-sm text-gray-700 mt-1">
                            <span id="modalLokasi">Gedung</span>
                            <span id="modalTanggal">Tanggal Pelaksanaan</span>
                        </div>
                    </div>
                    <a id="modalDetailLink" href="{{ route('kegiatan.index') }}" class="self-end sm:self-center border-2 border-black bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-1 text-sm transition">
                        Detail
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Script Buka/Tutup Modal & Status Warna Tombol -->
    <script>
        const modal = document.getElementById('detailModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalNamaKeg = document.getElementById('modalNamaKeg');
        const modalLokasi = document.getElementById('modalLokasi');
        const modalTanggal = document.getElementById('modalTanggal');
        const modalDetailLink = document.getElementById('modalDetailLink');
        let activeTriggerButton = null;

        function openModal(buttonElement, title, namaKeg, lokasi, tanggal, urlDetail) {
            modalTitle.innerText = title;
            modalNamaKeg.innerText = namaKeg;
            modalLokasi.innerText = lokasi;
            modalTanggal.innerText = tanggal;
            modalDetailLink.href = urlDetail;

            modal.classList.remove('hidden');

            // Reset tombol lain ke abu-abu
            document.querySelectorAll('.selengkapnya-btn').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-400', 'text-gray-900');
            });

            // Ubah tombol yang diklik menjadi biru
            activeTriggerButton = buttonElement;
            buttonElement.classList.remove('bg-gray-400', 'text-gray-900');
            buttonElement.classList.add('bg-blue-600', 'text-white');
        }

        function closeModal() {
            modal.classList.add('hidden');

            // Kembalikan tombol aktif ke warna abu-abu default
            if (activeTriggerButton) {
                activeTriggerButton.classList.remove('bg-blue-600', 'text-white');
                activeTriggerButton.classList.add('bg-gray-400', 'text-gray-900');
                activeTriggerButton = null;
            }
        }

        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    </script>
@endsection