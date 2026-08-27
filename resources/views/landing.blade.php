<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantor Regional BKN - Portal Informasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        summary::-webkit-details-marker { display: none; }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 font-sans antialiased">

    <!-- NAVBAR UTAMA -->
    <header class="sticky top-0 z-50 bg-white border-b-2 border-black px-4 lg:px-8 py-3 shadow-sm h-[65px] flex items-center">
        <div class="w-full max-w-7xl mx-auto flex items-center justify-between gap-4">
            
            <!-- Logo Icon Kiri -->
            <a href="{{ url('/') }}" class="flex items-center">
                <img src="{{ asset('images/Logo_BKN.png') }}" alt="Logo BKN" class="h-10 w-auto object-contain">
            </a>

            <!-- Navigasi Menu Tengah -->
            <nav class="hidden md:flex items-center space-x-2">
                <a href="#beranda" class="border-2 border-black bg-white hover:bg-gray-100 font-semibold px-4 py-1 text-xs sm:text-sm transition">
                    Beranda
                </a>
                <a href="#kalender" class="border-2 border-black bg-white hover:bg-gray-100 font-semibold px-4 py-1 text-xs sm:text-sm transition">
                    Kalender
                </a>
                <a href="#publikasi" class="border-2 border-black bg-white hover:bg-gray-100 font-semibold px-4 py-1 text-xs sm:text-sm transition">
                    Publikasi
                </a>
                <a href="#kontak" class="border-2 border-black bg-white hover:bg-gray-100 font-semibold px-4 py-1 text-xs sm:text-sm transition">
                    Kontak
                </a>

                <!-- Dropdown Informasi -->
                <details class="relative group">
                    <summary class="list-none border-2 border-black bg-white hover:bg-gray-100 font-semibold px-4 py-1 text-xs sm:text-sm cursor-pointer flex items-center space-x-1 transition">
                        <span>Informasi</span>
                        <svg class="w-4 h-4 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <div class="absolute left-0 mt-1 w-40 bg-white border-2 border-black shadow-lg py-1 z-30">
                        <a href="#publikasi" class="block px-4 py-1.5 text-xs font-semibold hover:bg-gray-100 border-b border-gray-200">Berita Terkini</a>
                        <a href="#publikasi" class="block px-4 py-1.5 text-xs font-semibold hover:bg-gray-100">Pengumuman</a>
                    </div>
                </details>
            </nav>

            <!-- Tombol Login Dashboard -->
            <div>
                <a href="{{ url('/dashboard') }}" class="border-2 border-black bg-white hover:bg-gray-200 font-bold px-6 py-1.5 text-xs sm:text-sm transition">
                    Login
                </a>
            </div>

        </div>
    </header>

    <main class="w-full">

        <!-- ==========================================
             1. SEKSI 1: BERANDA / CAROUSEL AUTO-ROTATE (Fit Gambar)
             ========================================== -->
        <section id="beranda" class="min-h-[calc(100vh-65px)] w-full max-w-7xl mx-auto p-4 md:p-8 flex flex-col justify-center items-center space-y-6">
            <div class="text-center space-y-1">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
                    Kantor Regional VIII Badan Kepegawaian Negara
                </h1>
                <p class="text-sm md:text-base text-gray-700">
                    Sistem Manajemen & Informasi Perencanaan Kegiatan Terpadu
                </p>
            </div>

            <!-- Carousel Wrapper: Border Pas Mengikuti Ukuran Gambar -->
            <div class="w-full flex items-center justify-center gap-4">
                
                <!-- Preview Kiri (Shrink to fit) -->
                <div class="hidden lg:inline-flex border-2 border-black bg-white p-1 rounded-2xl opacity-40 shadow-sm transition">
                    <img id="prevSlideImg" src="{{ asset('images/samplegambar3.jpg') }}" class="h-[320px] w-auto object-cover rounded-xl filter grayscale block">
                </div>

                <!-- Slide Utama Tengah (Border Pas Mengikuti Ukuran Gambar) -->
                <a href="#publikasi" class="inline-flex border-2 border-black bg-white p-1.5 rounded-3xl hover:shadow-md transition duration-300">
                    <img id="mainSlideImg" src="{{ asset('images/samplegambar1.jpg') }}" alt="Banner Utama BKN" class="h-[380px] sm:h-[430px] md:h-[460px] w-auto object-cover rounded-2xl block transition-all duration-500">
                </a>

                <!-- Preview Kanan (Shrink to fit) -->
                <div class="hidden lg:inline-flex border-2 border-black bg-white p-1 rounded-2xl opacity-40 shadow-sm transition">
                    <img id="nextSlideImg" src="{{ asset('images/samplegambar2.jpg') }}" class="h-[320px] w-auto object-cover rounded-xl filter grayscale block">
                </div>

            </div>

            <!-- Dots Navigasi Slider -->
            <div class="flex justify-center space-x-3 pt-1">
                <button onclick="setSlide(0)" class="slider-dot w-3.5 h-3.5 rounded-full bg-black border border-black transition"></button>
                <button onclick="setSlide(1)" class="slider-dot w-3.5 h-3.5 rounded-full bg-white border border-black transition"></button>
                <button onclick="setSlide(2)" class="slider-dot w-3.5 h-3.5 rounded-full bg-white border border-black transition"></button>
            </div>
        </section>


<!-- ==========================================
             2. SEKSI 2: KALENDER PUBLIK (Sesuai Desain Internal)
             ========================================== -->
        <section id="kalender" class="min-h-[calc(100vh-65px)] w-full max-w-7xl mx-auto p-4 md:p-8 flex flex-col justify-center space-y-6">
            
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
            <div class="border-2 border-black bg-white p-4 md:p-6 relative shadow-sm">
                
                <!-- Header Kontrol Kalender -->
                <div class="flex flex-wrap items-center justify-between gap-4 pb-4 border-b-2 border-black relative">
                    
                    <!-- Navigasi Bulan -->
                    <div class="flex items-center space-x-2">
                        <button class="border-2 border-black p-1 hover:bg-gray-100 font-bold px-2.5 text-xs">
                            &lt;
                        </button>
                        <div class="border-2 border-black px-4 py-1 font-semibold text-xs sm:text-sm">
                            April
                        </div>
                        <button class="border-2 border-black p-1 hover:bg-gray-100 font-bold px-2.5 text-xs">
                            &gt;
                        </button>
                    </div>

                    <!-- Teks Kalender Jadwal (Tahun) ver. umum -->
                    <div class="bg-gray-200 border-2 border-black px-6 py-1 font-bold text-xs sm:text-sm text-center grow max-w-sm hidden sm:block">
                        Kalender Jadwal (2026) ver. umum
                    </div>

                    <!-- Tombol Filter Corong -->
                    <button id="lpFilterCalendarBtn" class="border-2 border-black p-1.5 bg-gray-300 hover:bg-gray-400 text-gray-900 transition" title="Filter Kalender">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    </button>

                    <!-- POPUP POPOVER: FILTER KALENDER -->
                    <div id="lpFilterCalendarModal" class="hidden absolute right-0 top-full mt-2 w-80 sm:w-96 bg-white border-2 border-black p-4 shadow-2xl z-30">
                        <div class="flex items-center justify-between pb-3 border-b-2 border-black">
                            <button onclick="resetLpCalendarFilter()" class="border-2 border-black bg-gray-300 hover:bg-gray-400 px-3 py-0.5 text-xs font-semibold text-gray-900">
                                Reset
                            </button>
                            <h4 class="font-bold text-sm text-gray-900">
                                Filter Kalender
                            </h4>
                        </div>

                        <!-- Checkbox Kategori -->
                        <div class="mt-4 border-2 border-black p-3 space-y-3 bg-white">
                            <label class="flex items-center space-x-3 text-xs sm:text-sm font-semibold cursor-pointer">
                                <input type="checkbox" data-filter="pengembangan-karir" checked class="lp-filter-checkbox w-4 h-4 accent-black rounded border-2 border-black">
                                <span>Pengembangan Karir</span>
                            </label>
                            <label class="flex items-center space-x-3 text-xs sm:text-sm font-semibold cursor-pointer">
                                <input type="checkbox" data-filter="sekolah-kedinasan" checked class="lp-filter-checkbox w-4 h-4 accent-black rounded border-2 border-black">
                                <span>Sekolah Kedinasan</span>
                            </label>
                            <label class="flex items-center space-x-3 text-xs sm:text-sm font-semibold cursor-pointer">
                                <input type="checkbox" data-filter="tes-casn" checked class="lp-filter-checkbox w-4 h-4 accent-black rounded border-2 border-black">
                                <span>Tes CASN</span>
                            </label>
                            <label class="flex items-center space-x-3 text-xs sm:text-sm font-semibold cursor-pointer">
                                <input type="checkbox" data-filter="tes-non-asn" checked class="lp-filter-checkbox w-4 h-4 accent-black rounded border-2 border-black">
                                <span>Tes Non-ASN</span>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- TABEL GRID KALENDER PUBLIK -->
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
                                    <!-- Rentang Horizontal Tes CASN -->
                                    <div class="lp-calendar-event absolute top-8 left-3 w-[190%] h-6 bg-gray-300 border-2 border-black rounded-full flex items-center justify-center z-20 shadow-xs pointer-events-none" data-category="tes-casn">
                                        <span class="text-xs font-bold text-gray-900 tracking-wide">Tes CASN</span>
                                    </div>
                                </td>

                                <!-- Tanggal 4 -->
                                <td class="border-r-2 border-black p-2 align-top relative">
                                    <span>4</span>
                                    <!-- Rentang Horizontal Tes CAT -->
                                    <div class="lp-calendar-event absolute top-16 left-3 w-[190%] h-6 bg-gray-300 border-2 border-black rounded-full flex items-center justify-center z-10 shadow-xs pointer-events-none" data-category="sekolah-kedinasan">
                                        <span class="text-xs font-bold text-gray-900 tracking-wide">Tes CAT</span>
                                    </div>
                                </td>

                                <!-- Tanggal 5 -->
                                <td class="border-r-2 border-black p-2 align-top relative">
                                    <span>5</span>
                                    <!-- Badge Tunggal Tes CASN -->
                                    <div class="lp-calendar-event mt-1 mx-auto w-[85%] h-6 bg-gray-600 border-2 border-black text-white text-xs font-bold rounded-full flex items-center justify-center shadow-xs" data-category="tes-casn">
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
                                    <!-- Badge Tunggal Tes CASN -->
                                    <div class="lp-calendar-event mt-4 mx-auto w-[85%] h-6 bg-gray-600 border-2 border-black text-white text-xs font-bold rounded-full flex items-center justify-center shadow-xs" data-category="tes-casn">
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
        </section>

        <hr class="border-t-2 border-black">

        <!-- ==========================================
             3. SEKSI 3: PUBLIKASI & INFORMASI (1 Screen Height)
             ========================================== -->
        <section id="publikasi" class="min-h-[calc(100vh-65px)] w-full max-w-7xl mx-auto p-4 md:p-8 flex flex-col justify-center space-y-4">
            
            <!-- Filter Kategori -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <button class="border-2 border-black bg-gray-300 py-2.5 font-bold text-xs sm:text-sm text-center">
                    Berita
                </button>
                <button class="border-2 border-black bg-white hover:bg-gray-100 py-2.5 font-bold text-xs sm:text-sm text-center transition">
                    Pengumuman
                </button>
                <button class="border-2 border-black bg-white hover:bg-gray-100 py-2.5 font-bold text-xs sm:text-sm text-center transition">
                    Galeri Kegiatan
                </button>
                <button class="border-2 border-black bg-white hover:bg-gray-100 py-2.5 font-bold text-xs sm:text-sm text-center transition">
                    Dokumen Publik
                </button>
            </div>

            <!-- Konten Dua Kolom -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-stretch flex-1">
                <!-- Kolom Kiri: Informasi Singkat -->
                <div class="lg:col-span-4 border-2 border-black bg-white p-6 min-h-[300px] flex flex-col justify-center text-center font-bold text-sm md:text-base text-gray-900">
                    <h3 class="text-base font-bold pb-2 border-b-2 border-black">Section Informasi</h3>
                    <p class="text-xs font-normal text-gray-700 mt-4 leading-relaxed">
                        Pembaruan jadwal seleksi CASN, pengumuman berkas kepegawaian ASN, serta sosialisasi peraturan kepegawaian terbaru Kantor Regional BKN.
                    </p>
                </div>

                <!-- Kolom Kanan: Gambar & Deskripsi -->
                <div class="lg:col-span-8 flex flex-col space-y-3">
                    <div class="border-2 border-black bg-white p-4 min-h-[220px] flex-1 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/samplegambar2.jpg') }}" class="h-full max-h-[240px] w-auto object-contain">
                    </div>
                    <div class="border-2 border-black bg-white p-4 text-center font-semibold text-xs sm:text-sm text-gray-900">
                        Rapat Koordinasi Evaluasi Fasilitasi Ujian CAT BKN Bersama Instansi Daerah
                    </div>
                </div>
            </div>

            <!-- Tombol CTA -->
            <a href="#kontak" class="border-2 border-black bg-white p-3 text-center font-bold text-xs sm:text-sm text-gray-900 hover:bg-gray-100 transition block">
                Lihat Seluruh Arsip Publikasi & Informasi &rarr;
            </a>
        </section>

        <hr class="border-t-2 border-black">

        <!-- ==========================================
             4. SEKSI 4: INFORMASI TEKSTUAL & KONTAK (1 Screen Height)
             ========================================== -->
        <section id="kontak" class="min-h-[calc(100vh-65px)] w-full max-w-7xl mx-auto p-4 md:p-8 flex flex-col justify-center space-y-4">
            <div class="border-2 border-black bg-white p-6 md:p-10 shadow-sm space-y-6 flex flex-col justify-between flex-1">
                
                <h2 class="text-center text-xl md:text-2xl font-bold text-gray-900 border-b-2 border-black pb-3">
                    Tentang Kantor Regional BKN
                </h2>

                <div class="border-2 border-black bg-[#f8f9fa] p-6 md:p-10 flex-1 flex items-center justify-center text-center font-medium text-xs sm:text-sm md:text-base text-gray-800 leading-relaxed">
                    Badan Kepegawaian Negara bertugas mengelola manajemen kepegawaian aparatur sipil negara secara profesional, transparan, dan akuntabel. Kantor Regional memfasilitasi pelaksanaan seleksi CASN, pembinaan kepegawaian daerah, dan digitalisasi administrasi ASN terintegrasi.
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center text-xs sm:text-sm font-semibold text-gray-800 pt-2">
                    <div class="border-2 border-black p-3 bg-white">📍 Wilayah Kerja Regional</div>
                    <div class="border-2 border-black p-3 bg-white">✉️ Layanan Pengaduan & Helpdesk</div>
                    <div class="border-2 border-black p-3 bg-white">📞 Hotline Konsultasi Kepegawaian</div>
                </div>

            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="border-t-2 border-black bg-white p-4 text-center font-bold text-xs sm:text-sm text-gray-900">
        &copy; 2026 Kantor Regional Badan Kepegawaian Negara. Hak Cipta Dilindungi.
    </footer>

    <!-- SCRIPT AUTO-ROTATING CAROUSEL -->
    <script>
        const slides = [
            "{{ asset('images/samplegambar1.jpg') }}",
            "{{ asset('images/samplegambar2.jpg') }}",
            "{{ asset('images/samplegambar3.jpg') }}"
        ];

        let currentIndex = 0;
        const mainImg = document.getElementById('mainSlideImg');
        const prevImg = document.getElementById('prevSlideImg');
        const nextImg = document.getElementById('nextSlideImg');
        const dots = document.querySelectorAll('.slider-dot');

        function updateCarousel(index) {
            currentIndex = index;
            const total = slides.length;
            const prevIndex = (currentIndex - 1 + total) % total;
            const nextIndex = (currentIndex + 1) % total;

            // Update Image Sources
            mainImg.src = slides[currentIndex];
            if (prevImg) prevImg.src = slides[prevIndex];
            if (nextImg) nextImg.src = slides[nextIndex];

            // Update Dots
            dots.forEach((dot, idx) => {
                if (idx === currentIndex) {
                    dot.classList.remove('bg-white');
                    dot.classList.add('bg-black');
                } else {
                    dot.classList.remove('bg-black');
                    dot.classList.add('bg-white');
                }
            });
        }

        function setSlide(index) {
            updateCarousel(index);
            restartAutoSlide();
        }

        function nextSlide() {
            const nextIdx = (currentIndex + 1) % slides.length;
            updateCarousel(nextIdx);
        }

        // Auto rotate setiap 4 detik (4000ms)
        let autoSlideInterval = setInterval(nextSlide, 4000);

        function restartAutoSlide() {
            clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(nextSlide, 4000);
        }

        // LOGIKA FILTER KALENDER LANDING PAGE
        const lpFilterBtn = document.getElementById('lpFilterCalendarBtn');
        const lpFilterModal = document.getElementById('lpFilterCalendarModal');
        const lpCheckboxes = document.querySelectorAll('.lp-filter-checkbox');
        const lpEvents = document.querySelectorAll('.lp-calendar-event');

        if (lpFilterBtn && lpFilterModal) {
            lpFilterBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                lpFilterModal.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!lpFilterModal.contains(e.target) && e.target !== lpFilterBtn) {
                    lpFilterModal.classList.add('hidden');
                }
            });

            function applyLpCalendarFilter() {
                const activeCategories = Array.from(lpCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.getAttribute('data-filter'));

                lpEvents.forEach(event => {
                    const category = event.getAttribute('data-category');
                    if (activeCategories.includes(category)) {
                        event.classList.remove('hidden');
                    } else {
                        event.classList.add('hidden');
                    }
                });
            }

            lpCheckboxes.forEach(cb => {
                cb.addEventListener('change', applyLpCalendarFilter);
            });

            window.resetLpCalendarFilter = function() {
                lpCheckboxes.forEach(cb => cb.checked = true);
                applyLpCalendarFilter();
            };
        }
    </script>
</body>
</html>