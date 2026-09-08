@extends('layouts.app')

<title>Kantor Regional BKN - Perencanaan Kegiatan</title>

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
            <a href="{{ url('/kegiatan') }}" class="block border-2 border-black bg-gray-500 text-white font-semibold py-2 px-4 text-center transition">
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
            <a href="{{ url('/riwayat-kegiatan') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center text-sm hover:bg-gray-100 transition">
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
        Perencanaan Kegiatan
    </div>
@endsection

@section('navbar-right')
    <div class="border-2 border-black bg-white px-8 py-1.5 font-semibold text-gray-900">
        {{ Auth::user()->username ?? 'Username' }}
    </div>
@endsection

@section('content')
    <!-- NOTIFIKASI SUKSES -->
    @if(session('success'))
        <div class="mb-4 border-2 border-black bg-emerald-100 p-3 font-semibold text-sm text-emerald-900 shadow-sm flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-900 font-bold ml-4">&times;</button>
        </div>
    @endif

    <!-- NOTIFIKASI ERROR -->
    @if($errors->any())
        <div class="mb-4 border-2 border-black bg-rose-100 p-3 font-semibold text-xs text-rose-900 shadow-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- KONTEN UTAMA -->
    <div class="border-2 border-black bg-white p-4 md:p-6 flex flex-col space-y-4 shadow-sm">
        
        <!-- Header: Judul + Filter + Tambah -->
        <div class="flex items-center justify-between pb-3 border-b-2 border-black relative">
            <h2 class="text-base md:text-lg font-bold text-gray-900">
                Daftar Perencanaan Kegiatan
            </h2>

            <div class="flex items-center space-x-2">
                <!-- Dropdown Filter -->
                <div class="relative">
                    <button type="button" id="filterDropdownBtn" class="border-2 border-black p-1.5 hover:bg-gray-100 block transition cursor-pointer" title="Urutkan Data">
                        <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

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

                <!-- Tombol Tambah Kegiatan -->
                <button onclick="openAddModal()" class="border-2 border-black p-1.5 hover:bg-gray-100 block transition cursor-pointer" title="Tambah Kegiatan">
                    <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Daftar Kartu Kegiatan -->
        <div class="space-y-3">
            @forelse($kegiatan as $item)
                <div class="kegiatan-row border-2 border-black bg-[#d1d5db] p-4 flex flex-col md:flex-row md:items-center justify-between gap-4 transition hover:bg-[#c5c9ce]"
                     data-id="{{ $item->id_keg }}"
                     data-nama="{{ $item->nama_keg }}"
                     data-id-jenis="{{ $item->id_jeniskeg }}"
                     data-jenis="{{ $item->jenis->nama_jeniskeg ?? '-' }}"
                     data-id-koordinator="{{ $item->id_karyawan_koor }}"
                     data-koordinator="{{ $item->koordinator->nama_karyawan ?? 'Belum ditentukan' }}"
                     data-id-lokasi="{{ $item->id_tklokasi }}"
                     data-lokasi="{{ $item->lokasi->nm_lokasi ?? '-' }}"
                     data-id-instansi="{{ $item->id_instansi }}"
                     data-instansi="{{ $item->instansi->nm_instansi ?? '-' }}"
                     data-tgl-mulai="{{ $item->tanggal_mulai }}"
                     data-tgl-selesai="{{ $item->tanggal_selesai ?? $item->tanggal_mulai }}"
                     data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('l, d F Y') }}"
                     data-peserta="{{ $item->jmlh_peserta }}"
                     data-status="{{ $item->status }}"
                     data-lampiran="{{ $item->lampiran ?? '-' }}">
                    
                    <div>
                        <h3 class="font-bold text-gray-900 text-base">{{ $item->nama_keg }}</h3>
                        <p class="text-sm text-gray-700 mt-0.5">
                            Koordinator: {{ $item->koordinator->nama_karyawan ?? 'Tidak ada data' }}
                        </p>
                    </div>

                    <!-- Grup Tombol Aksi -->
                    <div class="flex items-center space-x-3 self-end md:self-center shrink-0">
                        <!-- Icon Detail -->
                        <button type="button" onclick="openDetailModal(this)" class="p-1 text-gray-900 hover:text-blue-600 transition cursor-pointer leading-none flex items-center justify-center" title="Detail Kegiatan">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </button>

                        <!-- Form Hapus -->
                        <form action="{{ url('/kegiatan/' . $item->id_keg) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data {{ $item->nama_keg }}?')" class="flex items-center justify-center m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1 text-gray-900 hover:text-red-600 transition cursor-pointer leading-none flex items-center justify-center" title="Hapus Kegiatan">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>

                        <!-- Icon Edit -->
                        <button type="button" onclick="openEditModal(this)" class="p-1 text-gray-900 hover:text-yellow-600 transition cursor-pointer leading-none flex items-center justify-center" title="Edit Kegiatan">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 font-semibold text-sm border-2 border-black p-4">
                    Belum ada data perencanaan kegiatan yang tersimpan di database.
                </div>
            @endforelse
        </div>

        <!-- PAGINATION -->
        @if ($kegiatan->hasPages())
            <div class="mt-4 flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t-2 border-black">
                <p class="text-xs sm:text-sm font-semibold text-gray-700">
                    Menampilkan <span class="font-bold text-gray-900">{{ $kegiatan->firstItem() }}</span> - <span class="font-bold text-gray-900">{{ $kegiatan->lastItem() }}</span> dari <span class="font-bold text-gray-900">{{ $kegiatan->total() }}</span> kegiatan
                </p>

                <div class="flex items-center space-x-1.5">
                    @if ($kegiatan->onFirstPage())
                        <span class="border-2 border-black bg-gray-200 text-gray-400 px-3 py-1 font-bold text-xs sm:text-sm cursor-not-allowed">&laquo;</span>
                    @else
                        <a href="{{ $kegiatan->previousPageUrl() }}" class="border-2 border-black bg-white hover:bg-gray-200 text-gray-900 px-3 py-1 font-bold text-xs sm:text-sm transition">&laquo;</a>
                    @endif

                    @foreach ($kegiatan->getUrlRange(1, $kegiatan->lastPage()) as $page => $url)
                        @if ($page == $kegiatan->currentPage())
                            <span class="border-2 border-black bg-black text-white px-3 py-1 font-bold text-xs sm:text-sm shadow-[2px_2px_0px_0px_rgba(0,0,0,0.3)]">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="border-2 border-black bg-white hover:bg-gray-200 text-gray-900 px-3 py-1 font-bold text-xs sm:text-sm transition">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($kegiatan->hasMorePages())
                        <a href="{{ $kegiatan->nextPageUrl() }}" class="border-2 border-black bg-white hover:bg-gray-200 text-gray-900 px-3 py-1 font-bold text-xs sm:text-sm transition">&raquo;</a>
                    @else
                        <span class="border-2 border-black bg-gray-200 text-gray-400 px-3 py-1 font-bold text-xs sm:text-sm cursor-not-allowed">&raquo;</span>
                    @endif
                </div>
            </div>
        @endif

    </div>

    <!-- POPUP MODAL 1: FORM TAMBAH / EDIT KEGIATAN -->
    <div id="addModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs overflow-y-auto">
        <div class="relative w-full max-w-xl bg-white border-2 border-black p-6 shadow-2xl my-8">
            
            <button type="button" onclick="closeAddModal()" class="absolute top-3 right-3 p-1 text-red-600 hover:text-red-800 transition cursor-pointer" title="Tutup">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <h3 id="formModalTitle" class="text-base sm:text-lg font-bold text-gray-900 pr-8 pb-4 border-b-2 border-black">
                Tambah Perencanaan Kegiatan
            </h3>

            <form id="kegiatanForm" action="{{ url('/kegiatan') }}" method="POST" class="mt-4 space-y-3 text-xs sm:text-sm">
                @csrf
                <input type="hidden" id="formMethod" name="_method" value="POST">

                <!-- Nama Kegiatan -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="font-semibold text-gray-800">Nama Kegiatan</label>
                    <input type="text" id="inputNamaKeg" name="nama_keg" required placeholder="Masukkan Nama Kegiatan" class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 focus:outline-none focus:bg-white">
                </div>

                <!-- INSTANSI: INPUT TEXT AUTOCOMPLETE (TANPA DROPDOWN SELECT) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-start gap-2 relative">
                    <label class="font-semibold text-gray-800 pt-2">Instansi</label>
                    <div class="sm:col-span-2 relative">
                        <!-- Input ID Tersembunyi -->
                        <input type="hidden" id="inputInstansiId" name="id_instansi" required>
                        
                        <!-- Input Text Pencarian -->
                        <input type="text" 
                               id="inputInstansiText" 
                               autocomplete="off"
                               placeholder="🔍 Ketik untuk mencari & memilih instansi..." 
                               class="w-full border-2 border-black bg-[#d1d5db] p-2 focus:outline-none focus:bg-white text-gray-900 font-medium">

                        <!-- Daftar Referensi Hasil Pencarian (Muncul di Bawah Input Text) -->
                        <div id="instansiSuggestions" class="hidden absolute left-0 right-0 top-full mt-1 max-h-48 overflow-y-auto border-2 border-black bg-white shadow-xl z-50">
                            @foreach($instansiList as $ins)
                                <div class="instansi-item px-3 py-2 text-xs font-semibold text-gray-900 hover:bg-amber-100 cursor-pointer border-b border-gray-200 last:border-b-0"
                                     data-id="{{ $ins->id_instansi }}"
                                     data-nama="{{ $ins->nm_instansi }}">
                                    {{ $ins->nm_instansi }}
                                </div>
                            @endforeach
                            <div id="noInstansiFound" class="hidden px-3 py-2 text-xs font-semibold text-gray-400 text-center italic">
                                Instansi tidak ditemukan
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jenis Kegiatan -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="font-semibold text-gray-800">Jenis Kegiatan</label>
                    <select id="selectJenis" name="id_jeniskeg" required class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 focus:outline-none focus:bg-white">
                        <option value="" disabled selected>Selection Input</option>
                        @foreach($jenisList as $j)
                            <option value="{{ $j->id_jeniskeg }}">{{ $j->nama_jeniskeg }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Koordinator -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="font-semibold text-gray-800">Koordinator</label>
                    <select id="selectKoordinator" name="id_karyawan_koor" required class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 focus:outline-none focus:bg-white">
                        <option value="" disabled selected>Selection Input</option>
                        @foreach($karyawanList as $k)
                            <option value="{{ $k->id_karyawan }}">{{ $k->nama_karyawan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal Mulai & Selesai -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="font-semibold text-gray-800">Tanggal Mulai</label>
                    <input type="date" id="inputTglMulai" name="tanggal_mulai" required class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 focus:outline-none focus:bg-white">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="font-semibold text-gray-800">Tanggal Selesai</label>
                    <input type="date" id="inputTglSelesai" name="tanggal_selesai" class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 focus:outline-none focus:bg-white">
                </div>

                <!-- Titik Lokasi -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="font-semibold text-gray-800">Titik Lokasi</label>
                    <select id="selectLokasi" name="id_tklokasi" required class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 focus:outline-none focus:bg-white">
                        <option value="" disabled selected>Selection Input</option>
                        @foreach($lokasiList as $l)
                            <option value="{{ $l->id_tklokasi }}">{{ $l->nm_lokasi }} ({{ $l->alamat }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Jumlah Peserta -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="font-semibold text-gray-800">Jumlah Peserta</label>
                    <input type="number" id="inputPeserta" name="jmlh_peserta" required min="1" placeholder="Numeric Input" class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 focus:outline-none focus:bg-white">
                </div>

                <!-- Status -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="font-semibold text-gray-800">Status</label>
                    <select id="selectStatus" name="status" required class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 focus:outline-none focus:bg-white">
                        <option value="Belum Konfirmasi">Belum Konfirmasi</option>
                        <option value="Terkonfirmasi">Terkonfirmasi</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                    </select>
                </div>

                <!-- Lampiran Link -->
                <div class="grid grid-cols-1 sm:grid-cols-3 items-center gap-2">
                    <label class="font-semibold text-gray-800">Lampiran Link</label>
                    <input type="text" id="inputLampiran" name="lampiran" placeholder="https://drive.google.com/..." class="sm:col-span-2 border-2 border-black bg-[#d1d5db] p-2 focus:outline-none focus:bg-white">
                </div>

                <!-- Submit Button -->
                <div class="pt-3 flex justify-center">
                    <button type="submit" id="btnSubmitForm" class="border-2 border-black bg-gray-300 hover:bg-gray-400 font-bold px-10 py-1.5 text-sm transition cursor-pointer">
                        Simpan Data
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- POPUP MODAL 2: DETAIL KEGIATAN -->
    <div id="detailKegiatanModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs">
        <div class="relative w-full max-w-xl bg-white border-2 border-black p-5 shadow-2xl">
            <button type="button" onclick="closeDetailModal()" class="absolute top-2 right-2 p-1 text-red-600 hover:text-red-800 transition cursor-pointer" title="Tutup">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>

            <h3 id="modalDetailTitle" class="text-base sm:text-lg font-bold text-gray-900 pr-8 pb-3 border-b-2 border-black">
                Detail Kegiatan
            </h3>

            <div class="mt-4 border-2 border-black bg-[#d1d5db] p-5 space-y-2.5 text-xs sm:text-sm text-gray-900">
                <p><span class="font-semibold">Koordinator :</span> <span id="dtKoordinator">-</span></p>
                <p><span class="font-semibold">Jenis Kegiatan :</span> <span id="dtJenis">-</span></p>
                <p><span class="font-semibold">Tanggal pelaksanaan :</span> <span id="dtTanggal">-</span></p>
                <p><span class="font-semibold">Titik Lokasi :</span> <span id="dtLokasi">-</span></p>
                <p><span class="font-semibold">Nama Instansi :</span> <span id="dtInstansi">-</span></p>
                <p><span class="font-semibold">Jumlah peserta :</span> <span id="dtPeserta">-</span> Orang</p>
                <p><span class="font-semibold">Status :</span> <span id="dtStatus">-</span></p>
                <p>
                    <span class="font-semibold">Lampiran :</span> 
                    <a id="dtLampiran" href="#" target="_blank" class="text-blue-700 underline font-medium break-all">-</a>
                </p>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT: LOGIKA AUTOCOMPLETE INSTANSI & MODAL -->
    <script>
        // 1. Filter Dropdown Header (Terbaru / Terlama)
        const filterBtn = document.getElementById('filterDropdownBtn');
        const filterMenu = document.getElementById('filterMenu');
        filterBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            filterMenu.classList.toggle('hidden');
        });

        // 2. LOGIKA INPUT TEXT PENCARIAN REKOMENDASI INSTANSI
        const inputInstansiText = document.getElementById('inputInstansiText');
        const inputInstansiId = document.getElementById('inputInstansiId');
        const instansiSuggestions = document.getElementById('instansiSuggestions');
        const instansiItems = document.querySelectorAll('.instansi-item');
        const noInstansiFound = document.getElementById('noInstansiFound');

        // Buka rekomendasi saat input text diklik / difokuskan
        inputInstansiText.addEventListener('focus', () => {
            filterInstansiSuggestions();
            instansiSuggestions.classList.remove('hidden');
        });

        // Filter daftar saat pengguna mengetik
        inputInstansiText.addEventListener('input', () => {
            inputInstansiId.value = ""; // Reset ID jika pengguna mengubah ketikan
            filterInstansiSuggestions();
            instansiSuggestions.classList.remove('hidden');
        });

        function filterInstansiSuggestions() {
            const query = inputInstansiText.value.toLowerCase().trim();
            let hasResult = false;

            instansiItems.forEach(item => {
                const name = item.getAttribute('data-nama').toLowerCase();
                if (name.includes(query)) {
                    item.classList.remove('hidden');
                    hasResult = true;
                } else {
                    item.classList.add('hidden');
                }
            });

            if (hasResult) {
                noInstansiFound.classList.add('hidden');
            } else {
                noInstansiFound.classList.remove('hidden');
            }
        }

        // Pilih instansi dari daftar rekomendasi
        instansiItems.forEach(item => {
            item.addEventListener('click', () => {
                const selectedId = item.getAttribute('data-id');
                const selectedName = item.getAttribute('data-nama');

                inputInstansiId.value = selectedId;
                inputInstansiText.value = selectedName;

                instansiSuggestions.classList.add('hidden');
            });
        });

        // 3. Logika Modal Form (Tambah & Edit)
        const addModal = document.getElementById('addModal');
        const kegiatanForm = document.getElementById('kegiatanForm');

        function openAddModal() {
            document.getElementById('formModalTitle').innerText = 'Tambah Perencanaan Kegiatan';
            document.getElementById('formMethod').value = 'POST';
            kegiatanForm.action = "{{ url('/kegiatan') }}";
            
            kegiatanForm.reset();
            inputInstansiId.value = "";
            inputInstansiText.value = "";
            instansiSuggestions.classList.add('hidden');
            
            addModal.classList.remove('hidden');
        }

        function openEditModal(button) {
            const row = button.closest('.kegiatan-row');

            document.getElementById('formModalTitle').innerText = 'Edit Perencanaan Kegiatan';
            document.getElementById('formMethod').value = 'PUT';
            kegiatanForm.action = "{{ url('/kegiatan') }}/" + row.getAttribute('data-id');

            document.getElementById('inputNamaKeg').value = row.getAttribute('data-nama') || '';
            
            // Set ID dan Nama Instansi pada Input Text
            inputInstansiId.value = row.getAttribute('data-id-instansi') || '';
            inputInstansiText.value = row.getAttribute('data-instansi') || '';

            document.getElementById('selectJenis').value = row.getAttribute('data-id-jenis') || '';
            document.getElementById('selectLokasi').value = row.getAttribute('data-id-lokasi') || '';
            document.getElementById('selectKoordinator').value = row.getAttribute('data-id-koordinator') || '';
            document.getElementById('inputTglMulai').value = row.getAttribute('data-tgl-mulai') || '';
            document.getElementById('inputTglSelesai').value = row.getAttribute('data-tgl-selesai') || '';
            document.getElementById('inputPeserta').value = row.getAttribute('data-peserta') || '';
            document.getElementById('selectStatus').value = row.getAttribute('data-status') || 'Belum Konfirmasi';
            document.getElementById('inputLampiran').value = row.getAttribute('data-lampiran') || '';

            instansiSuggestions.classList.add('hidden');
            addModal.classList.remove('hidden');
        }

        function closeAddModal() {
            addModal.classList.add('hidden');
            instansiSuggestions.classList.add('hidden');
        }

        // 4. Logika Modal Detail
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
            lampiranLink.href = (url && url !== '-') ? url : '#';

            detailModal.classList.remove('hidden');
        }

        function closeDetailModal() {
            detailModal.classList.add('hidden');
        }

        // Tutup elemen saat area luar diklik
        document.addEventListener('click', (e) => {
            if (!filterMenu.classList.contains('hidden') && !filterBtn.contains(e.target)) {
                filterMenu.classList.add('hidden');
            }
            if (!inputInstansiText.contains(e.target) && !instansiSuggestions.contains(e.target)) {
                instansiSuggestions.classList.add('hidden');
            }
            if (e.target === addModal) closeAddModal();
            if (e.target === detailModal) closeDetailModal();
        });
    </script>
@endsection