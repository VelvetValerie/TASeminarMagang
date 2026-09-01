@extends('layouts.app')

@section('content')
    <!-- KONTEN UTAMA: DAFTAR JENIS KEGIATAN (DATABASE CONNECTED) -->
    <div class="border-2 border-black bg-white p-4 md:p-6 flex flex-col min-h-[520px] shadow-sm">
        
        <!-- Header Kotak: Judul + Search & Sort Dropdown -->
        <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b-2 border-black relative">
            <h2 class="text-base md:text-lg font-bold text-gray-900">
                Daftar Jenis Kegiatan
            </h2>

            <!-- Kontrol Filter & Search -->
            <div class="flex items-center space-x-2">
                <!-- Search Input Box -->
                <div class="flex items-center border-2 border-black bg-gray-100 px-2 py-1">
                    <svg class="w-4 h-4 text-gray-700 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="searchInput" placeholder="cari nama" class="bg-transparent text-sm focus:outline-none w-28 sm:w-40 text-gray-900">
                </div>

                <!-- Tombol Menu Sort List -->
                <div class="relative">
                    <button id="sortDropdownBtn" class="border-2 border-black p-1.5 hover:bg-gray-100 block transition" title="Urutkan Kategori">
                        <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Popover Pilihan: A - Z, Terbaru, Terlama -->
                    <div id="sortMenu" class="hidden absolute right-0 top-full mt-1 w-32 border-2 border-black bg-white shadow-md z-20">
                        <button onclick="sortItems('az')" class="w-full text-center py-1.5 text-xs sm:text-sm font-medium text-gray-900 border-b-2 border-black hover:bg-gray-100 block">
                            A - Z
                        </button>
                        <button onclick="sortItems('terbaru')" class="w-full text-center py-1.5 text-xs sm:text-sm font-medium text-gray-900 border-b-2 border-black hover:bg-gray-100 block">
                            Terbaru
                        </button>
                        <button onclick="sortItems('terlama')" class="w-full text-center py-1.5 text-xs sm:text-sm font-medium text-gray-900 hover:bg-gray-100 block">
                            Terlama
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kontainer Daftar Jenis Kegiatan (Dinamis dari Database SQL) -->
        <div id="jenisKegiatanList" class="mt-4 border-2 border-black p-3 md:p-4 max-h-[460px] overflow-y-auto space-y-4">
            
            @forelse($jenis as $item)
                @php
                    // Ambil waktu pembuatan atau tanggal kegiatan terkait pertama
                    $waktuDibuat = isset($item->created_at) 
                        ? \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') 
                        : '2026-06-01';

                    // Hitung total peserta yang berpartisipasi pada jenis kegiatan ini
                    $totalPeserta = \App\Models\Kegiatan::where('id_jeniskeg', $item->id_jeniskeg)->sum('jmlh_peserta');
                @endphp

                <div class="jenis-item border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4" 
                     data-order="{{ $item->id_jeniskeg }}" 
                     data-name="{{ $item->nama_jeniskeg }}"
                     data-time="{{ $waktuDibuat }}"
                     data-extra="{{ number_format($totalPeserta) }} Orang">
                    
                    <div class="flex items-center space-x-3">
                        <span class="w-7 h-7 rounded-full border-2 border-black bg-white flex items-center justify-center text-xs font-bold text-gray-900 shrink-0">
                            {{ $loop->iteration }}
                        </span>
                        <p class="item-title font-medium text-gray-900 text-sm md:text-base">
                            {{ $item->nama_jeniskeg }}
                        </p>
                    </div>

                    <button onclick="openModal(this)" 
                            class="detail-btn self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-blue-600 hover:text-white text-gray-900 font-semibold px-6 py-1 text-sm transition">
                        Detail
                    </button>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 font-semibold text-sm">
                    Belum ada jenis kegiatan yang terdaftar di database.
                </div>
            @endforelse

        </div>
    </div>

    <!-- POPUP MODAL INFORMASI JENIS KEGIATAN -->
    <div id="infoModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40">
        <div class="relative w-full max-w-lg bg-white border-2 border-black p-5 shadow-2xl">
            
            <!-- Tombol Close Silang Merah -->
            <button onclick="closeModal()" class="absolute top-2 right-2 p-1 text-red-600 hover:text-red-800 transition" title="Tutup">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- Judul Popup -->
            <h3 class="text-base font-bold text-gray-900 pr-8 pb-3 border-b-2 border-black">
                Informasi Jenis Kegiatan
            </h3>

            <!-- Kontainer Box Abu-abu Isi Informasi -->
            <div class="mt-4 border-2 border-black bg-[#d1d5db] p-5 space-y-3">
                <p class="text-sm font-semibold text-gray-900">
                    Nama : <span id="modalNama" class="font-normal">Pengembangan Karir</span>
                </p>
                <p class="text-sm font-semibold text-gray-900">
                    Waktu Ditambahkan : <span id="modalWaktu" class="font-normal">20 April 2026</span>
                </p>
                <p class="text-sm font-semibold text-gray-900">
                    Total Peserta : <span id="modalExtra" class="font-normal">0 Orang</span>
                </p>
            </div>
        </div>
    </div>

    <!-- LOGIKA JAVASCRIPT: MODAL, SEARCH, & SORTING -->
    <script>
        const searchInput = document.getElementById('searchInput');
        const sortDropdownBtn = document.getElementById('sortDropdownBtn');
        const sortMenu = document.getElementById('sortMenu');
        const jenisKegiatanList = document.getElementById('jenisKegiatanList');
        const infoModal = document.getElementById('infoModal');
        let activeBtn = null;

        // Toggle dropdown sorting
        sortDropdownBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sortMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            if (!sortMenu.classList.contains('hidden')) {
                sortMenu.classList.add('hidden');
            }
        });

        // Fitur Pencarian Realtime
        searchInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            const items = jenisKegiatanList.querySelectorAll('.jenis-item');
            
            items.forEach(item => {
                const title = item.getAttribute('data-name').toLowerCase();
                if (title.includes(query)) {
                    item.classList.remove('hidden');
                    item.classList.add('flex');
                } else {
                    item.classList.add('hidden');
                    item.classList.remove('flex');
                }
            });
        });

        // Fitur Sorting (A-Z, Terbaru, Terlama)
        function sortItems(type) {
            const items = Array.from(jenisKegiatanList.querySelectorAll('.jenis-item'));
            
            items.sort((a, b) => {
                if (type === 'az') {
                    return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
                }
                const orderA = parseInt(a.getAttribute('data-order')) || 0;
                const orderB = parseInt(b.getAttribute('data-order')) || 0;
                return type === 'terbaru' ? orderB - orderA : orderA - orderB;
            });

            items.forEach(item => jenisKegiatanList.appendChild(item));
            sortMenu.classList.add('hidden');
        }

        // Modal Handler
        function openModal(btn) {
            const parent = btn.closest('.jenis-item');
            document.getElementById('modalNama').innerText = parent.getAttribute('data-name');
            document.getElementById('modalWaktu').innerText = parent.getAttribute('data-time');
            document.getElementById('modalExtra').innerText = parent.getAttribute('data-extra');

            // Reset tombol lain
            document.querySelectorAll('.detail-btn').forEach(b => {
                b.classList.remove('bg-blue-600', 'text-white');
                b.classList.add('bg-gray-400', 'text-gray-900');
            });

            // Aktifkan tombol yang diklik
            activeBtn = btn;
            btn.classList.remove('bg-gray-400', 'text-gray-900');
            btn.classList.add('bg-blue-600', 'text-white');

            infoModal.classList.remove('hidden');
        }

        function closeModal() {
            infoModal.classList.add('hidden');
            if (activeBtn) {
                activeBtn.classList.remove('bg-blue-600', 'text-white');
                activeBtn.classList.add('bg-gray-400', 'text-gray-900');
                activeBtn = null;
            }
        }

        infoModal.addEventListener('click', function(e) {
            if (e.target === infoModal) closeModal();
        });
    </script>
@endsection