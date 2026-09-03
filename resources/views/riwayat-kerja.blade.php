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
                    <button id="sortDropdownBtn" class="border-2 border-black p-1.5 hover:bg-gray-100 block transition cursor-pointer" title="Urutkan Data">
                        <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Popover Pilihan Sort -->
                    <div id="sortMenu" class="hidden absolute right-0 top-full mt-1 w-32 border-2 border-black bg-white shadow-md z-20">
                        <button type="button" onclick="sortItems('az')" class="w-full text-center py-1.5 text-xs sm:text-sm font-medium text-gray-900 border-b-2 border-black hover:bg-gray-100 block cursor-pointer">
                            A - Z
                        </button>
                        <button type="button" onclick="sortItems('terbaru')" class="w-full text-center py-1.5 text-xs sm:text-sm font-medium text-gray-900 border-b-2 border-black hover:bg-gray-100 block cursor-pointer">
                            Terbanyak
                        </button>
                        <button type="button" onclick="sortItems('terlama')" class="w-full text-center py-1.5 text-xs sm:text-sm font-medium text-gray-900 hover:bg-gray-100 block cursor-pointer">
                            Tersedikit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kontainer Daftar Karyawan -->
        <div id="karyawanList" class="mt-4 border-2 border-black p-3 md:p-4 max-h-[460px] overflow-y-auto space-y-4">
            @if(isset($karyawan) && $karyawan->count() > 0)
                {{-- Mode Dinamis Database --}}
                @foreach($karyawan as $idx => $item)
                    @php
                        $kegiatanList = $item->kegiatan ?? collect();
                        $kegiatanTerakhir = $kegiatanList->sortByDesc('tanggal_mulai')->first();
                        $kegiatanPayload = $kegiatanList->map(function($k) use ($item) {
                            $tglMulai = \Carbon\Carbon::parse($k->tanggal_mulai)->translatedFormat('l, d F Y');
                            $tglSelesai = $k->tanggal_selesai ? \Carbon\Carbon::parse($k->tanggal_selesai)->translatedFormat('l, d F Y') : $tglMulai;
                            $tglText = ($tglMulai === $tglSelesai) ? $tglMulai : "{$tglMulai} ~ {$tglSelesai}";
                            return [
                                'nama' => $k->nama_keg,
                                'lokasi' => $k->lokasi->nm_lokasi ?? '-',
                                'alamat' => $k->lokasi->alamat ?? '-',
                                'tanggal' => $tglText,
                                'koordinator' => $item->nama_karyawan ?? '-',
                                'jenis' => $k->jenis->nama_jeniskeg ?? '-',
                                'peserta' => number_format($k->jmlh_peserta ?? 0),
                                'status' => $k->status ?? '-',
                                'lampiran' => $k->lampiran ?? '-'
                            ];
                        })->values();
                    @endphp
                    <div class="karyawan-item border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                         data-order="{{ $idx + 1 }}"
                         data-name="{{ $item->nama_karyawan }}"
                         data-jumlah="{{ $kegiatanList->count() }}"
                         data-kegiatan="{{ $kegiatanTerakhir->nama_keg ?? '-' }}"
                         data-lokasi="{{ $kegiatanTerakhir->lokasi->nm_lokasi ?? '-' }}"
                         data-items='@json($kegiatanPayload)'>
                        <p class="font-medium text-gray-900 text-sm md:text-base">{{ $item->nama_karyawan }}</p>
                        <button type="button" onclick="openModal1(this)" class="detail-main-btn self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-blue-600 hover:text-white text-gray-900 font-semibold px-6 py-1 text-sm transition cursor-pointer">
                            Detail
                        </button>
                    </div>
                @endforeach
            @else
                {{-- Mode Fallback Statis (Jika Belum Memuat Variabel dari Controller) --}}
                <div class="karyawan-item border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                     data-order="1"
                     data-name="Karyawan A"
                     data-jumlah="4"
                     data-kegiatan="Tes CASN"
                     data-lokasi="Gedung A"
                     data-items='[{"nama":"Kegiatan A","lokasi":"Gedung A","alamat":"Ruang 1","tanggal":"Selasa, 03 Juni 2026","koordinator":"Karyawan A","jenis":"Tes CASN","peserta":"200","status":"Terlaksana","lampiran":"-"},{"nama":"Kegiatan B","lokasi":"Gedung B","alamat":"Ruang 2","tanggal":"Rabu, 04 Juni 2026","koordinator":"Karyawan A","jenis":"Tes CAT","peserta":"150","status":"Terlaksana","lampiran":"-"},{"nama":"Kegiatan C","lokasi":"Gedung C","alamat":"Ruang 3","tanggal":"Kamis, 05 Juni 2026","koordinator":"Karyawan A","jenis":"Seleksi CPNS","peserta":"180","status":"Terlaksana","lampiran":"-"},{"nama":"Kegiatan D","lokasi":"Gedung D","alamat":"Ruang 4","tanggal":"Selasa, 10 Juni 2026","koordinator":"Karyawan A","jenis":"Tes Non-ASN","peserta":"120","status":"Terlaksana","lampiran":"-"}]'>
                    <p class="font-medium text-gray-900 text-sm md:text-base">Karyawan A</p>
                    <button type="button" onclick="openModal1(this)" class="detail-main-btn self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-blue-600 hover:text-white text-gray-900 font-semibold px-6 py-1 text-sm transition cursor-pointer">
                        Detail
                    </button>
                </div>

                <div class="karyawan-item border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                     data-order="2"
                     data-name="Karyawan B"
                     data-jumlah="2"
                     data-kegiatan="Seleksi CPNS"
                     data-lokasi="Gedung B"
                     data-items='[{"nama":"Kegiatan B","lokasi":"Gedung B","alamat":"Ruang Utama","tanggal":"Rabu, 04 Juni 2026","koordinator":"Karyawan B","jenis":"Seleksi CPNS","peserta":"150","status":"Terlaksana","lampiran":"-"},{"nama":"Kegiatan C","lokasi":"Gedung C","alamat":"Ruang CAT","tanggal":"Kamis, 05 Juni 2026","koordinator":"Karyawan B","jenis":"Tes CAT","peserta":"180","status":"Terlaksana","lampiran":"-"}]'>
                    <p class="font-medium text-gray-900 text-sm md:text-base">Karyawan B</p>
                    <button type="button" onclick="openModal1(this)" class="detail-main-btn self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-blue-600 hover:text-white text-gray-900 font-semibold px-6 py-1 text-sm transition cursor-pointer">
                        Detail
                    </button>
                </div>

                <div class="karyawan-item border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                     data-order="3"
                     data-name="Karyawan C"
                     data-jumlah="1"
                     data-kegiatan="Seleksi CAT"
                     data-lokasi="Gedung C"
                     data-items='[{"nama":"Kegiatan C","lokasi":"Gedung C","alamat":"Ruang Sidang","tanggal":"Kamis, 05 Juni 2026","koordinator":"Karyawan C","jenis":"Seleksi CAT","peserta":"180","status":"Terlaksana","lampiran":"-"}]'>
                    <p class="font-medium text-gray-900 text-sm md:text-base">Karyawan C</p>
                    <button type="button" onclick="openModal1(this)" class="detail-main-btn self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-blue-600 hover:text-white text-gray-900 font-semibold px-6 py-1 text-sm transition cursor-pointer">
                        Detail
                    </button>
                </div>

                <div class="karyawan-item border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                     data-order="4"
                     data-name="Karyawan D"
                     data-jumlah="1"
                     data-kegiatan="Ujian Praktik"
                     data-lokasi="Gedung A"
                     data-items='[{"nama":"Kegiatan D","lokasi":"Gedung A","alamat":"Ruang Komputer","tanggal":"Selasa, 10 Juni 2026","koordinator":"Karyawan D","jenis":"Ujian Praktik","peserta":"100","status":"Terlaksana","lampiran":"-"}]'>
                    <p class="font-medium text-gray-900 text-sm md:text-base">Karyawan D</p>
                    <button type="button" onclick="openModal1(this)" class="detail-main-btn self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-blue-600 hover:text-white text-gray-900 font-semibold px-6 py-1 text-sm transition cursor-pointer">
                        Detail
                    </button>
                </div>

                <div class="karyawan-item border-2 border-black bg-[#d1d5db] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                     data-order="5"
                     data-name="Karyawan E"
                     data-jumlah="1"
                     data-kegiatan="Wawancara"
                     data-lokasi="Gedung D"
                     data-items='[{"nama":"Kegiatan E","lokasi":"Gedung D","alamat":"Ruang Wawancara","tanggal":"Rabu, 11 Juni 2026","koordinator":"Karyawan E","jenis":"Wawancara","peserta":"50","status":"Terlaksana","lampiran":"-"}]'>
                    <p class="font-medium text-gray-900 text-sm md:text-base">Karyawan E</p>
                    <button type="button" onclick="openModal1(this)" class="detail-main-btn self-end sm:self-center border-2 border-black bg-gray-400 hover:bg-blue-600 hover:text-white text-gray-900 font-semibold px-6 py-1 text-sm transition cursor-pointer">
                        Detail
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- POPUP MODAL 1: RINGKASAN RIWAYAT KERJA -->
    <div id="modal1" class="hidden fixed inset-0 z-40 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs">
        <div class="relative w-full max-w-xl bg-white border-2 border-black p-5 shadow-2xl">
            
            <!-- Close Silang Merah -->
            <button type="button" onclick="closeModal1()" class="absolute top-2 right-2 p-1 text-red-600 hover:text-red-800 transition cursor-pointer" title="Tutup">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <h3 id="modal1Title" class="text-base sm:text-lg font-bold text-gray-900 pr-8 pb-3">
                Riwayat Kerja Karyawan
            </h3>

            <!-- Kontainer Box Abu-abu -->
            <div class="border-2 border-black bg-[#d1d5db] p-4 space-y-3 text-sm text-gray-900">
                <p><span class="font-semibold">Jumlah Kegiatan yang telah difasilitasi:</span> <span id="modal1Jumlah">0</span></p>
                <p><span class="font-semibold">Kegiatan yang difasilitasi sekarang :</span> <span id="modal1Kegiatan">-</span></p>
                <p><span class="font-semibold">Tempat kegiatan sekarang :</span> <span id="modal1Lokasi">-</span></p>
                
                <p class="font-semibold pt-1">Daftar Riwayat Kerja :</p>
                
                <!-- Kotak Putih Daftar List Nomor + Tombol Lihat Semua -->
                <div class="border-2 border-black bg-white p-3 flex flex-col justify-between min-h-[140px]">
                    <div id="modal1ListSnippet" class="space-y-1 text-sm max-h-36 overflow-y-auto">
                        <!-- Diisi otomatis melalui JS -->
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="button" id="btnLihatSemua" onclick="openModal2(this)" class="border-2 border-black bg-gray-400 hover:bg-blue-600 hover:text-white text-gray-900 font-semibold px-4 py-1 text-xs sm:text-sm transition cursor-pointer">
                            Lihat Semua
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- POPUP MODAL 2: DAFTAR LENGKAP RIWAYAT KERJA -->
    <div id="modal2" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div class="relative w-full max-w-2xl bg-white border-2 border-black p-5 shadow-2xl">
            
            <!-- Close Silang Merah -->
            <button type="button" onclick="closeModal2()" class="absolute top-2 right-2 p-1 text-red-600 hover:text-red-800 transition cursor-pointer" title="Tutup">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <h3 id="modal2Title" class="text-base sm:text-lg font-bold text-gray-900 pr-8 pb-3">
                Daftar Riwayat Kerja Karyawan
            </h3>

            <!-- Kontainer Box Abu-abu dengan Scroll -->
            <div id="modal2ListFull" class="border-2 border-black bg-[#d1d5db] p-4 max-h-[380px] overflow-y-auto space-y-3">
                <!-- Rincian lengkap seluruh kegiatan dimasukkan secara dinamis di sini -->
            </div>
        </div>
    </div>

    <!-- POPUP MODAL 3: RINCIAN DETAIL KEGIATAN SPESIFIK -->
    <div id="modal3Detail" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div class="relative w-full max-w-xl bg-white border-2 border-black p-5 shadow-2xl">
            <button type="button" onclick="closeModal3()" class="absolute top-2 right-2 p-1 text-red-600 hover:text-red-800 transition cursor-pointer" title="Kembali">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <h3 id="dtJudulModal" class="text-base sm:text-lg font-bold text-gray-900 pr-8 pb-3 border-b-2 border-black">
                Detail Kegiatan
            </h3>
            <div class="mt-4 border-2 border-black bg-[#d1d5db] p-5 space-y-2.5 text-xs sm:text-sm text-gray-900">
                <p><span class="font-semibold">Nama Kegiatan :</span> <span id="dtNamaKeg">-</span></p>
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

    <!-- SCRIPT JAVASCRIPT: FILTER, SEARCH, & MODAL DINAMIS -->
    <script>
        const searchInput = document.getElementById('searchInput');
        const sortDropdownBtn = document.getElementById('sortDropdownBtn');
        const sortMenu = document.getElementById('sortMenu');
        const karyawanList = document.getElementById('karyawanList');
        
        const modal1 = document.getElementById('modal1');
        const modal2 = document.getElementById('modal2');
        const modal3 = document.getElementById('modal3Detail');

        let currentKaryawanName = '';
        let currentKaryawanItems = [];
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
                const countA = parseInt(a.getAttribute('data-jumlah')) || 0;
                const countB = parseInt(b.getAttribute('data-jumlah')) || 0;
                return type === 'terbaru' ? countB - countA : countA - countB;
            });
            items.forEach(item => karyawanList.appendChild(item));
            sortMenu.classList.add('hidden');
        }

        // Buka Modal 1 (Ringkasan Riwayat Kerja)
        function openModal1(btn) {
            const parent = btn.closest('.karyawan-item');
            currentKaryawanName = parent.getAttribute('data-name');
            
            try {
                currentKaryawanItems = JSON.parse(parent.getAttribute('data-items') || '[]');
            } catch(err) {
                currentKaryawanItems = [];
            }
            
            document.getElementById('modal1Title').innerText = `Riwayat Kerja ${currentKaryawanName}`;
            document.getElementById('modal1Jumlah').innerText = parent.getAttribute('data-jumlah');
            document.getElementById('modal1Kegiatan').innerText = parent.getAttribute('data-kegiatan') || '-';
            document.getElementById('modal1Lokasi').innerText = parent.getAttribute('data-lokasi') || '-';

            // Masukkan cuplikan nomor daftar kegiatan
            const snippetContainer = document.getElementById('modal1ListSnippet');
            snippetContainer.innerHTML = '';
            if (currentKaryawanItems.length > 0) {
                currentKaryawanItems.slice(0, 4).forEach((item, index) => {
                    const p = document.createElement('p');
                    p.innerText = `${index + 1}. ${item.nama}`;
                    snippetContainer.appendChild(p);
                });
                if (currentKaryawanItems.length > 4) {
                    const p = document.createElement('p');
                    p.innerText = '5. ...';
                    snippetContainer.appendChild(p);
                }
            } else {
                snippetContainer.innerHTML = '<p class="text-gray-500 italic">Belum ada kegiatan yang difasilitasi.</p>';
            }

            // Reset highlight tombol detail baris
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

        // Buka Modal 2 (Lihat Semua Kegiatan Karyawan)
        function openModal2(btn) {
            document.getElementById('modal2Title').innerText = `Daftar Riwayat Kerja ${currentKaryawanName}`;
            
            const listFullContainer = document.getElementById('modal2ListFull');
            listFullContainer.innerHTML = '';

            if (currentKaryawanItems.length > 0) {
                currentKaryawanItems.forEach((item, index) => {
                    const card = document.createElement('div');
                    card.className = 'border-2 border-black bg-white p-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3';
                    card.innerHTML = `
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm sm:text-base">${item.nama}</h4>
                            <div class="flex flex-wrap items-center gap-x-6 text-xs text-gray-700 mt-1">
                                <span>${item.lokasi}</span>
                                <span>${item.tanggal}</span>
                            </div>
                        </div>
                        <button type="button" 
                                onclick="openModal3('${encodeURIComponent(JSON.stringify(item))}')"
                                class="self-end sm:self-center border-2 border-black bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-1 text-xs sm:text-sm transition cursor-pointer">
                            Detail
                        </button>
                    `;
                    listFullContainer.appendChild(card);
                });
            } else {
                listFullContainer.innerHTML = '<div class="text-center py-6 text-gray-500 font-semibold text-sm">Tidak ada riwayat kegiatan tercatat.</div>';
            }

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

        // Buka Modal 3 (Rincian Lengkap Kegiatan)
        function openModal3(encodedJson) {
            const item = JSON.parse(decodeURIComponent(encodedJson));
            document.getElementById('dtJudulModal').innerText = `Detail ${item.nama}`;
            document.getElementById('dtNamaKeg').innerText = item.nama;
            document.getElementById('dtKoordinator').innerText = item.koordinator;
            document.getElementById('dtJenis').innerText = item.jenis;
            document.getElementById('dtTanggalPelaksanaan').innerText = item.tanggal;
            document.getElementById('dtTitikLokasi').innerText = `${item.lokasi} (${item.alamat})`;
            document.getElementById('dtJumlahPeserta').innerText = item.peserta;
            document.getElementById('dtStatusKegiatan').innerText = item.status;
            
            const lampiranElem = document.getElementById('dtLampiranUrl');
            lampiranElem.innerText = item.lampiran;
            lampiranElem.href = (item.lampiran && item.lampiran !== '-') ? item.lampiran : '#';

            modal3.classList.remove('hidden');
        }

        function closeModal3() {
            modal3.classList.add('hidden');
        }

        // Klik di luar modal untuk menutup
        modal1.addEventListener('click', (e) => { if (e.target === modal1) closeModal1(); });
        modal2.addEventListener('click', (e) => { if (e.target === modal2) closeModal2(); });
        modal3.addEventListener('click', (e) => { if (e.target === modal3) closeModal3(); });
    </script>
@endsection