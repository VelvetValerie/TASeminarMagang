@extends('layouts.app')

@section('content')
    <!-- AREA KONTEN UTAMA: DAFTAR PERENCANAAN KEGIATAN -->
    <div class="border-2 border-black bg-white p-4 md:p-6 flex flex-col min-h-[520px] shadow-sm">
        
        <!-- Header Kotak: Judul + Icon Filter + Icon Tambah -->
        <div class="flex items-center justify-between pb-3 border-b-2 border-black">
            <h2 class="text-base md:text-lg font-bold text-gray-900">
                Daftar Perencanaan Kegiatan
            </h2>

            <div class="flex items-center space-x-3">
                <!-- Icon Filter Corong -->
                <button class="p-1 hover:bg-gray-100 rounded text-gray-900 transition" title="Filter Kegiatan">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                </button>

                <!-- Icon Tambah / Plus Bars -->
                <button class="p-1 hover:bg-gray-100 rounded text-gray-900 transition" title="Tambah Kegiatan">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h9M4 12h9M4 18h9M18 9v6m-3-3h6"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Kontainer Daftar Kartu Kegiatan -->
        <div class="mt-4 border-2 border-black p-3 md:p-4 max-h-[460px] overflow-y-auto space-y-4">
            
            <!-- Kegiatan A -->
            <div class="kegiatan-row border-2 border-black bg-[#d1d5db] p-4 flex flex-col md:flex-row md:items-center justify-between gap-4"
                 data-nama="Kegiatan A"
                 data-koordinator="Pegawai A"
                 data-jenis="Tes CASN"
                 data-tanggal="Selasa, 03 ... 20xx"
                 data-lokasi="Gedung A"
                 data-instansi="Instansi A"
                 data-peserta="100"
                 data-status="Belum Konfirmasi"
                 data-lampiran="https://drive.google.com/file/d/sampleA">
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Kegiatan A</h3>
                    <p class="text-sm text-gray-700 mt-0.5">Koordinator: Pegawai A</p>
                </div>
                <!-- Grup Tombol Aksi -->
                <div class="flex items-center space-x-3 self-end md:self-center">
                    <!-- Icon Detail / Rantai -->
                    <button onclick="openDetailModal(this)" class="p-1 text-gray-900 hover:text-blue-600 transition" title="Detail Lampiran / Info">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </button>
                    <!-- Icon Hapus / Sampah -->
                    <button onclick="hapusKegiatan('Kegiatan A')" class="p-1 text-gray-900 hover:text-red-600 transition" title="Hapus Kegiatan">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                    <!-- Icon Edit / Pensil -->
                    <button onclick="editKegiatan('Kegiatan A')" class="p-1 text-gray-900 hover:text-yellow-600 transition" title="Edit Kegiatan">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </button>
                    <!-- Tombol Konfirmasi -->
                    <button class="border-2 border-black bg-gray-400 hover:bg-gray-500 text-gray-900 font-semibold px-4 py-1 text-sm transition">
                        Konfirmasi
                    </button>
                </div>
            </div>

            <!-- Kegiatan B -->
            <div class="kegiatan-row border-2 border-black bg-[#d1d5db] p-4 flex flex-col md:flex-row md:items-center justify-between gap-4"
                 data-nama="Kegiatan B"
                 data-koordinator="Pegawai B"
                 data-jenis="Seleksi CPNS"
                 data-tanggal="Rabu, 04 ... 20xx"
                 data-lokasi="Gedung B"
                 data-instansi="Instansi B"
                 data-peserta="120"
                 data-status="Belum Konfirmasi"
                 data-lampiran="https://drive.google.com/file/d/sampleB">
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Kegiatan B</h3>
                    <p class="text-sm text-gray-700 mt-0.5">Koordinator: Pegawai B</p>
                </div>
                <div class="flex items-center space-x-3 self-end md:self-center">
                    <button onclick="openDetailModal(this)" class="p-1 text-gray-900 hover:text-blue-600 transition" title="Detail Lampiran / Info">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </button>
                    <button onclick="hapusKegiatan('Kegiatan B')" class="p-1 text-gray-900 hover:text-red-600 transition" title="Hapus Kegiatan">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                    <button onclick="editKegiatan('Kegiatan B')" class="p-1 text-gray-900 hover:text-yellow-600 transition" title="Edit Kegiatan">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </button>
                    <button class="border-2 border-black bg-gray-400 hover:bg-gray-500 text-gray-900 font-semibold px-4 py-1 text-sm transition">
                        Konfirmasi
                    </button>
                </div>
            </div>

            <!-- Kegiatan C -->
            <div class="kegiatan-row border-2 border-black bg-[#d1d5db] p-4 flex flex-col md:flex-row md:items-center justify-between gap-4"
                 data-nama="Kegiatan C"
                 data-koordinator="Pegawai C"
                 data-jenis="Seleksi CAT"
                 data-tanggal="Kamis, 05 ... 20xx"
                 data-lokasi="Gedung C"
                 data-instansi="Instansi C"
                 data-peserta="80"
                 data-status="Belum Konfirmasi"
                 data-lampiran="https://drive.google.com/file/d/sampleC">
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Kegiatan C</h3>
                    <p class="text-sm text-gray-700 mt-0.5">Koordinator: Pegawai C</p>
                </div>
                <div class="flex items-center space-x-3 self-end md:self-center">
                    <button onclick="openDetailModal(this)" class="p-1 text-gray-900 hover:text-blue-600 transition" title="Detail Lampiran / Info">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </button>
                    <button onclick="hapusKegiatan('Kegiatan C')" class="p-1 text-gray-900 hover:text-red-600 transition" title="Hapus Kegiatan">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                    <button onclick="editKegiatan('Kegiatan C')" class="p-1 text-gray-900 hover:text-yellow-600 transition" title="Edit Kegiatan">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </button>
                    <button class="border-2 border-black bg-gray-400 hover:bg-gray-500 text-gray-900 font-semibold px-4 py-1 text-sm transition">
                        Konfirmasi
                    </button>
                </div>
            </div>

            <!-- Kegiatan D -->
            <div class="kegiatan-row border-2 border-black bg-[#d1d5db] p-4 flex flex-col md:flex-row md:items-center justify-between gap-4"
                 data-nama="Kegiatan D"
                 data-koordinator="Pegawai D"
                 data-jenis="Ujian Praktik"
                 data-tanggal="Jumat, 06 ... 20xx"
                 data-lokasi="Gedung D"
                 data-instansi="Instansi D"
                 data-peserta="90"
                 data-status="Belum Konfirmasi"
                 data-lampiran="https://drive.google.com/file/d/sampleD">
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Kegiatan D</h3>
                    <p class="text-sm text-gray-700 mt-0.5">Koordinator: Pegawai D</p>
                </div>
                <div class="flex items-center space-x-3 self-end md:self-center">
                    <button onclick="openDetailModal(this)" class="p-1 text-gray-900 hover:text-blue-600 transition" title="Detail Lampiran / Info">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </button>
                    <button onclick="hapusKegiatan('Kegiatan D')" class="p-1 text-gray-900 hover:text-red-600 transition" title="Hapus Kegiatan">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                    <button onclick="editKegiatan('Kegiatan D')" class="p-1 text-gray-900 hover:text-yellow-600 transition" title="Edit Kegiatan">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </button>
                    <button class="border-2 border-black bg-gray-400 hover:bg-gray-500 text-gray-900 font-semibold px-4 py-1 text-sm transition">
                        Konfirmasi
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- POPUP MODAL DETAIL KEGIATAN -->
    <div id="detailKegiatanModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40">
        <div class="relative w-full max-w-xl bg-white border-2 border-black p-5 shadow-2xl">
            
            <!-- Tombol Close Silang Merah -->
            <button onclick="closeDetailModal()" class="absolute top-2 right-2 p-1 text-red-600 hover:text-red-800 transition" title="Tutup">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- Judul Modal -->
            <h3 id="modalDetailTitle" class="text-base sm:text-lg font-bold text-gray-900 pr-8 pb-3">
                Detail Kegiatan A
            </h3>

            <!-- Kontainer Box Abu-abu Isi Lengkap -->
            <div class="border-2 border-black bg-[#d1d5db] p-5 space-y-2.5 text-xs sm:text-sm text-gray-900">
                <p><span class="font-semibold">Koordinator :</span> <span id="dtKoordinator">Pegawai A</span></p>
                <p><span class="font-semibold">Jenis Kegiatan :</span> <span id="dtJenis">Tes CASN</span></p>
                <p><span class="font-semibold">Tanggal pelaksanaan :</span> <span id="dtTanggal">Selasa, 03 ... 20xx</span></p>
                <p><span class="font-semibold">Titik Lokasi :</span> <span id="dtLokasi">Gedung A</span></p>
                <p><span class="font-semibold">Nama Instansi :</span> <span id="dtInstansi">Instansi A</span></p>
                <p><span class="font-semibold">Jumlah peserta :</span> <span id="dtPeserta">100</span></p>
                <p><span class="font-semibold">Status :</span> <span id="dtStatus">Belum Konfirmasi</span></p>
                <p>
                    <span class="font-semibold">Lampiran :</span> 
                    <a id="dtLampiran" href="#" target="_blank" class="text-blue-700 underline font-medium break-all">https://drive.google.com/...</a>
                </p>
            </div>
        </div>
    </div>

    <!-- SCRIPT JAVASCRIPT AKSI & MODAL -->
    <script>
        const modal = document.getElementById('detailKegiatanModal');

        function openDetailModal(button) {
            const row = button.closest('.kegiatan-row');
            
            document.getElementById('modalDetailTitle').innerText = 'Detail ' + row.getAttribute('data-nama');
            document.getElementById('dtKoordinator').innerText = row.getAttribute('data-koordinator');
            document.getElementById('dtJenis').innerText = row.getAttribute('data-jenis');
            document.getElementById('dtTanggal').innerText = row.getAttribute('data-tanggal');
            document.getElementById('dtLokasi').innerText = row.getAttribute('data-lokasi');
            document.getElementById('dtInstansi').innerText = row.getAttribute('data-instansi');
            document.getElementById('dtPeserta').innerText = row.getAttribute('data-peserta');
            document.getElementById('dtStatus').innerText = row.getAttribute('data-status');
            
            const lampiranLink = document.getElementById('dtLampiran');
            const url = row.getAttribute('data-lampiran');
            lampiranLink.innerText = url;
            lampiranLink.href = url;

            modal.classList.remove('hidden');
        }

        function closeDetailModal() {
            modal.classList.add('hidden');
        }

        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeDetailModal();
        });

        function hapusKegiatan(nama) {
            if (confirm(`Apakah Anda yakin ingin menghapus data ${nama}?`)) {
                alert(`Data ${nama} berhasil dihapus.`);
            }
        }

        function editKegiatan(nama) {
            alert(`Membuka form edit untuk ${nama}.`);
        }
    </script>
@endsection