@extends('layouts.app')

<title>Kantor Regional BKN - Laporan Kegiatan</title>

@section('sidebar-header')
    <div class="border-2 border-black bg-white p-2.5 text-center font-bold text-gray-900">
        Kantor Regional BKN
    </div>
@endsection

@section('navbar-left')
    <div class="border-2 border-black bg-white px-6 py-1.5 font-bold text-gray-900">
        Laporan Hasil Kegiatan
    </div>
@endsection

@section('navbar-right')
    <div class="border-2 border-black bg-white px-8 py-1.5 font-semibold text-gray-900">
        {{ Auth::user()->username ?? 'Username' }}
    </div>
@endsection

@section('content')
    <!-- CDN SELECT2 UNTUK DROPDOWN SEARCH & SELECT -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .select2-container--default .select2-selection--single {
            border: 2px solid #000000 !important;
            border-radius: 0px !important;
            height: 42px !important;
            padding-top: 5px;
            font-weight: 600;
        }
        .select2-dropdown {
            border: 2px solid #000000 !important;
            border-radius: 0px !important;
            box-shadow: 4px 4px 0px 0px rgba(0,0,0,1);
            z-index: 9999 !important;
        }
        .select2-search__field {
            border: 2px solid #000000 !important;
            outline: none !important;
        }
    </style>

    @php
        $loggedUser = Auth::user();
    @endphp

    <!-- NOTIFIKASI PESAN SUKSES / ERROR -->
    @if (session('success'))
        <div class="mb-4 border-2 border-black bg-emerald-100 p-3 font-bold text-emerald-900 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
            ✅ {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 border-2 border-black bg-rose-100 p-3 font-bold text-rose-900 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 border-2 border-black bg-rose-100 p-3 font-bold text-rose-900 shadow-[3px_3px_0px_0px_rgba(0,0,0,1)] text-xs sm:text-sm">
            <p class="font-extrabold mb-1">Gagal Menyimpan Data Laporan:</p>
            <ul class="list-disc pl-5 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="border-2 border-black bg-white p-4 md:p-6 flex flex-col space-y-4 shadow-sm">
        
        <!-- Header: Judul + Pencarian + Tombol Buat Laporan -->
        <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b-2 border-black relative">
            <h2 class="text-base md:text-lg font-bold text-gray-900">
                Laporan Hasil & Evaluasi Kegiatan
            </h2>

            <div class="flex items-center space-x-2">
                <!-- Search Form -->
                <form id="searchForm" method="GET" action="{{ url('/laporan-kegiatan') }}" class="m-0 p-0 flex items-center">
                    @if(request('range')) <input type="hidden" name="range" value="{{ request('range') }}"> @endif
                    @if(request('tgl_mulai')) <input type="hidden" name="tgl_mulai" value="{{ request('tgl_mulai') }}"> @endif
                    @if(request('tgl_selesai')) <input type="hidden" name="tgl_selesai" value="{{ request('tgl_selesai') }}"> @endif
                    <div class="flex items-center border-2 border-black bg-gray-100 px-2 py-1 relative">
                        <svg class="w-4 h-4 text-gray-700 mr-2 shrink-0 cursor-pointer" onclick="document.getElementById('searchForm').submit()" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="cari nama kegiatan" class="bg-transparent text-sm focus:outline-none w-32 sm:w-44 text-gray-900">
                    </div>
                </form>

                <!-- Tombol Tambah Laporan Baru -->
                <button type="button" onclick="openTambahLaporanModal()" class="border-2 border-black bg-amber-400 hover:bg-amber-500 text-black font-extrabold px-3 py-1.5 text-xs sm:text-sm transition cursor-pointer shadow-[2px_2px_0px_0px_rgba(0,0,0,1)]">
                    + Buat Laporan
                </button>
            </div>
        </div>

        <!-- BARIS FILTER TANGGAL & PERIODE -->
        <div class="border-2 border-black bg-gray-50 p-3">
            <form method="GET" action="{{ url('/laporan-kegiatan') }}" class="flex flex-wrap items-end gap-3 text-xs">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <!-- Periode Cepat -->
                <div>
                    <label class="block font-bold text-gray-800 mb-1">PERIODE CEPAT:</label>
                    <select name="range" onchange="this.form.submit()" class="border-2 border-black bg-white p-1.5 font-bold">
                        <option value="">-- Semua Waktu --</option>
                        <option value="7_days" {{ request('range') == '7_days' ? 'selected' : '' }}>7 Hari Terakhir</option>
                        <option value="1_month" {{ request('range') == '1_month' ? 'selected' : '' }}>1 Bulan Terakhir</option>
                        <option value="3_months" {{ request('range') == '3_months' ? 'selected' : '' }}>3 Bulan Terakhir</option>
                    </select>
                </div>

                <span class="font-bold self-center pt-3 text-gray-500">ATAU</span>

                <!-- Tanggal Mulai -->
                <div>
                    <label class="block font-bold text-gray-800 mb-1">DARI TANGGAL:</label>
                    <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}" class="border-2 border-black bg-white p-1.5 font-bold">
                </div>

                <!-- Tanggal Selesai -->
                <div>
                    <label class="block font-bold text-gray-800 mb-1">SAMPAI TANGGAL:</label>
                    <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}" class="border-2 border-black bg-white p-1.5 font-bold">
                </div>

                <!-- Tombol Submit Filter & Reset -->
                <div class="flex items-center gap-1.5">
                    <button type="submit" class="border-2 border-black bg-blue-500 hover:bg-blue-600 text-white font-bold px-3 py-1.5 shadow-xs">
                        Filter
                    </button>
                    @if(request()->hasAny(['range', 'tgl_mulai', 'tgl_selesai']))
                        <a href="{{ url('/laporan-kegiatan') }}" class="border-2 border-black bg-gray-200 hover:bg-gray-300 text-black font-bold px-3 py-1.5">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Laporan Hasil Kegiatan -->
        <div class="mt-2 border-2 border-black overflow-x-auto">
            <table class="w-full border-collapse border-black min-w-[900px] text-xs sm:text-sm">
                <thead>
                    <tr class="border-b-2 border-black bg-gray-100 text-center font-bold text-gray-900">
                        <th class="border-r-2 border-black py-3 px-2 w-10">No</th>
                        <th class="border-r-2 border-black py-3 px-3">Nama Kegiatan & Koordinator</th>
                        <th class="border-r-2 border-black py-3 px-2 w-32">Peserta (Hadir / Absen)</th>
                        <th class="border-r-2 border-black py-3 px-2 w-28">Nilai (Max / Min)</th>
                        <th class="border-r-2 border-black py-3 px-3 w-32">Dokumen Laporan</th>
                        <th class="py-3 px-2 w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="font-medium text-gray-900">
                    @if (isset($laporan) && count($laporan) > 0)
                        @foreach ($laporan as $idx => $item)
                            @php 
                                $no = $laporan->firstItem() + $idx; 
                                $keg = $item->kegiatan;
                                
                                $isKoordinator = ($loggedUser->role === 'pegawai') 
                                    ? ($keg && $keg->id_karyawan_koor == $loggedUser->id_karyawan) 
                                    : true;

                                $payloadEdit = [
                                    'id_laporan' => $item->id_laporan,
                                    'nama_keg' => $keg->nama_keg ?? '-',
                                    'peserta_hadir' => $item->peserta_hadir,
                                    'peserta_tidak_hadir' => $item->peserta_tidak_hadir,
                                    'nilai_tertinggi' => $item->nilai_tertinggi,
                                    'nilai_terendah' => $item->nilai_terendah,
                                    'lampiran_laporan' => $item->lampiran_laporan,
                                    'catatan_evaluasi' => $item->catatan_evaluasi,
                                ];
                            @endphp
                            <tr class="border-b-2 border-black last:border-b-0 bg-[#d1d5db] hover:bg-[#c4c8ce] transition">
                                <td class="border-r-2 border-black py-3 px-2 text-center font-bold">{{ $no }}</td>
                                <td class="border-r-2 border-black py-3 px-3">
                                    <span class="block font-bold text-gray-900">{{ $keg->nama_keg ?? '-' }}</span>
                                    <span class="block text-xs text-gray-800 font-semibold mt-0.5">
                                        👤 Koor: <span class="underline">{{ $keg->koordinator->nama_karyawan ?? '-' }}</span>
                                    </span>
                                    <span class="text-[11px] text-gray-700 font-medium">
                                        📍 {{ $keg->lokasi->nm_lokasi ?? '-' }} | 🏢 {{ $keg->instansi->nm_instansi ?? '-' }}
                                    </span>
                                </td>
                                <td class="border-r-2 border-black py-3 px-2 text-center">
                                    <span class="inline-block px-2 py-0.5 bg-emerald-200 border border-black font-extrabold text-emerald-950 text-xs rounded">
                                        {{ number_format($item->peserta_hadir) }} Hadir
                                    </span>
                                    <span class="inline-block px-2 py-0.5 bg-rose-200 border border-black font-extrabold text-rose-950 text-xs rounded mt-1">
                                        {{ number_format($item->peserta_tidak_hadir) }} Absen
                                    </span>
                                </td>
                                <td class="border-r-2 border-black py-3 px-2 text-center font-bold">
                                    <p class="text-emerald-900">Max: {{ $item->nilai_tertinggi ?? '-' }}</p>
                                    <p class="text-rose-900">Min: {{ $item->nilai_terendah ?? '-' }}</p>
                                </td>
                                <td class="border-r-2 border-black py-3 px-3 text-center">
                                    @if ($item->lampiran_laporan && $item->lampiran_laporan !== '-')
                                        <a href="{{ $item->lampiran_laporan }}" target="_blank" class="border-2 border-black bg-blue-500 hover:bg-blue-600 text-white px-2.5 py-1 text-xs font-bold transition inline-block shadow-xs">
                                            📄 Laporan
                                        </a>
                                    @else
                                        <span class="text-gray-500 text-xs">-</span>
                                    @endif
                                </td>
                                <!-- KOLOM AKSI (EDIT, HAPUS, CETAK PDF) -->
                                <td class="py-3 px-2 text-center">
                                    <div class="flex flex-col items-center justify-center gap-1.5 w-full">
                                        @if ($isKoordinator)
                                            <!-- Tombol Edit -->
                                            <button type="button" 
                                                    onclick="openEditLaporanModal('{{ rawurlencode(json_encode($payloadEdit)) }}')" 
                                                    class="w-20 border-2 border-black bg-amber-300 hover:bg-amber-400 text-black font-bold px-2 py-1 text-xs transition cursor-pointer shadow-xs">
                                                Edit
                                            </button>
                                            
                                            <!-- Tombol Hapus -->
                                            <form action="{{ url('/laporan-kegiatan/'.$item->id_laporan) }}" method="POST" class="w-20" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan kegiatan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="w-full border-2 border-black bg-rose-500 hover:bg-rose-600 text-white font-bold px-2 py-1 text-xs transition cursor-pointer shadow-xs">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif

                                        <!-- TOMBOL CETAK PDF (Dapat diakses seluruh user) -->
                                        <a href="{{ url('/laporan-kegiatan/'.$item->id_laporan.'/cetak') }}" target="_blank" class="w-20 border-2 border-black bg-emerald-400 hover:bg-emerald-500 text-black font-bold px-2 py-1 text-xs transition inline-block text-center shadow-xs">
                                            🖨️ Cetak
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500 font-semibold text-sm">
                                Belum ada data laporan hasil kegiatan yang terdaftar.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        @if (isset($laporan) && $laporan->hasPages())
            <div class="mt-4 flex flex-col sm:flex-row justify-between items-center gap-3 pt-3 border-t-2 border-black text-xs font-bold">
                <span>Menampilkan {{ $laporan->firstItem() }} - {{ $laporan->lastItem() }} dari {{ $laporan->total() }} Laporan</span>
                <div class="flex gap-1">
                    {{ $laporan->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- MODAL 1: FORM TAMBAH LAPORAN KEGIATAN -->
    <div id="tambahLaporanModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div class="relative w-full max-w-lg bg-white border-2 border-black p-5 shadow-2xl">
            <button type="button" onclick="closeTambahLaporanModal()" class="absolute top-2 right-2 p-1 text-red-600 font-bold">✕</button>
            <h3 class="text-base font-bold text-gray-900 pb-2 border-b-2 border-black">Input Laporan Hasil Kegiatan</h3>
            
            <form action="{{ url('/laporan-kegiatan') }}" method="POST" class="mt-4 space-y-3 text-xs sm:text-sm">
                @csrf
                <div>
                    <label class="block font-bold mb-1">PILIH KEGIATAN (STATUS SELESAI):</label>
                    <select name="id_keg" id="tambah_id_keg" required class="select2-kegiatan w-full border-2 border-black bg-white p-2 font-medium">
                        <option value="" data-peserta="0">-- Cari / Pilih Kegiatan --</option>
                        @foreach ($kegiatanSelesai as $kS)
                            <option value="{{ $kS->id_keg }}" data-peserta="{{ $kS->jmlh_peserta }}">
                                {{ $kS->nama_keg }} (Total Peserta: {{ $kS->jmlh_peserta }} Orang)
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Banner Informasi Total Peserta -->
                <div id="infoPesertaBox" class="p-2 border-2 border-black bg-sky-100 font-bold text-xs text-sky-950 hidden">
                    ℹ️ Total Peserta Terdaftar: <span id="textTotalPeserta">0</span> Orang
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold mb-1">PESERTA HADIR:</label>
                        <input type="number" name="peserta_hadir" id="tambah_peserta_hadir" required min="0" value="0" oninput="calcAbsenTambah()" class="w-full border-2 border-black p-2 font-medium">
                    </div>
                    <div>
                        <label class="block font-bold mb-1">PESERTA ABSEN (OTOMATIS):</label>
                        <input type="number" name="peserta_tidak_hadir" id="tambah_peserta_tidak_hadir" required min="0" value="0" readonly class="w-full border-2 border-black bg-gray-200 p-2 font-bold text-gray-700 cursor-not-allowed">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold mb-1">NILAI TERTINGGI:</label>
                        <input type="number" step="0.01" name="nilai_tertinggi" placeholder="485.50" class="w-full border-2 border-black p-2 font-medium">
                    </div>
                    <div>
                        <label class="block font-bold mb-1">NILAI TERENDAH:</label>
                        <input type="number" step="0.01" name="nilai_terendah" placeholder="280.00" class="w-full border-2 border-black p-2 font-medium">
                    </div>
                </div>

                <div>
                    <label class="block font-bold mb-1">LINK DOKUMEN LAPORAN:</label>
                    <input type="text" name="lampiran_laporan" placeholder="https://drive.google.com/..." class="w-full border-2 border-black p-2 font-medium">
                </div>

                <div>
                    <label class="block font-bold mb-1">CATATAN EVALUASI:</label>
                    <textarea name="catatan_evaluasi" rows="2" class="w-full border-2 border-black p-2 font-medium"></textarea>
                </div>

                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" onclick="closeTambahLaporanModal()" class="border-2 border-black bg-gray-200 px-4 py-1.5 font-bold">Batal</button>
                    <button type="submit" class="border-2 border-black bg-emerald-400 hover:bg-emerald-500 px-4 py-1.5 font-extrabold text-black">Simpan Laporan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: FORM EDIT LAPORAN KEGIATAN -->
    <div id="editLaporanModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        <div class="relative w-full max-w-lg bg-white border-2 border-black p-5 shadow-2xl">
            <button type="button" onclick="closeEditLaporanModal()" class="absolute top-2 right-2 p-1 text-red-600 font-bold">✕</button>
            <h3 id="editModalJudul" class="text-base font-bold text-gray-900 pb-2 border-b-2 border-black">Edit Laporan Kegiatan</h3>
            
            <form id="editLaporanForm" method="POST" class="mt-4 space-y-3 text-xs sm:text-sm">
                @csrf
                @method('PUT')

                <!-- Banner Informasi Total Peserta Edit -->
                <div id="infoPesertaBoxEdit" class="p-2 border-2 border-black bg-amber-100 font-bold text-xs text-amber-950">
                    ℹ️ Total Peserta Terdaftar: <span id="textTotalPesertaEdit">0</span> Orang
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold mb-1">PESERTA HADIR:</label>
                        <input type="number" name="peserta_hadir" id="edit_peserta_hadir" required min="0" oninput="calcAbsenEdit()" class="w-full border-2 border-black p-2 font-medium">
                    </div>
                    <div>
                        <label class="block font-bold mb-1">PESERTA ABSEN (OTOMATIS):</label>
                        <input type="number" name="peserta_tidak_hadir" id="edit_peserta_tidak_hadir" required min="0" readonly class="w-full border-2 border-black bg-gray-200 p-2 font-bold text-gray-700 cursor-not-allowed">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold mb-1">NILAI TERTINGGI:</label>
                        <input type="number" step="0.01" name="nilai_tertinggi" id="edit_nilai_tertinggi" class="w-full border-2 border-black p-2 font-medium">
                    </div>
                    <div>
                        <label class="block font-bold mb-1">NILAI TERENDAH:</label>
                        <input type="number" step="0.01" name="nilai_terendah" id="edit_nilai_terendah" class="w-full border-2 border-black p-2 font-medium">
                    </div>
                </div>

                <div>
                    <label class="block font-bold mb-1">LINK DOKUMEN LAPORAN:</label>
                    <input type="text" name="lampiran_laporan" id="edit_lampiran_laporan" class="w-full border-2 border-black p-2 font-medium">
                </div>

                <div>
                    <label class="block font-bold mb-1">CATATAN EVALUASI:</label>
                    <textarea name="catatan_evaluasi" id="edit_catatan_evaluasi" rows="2" class="w-full border-2 border-black p-2 font-medium"></textarea>
                </div>

                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" onclick="closeEditLaporanModal()" class="border-2 border-black bg-gray-200 px-4 py-1.5 font-bold">Batal</button>
                    <button type="submit" class="border-2 border-black bg-amber-400 hover:bg-amber-500 px-4 py-1.5 font-extrabold text-black">Update Laporan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT JAVASCRIPT: SELECT2 & OTOMATISASI FORM -->
    <script>
        let currentTotalPesertaTambah = 0;
        let currentTotalPesertaEdit = 0;

        const tambahModal = document.getElementById('tambahLaporanModal');
        const editModal = document.getElementById('editLaporanModal');

        $(document).ready(function() {
            $('.select2-kegiatan').select2({
                dropdownParent: $('#tambahLaporanModal'),
                placeholder: "-- Cari / Pilih Kegiatan --",
                width: '100%'
            });

            $('.select2-kegiatan').on('change', function() {
                updateTotalPesertaTambah();
            });
        });

        function openTambahLaporanModal() {
            tambahModal.classList.remove('hidden');
        }

        function closeTambahLaporanModal() {
            tambahModal.classList.add('hidden');
        }

        function updateTotalPesertaTambah() {
            const select = document.getElementById('tambah_id_keg');
            const selectedOption = select.options[select.selectedIndex];
            currentTotalPesertaTambah = parseInt(selectedOption.getAttribute('data-peserta') || 0);

            const infoBox = document.getElementById('infoPesertaBox');
            if (currentTotalPesertaTambah > 0) {
                document.getElementById('textTotalPeserta').innerText = currentTotalPesertaTambah;
                infoBox.classList.remove('hidden');
            } else {
                infoBox.classList.add('hidden');
            }

            document.getElementById('tambah_peserta_hadir').max = currentTotalPesertaTambah;
            document.getElementById('tambah_peserta_hadir').value = currentTotalPesertaTambah;
            calcAbsenTambah();
        }

        function calcAbsenTambah() {
            let hadir = parseInt(document.getElementById('tambah_peserta_hadir').value) || 0;
            if (hadir > currentTotalPesertaTambah) {
                hadir = currentTotalPesertaTambah;
                document.getElementById('tambah_peserta_hadir').value = hadir;
            }
            const absen = Math.max(0, currentTotalPesertaTambah - hadir);
            document.getElementById('tambah_peserta_tidak_hadir').value = absen;
        }

        function openEditLaporanModal(encodedJson) {
            try {
                const data = JSON.parse(decodeURIComponent(encodedJson));
                document.getElementById('editModalJudul').innerText = `Edit Laporan - ${data.nama_keg}`;
                document.getElementById('editLaporanForm').action = `/laporan-kegiatan/${data.id_laporan}`;

                currentTotalPesertaEdit = data.peserta_hadir + data.peserta_tidak_hadir;
                document.getElementById('textTotalPesertaEdit').innerText = currentTotalPesertaEdit;

                document.getElementById('edit_peserta_hadir').max = currentTotalPesertaEdit;
                document.getElementById('edit_peserta_hadir').value = data.peserta_hadir;
                document.getElementById('edit_peserta_tidak_hadir').value = data.peserta_tidak_hadir;

                document.getElementById('edit_nilai_tertinggi').value = data.nilai_tertinggi || '';
                document.getElementById('edit_nilai_terendah').value = data.nilai_terendah || '';
                document.getElementById('edit_lampiran_laporan').value = data.lampiran_laporan || '';
                document.getElementById('edit_catatan_evaluasi').value = data.catatan_evaluasi || '';

                editModal.classList.remove('hidden');
            } catch (e) {
                console.error("Gagal membuka modal edit:", e);
            }
        }

        function calcAbsenEdit() {
            let hadir = parseInt(document.getElementById('edit_peserta_hadir').value) || 0;
            if (hadir > currentTotalPesertaEdit) {
                hadir = currentTotalPesertaEdit;
                document.getElementById('edit_peserta_hadir').value = hadir;
            }
            const absen = Math.max(0, currentTotalPesertaEdit - hadir);
            document.getElementById('edit_peserta_tidak_hadir').value = absen;
        }

        function closeEditLaporanModal() {
            editModal.classList.add('hidden');
        }
    </script>
@endsection