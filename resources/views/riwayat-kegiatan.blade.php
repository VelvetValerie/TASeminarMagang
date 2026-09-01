@extends('layouts.app')

@section('content')
    <!-- KONTEN UTAMA: DAFTAR RIWAYAT KEGIATAN -->
    <div class="border-2 border-black bg-white p-4 md:p-6 flex flex-col min-h-[500px] shadow-sm">
        
        <!-- Header: Judul + Tombol Filter -->
        <div class="flex items-center justify-between pb-3 border-b-2 border-black">
            <h2 class="text-base md:text-lg font-bold text-gray-900">
                Daftar Kegiatan
            </h2>
            <button type="button" class="p-1 hover:bg-gray-100 rounded text-gray-900 transition" title="Filter Data">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
            </button>
        </div>

        <!-- Kontainer List Riwayat Kegiatan Dinamis SQL -->
        <div class="mt-4 border-2 border-black p-3 md:p-4 max-h-[480px] overflow-y-auto space-y-4">
            
            @forelse($kegiatan as $item)
                @php
                    $tglMulai = \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y');
                    $tglSelesai = $item->tanggal_selesai 
                        ? \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d F Y') 
                        : $tglMulai;
                    $rentangLabel = "Rekaman Riwayat {$tglMulai}" . ($tglMulai !== $tglSelesai ? " ~ {$tglSelesai}" : "");
                    $modalTitleText = "Daftar Kegiatan {$tglMulai}" . ($tglMulai !== $tglSelesai ? " ~ {$tglSelesai}" : "");
                    $tglLengkap = \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('l, d F Y');
                @endphp

                <div class="border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <p class="font-medium text-gray-900 text-sm md:text-base">
                        {{ $rentangLabel }} : <span class="font-bold">{{ $item->nama_keg }}</span>
                    </p>
                    
                    <!-- Tombol Selengkapnya Membuka Modal 1 -->
                    <button type="button"
                            onclick="handleOpenDaftarModal(this)" 
                            data-title="{{ $modalTitleText }}"
                            data-nama="{{ $item->nama_keg }}"
                            data-lokasi="{{ $item->lokasi->nm_lokasi ?? '-' }}"
                            data-alamat="{{ $item->lokasi->alamat ?? '-' }}"
                            data-tanggal="{{ $tglLengkap }}"
                            data-koordinator="{{ $item->koordinator->nama_karyawan ?? '-' }}"
                            data-jenis="{{ $item->jenis->nama_jeniskeg ?? '-' }}"
                            data-peserta="{{ number_format($item->jmlh_peserta) }}"
                            data-status="{{ $item->status }}"
                            data-lampiran="{{ $item->lampiran ?? '-' }}"
                            class="selengkapnya-btn self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-blue-600 hover:text-white text-gray-900 font-semibold px-6 py-1.5 text-sm transition cursor-pointer">
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

    <!-- POPUP MODAL 1: DAFTAR KEGIATAN DALAM PERIODE -->
    <div id="daftarModal" class="hidden fixed inset-0 z-40 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs">
        <div class="relative w-full max-w-2xl bg-white border-2 border-black p-5 shadow-2xl">
            
            <button type="button" onclick="handleCloseDaftarModal()" class="absolute top-2 right-2 p-1 text-red-600 hover:text-red-800 transition cursor-pointer" title="Tutup">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <h3 id="modalTitle" class="text-base sm:text-lg font-bold text-gray-900 pr-8 pb-3 border-b-2 border-black">
                Daftar Kegiatan
            </h3>

            <div class="mt-4 border-2 border-black bg-[#d1d5db] p-4 max-h-[380px] overflow-y-auto space-y-3">
                <div class="border-2 border-black bg-white p-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h4 id="modalNamaKeg" class="font-bold text-gray-900 text-base">Nama Kegiatan</h4>
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-1 text-xs sm:text-sm text-gray-700 mt-1">
                            <span id="modalLokasi">Gedung / Lokasi</span>
                            <span id="modalTanggal">Tanggal Pelaksanaan</span>
                        </div>
                    </div>
                    
                    <!-- Tombol Detail Membuka Modal 2 (Tanpa Pindah Halaman) -->
                    <button type="button" 
                            onclick="handleOpenDetailModal()" 
                            class="self-end sm:self-center border-2 border-black bg-gray-500 hover:bg-gray-600 text-white font-semibold px-5 py-1.5 text-sm transition cursor-pointer">
                        Detail
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- POPUP MODAL 2: DETAIL RINCIAN KEGIATAN (IN-PLACE POPUP) -->
    <div id="detailKegiatanModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div class="relative w-full max-w-xl bg-white border-2 border-black p-5 shadow-2xl">
            
            <!-- Tombol Tutup Detail -->
            <button type="button" onclick="handleCloseDetailModal()" class="absolute top-2 right-2 p-1 text-red-600 hover:text-red-800 transition cursor-pointer" title="Kembali">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <h3 id="dtJudulModal" class="text-base sm:text-lg font-bold text-gray-900 pr-8 pb-3 border-b-2 border-black">
                Detail Kegiatan
            </h3>

            <!-- Kontainer Box Rincian Lengkap Sesuai Desain Asli -->
            <div class="mt-4 border-2 border-black bg-[#d1d5db] p-5 space-y-2.5 text-xs sm:text-sm text-gray-900">
                <p><span class="font-semibold">Koordinator :</span> <span id="dtKoordinator">-</span></p>
                <p><span class="font-semibold">Jenis Kegiatan :</span> <span id="dtJenis">-</span></p>
                <p><span class="font-semibold">Tanggal pelaksanaan :</span> <span id="dtTanggalPelaksanaan">-</span></p>
                <p><span class="font-semibold">Titik Lokasi :</span> <span id="dtTitikLokasi">-</span></p>
                <p><span class="font-semibold">Jumlah peserta :</span> <span id="dtJumlahPeserta">-</span> Orang</p>
                <p><span class="font-semibold">Status :</span> <span id="dtStatusKegiatan">-</span></p>
                <p>
                    <span class="font-semibold">Lampiran :</span> 
                    <a id="dtLampiranUrl" href="#" target="_blank" class="text-blue-700 underline font-medium break-all">-</a>
                </p>
            </div>
        </div>
    </div>

    <!-- LOGIKA JAVASCRIPT LENGKAP -->
    <script>
        const daftarModal = document.getElementById('daftarModal');
        const detailModal = document.getElementById('detailKegiatanModal');
        let activeTriggerButton = null;

        // 1. Membuka Modal Pertama (Daftar Kegiatan)
        function handleOpenDaftarModal(buttonElement) {
            activeTriggerButton = buttonElement;

            document.getElementById('modalTitle').innerText = buttonElement.getAttribute('data-title') || 'Daftar Kegiatan';
            document.getElementById('modalNamaKeg').innerText = buttonElement.getAttribute('data-nama') || '-';
            document.getElementById('modalLokasi').innerText = buttonElement.getAttribute('data-lokasi') || '-';
            document.getElementById('modalTanggal').innerText = buttonElement.getAttribute('data-tanggal') || '-';

            // Set data untuk Modal Detail Kedua
            document.getElementById('dtJudulModal').innerText = 'Detail ' + (buttonElement.getAttribute('data-nama') || '');
            document.getElementById('dtKoordinator').innerText = buttonElement.getAttribute('data-koordinator') || '-';
            document.getElementById('dtJenis').innerText = buttonElement.getAttribute('data-jenis') || '-';
            document.getElementById('dtTanggalPelaksanaan').innerText = buttonElement.getAttribute('data-tanggal') || '-';
            document.getElementById('dtTitikLokasi').innerText = (buttonElement.getAttribute('data-lokasi') || '-') + ' (' + (buttonElement.getAttribute('data-alamat') || '-') + ')';
            document.getElementById('dtJumlahPeserta').innerText = buttonElement.getAttribute('data-peserta') || '0';
            document.getElementById('dtStatusKegiatan').innerText = buttonElement.getAttribute('data-status') || '-';
            
            const lampiran = buttonElement.getAttribute('data-lampiran') || '-';
            const lampiranElem = document.getElementById('dtLampiranUrl');
            lampiranElem.innerText = lampiran;
            lampiranElem.href = lampiran !== '-' ? lampiran : '#';

            daftarModal.classList.remove('hidden');

            // Highlight tombol aktif
            document.querySelectorAll('.selengkapnya-btn').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-400', 'text-gray-900');
            });
            buttonElement.classList.remove('bg-gray-400', 'text-gray-900');
            buttonElement.classList.add('bg-blue-600', 'text-white');
        }

        function handleCloseDaftarModal() {
            daftarModal.classList.add('hidden');
            if (activeTriggerButton) {
                activeTriggerButton.classList.remove('bg-blue-600', 'text-white');
                activeTriggerButton.classList.add('bg-gray-400', 'text-gray-900');
                activeTriggerButton = null;
            }
        }

        // 2. Membuka Modal Kedua (Rincian Detail Kegiatan)
        function handleOpenDetailModal() {
            detailModal.classList.remove('hidden');
        }

        function handleCloseDetailModal() {
            detailModal.classList.add('hidden');
        }

        // Tutup saat area luar modal diklik
        daftarModal.addEventListener('click', function(e) {
            if (e.target === daftarModal) handleCloseDaftarModal();
        });
        detailModal.addEventListener('click', function(e) {
            if (e.target === detailModal) handleCloseDetailModal();
        });
    </script>
@endsection