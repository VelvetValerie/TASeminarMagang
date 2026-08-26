@extends('layouts.app')

@section('sidebar-header')
    <div class="border-2 border-black bg-white p-2.5 text-center font-bold text-gray-900">
        Kantor Regional BKN
    </div>
@endsection

@section('sidebar-menu')
    <!-- Grup 1: Menu Utama (Kalender Aktif) -->
        <div class="space-y-2">
            <a href="{{ url('/dashboard') }}" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Menu Dasboard
            </a>
            <a href="{{ url('/kalender') }}" class="block border-2 border-black bg-gray-500 text-white font-semibold py-2 px-4 text-center shadow-sm">
                Kalender
            </a>
        </div>

        <!-- Grup 2: Kegiatan & Rekam Kerja -->
        <div class="space-y-2 pt-2">
            <a href="#" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Kegiatan
            </a>
            <a href="#" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                Rekam Kerja
            </a>
        </div>

        <!-- Grup 3: Master Data & Manajemen -->
        <div class="space-y-2 pt-2">
            <a href="#" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center text-sm hover:bg-gray-100 transition">
                Jenis Kegiatan
            </a>
            <a href="{{ url('/titik-lokasi') }}" 
            class="block py-2 px-4 text-center text-sm font-semibold transition {{ request()->is('titik-lokasi') ? 'bg-gray-400 text-gray-900' : 'text-gray-800 hover:bg-gray-100' }}">
                Titik Lokasi
            </a>
            <a href="#" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center text-sm hover:bg-gray-100 transition">
                Instansi
            </a>
            <a href="#" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center text-sm hover:bg-gray-100 transition">
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
                    <a href="#" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 border-b-2 border-black hover:bg-gray-100 transition">
                        User
                    </a>
                    <a href="#" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 border-b-2 border-black hover:bg-gray-100 transition">
                        Kegiatan
                    </a>
                    <a href="#" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 hover:bg-gray-100 transition">
                        Lokasi
                    </a>
                </div>
            </details>
        </div>
    </div>
@endsection

@section('navbar-left')
    <div class="border-2 border-black bg-white px-6 py-1.5 font-bold text-gray-900">
        Kalender Kegiatan
    </div>
@endsection

@section('navbar-right')
    <div class="border-2 border-black bg-white px-8 py-1.5 font-semibold text-gray-900">
        Username
    </div>
@endsection

@section('content')
    <!-- 1. DUA KOTAK ATAS: LEGENDA & KEGIATAN BERLANGSUNG -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
        
        <!-- KOTAK KIRI: LEGENDA INDIKATOR -->
        <div class="border-2 border-black bg-white shadow-sm flex flex-col">
            <h3 class="text-sm font-bold text-gray-900 text-center py-1.5 border-b-2 border-black bg-gray-50">
                Legenda Indikator
            </h3>
            <div class="p-4 grid grid-cols-2 gap-x-4 gap-y-3 text-xs sm:text-sm font-medium text-gray-800">
                <div class="flex items-center space-x-2">
                    <span class="w-3.5 h-3.5 rounded-full bg-gray-300 border border-black inline-block shrink-0"></span>
                    <span>Pengembangan Karir</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="w-3.5 h-3.5 rounded-full bg-gray-600 border border-black inline-block shrink-0"></span>
                    <span>Sekolah Kedinasan</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="w-3.5 h-3.5 rounded-full bg-gray-400 border border-black inline-block shrink-0"></span>
                    <span>Tes CASN</span>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="w-3.5 h-3.5 rounded-full bg-gray-800 border border-black inline-block shrink-0"></span>
                    <span>Tes Non-ASN</span>
                </div>
            </div>
        </div>

        <!-- KOTAK KANAN: KEGIATAN BERLANGSUNG -->
        <div class="border-2 border-black bg-white shadow-sm flex flex-col min-h-[110px]">
            <h3 class="text-xs sm:text-sm font-bold text-gray-900 px-3 py-1.5 border-b-2 border-black bg-gray-50">
                [Rabu, 03 ... 20xx] Kegiatan yang sedang berlangsung
            </h3>
            <div class="p-3 text-xs sm:text-sm space-y-1 font-medium text-gray-800">
                <p>1. Kegiatan B</p>
                <p>2. Kegiatan C</p>
            </div>
        </div>

    </div>

    <!-- 2. KOTAK KALENDER UTAMA -->
    <div class="border-2 border-black bg-white p-4 md:p-6 mt-6 relative shadow-sm">
        
        <!-- Header Kontrol Kalender -->
        <div class="flex flex-wrap items-center justify-between gap-4 pb-4 border-b-2 border-black relative">
            
            <!-- Navigasi Bulan -->
            <div class="flex items-center space-x-2">
                <button class="border-2 border-black p-1 hover:bg-gray-100 font-bold px-2.5">
                    &lt;
                </button>
                <div class="border-2 border-black px-4 py-1 font-semibold text-sm">
                    (Bulan)
                </div>
                <button class="border-2 border-black p-1 hover:bg-gray-100 font-bold px-2.5">
                    &gt;
                </button>
            </div>

            <!-- Teks Kalender (Tahun) -->
            <div class="bg-gray-200 border-2 border-black px-8 py-1 font-bold text-sm text-center grow max-w-sm hidden sm:block">
                Kalender (Tahun)
            </div>

            <!-- Tombol Filter Corong -->
            <button id="filterCalendarBtn" class="border-2 border-black p-1.5 bg-gray-300 hover:bg-gray-400 text-gray-900 transition" title="Filter Kalender">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
            </button>

            <!-- POPUP POPOVER: FILTER KALENDER -->
            <div id="filterCalendarModal" class="hidden absolute right-0 top-full mt-2 w-80 sm:w-96 bg-white border-2 border-black p-4 shadow-2xl z-30">
                <div class="flex items-center justify-between pb-3 border-b-2 border-black">
                    <button onclick="resetCalendarFilter()" class="border-2 border-black bg-gray-300 hover:bg-gray-400 px-3 py-0.5 text-xs font-semibold text-gray-900">
                        Reset
                    </button>
                    <h4 class="font-bold text-sm text-gray-900">
                        Filter Kalender
                    </h4>
                </div>

                <!-- Daftar Checkbox Kategori dengan Data-Target -->
                <div class="mt-4 border-2 border-black p-3 space-y-3 bg-white">
                    <label class="flex items-center space-x-3 text-xs sm:text-sm font-semibold cursor-pointer">
                        <input type="checkbox" data-filter="pengembangan-karir" checked class="calendar-filter-checkbox w-4 h-4 accent-black rounded border-2 border-black">
                        <span>Pengembangan Karir</span>
                    </label>
                    <label class="flex items-center space-x-3 text-xs sm:text-sm font-semibold cursor-pointer">
                        <input type="checkbox" data-filter="sekolah-kedinasan" checked class="calendar-filter-checkbox w-4 h-4 accent-black rounded border-2 border-black">
                        <span>Sekolah Kedinasan</span>
                    </label>
                    <label class="flex items-center space-x-3 text-xs sm:text-sm font-semibold cursor-pointer">
                        <input type="checkbox" data-filter="tes-casn" checked class="calendar-filter-checkbox w-4 h-4 accent-black rounded border-2 border-black">
                        <span>Tes CASN</span>
                    </label>
                    <label class="flex items-center space-x-3 text-xs sm:text-sm font-semibold cursor-pointer">
                        <input type="checkbox" data-filter="tes-non-asn" checked class="calendar-filter-checkbox w-4 h-4 accent-black rounded border-2 border-black">
                        <span>Tes Non-ASN</span>
                    </label>
                </div>
            </div>

        </div>

        <!-- Tabel Grid Kalender -->
        <div class="mt-4 border-2 border-black overflow-x-auto">
            <table class="w-full border-collapse border-black min-w-[750px] table-fixed">
                <thead>
                    <tr class="border-b-2 border-black bg-white text-center font-bold text-sm">
                        <th class="border-r-2 border-black py-2 w-[14.28%]">Minggu</th>
                        <th class="border-r-2 border-black py-2 w-[14.28%]">Senin</th>
                        <th class="border-r-2 border-black py-2 w-[14.28%]">Selasa</th>
                        <th class="border-r-2 border-black py-2 w-[14.28%]">Rabu</th>
                        <th class="border-r-2 border-black py-2 w-[14.28%]">Kamis</th>
                        <th class="border-r-2 border-black py-2 w-[14.28%]">Jumat</th>
                        <th class="py-2 w-[14.28%]">Sabtu</th>
                    </tr>
                </thead>

                <tbody class="text-sm font-semibold">
                    <!-- BARIS 1 -->
                    <tr class="border-b-2 border-black h-28">
                        <td class="border-r-2 border-black p-2 align-top">1</td>
                        <td class="border-r-2 border-black p-2 align-top">2</td>
                        
                        <!-- Tanggal 3 -->
                        <td class="border-r-2 border-black p-2 align-top relative">
                            <span>3</span>
                            <!-- Event Rentang: Tes CASN -->
                            <div class="calendar-event absolute top-8 left-3 w-[190%] h-6 bg-gray-300 border-2 border-black rounded-full flex items-center justify-center z-20 shadow-xs pointer-events-none" data-category="tes-casn">
                                <span class="text-xs font-bold text-gray-900 tracking-wide">Tes CASN</span>
                            </div>
                        </td>

                        <!-- Tanggal 4 -->
                        <td class="border-r-2 border-black p-2 align-top relative">
                            <span>4</span>
                            <!-- Event Rentang: Tes CAT (Kategori dipisahkan ke 'sekolah-kedinasan') -->
                            <div class="calendar-event absolute top-16 left-3 w-[190%] h-6 bg-gray-300 border-2 border-black rounded-full flex items-center justify-center z-10 shadow-xs pointer-events-none" data-category="sekolah-kedinasan">
                                <span class="text-xs font-bold text-gray-900 tracking-wide">Tes CAT</span>
                            </div>
                        </td>

                        <!-- Tanggal 5 -->
                        <td class="border-r-2 border-black p-2 align-top relative">
                            <span>5</span>
                            <!-- Event Tunggal: Tes CASN -->
                            <div class="calendar-event mt-1 mx-auto w-[85%] h-6 bg-gray-600 border-2 border-black text-white text-xs font-bold rounded-full flex items-center justify-center shadow-xs" data-category="tes-casn">
                                Tes CASN
                            </div>
                        </td>

                        <td class="border-r-2 border-black p-2 align-top">6</td>
                        <td class="p-2 align-top">7</td>
                    </tr>

                    <!-- BARIS 2 -->
                    <tr class="border-b-2 border-black h-28">
                        <td class="border-r-2 border-black p-2 align-top">8</td>
                        <td class="border-r-2 border-black p-2 align-top">9</td>
                        
                        <!-- Tanggal 10 -->
                        <td class="border-r-2 border-black p-2 align-top relative">
                            <span>10</span>
                            <!-- Event Tunggal: Tes CASN -->
                            <div class="calendar-event mt-4 mx-auto w-[85%] h-6 bg-gray-600 border-2 border-black text-white text-xs font-bold rounded-full flex items-center justify-center shadow-xs" data-category="tes-casn">
                                Tes CASN
                            </div>
                        </td>

                        <td class="border-r-2 border-black p-2 align-top">11</td>
                        <td class="border-r-2 border-black p-2 align-top">12</td>
                        <td class="border-r-2 border-black p-2 align-top">13</td>
                        <td class="p-2 align-top">14</td>
                    </tr>

                    <!-- BARIS 3 -->
                    <tr class="border-b-2 border-black h-28">
                        <td class="border-r-2 border-black p-2 align-top">15</td>
                        <td class="border-r-2 border-black p-2 align-top">16</td>
                        <td class="border-r-2 border-black p-2 align-top">17</td>
                        <td class="border-r-2 border-black p-2 align-top">18</td>
                        <td class="border-r-2 border-black p-2 align-top">19</td>
                        <td class="border-r-2 border-black p-2 align-top">20</td>
                        <td class="p-2 align-top">21</td>
                    </tr>

                    <!-- BARIS 4 -->
                    <tr class="border-b-2 border-black h-28">
                        <td class="border-r-2 border-black p-2 align-top">22</td>
                        <td class="border-r-2 border-black p-2 align-top">23</td>
                        <td class="border-r-2 border-black p-2 align-top">24</td>
                        <td class="border-r-2 border-black p-2 align-top">25</td>
                        <td class="border-r-2 border-black p-2 align-top">26</td>
                        <td class="border-r-2 border-black p-2 align-top">27</td>
                        <td class="p-2 align-top">28</td>
                    </tr>

                    <!-- BARIS 5 -->
                    <tr class="border-b-2 border-black h-28">
                        <td class="border-r-2 border-black p-2 align-top">29</td>
                        <td class="border-r-2 border-black p-2 align-top">30</td>
                        <td class="border-r-2 border-black p-2 align-top">31</td>
                        <td class="border-r-2 border-black p-2 align-top text-gray-400">1</td>
                        <td class="border-r-2 border-black p-2 align-top text-gray-400">2</td>
                        <td class="border-r-2 border-black p-2 align-top text-gray-400">3</td>
                        <td class="p-2 align-top text-gray-400">4</td>
                    </tr>

                    <!-- BARIS 6 -->
                    <tr class="h-28 text-gray-400">
                        <td class="border-r-2 border-black p-2 align-top">5</td>
                        <td class="border-r-2 border-black p-2 align-top">6</td>
                        <td class="border-r-2 border-black p-2 align-top">7</td>
                        <td class="border-r-2 border-black p-2 align-top">8</td>
                        <td class="border-r-2 border-black p-2 align-top">9</td>
                        <td class="border-r-2 border-black p-2 align-top">10</td>
                        <td class="p-2 align-top">11</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <!-- SCRIPT FILTER REALTIME -->
    <script>
        const filterBtn = document.getElementById('filterCalendarBtn');
        const filterModal = document.getElementById('filterCalendarModal');
        const checkboxes = document.querySelectorAll('.calendar-filter-checkbox');
        const events = document.querySelectorAll('.calendar-event');

        // Toggle Modal Popup Filter
        filterBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            filterModal.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!filterModal.contains(e.target) && e.target !== filterBtn) {
                filterModal.classList.add('hidden');
            }
        });

        // Logika Sinkronisasi Filter Checkbox dengan Item di Grid
        function applyCalendarFilter() {
            // Ambil daftar kategori yang sedang dicentang
            const activeCategories = Array.from(checkboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.getAttribute('data-filter'));

            // Sembunyikan atau tampilkan elemen event berdasarkan kategori
            events.forEach(event => {
                const category = event.getAttribute('data-category');
                if (activeCategories.includes(category)) {
                    event.classList.remove('hidden');
                } else {
                    event.classList.add('hidden');
                }
            });
        }

        // Pasang event change pada setiap checkbox
        checkboxes.forEach(cb => {
            cb.addEventListener('change', applyCalendarFilter);
        });

        // Tombol Reset
        function resetCalendarFilter() {
            checkboxes.forEach(cb => cb.checked = true);
            applyCalendarFilter();
        }
    </script>
@endsection