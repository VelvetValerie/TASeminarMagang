@extends('layouts.app')

<title>Kantor Regional BKN - Riwayat Kegiatan</title>

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

        <!-- Grup 2: Operasional -->
        <div class="space-y-2 pt-2">
            <a href="{{ url('/kegiatan') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Kegiatan
            </a>
            <a href="{{ url('/riwayat-kerja') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Rekam Kerja
            </a>
        </div>

        <!-- Grup 3: Master Data & Dropdown -->
        <div class="space-y-2 pt-2">
            <a href="{{ url('/jenis-kegiatan') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center text-sm hover:bg-gray-100 transition">
                Jenis Kegiatan
            </a>
            <a href="{{ url('/titik-lokasi') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center text-sm hover:bg-gray-100 transition">
                Titik Lokasi
            </a>
            <a href="{{ url('/instansi') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center text-sm hover:bg-gray-100 transition">
                Instansi
            </a>
            <a href="{{ url('/riwayat-kegiatan') }}" class="block border-2 border-black bg-gray-500 text-white font-semibold py-2 px-4 text-center text-sm transition">
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
                    <a href="{{ url('/master-user') }}" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 border-b-2 border-black hover:bg-gray-100 transition">
                        User
                    </a>
                    <a href="{{ url('/master-kegiatan') }}" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 border-b-2 border-black hover:bg-gray-100 transition">
                        Kegiatan
                    </a>
                    <a href="{{ url('/master-lokasi') }}" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 hover:bg-gray-100 transition">
                        Lokasi
                    </a>
                </div>
            </details>
        </div>
    </div>
@endsection

@section('navbar-left')
    <div class="border-2 border-black bg-white px-6 py-1.5 font-bold text-gray-900">
        Riwayat Kegiatan
    </div>
@endsection

@section('navbar-right')
    <div class="border-2 border-black bg-white px-8 py-1.5 font-semibold text-gray-900">
        {{ Auth::user()->username ?? 'Username' }}
    </div>
@endsection

@section('content')
    <!-- KONTEN UTAMA: DAFTAR REKAMAN RIWAYAT KEGIATAN -->
    <div class="border-2 border-black bg-white p-4 md:p-6 flex flex-col space-y-4 shadow-sm">
        
            <!-- Header: Judul + Dropdown Filter Urutan (Sama Presisi dengan Dashboard) -->
            <div class="flex items-center justify-between pb-3 border-b-2 border-black relative">
                <h2 class="text-base md:text-lg font-bold text-gray-900">
                    Daftar Rekaman Riwayat Kegiatan
                </h2>
                <!-- Tombol & Popover Filter bergaya Brutalist Dashboard -->
                <div class="relative">
                    <button type="button" id="filterDropdownBtn" class="border-2 border-black p-1.5 hover:bg-gray-100 block transition cursor-pointer" title="Urutkan Data">
                        <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <!-- Menu Dropdown Filter -->
                    <div id="filterMenu" class="hidden absolute right-0 top-full mt-1 w-36 border-2 border-black bg-white shadow-md z-30">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'terbaru', 'page' => 1]) }}" 
                           class="block text-center py-1.5 text-xs sm:text-sm font-semibold text-gray-900 border-b-2 border-black hover:bg-gray-100 {{ ($sort ?? 'terbaru') === 'terbaru' ? 'bg-gray-200 font-bold' : '' }}">
                            Terbaru {{ ($sort ?? 'terbaru') === 'terbaru' ? '✓' : '' }}
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'terlama', 'page' => 1]) }}" 
                           class="block text-center py-1.5 text-xs sm:text-sm font-semibold text-gray-900 hover:bg-gray-100 {{ ($sort ?? '') === 'terlama' ? 'bg-gray-200 font-bold' : '' }}">
                            Terlama {{ ($sort ?? '') === 'terlama' ? '✓' : '' }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tabel Rekaman Riwayat Kegiatan (Maksimal 5 Baris per Laman) -->
            <div class="mt-4 border-2 border-black overflow-x-auto">
                <table class="w-full border-collapse border-black min-w-[650px] text-xs sm:text-sm">
                    <thead>
                        <tr class="border-b-2 border-black bg-gray-100 text-center font-bold text-gray-900">
                            <th class="border-r-2 border-black py-3 px-3 w-12">No</th>
                            <th class="border-r-2 border-black py-3 px-3 w-28 sm:w-36">Log ID</th>
                            <th class="border-r-2 border-black py-3 px-3">Rentang Tanggal & Waktu</th>
                            <th class="py-3 px-3 w-32 sm:w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="font-medium text-gray-900">
                        @forelse($kegiatan as $idx => $item)
                            @php
                                $no = $kegiatan->firstItem() + $idx;
                                $logId = "LOG-" . str_pad($item->id_keg ?? $no, 3, '0', STR_PAD_LEFT);

                                $tglMulai = \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y');
                                $tglSelesai = $item->tanggal_selesai 
                                    ? \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d F Y') 
                                    : $tglMulai;
                                
                                $rentangDisplay = ($tglMulai === $tglSelesai) 
                                    ? $tglMulai 
                                    : "{$tglMulai} ↔ {$tglSelesai}";

                                $modalTitleText = "Daftar Kegiatan {$tglMulai}" . ($tglMulai !== $tglSelesai ? " ~ {$tglSelesai}" : "");
                                $tglLengkap = \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('l, d F Y');
                            @endphp

                            <tr class="border-b-2 border-black last:border-b-0 bg-[#d1d5db] hover:bg-[#c4c8ce] transition">
                                <td class="border-r-2 border-black py-3 px-3 text-center font-bold">
                                    {{ $no }}
                                </td>
                                <td class="border-r-2 border-black py-3 px-3 text-center font-bold tracking-wider">
                                    {{ $logId }}
                                </td>
                                <td class="border-r-2 border-black py-3 px-4 text-center font-semibold">
                                    {{ $rentangDisplay }}
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <button type="button"
                                            onclick="handleOpenDaftarModal(this)" 
                                            data-title="{{ $modalTitleText }}"
                                            data-nama="{{ $item->nama_keg }}"
                                            data-lokasi="{{ $item->lokasi->nm_lokasi ?? '-' }}"
                                            data-alamat="{{ $item->lokasi->alamat ?? '-' }}"
                                            data-tanggal="{{ $tglLengkap }}"
                                            data-koordinator="{{ $item->koordinator->nama_karyawan ?? '-' }}"
                                            data-jenis="{{ $item->jenis->nama_jeniskeg ?? '-' }}"
                                            data-peserta="{{ number_format($item->jmlh_peserta ?? 0) }}"
                                            data-status="{{ $item->status ?? '-' }}"
                                            data-lampiran="{{ $item->lampiran ?? '-' }}"
                                            class="selengkapnya-btn border-2 border-black bg-gray-400 hover:bg-gray-500 text-gray-900 font-semibold px-4 py-1 text-xs sm:text-sm transition cursor-pointer shadow-xs">
                                        Selengkapnya
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500 font-semibold text-sm">
                                    Belum ada rekaman riwayat kegiatan di database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- NAVIGASI PAGINATION ANGKA (1, 2, 3, dst.) -->
        @if ($kegiatan->hasPages())
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t-2 border-black">
                <p class="text-xs sm:text-sm font-semibold text-gray-700">
                    Menampilkan <span class="font-bold text-gray-900">{{ $kegiatan->firstItem() }}</span> - <span class="font-bold text-gray-900">{{ $kegiatan->lastItem() }}</span> dari <span class="font-bold text-gray-900">{{ $kegiatan->total() }}</span> rekaman
                </p>

                <div class="flex items-center space-x-1.5">
                    <!-- Tombol Laman Sebelumnya (<) -->
                    @if ($kegiatan->onFirstPage())
                        <span class="border-2 border-black bg-gray-200 text-gray-400 px-3 py-1 font-bold text-xs sm:text-sm cursor-not-allowed">
                            &laquo;
                        </span>
                    @else
                        <a href="{{ $kegiatan->previousPageUrl() }}" class="border-2 border-black bg-white hover:bg-gray-200 text-gray-900 px-3 py-1 font-bold text-xs sm:text-sm transition">
                            &laquo;
                        </a>
                    @endif

                    <!-- Tombol Nomor Laman (1, 2, 3, dst) -->
                    @foreach ($kegiatan->getUrlRange(1, $kegiatan->lastPage()) as $page => $url)
                        @if ($page == $kegiatan->currentPage())
                            <span class="border-2 border-black bg-black text-white px-3 py-1 font-bold text-xs sm:text-sm shadow-[2px_2px_0px_0px_rgba(0,0,0,0.3)]">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="border-2 border-black bg-white hover:bg-gray-200 text-gray-900 px-3 py-1 font-bold text-xs sm:text-sm transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    <!-- Tombol Laman Berikutnya (>) -->
                    @if ($kegiatan->hasMorePages())
                        <a href="{{ $kegiatan->nextPageUrl() }}" class="border-2 border-black bg-white hover:bg-gray-200 text-gray-900 px-3 py-1 font-bold text-xs sm:text-sm transition">
                            &raquo;
                        </a>
                    @else
                        <span class="border-2 border-black bg-gray-200 text-gray-400 px-3 py-1 font-bold text-xs sm:text-sm cursor-not-allowed">
                            &raquo;
                        </span>
                    @endif
                </div>
            </div>
        @endif

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
                    
                    <button type="button" 
                            onclick="handleOpenDetailModal()" 
                            class="self-end sm:self-center border-2 border-black bg-gray-500 hover:bg-gray-600 text-white font-semibold px-5 py-1.5 text-sm transition cursor-pointer">
                        Detail
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- POPUP MODAL 2: DETAIL RINCIAN KEGIATAN -->
    <div id="detailKegiatanModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div class="relative w-full max-w-xl bg-white border-2 border-black p-5 shadow-2xl">
            <button type="button" onclick="handleCloseDetailModal()" class="absolute top-2 right-2 p-1 text-red-600 hover:text-red-800 transition cursor-pointer" title="Kembali">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <h3 id="dtJudulModal" class="text-base sm:text-lg font-bold text-gray-900 pr-8 pb-3 border-b-2 border-black">
                Detail Kegiatan
            </h3>

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

    <!-- LOGIKA JAVASCRIPT -->
    <script>
        // Toggle Dropdown Filter
        const filterBtn = document.getElementById('filterDropdownBtn');
        const filterMenu = document.getElementById('filterMenu');

        filterBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            filterMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            if (!filterMenu.classList.contains('hidden')) {
                filterMenu.classList.add('hidden');
            }
        });

        // Logika Popup Modal
        const daftarModal = document.getElementById('daftarModal');
        const detailModal = document.getElementById('detailKegiatanModal');

        function handleOpenDaftarModal(buttonElement) {
            document.getElementById('modalTitle').innerText = buttonElement.getAttribute('data-title') || 'Daftar Kegiatan';
            document.getElementById('modalNamaKeg').innerText = buttonElement.getAttribute('data-nama') || '-';
            document.getElementById('modalLokasi').innerText = buttonElement.getAttribute('data-lokasi') || '-';
            document.getElementById('modalTanggal').innerText = buttonElement.getAttribute('data-tanggal') || '-';

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
            lampiranElem.href = (lampiran && lampiran !== '-') ? lampiran : '#';

            daftarModal.classList.remove('hidden');
        }

        function handleCloseDaftarModal() {
            daftarModal.classList.add('hidden');
        }

        function handleOpenDetailModal() {
            detailModal.classList.remove('hidden');
        }

        function handleCloseDetailModal() {
            detailModal.classList.add('hidden');
        }

        daftarModal.addEventListener('click', function(e) {
            if (e.target === daftarModal) handleCloseDaftarModal();
        });
        detailModal.addEventListener('click', function(e) {
            if (e.target === detailModal) handleCloseDetailModal();
        });
    </script>
@endsection