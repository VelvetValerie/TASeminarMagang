@extends('layouts.app')

@section('content')
    <!-- NOTIFIKASI SUKSES (Jika ada aksi tambah/hapus) -->
    @if(session('success'))
        <div class="mb-4 border-2 border-black bg-emerald-100 p-3 font-semibold text-sm text-emerald-900 shadow-sm flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-900 font-bold ml-4">&times;</button>
        </div>
    @endif

    <!-- NOTIFIKASI VALIDASI ERROR -->
    @if($errors->any())
        <div class="mb-4 border-2 border-black bg-rose-100 p-3 font-semibold text-xs text-rose-900 shadow-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- AREA KONTEN UTAMA: DAFTAR PERENCANAAN KEGIATAN -->
    <div class="border-2 border-black bg-white p-4 md:p-6 flex flex-col min-h-[520px] shadow-sm">
        
        <!-- Header Kotak: Judul + Icon Filter + Tombol Tambah (+) -->
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

                <!-- Tombol Tambah Kegiatan (Membuka Popup Modal) -->
                <button onclick="openAddModal()" class="p-1 text-[#0095ff] hover:bg-blue-50 border-2 border-transparent transition" title="Tambah Kegiatan">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h9M4 12h9M4 18h9M18 9v6m-3-3h6"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Kontainer Daftar Kartu Kegiatan dari Database SQL -->
        <div class="mt-4 border-2 border-black p-3 md:p-4 max-h-[460px] overflow-y-auto space-y-4">
            @forelse($kegiatan as $item)
                <div class="kegiatan-row border-2 border-black bg-[#d1d5db] p-4 flex flex-col md:flex-row md:items-center justify-between gap-4"
                     data-nama="{{ $item->nama_keg }}"
                     data-koordinator="{{ $item->koordinator->nama_karyawan ?? 'Belum ditentukan' }}"
                     data-jenis="{{ $item->jenis->nama_jeniskeg ?? '-' }}"
                     data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('l, d F Y') }}"
                     data-lokasi="{{ $item->lokasi->nm_lokasi ?? '-' }}"
                     data-instansi="{{ $item->instansi->nm_instansi ?? '-' }}"
                     data-peserta="{{ number_format($item->jmlh_peserta) }}"
                     data-status="{{ $item->status }}"
                     data-lampiran="{{ $item->lampiran ?? 'https://drive.google.com/...' }}">
                    
                    <div>
                        <h3 class="font-bold text-gray-900 text-base">{{ $item->nama_keg }}</h3>
                        <p class="text-sm text-gray-700 mt-0.5">
                            Koordinator: {{ $item->koordinator->nama_karyawan ?? 'Tidak ada data' }}
                        </p>
                    </div>

                    <!-- Grup Tombol Aksi -->
                    <div class="flex items-center space-x-3 self-end md:self-center">
                        <!-- Icon Detail / Rantai -->
                        <button onclick="openDetailModal(this)" class="p-1 text-gray-900 hover:text-blue-600 transition" title="Detail Kegiatan">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </button>

                        <!-- Form & Icon Hapus / Sampah (Langsung ke Database) -->
                        <form action="{{ route('kegiatan.destroy', $item->id_keg) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data {{ $item->nama_keg }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 text-gray-900 hover:text-red-600 transition" title="Hapus Kegiatan">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>

                        <!-- Icon Edit / Pensil -->
                        <button onclick="alert('Membuka form edit untuk {{ $item->nama_keg }}')" class="p-1 text-gray-900 hover:text-yellow-600 transition" title="Edit Kegiatan">
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
            @empty
                <div class="text-center py-8 text-gray-500 font-semibold text-sm">
                    Belum ada data perencanaan kegiatan yang tersimpan di database.
                </div>
            @endforelse
        </div>
    </div>

    <!-- POPUP MODAL 1: TAMBAH PERENCANAAN KEGIATAN -->
    <div id="addModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40">
        <div class="relative w-full max-w-xl bg-white border-2 border-black p-6 shadow-2xl">
            
            <!-- Tombol Close Silang Merah -->
            <button type="button" onclick="closeAddModal()" class="absolute top-3 right-3 p-1 text-red-600 hover:text-red-800 transition" title="Tutup">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- Judul Popup -->
            <h3 class="text-base sm:text-lg font-bold text-gray-900 pr-8 pb-4">
                Tambah Perencanaan Kegiatan
            </h3>

            <!-- Form Input (POST Langsung ke Database via Controller) -->
            <form action="{{ route('kegiatan.store') }}" method="POST" class="space-y-3">
                @csrf

                <!-- Nama Kegiatan -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="text-xs sm:text-sm font-semibold text-gray-800">Nama Kegiatan</label>
                    <input type="text" name="nama_keg" required placeholder="Field Input" class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 text-xs sm:text-sm focus:outline-none focus:bg-white">
                </div>

                <!-- Jenis Kegiatan (Dinamis dari Tabel jenis_keg) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="text-xs sm:text-sm font-semibold text-gray-800">Jenis Kegiatan</label>
                    <select name="id_jeniskeg" required class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 text-xs sm:text-sm focus:outline-none focus:bg-white">
                        <option value="" disabled selected>Selection Input</option>
                        @foreach($jenisList as $j)
                            <option value="{{ $j->id_jeniskeg }}">{{ $j->nama_jeniskeg }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Koordinator (Dinamis dari Tabel karyawan) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="text-xs sm:text-sm font-semibold text-gray-800">Koordinator</label>
                    <select name="id_karyawan_koor" required class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 text-xs sm:text-sm focus:outline-none focus:bg-white">
                        <option value="" disabled selected>Selection Input</option>
                        @foreach($karyawanList as $k)
                            <option value="{{ $k->id_karyawan }}">{{ $k->nama_karyawan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Mulai -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="text-xs sm:text-sm font-semibold text-gray-800">Tanggal</label>
                    <input type="date" name="tanggal_mulai" required class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 text-xs sm:text-sm focus:outline-none focus:bg-white">
                </div>

                <!-- Titik Lokasi (Dinamis dari Tabel titik_lokasi) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="text-xs sm:text-sm font-semibold text-gray-800">Titik Lokasi</label>
                    <select name="id_tklokasi" required class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 text-xs sm:text-sm focus:outline-none focus:bg-white">
                        <option value="" disabled selected>Selection Input</option>
                        @foreach($lokasiList as $l)
                            <option value="{{ $l->id_tklokasi }}">{{ $l->nm_lokasi }} ({{ $l->alamat }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Instansi (Dinamis dari Tabel instansi) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="text-xs sm:text-sm font-semibold text-gray-800">Instansi</label>
                    <select name="id_instansi" required class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 text-xs sm:text-sm focus:outline-none focus:bg-white">
                        <option value="" disabled selected>Selection Input</option>
                        @foreach($instansiList as $ins)
                            <option value="{{ $ins->id_instansi }}">{{ $ins->nm_instansi }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Jumlah Peserta -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="text-xs sm:text-sm font-semibold text-gray-800">Jumlah Peserta</label>
                    <input type="number" name="jmlh_peserta" required min="1" placeholder="Field Input Numeric" class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 text-xs sm:text-sm focus:outline-none focus:bg-white">
                </div>

                <!-- Lampiran Link -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="text-xs sm:text-sm font-semibold text-gray-800">Lampiran Link</label>
                    <input type="url" name="lampiran" placeholder="https://drive.google.com/..." class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 text-xs sm:text-sm focus:outline-none focus:bg-white">
                </div>

                <!-- Tombol Submit Tambah -->
                <div class="pt-3 flex justify-center">
                    <button type="submit" class="border-2 border-black bg-gray-300 hover:bg-gray-400 font-bold px-10 py-1.5 text-sm transition">
                        Tambah
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- POPUP MODAL 2: DETAIL KEGIATAN -->
    <div id="detailKegiatanModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40">
        <div class="relative w-full max-w-xl bg-white border-2 border-black p-5 shadow-2xl">
            
            <!-- Tombol Close Silang Merah -->
            <button type="button" onclick="closeDetailModal()" class="absolute top-2 right-2 p-1 text-red-600 hover:text-red-800 transition" title="Tutup">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- Judul Modal -->
            <h3 id="modalDetailTitle" class="text-base sm:text-lg font-bold text-gray-900 pr-8 pb-3">
                Detail Kegiatan
            </h3>

            <!-- Kontainer Rincian Data Lengkap -->
            <div class="border-2 border-black bg-[#d1d5db] p-5 space-y-2.5 text-xs sm:text-sm text-gray-900">
                <p><span class="font-semibold">Koordinator :</span> <span id="dtKoordinator">-</span></p>
                <p><span class="font-semibold">Jenis Kegiatan :</span> <span id="dtJenis">-</span></p>
                <p><span class="font-semibold">Tanggal pelaksanaan :</span> <span id="dtTanggal">-</span></p>
                <p><span class="font-semibold">Titik Lokasi :</span> <span id="dtLokasi">-</span></p>
                <p><span class="font-semibold">Nama Instansi :</span> <span id="dtInstansi">-</span></p>
                <p><span class="font-semibold">Jumlah peserta :</span> <span id="dtPeserta">-</span></p>
                <p><span class="font-semibold">Status :</span> <span id="dtStatus">-</span></p>
                <p>
                    <span class="font-semibold">Lampiran :</span> 
                    <a id="dtLampiran" href="#" target="_blank" class="text-blue-700 underline font-medium break-all">-</a>
                </p>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT: LOGIKA POPUP MODAL -->
    <script>
        // Modal Tambah
        const addModal = document.getElementById('addModal');
        function openAddModal() { addModal.classList.remove('hidden'); }
        function closeAddModal() { addModal.classList.add('hidden'); }

        // Modal Detail
        const detailModal = document.getElementById('detailKegiatanModal');
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

            detailModal.classList.remove('hidden');
        }

        function closeDetailModal() { detailModal.classList.add('hidden'); }

        // Tutup modal jika klik area luar / backdrop
        window.addEventListener('click', (e) => {
            if (e.target === addModal) closeAddModal();
            if (e.target === detailModal) closeDetailModal();
        });
    </script>
@endsection