@extends('layouts.app')

@section('content')
    <!-- KONTEN UTAMA: DAFTAR KARYAWAN -->
    <div class="border-2 border-black bg-white p-4 md:p-6 flex flex-col min-h-[520px] shadow-sm">
        
        <!-- Header Kotak: Judul + Kontrol Filter & Search -->
        <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b-2 border-black relative">
            <h2 class="text-base md:text-lg font-bold text-gray-900">
                Daftar Karyawan
            </h2>

            <!-- Kontrol Search & Dropdown Sorting -->
            <div class="flex items-center space-x-2">
                <!-- Search Box -->
                <div class="flex items-center border-2 border-black bg-gray-100 px-2 py-1">
                    <svg class="w-4 h-4 text-gray-700 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="searchInput" placeholder="cari nama" class="bg-transparent text-sm focus:outline-none w-28 sm:w-40 text-gray-900">
                </div>

                <!-- Tombol Menu Sort List -->
                <div class="relative">
                    <button id="sortDropdownBtn" class="border-2 border-black p-1.5 hover:bg-gray-100 block transition">
                        <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Popover Pilihan Sort -->
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

        <!-- Kontainer Daftar Karyawan -->
        <div id="karyawanList" class="mt-4 border-2 border-black p-3 md:p-4 max-h-[460px] overflow-y-auto space-y-4">
            
            <!-- Item 1 -->
            <div class="karyawan-item border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                 data-order="1"
                 data-name="Karyawan A"
                 data-jumlah="2"
                 data-kegiatan="Tes CASN"
                 data-lokasi="Gedung A">
                <p class="font-medium text-gray-900 text-sm md:text-base">Karyawan A</p>
                <button onclick="openModal1(this)" class="detail-main-btn self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-blue-600 hover:text-white text-gray-900 font-semibold px-6 py-1 text-sm transition">
                    Detail
                </button>
            </div>

            <!-- Item 2 -->
            <div class="karyawan-item border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                 data-order="2"
                 data-name="Karyawan B"
                 data-jumlah="4"
                 data-kegiatan="Seleksi CPNS"
                 data-lokasi="Gedung B">
                <p class="font-medium text-gray-900 text-sm md:text-base">Karyawan B</p>
                <button onclick="openModal1(this)" class="detail-main-btn self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-blue-600 hover:text-white text-gray-900 font-semibold px-6 py-1 text-sm transition">
                    Detail
                </button>
            </div>

            <!-- Item 3 -->
            <div class="karyawan-item border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                 data-order="3"
                 data-name="Karyawan C"
                 data-jumlah="5"
                 data-kegiatan="Seleksi CAT"
                 data-lokasi="Gedung C">
                <p class="font-medium text-gray-900 text-sm md:text-base">Karyawan C</p>
                <button onclick="openModal1(this)" class="detail-main-btn self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-blue-600 hover:text-white text-gray-900 font-semibold px-6 py-1 text-sm transition">
                    Detail
                </button>
            </div>

            <!-- Item 4 -->
            <div class="karyawan-item border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                 data-order="4"
                 data-name="Karyawan D"
                 data-jumlah="3"
                 data-kegiatan="Ujian Praktik"
                 data-lokasi="Gedung A">
                <p class="font-medium text-gray-900 text-sm md:text-base">Karyawan D</p>
                <button onclick="openModal1(this)" class="detail-main-btn self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-blue-600 hover:text-white text-gray-900 font-semibold px-6 py-1 text-sm transition">
                    Detail
                </button>
            </div>

            <!-- Item 5 -->
            <div class="karyawan-item border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                 data-order="5"
                 data-name="Karyawan E"
                 data-jumlah="6"
                 data-kegiatan="Wawancara"
                 data-lokasi="Gedung D">
                <p class="font-medium text-gray-900 text-sm md:text-base">Karyawan E</p>
                <button onclick="openModal1(this)" class="detail-main-btn self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-blue-600 hover:text-white text-gray-900 font-semibold px-6 py-1 text-sm transition">
                    Detail
                </button>
            </div>

        </div>
    </div>

    <!-- POPUP MODAL 1: RINGKASAN RIWAYAT KERJA -->
    <div id="modal1" class="hidden fixed inset-0 z-40 flex items-center justify-center p-4 bg-black/40">
        <div class="relative w-full max-w-xl bg-white border-2 border-black p-5 shadow-2xl">
            
            <!-- Close Silang Merah -->
            <button onclick="closeModal1()" class="absolute top-2 right-2 p-1 text-red-600 hover:text-red-800 transition">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <h3 id="modal1Title" class="text-base sm:text-lg font-bold text-gray-900 pr-8 pb-3">
                Riwayat Kerja Karyawan A
            </h3>

            <!-- Kontainer Box Abu-abu -->
            <div class="border-2 border-black bg-[#d1d5db] p-4 space-y-3 text-sm text-gray-900">
                <p><span class="font-semibold">Jumlah Kegiatan yang telah difasilitasi:</span> <span id="modal1Jumlah">2</span></p>
                <p><span class="font-semibold">Kegiatan yang difasilitasi sekarang :</span> <span id="modal1Kegiatan">Tes CASN</span></p>
                <p><span class="font-semibold">Tempat kegiatan sekarang :</span> <span id="modal1Lokasi">Gedung A</span></p>
                
                <p class="font-semibold pt-1">Daftar Riwayat Kerja :</p>
                
                <!-- Kotak Putih Daftar List Nomor + Tombol Lihat Semua -->
                <div class="border-2 border-black bg-white p-3 flex flex-col justify-between min-h-[140px]">
                    <div class="space-y-1 text-sm">
                        <p>1. Kegiatan A</p>
                        <p>2. Kegiatan B</p>
                        <p>3. Kegiatan C</p>
                        <p>4. Kegiatan D</p>
                        <p>5. ...</p>
                    </div>
                    <div class="flex justify-end pt-2">
                        <button id="btnLihatSemua" onclick="openModal2(this)" class="border-2 border-black bg-gray-400 hover:bg-blue-600 hover:text-white text-gray-900 font-semibold px-4 py-1 text-xs sm:text-sm transition">
                            Lihat Semua
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- POPUP MODAL 2: DAFTAR LENGKAP RIWAYAT KERJA -->
    <div id="modal2" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40">
        <div class="relative w-full max-w-2xl bg-white border-2 border-black p-5 shadow-2xl">
            
            <!-- Close Silang Merah -->
            <button onclick="closeModal2()" class="absolute top-2 right-2 p-1 text-red-600 hover:text-red-800 transition">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <h3 id="modal2Title" class="text-base sm:text-lg font-bold text-gray-900 pr-8 pb-3">
                Daftar Riwayat Kerja Karyawan A
            </h3>

            <!-- Kontainer Box Abu-abu dengan Scroll -->
            <div class="border-2 border-black bg-[#d1d5db] p-4 max-h-[380px] overflow-y-auto space-y-3">
                
                <div class="border-2 border-black bg-white p-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm sm:text-base">Kegiatan A</h4>
                        <div class="flex flex-wrap items-center gap-x-6 text-xs text-gray-700 mt-1">
                            <span>Gedung A</span>
                            <span>Selasa, 03 ... 20xx</span>
                        </div>
                    </div>
                    <button class="self-end sm:self-center border-2 border-black bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-1 text-xs sm:text-sm transition">
                        Detail
                    </button>
                </div>

                <div class="border-2 border-black bg-white p-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm sm:text-base">Kegiatan B</h4>
                        <div class="flex flex-wrap items-center gap-x-6 text-xs text-gray-700 mt-1">
                            <span>Gedung B</span>
                            <span>Rabu, 04 ... 20xx</span>
                        </div>
                    </div>
                    <button class="self-end sm:self-center border-2 border-black bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-1 text-xs sm:text-sm transition">
                        Detail
                    </button>
                </div>

                <div class="border-2 border-black bg-white p-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm sm:text-base">Kegiatan C</h4>
                        <div class="flex flex-wrap items-center gap-x-6 text-xs text-gray-700 mt-1">
                            <span>Gedung C</span>
                            <span>Kamis, 05 ... 20xx</span>
                        </div>
                    </div>
                    <button class="self-end sm:self-center border-2 border-black bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-1 text-xs sm:text-sm transition">
                        Detail
                    </button>
                </div>

                <div class="border-2 border-black bg-white p-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm sm:text-base">Kegiatan D</h4>
                        <div class="flex flex-wrap items-center gap-x-6 text-xs text-gray-700 mt-1">
                            <span>Gedung D</span>
                            <span>Selasa, 10 ... 20xx</span>
                        </div>
                    </div>
                    <button class="self-end sm:self-center border-2 border-black bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-1 text-xs sm:text-sm transition">
                        Detail
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- SCRIPT JAVASCRIPT: FILTER, SEARCH, & MODAL BERJENJANG -->
    <script>
        const searchInput = document.getElementById('searchInput');
        const sortDropdownBtn = document.getElementById('sortDropdownBtn');
        const sortMenu = document.getElementById('sortMenu');
        const karyawanList = document.getElementById('karyawanList');
        
        const modal1 = document.getElementById('modal1');
        const modal2 = document.getElementById('modal2');
        let currentKaryawanName = '';
        let activeMainBtn = null;
        let activeLihatSemuaBtn = null;

        // Toggle Sort Menu
        sortDropdownBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sortMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            if (!sortMenu.classList.contains('hidden')) {
                sortMenu.classList.add('hidden');
            }
        });

        // Search Karyawan
        searchInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            const items = karyawanList.querySelectorAll('.karyawan-item');
            items.forEach(item => {
                const name = item.getAttribute('data-name').toLowerCase();
                if (name.includes(query)) {
                    item.classList.remove('hidden');
                    item.classList.add('flex');
                } else {
                    item.classList.add('hidden');
                    item.classList.remove('flex');
                }
            });
        });

        // Sorting
        function sortItems(type) {
            const items = Array.from(karyawanList.querySelectorAll('.karyawan-item'));
            items.sort((a, b) => {
                if (type === 'az') {
                    return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
                }
                const orderA = parseInt(a.getAttribute('data-order')) || 0;
                const orderB = parseInt(b.getAttribute('data-order')) || 0;
                return type === 'terbaru' ? orderB - orderA : orderA - orderB;
            });
            items.forEach(item => karyawanList.appendChild(item));
            sortMenu.classList.add('hidden');
        }

        // Buka Modal 1 (Ringkasan)
        function openModal1(btn) {
            const parent = btn.closest('.karyawan-item');
            currentKaryawanName = parent.getAttribute('data-name');
            
            document.getElementById('modal1Title').innerText = `Riwayat Kerja ${currentKaryawanName}`;
            document.getElementById('modal1Jumlah').innerText = parent.getAttribute('data-jumlah');
            document.getElementById('modal1Kegiatan').innerText = parent.getAttribute('data-kegiatan');
            document.getElementById('modal1Lokasi').innerText = parent.getAttribute('data-lokasi');

            // Reset tombol detail baris
            document.querySelectorAll('.detail-main-btn').forEach(b => {
                b.classList.remove('bg-blue-600', 'text-white');
                b.classList.add('bg-gray-400', 'text-gray-900');
            });

            activeMainBtn = btn;
            btn.classList.remove('bg-gray-400', 'text-gray-900');
            btn.classList.add('bg-blue-600', 'text-white');

            modal1.classList.remove('hidden');
        }

        function closeModal1() {
            modal1.classList.add('hidden');
            if (activeMainBtn) {
                activeMainBtn.classList.remove('bg-blue-600', 'text-white');
                activeMainBtn.classList.add('bg-gray-400', 'text-gray-900');
                activeMainBtn = null;
            }
        }

        // Buka Modal 2 (Lihat Semua)
        function openModal2(btn) {
            document.getElementById('modal2Title').innerText = `Daftar Riwayat Kerja ${currentKaryawanName}`;
            
            activeLihatSemuaBtn = btn;
            btn.classList.remove('bg-gray-400', 'text-gray-900');
            btn.classList.add('bg-blue-600', 'text-white');

            modal2.classList.remove('hidden');
        }

        function closeModal2() {
            modal2.classList.add('hidden');
            if (activeLihatSemuaBtn) {
                activeLihatSemuaBtn.classList.remove('bg-blue-600', 'text-white');
                activeLihatSemuaBtn.classList.add('bg-gray-400', 'text-gray-900');
                activeLihatSemuaBtn = null;
            }
        }

        modal1.addEventListener('click', (e) => { if (e.target === modal1) closeModal1(); });
        modal2.addEventListener('click', (e) => { if (e.target === modal2) closeModal2(); });
    </script>
@endsection