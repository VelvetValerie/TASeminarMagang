<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantor Regional BKN - Portal Informasi</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        summary::-webkit-details-marker { display: none; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .marquee-container {
            width: 100%;
            overflow: hidden;
            white-space: nowrap;
            position: relative;
            container-type: inline-size;
        }
        .marquee-text {
            display: inline-block;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            transition: color 0.2s;
        }
        .marquee-container:hover .marquee-text {
            text-overflow: clip;
            max-width: none;
            animation: scroll-text 3s ease-out forwards;
            animation-delay: 0.2s;
        }
        @keyframes scroll-text {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-100% + 100cqw)); }
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 antialiased">

    <!-- NAVBAR TRANSPARAN DINAMIS -->
    <nav id="main-navbar" class="w-full fixed top-0 left-0 right-0 z-50 flex justify-between items-center px-6 md:px-12 py-4 transition-all duration-300 bg-transparent">
        <div class="h-12 overflow-hidden flex-shrink-0 flex items-center">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/Logo_BKN.png') }}" 
                     onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/9/9f/Logo_BKN.png';" 
                     alt="Logo BKN" class="h-10 w-auto object-contain bg-white p-1 border-2 border-black">
                <span class="text-white font-black text-sm tracking-wider uppercase hidden sm:block drop-shadow">KANREG VIII BKN</span>
            </a>
        </div>

        <div class="hidden md:flex items-center space-x-2">
            <a href="#beranda" class="px-4 py-2 text-base font-semibold text-white transition hover:text-white/80">
                Beranda
            </a>
            <a href="#kalender" class="px-4 py-2 text-base font-semibold text-white transition hover:text-white/80">
                Kalender
            </a>
            <a href="#publikasi" class="px-4 py-2 text-base font-semibold text-white transition hover:text-white/80">
                Publikasi
            </a>
            <a href="#kontak" class="px-4 py-2 text-base font-semibold text-white transition hover:text-white/80">
                Kontak
            </a>

            <!-- Dropdown Informasi -->
            <div class="relative group">
                <button class="px-4 py-2 flex items-center gap-1.5 text-base font-semibold text-white transition hover:text-white/80 cursor-pointer">
                    Informasi
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div class="absolute left-0 top-full mt-1 w-56 bg-white opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden shadow-xl border-2 border-black">
                    <a href="#timeline" class="block px-4 py-2.5 text-sm font-semibold text-gray-800 border-b border-gray-200 hover:bg-gray-100">Timeline Pelaksanaan</a>
                    <a href="#kalender" class="block px-4 py-2.5 text-sm font-semibold text-gray-800 border-b border-gray-200 hover:bg-gray-100">Tes CASN</a>
                    <a href="#kalender" class="block px-4 py-2.5 text-sm font-semibold text-gray-800 border-b border-gray-200 hover:bg-gray-100">Tes Non-ASN</a>
                    <a href="#kalender" class="block px-4 py-2.5 text-sm font-semibold text-gray-800 hover:bg-gray-100">Pengembangan Karir</a>
                </div>
            </div>
        </div>

        <!-- DETEKSI STATUS LOGIN DI NAVBAR KANAN -->
        <div class="flex items-center gap-2">
            @auth
                <a href="{{ url('/dashboard') }}" 
                   class="border-2 border-black bg-white hover:bg-gray-200 font-bold px-4 py-1.5 text-xs sm:text-sm transition inline-flex items-center gap-1.5 shadow-xs">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>
                    <span class="max-w-[120px] sm:max-w-none truncate">{{ Auth::user()->username }}</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline m-0">
                    @csrf
                    <button type="submit" 
                            class="border-2 border-black bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold px-3 py-1.5 text-xs sm:text-sm transition inline-flex items-center gap-1 cursor-pointer shadow-xs">
                        <span>Keluar</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-6 py-2 border-2 border-white text-white font-bold text-sm transition hover:bg-white hover:text-black shadow-xs">
                    Login
                </a>
            @endauth
        </div>
    </nav>

    <main class="w-full">

        <!-- SECTION 1: HERO CAROUSEL FULL WIDTH -->
        <section id="hero-section" class="relative w-full overflow-hidden group mb-16 h-[480px] md:h-[620px] bg-black">
            <div id="carouselSlider" class="flex w-full h-full absolute inset-0 transition-transform duration-700 ease-in-out">
                
                <!-- [CLONE] Slide 3 -->
                <div class="slide-item w-full h-full flex-shrink-0 relative overflow-hidden bg-gray-800">
                    <img src="{{ asset('images/samplegambar3.jpg') }}" onerror="this.src='https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1600';" alt="Slide 3" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/20"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 z-10 pt-20">
                        <h2 class="font-bold text-white text-3xl md:text-5xl drop-shadow-lg">Transparansi Seleksi ASN</h2>
                    </div>
                </div>

                <!-- [REAL] Slide 1: HERO UTAMA -->
                <div class="slide-item w-full h-full flex-shrink-0 relative overflow-hidden bg-gray-900">
                    <img src="{{ asset('images/samplegambar1.jpg') }}" onerror="this.src='https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1600';" alt="Slide 1" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/30"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 z-10 pt-20">
                        <h1 class="text-4xl md:text-6xl font-black text-white mb-3 tracking-tight drop-shadow-md">Portal Informasi BKN</h1>
                        <p class="text-lg md:text-2xl text-gray-200 font-medium max-w-2xl drop-shadow">Sistem Manajemen & Informasi Perencanaan Kegiatan Terpadu</p>
                    </div>
                </div>

                <!-- [REAL] Slide 2 -->
                <div class="slide-item w-full h-full flex-shrink-0 relative overflow-hidden bg-gray-800">
                    <img src="{{ asset('images/samplegambar2.jpg') }}" onerror="this.src='https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1600';" alt="Slide 2" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/20"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 z-10 pt-20">
                        <h2 class="font-bold text-white text-3xl md:text-5xl drop-shadow-lg">Fasilitasi Ujian CAT BKN</h2>
                    </div>
                </div>

                <!-- [REAL] Slide 3 -->
                <div class="slide-item w-full h-full flex-shrink-0 relative overflow-hidden bg-gray-800">
                    <img src="{{ asset('images/samplegambar3.jpg') }}" onerror="this.src='https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1600';" alt="Slide 3" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/20"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 z-10 pt-20">
                        <h2 class="font-bold text-white text-3xl md:text-5xl drop-shadow-lg">Transparansi Seleksi ASN</h2>
                    </div>
                </div>

                <!-- [CLONE] Slide 1 -->
                <div class="slide-item w-full h-full flex-shrink-0 relative overflow-hidden bg-gray-900">
                    <img src="{{ asset('images/samplegambar1.jpg') }}" onerror="this.src='https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1600';" alt="Slide 1" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/30"></div>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 z-10 pt-20">
                        <h1 class="text-4xl md:text-6xl font-black text-white mb-3 tracking-tight drop-shadow-md">Portal Informasi BKN</h1>
                        <p class="text-lg md:text-2xl text-gray-200 font-medium max-w-2xl drop-shadow">Sistem Manajemen & Informasi Perencanaan Kegiatan Terpadu</p>
                    </div>
                </div>

            </div>

            <!-- Tombol Navigasi Carousel -->
            <button id="btnPrev" type="button" class="absolute left-0 top-0 bottom-0 w-[10%] bg-gradient-to-r from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-white cursor-pointer z-20 outline-none border-none">
                <svg class="w-10 h-10 md:w-14 md:h-14 drop-shadow-md" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button id="btnNext" type="button" class="absolute right-0 top-0 bottom-0 w-[10%] bg-gradient-to-l from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-white cursor-pointer z-20 outline-none border-none">
                <svg class="w-10 h-10 md:w-14 md:h-14 drop-shadow-md" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <!-- Indicator Dots -->
            <div class="absolute bottom-6 left-0 right-0 flex justify-center gap-3 z-30" id="carouselDots">
                <button type="button" class="dot w-3.5 h-3.5 md:w-4 md:h-4 rounded-full border-2 border-white bg-white transition-all transform scale-125 shadow-md cursor-pointer" onclick="goToSlide(1)"></button>
                <button type="button" class="dot w-3.5 h-3.5 md:w-4 md:h-4 rounded-full border-2 border-white bg-white/50 hover:bg-white transition-all shadow-md cursor-pointer" onclick="goToSlide(2)"></button>
                <button type="button" class="dot w-3.5 h-3.5 md:w-4 md:h-4 rounded-full border-2 border-white bg-white/50 hover:bg-white transition-all shadow-md cursor-pointer" onclick="goToSlide(3)"></button>
            </div>
        </section>

        <!-- ==========================================
             SECTION 2: KALENDER PUBLIK DINAMIS (GAMBAR KE-2)
             ========================================== -->
        <section id="kalender" class="min-h-[calc(100vh-65px)] w-full max-w-7xl mx-auto p-4 md:p-8 flex flex-col justify-center space-y-6 scroll-mt-28">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 border-b-2 border-black pb-2">Agenda & Jadwal Kegiatan</h2>

            <!-- KOTAK KALENDER UTAMA -->
            <div class="border-2 border-black bg-white p-4 md:p-6 relative shadow-sm">
                
                <div class="flex flex-wrap items-center justify-between gap-4 pb-4 border-b-2 border-black relative">
                    <div class="flex items-center space-x-2">
                        <button type="button" onclick="navigateMonth(-1)" class="border-2 border-black p-1 hover:bg-gray-100 font-bold px-2.5 text-xs select-none cursor-pointer" title="Bulan Sebelumnya">&lt;</button>
                        <div id="calMonthYearLabel" class="border-2 border-black px-4 py-1 font-semibold text-xs sm:text-sm min-w-[140px] text-center select-none">
                            Memuat...
                        </div>
                        <button type="button" onclick="navigateMonth(1)" class="border-2 border-black p-1 hover:bg-gray-100 font-bold px-2.5 text-xs select-none cursor-pointer" title="Bulan Berikutnya">&gt;</button>
                    </div>

                    <div class="bg-gray-200 border-2 border-black px-6 py-1 font-bold text-xs sm:text-sm text-center grow max-w-sm hidden sm:block">
                        Kalender Jadwal BKN
                    </div>

                    <!-- Tombol Filter Corong -->
                    <button id="filterCalendarBtn" class="border-2 border-black p-1.5 bg-gray-300 hover:bg-gray-400 text-gray-900 transition cursor-pointer" title="Filter Kalender">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    </button>

                    <!-- Popup Filter Kategori -->
                    <div id="filterCalendarModal" class="hidden absolute right-0 top-full mt-2 w-80 bg-white border-2 border-black p-4 shadow-2xl z-30">
                        <div class="flex items-center justify-between pb-3 border-b-2 border-black">
                            <button type="button" onclick="resetCalendarFilter()" class="border-2 border-black bg-gray-300 hover:bg-gray-400 px-3 py-0.5 text-xs font-semibold text-gray-900 cursor-pointer">
                                Reset
                            </button>
                            <h4 class="font-bold text-sm text-gray-900">Filter Kategori</h4>
                        </div>
                        <div class="mt-4 border-2 border-black p-3 space-y-3 bg-white">
                            <label class="flex items-center space-x-3 text-xs sm:text-sm font-semibold cursor-pointer">
                                <input type="checkbox" data-filter="pengembangan-karir" checked class="cal-filter-checkbox w-4 h-4 accent-black rounded border-2 border-black">
                                <span>Pengembangan Karir</span>
                            </label>
                            <label class="flex items-center space-x-3 text-xs sm:text-sm font-semibold cursor-pointer">
                                <input type="checkbox" data-filter="tes-cat" checked class="cal-filter-checkbox w-4 h-4 accent-black rounded border-2 border-black">
                                <span>Tes CAT</span>
                            </label>
                            <label class="flex items-center space-x-3 text-xs sm:text-sm font-semibold cursor-pointer">
                                <input type="checkbox" data-filter="tes-casn" checked class="cal-filter-checkbox w-4 h-4 accent-black rounded border-2 border-black">
                                <span>Tes CASN</span>
                            </label>
                            <label class="flex items-center space-x-3 text-xs sm:text-sm font-semibold cursor-pointer">
                                <input type="checkbox" data-filter="tes-non-asn" checked class="cal-filter-checkbox w-4 h-4 accent-black rounded border-2 border-black">
                                <span>Tes Non-ASN</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- TABEL GRID KALENDER DINAMIS -->
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
                        <tbody id="calGridBody" class="text-sm font-semibold">
                            <!-- Dirender Dinamis oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MODAL 1: DAFTAR KEGIATAN HARI TERPILIH -->
            <div id="dayEventsModal" class="hidden fixed inset-0 z-40 flex items-center justify-center p-4 bg-black/50 backdrop-blur-xs">
                <div class="relative w-full max-w-2xl bg-white border-2 border-black p-5 shadow-2xl">
                    <button type="button" onclick="closeDayEventsModal()" class="absolute top-2 right-2 p-1 text-red-600 hover:text-red-800 transition cursor-pointer">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <h3 id="dayModalTitle" class="text-base sm:text-lg font-bold text-gray-900 pr-8 pb-3 border-b-2 border-black">
                        Daftar Kegiatan
                    </h3>
                    <div id="dayModalListContainer" class="mt-4 border-2 border-black bg-[#d1d5db] p-4 max-h-[380px] overflow-y-auto space-y-3">
                        <!-- Diisi dinamis -->
                    </div>
                </div>
            </div>

            <!-- MODAL 2: RINCIAN DETAIL KEGIATAN LENGKAP -->
            <div id="eventDetailModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
                <div class="relative w-full max-w-xl bg-white border-2 border-black p-5 shadow-2xl">
                    <button type="button" onclick="closeEventDetailModal()" class="absolute top-2 right-2 p-1 text-red-600 hover:text-red-800 transition cursor-pointer">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
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
        </section>

        <!-- SECTION 3: PUSAT INFORMASI & PENGUMUMAN -->
        <section id="publikasi" class="min-h-[calc(100vh-65px)] w-full max-w-7xl mx-auto p-4 md:p-8 flex flex-col justify-center space-y-6 scroll-mt-28">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 border-b-2 border-black pb-2 text-center">Pusat Informasi & Pengumuman</h2>
            
            <div class="flex flex-col md:flex-row gap-5 w-full items-stretch">
                <div class="wire-box md:w-[28%] bg-white p-4 flex flex-col border-2 border-black shrink-0 overflow-hidden">
                    <h3 class="text-lg font-bold border-b-2 border-black pb-2 text-center bg-white z-10">Pengumuman Terbaru</h3>
                    <div class="flex flex-col gap-3 mt-4 overflow-y-auto pr-1">
                        <div class="border-l-4 border-gray-600 pl-3">
                            <p class="text-xs text-gray-500 font-medium">12 Agustus 2026</p>
                            <a href="#" class="text-sm font-semibold hover:underline leading-tight mt-0.5 block">Hasil Seleksi Administrasi Tahap 1 CPNS & PPPK</a>
                        </div>
                        <div class="border-l-4 border-gray-600 pl-3">
                            <p class="text-xs text-gray-500 font-medium">08 Agustus 2026</p>
                            <a href="#" class="text-sm font-semibold hover:underline leading-tight mt-0.5 block">Jadwal Pengambilan Kartu Ujian Fisik</a>
                        </div>
                        <div class="border-l-4 border-gray-600 pl-3">
                            <p class="text-xs text-gray-500 font-medium">01 Agustus 2026</p>
                            <a href="#" class="text-sm font-semibold hover:underline leading-tight mt-0.5 block">Panduan Penggunaan Sistem CAT 2026 Lengkap</a>
                        </div>
                    </div>
                    <button type="button" class="w-full py-2 mt-auto border-2 border-black text-sm font-bold hover:bg-gray-100 transition-colors cursor-pointer">Lihat Semua</button>
                </div>

                <div class="md:w-[72%] aspect-video border-2 border-black relative group/news bg-black overflow-hidden" id="newsFadeContainer">
                    <div class="news-slide absolute inset-0 transition-opacity duration-700 ease-in-out opacity-100 z-10 pointer-events-auto">
                        <img src="{{ asset('images/samplegambar1.jpg') }}" onerror="this.src='https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=1200';" alt="Thumbnail" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent pointer-events-none"></div>

                        <div class="absolute bottom-0 inset-x-0 p-6 flex flex-col justify-end">
                            <div class="marquee-container mb-2">
                                <h3 class="text-xl md:text-2xl font-black text-white marquee-text drop-shadow-md cursor-default">
                                    Persiapan Mengikuti Seleksi Kompetensi Dasar (SKD) Tahun 2026 Secara Serentak
                                </h3>
                            </div>

                            <div class="relative">
                                <div class="h-[105px] overflow-hidden text-gray-300 text-sm leading-relaxed relative z-0">
                                    <p class="mb-1">Menjelang pelaksanaan SKD tahun 2026, seluruh peserta diwajibkan untuk mempersiapkan dokumen identitas asli berupa KTP dan Kartu Peserta Ujian yang dicetak berwarna.</p>
                                    <ul class="list-disc pl-5 space-y-1 opacity-80">
                                        <li>Hadir 90 menit sebelum jadwal sesi dimulai.</li>
                                        <li>Mengenakan kemeja putih polos.</li>
                                        <li>Dilarang membawa alat elektronik, perhiasan, maupun ikat pinggang.</li>
                                    </ul>
                                </div>
                                <button type="button" class="absolute bottom-0 right-0 z-20 py-1.5 px-4 bg-white/90 hover:bg-white text-black font-bold text-xs transition-colors shadow-lg border border-transparent hover:border-black backdrop-blur-sm translate-y-1/4 cursor-pointer">
                                    Baca selengkapnya...
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="news-slide absolute inset-0 transition-opacity duration-700 ease-in-out opacity-0 z-0 pointer-events-none">
                        <img src="{{ asset('images/samplegambar2.jpg') }}" onerror="this.src='https://images.unsplash.com/photo-1434030216411-0b793f4b4173?q=80&w=1200';" alt="Thumbnail" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent pointer-events-none"></div>
                        
                        <div class="absolute bottom-0 inset-x-0 p-6 flex flex-col justify-end">
                            <div class="marquee-container mb-2">
                                <h3 class="text-xl md:text-2xl font-black text-white marquee-text drop-shadow-md cursor-default">
                                    Pengumuman Hasil Verifikasi Sanggah Kelulusan Administrasi CASN 2026
                                </h3>
                            </div>
                            <div class="relative">
                                <div class="h-[105px] overflow-hidden text-gray-300 text-sm leading-relaxed relative z-0">
                                    <p>Berdasarkan hasil verifikasi ulang dokumen yang diajukan pada masa sanggah, panitia seleksi nasional telah merilis daftar nama peserta yang berhak melanjutkan ke tahap selanjutnya.</p>
                                </div>
                                <button type="button" class="absolute bottom-0 right-0 z-20 py-1.5 px-4 bg-white/90 hover:bg-white text-black font-bold text-xs transition-colors shadow-lg border border-transparent hover:border-black backdrop-blur-sm translate-y-1/4 cursor-pointer">
                                    Baca selengkapnya...
                                </button>
                            </div>
                        </div>
                    </div>

                    <button id="btnPrevFade" type="button" class="absolute left-0 top-1/2 -translate-y-1/2 w-12 h-14 bg-black/40 hover:bg-black/80 text-white flex items-center justify-center opacity-0 group-hover/news:opacity-100 transition-all duration-300 z-30 focus:outline-none backdrop-blur-sm border-none cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button id="btnNextFade" type="button" class="absolute right-0 top-1/2 -translate-y-1/2 w-12 h-14 bg-black/40 hover:bg-black/80 text-white flex items-center justify-center opacity-0 group-hover/news:opacity-100 transition-all duration-300 z-30 focus:outline-none backdrop-blur-sm border-none cursor-pointer">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        </section>

        <!-- SECTION 4: TIMELINE PELAKSANAAN -->
        <section id="timeline" class="mb-16 w-full scroll-mt-28 bg-gray-200 border-y-2 border-black py-12 md:py-16 shadow-sm">
            <div class="max-w-7xl mx-auto w-full px-4">
                <div class="text-center mb-12 md:mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold mb-2">Timeline Pelaksanaan</h2>
                    <p class="text-lg text-gray-700 font-medium">Rangkaian Alur Kegiatan Seleksi 2026</p>
                </div>
                
                <div class="wire-box bg-white p-8 py-24 md:px-32 md:py-32 relative shadow-sm border-2 border-black overflow-x-auto">
                    <div class="absolute top-1/2 left-20 right-20 h-1.5 bg-gray-600 -translate-y-1/2 z-0 min-w-[800px]"></div>
                    <div class="relative z-10 w-full flex justify-between items-center min-w-[800px]">
                        <div class="relative flex flex-col items-center justify-center">
                            <div class="absolute bottom-full mb-10 bg-[#d9d9d9] px-6 py-2 rounded-full font-bold whitespace-nowrap text-base text-black z-20 shadow-sm border-2 border-black">Pendaftaran</div>
                            <div class="absolute bottom-1/2 w-0.5 h-14 bg-gray-600 z-10"></div>
                            <div class="w-8 h-8 rounded-full bg-white border-[3px] border-gray-800 relative z-20"></div>
                        </div>
                        <div class="relative flex flex-col items-center justify-center">
                            <div class="w-8 h-8 rounded-full bg-[#e5e7eb] border-[3px] border-gray-400 relative z-20"></div>
                            <div class="absolute top-1/2 w-0.5 h-24 bg-gray-400 z-10"></div>
                            <div class="absolute top-full mt-12 bg-gray-100 px-6 py-2 rounded-full font-bold whitespace-nowrap text-base text-gray-500 z-20 shadow-sm border-2 border-gray-300">Penyerahan Berkas</div>
                        </div>
                        <div class="relative flex flex-col items-center justify-center">
                            <div class="absolute bottom-full mb-10 bg-gray-100 px-6 py-2 rounded-full font-bold whitespace-nowrap text-base text-gray-500 z-20 shadow-sm border-2 border-gray-300">Tes Tahap 1</div>
                            <div class="absolute bottom-1/2 w-0.5 h-14 bg-gray-400 z-10"></div>
                            <div class="w-8 h-8 rounded-full bg-[#e5e7eb] border-[3px] border-gray-400 relative z-20"></div>
                        </div>
                        <div class="relative flex flex-col items-center justify-center">
                            <div class="w-8 h-8 rounded-full bg-[#e5e7eb] border-[3px] border-gray-400 relative z-20"></div>
                            <div class="absolute top-1/2 w-0.5 h-24 bg-gray-400 z-10"></div>
                            <div class="absolute top-full mt-12 bg-gray-100 px-6 py-2 rounded-full font-bold whitespace-nowrap text-base text-gray-500 z-20 shadow-sm border-2 border-gray-300">Tes Tahap 2</div>
                        </div>
                        <div class="relative flex flex-col items-center justify-center">
                            <div class="absolute bottom-full mb-10 bg-gray-100 px-6 py-2 rounded-full font-bold whitespace-nowrap text-base text-gray-500 z-20 shadow-sm border-2 border-gray-300">Pengumuman</div>
                            <div class="absolute bottom-1/2 w-0.5 h-14 bg-gray-400 z-10"></div>
                            <div class="w-8 h-8 rounded-full bg-[#e5e7eb] border-[3px] border-gray-400 relative z-20"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 5: KONTAK -->
        <section id="kontak" class="min-h-[calc(100vh-65px)] w-full max-w-7xl mx-auto p-4 md:p-8 flex flex-col justify-center space-y-6 scroll-mt-28">
            <div class="bg-gray-300 border-2 border-black p-6 md:p-8 rounded-xl shadow-sm">
                <h2 class="text-3xl font-bold mb-8 text-center text-gray-900">Hubungi Kami</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="wire-box bg-white flex-1 h-56 flex flex-col items-center justify-center text-center p-6 hover:-translate-y-1 transition-transform border-2 border-black">
                        <svg class="w-12 h-12 mb-4 text-gray-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"></path></svg>
                        <h3 class="text-xl font-bold mb-2">Alamat</h3>
                        <p class="text-xs text-gray-600 font-medium">Jl. Hasan Basri No. 1<br>Banjarbaru, Kalimantan Selatan</p>
                    </div>
                    <div class="wire-box bg-white flex-1 h-56 flex flex-col items-center justify-center text-center p-6 hover:-translate-y-1 transition-transform border-2 border-black">
                        <svg class="w-12 h-12 mb-4 text-gray-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
                        <h3 class="text-xl font-bold mb-2">Email</h3>
                        <p class="text-xs text-gray-600 font-medium">bantuan@bkn.go.id<br>info@bkn.go.id</p>
                    </div>
                    <div class="wire-box bg-white flex-1 h-56 flex flex-col items-center justify-center text-center p-6 hover:-translate-y-1 transition-transform border-2 border-black">
                        <svg class="w-12 h-12 mb-4 text-gray-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.48-4.18-7.077-7.077l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"></path></svg>
                        <h3 class="text-xl font-bold mb-2">Telepon</h3>
                        <p class="text-xs text-gray-600 font-medium">(0511) 1234-5678<br>0812-3456-7890</p>
                    </div>
                    <div class="wire-box bg-white flex-1 h-56 flex flex-col items-center justify-center text-center p-6 hover:-translate-y-1 transition-transform border-2 border-black">
                        <svg class="w-12 h-12 mb-4 text-gray-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"></path></svg>
                        <h3 class="text-xl font-bold mb-2">Konsultasi</h3>
                        <p class="text-xs text-gray-600 font-medium">Senin - Jumat<br>08:00 - 15:00 WITA</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer class="border-t-2 border-black bg-white p-4 text-center font-bold text-xs sm:text-sm text-gray-900">
        &copy; 2026 Kantor Regional Badan Kepegawaian Negara. Hak Cipta Dilindungi.
    </footer>

    <!-- SCRIPT GABUNGAN: NAVBAR SCROLL, HERO CAROUSEL, FADE SLIDER & KALENDER JAVASCRIPT DINAMIS -->
    <script>
        // ==========================================
        // DOKUMEN PARSING & LOGIKA KALENDER UTAMA
        // ==========================================
        @php
            $formattedEvents = collect($kegiatan ?? [])->map(function($k, $index) {
                $namaJenis = strtolower($k->jenis->nama_jeniskeg ?? '');
                $kategoriSlug = 'tes-non-asn';
                
                if (str_contains($namaJenis, 'karir') || str_contains($namaJenis, 'pengembangan')) {
                    $kategoriSlug = 'pengembangan-karir';
                } elseif (str_contains($namaJenis, 'cat') || str_contains($namaJenis, 'dinas') || str_contains($namaJenis, 'sekolah')) {
                    $kategoriSlug = 'tes-cat';
                } elseif (str_contains($namaJenis, 'casn') || str_contains($namaJenis, 'cpns')) {
                    $kategoriSlug = 'tes-casn';
                }

                $tglMulai = \Carbon\Carbon::parse($k->tanggal_mulai)->format('Y-m-d');
                $tglSelesai = $k->tanggal_selesai ? \Carbon\Carbon::parse($k->tanggal_selesai)->format('Y-m-d') : $tglMulai;
                
                $tglLabelLengkap = \Carbon\Carbon::parse($k->tanggal_mulai)->translatedFormat('l, d F Y');
                if ($k->tanggal_selesai && $tglMulai !== $tglSelesai) {
                    $tglLabelLengkap .= ' ~ ' . \Carbon\Carbon::parse($k->tanggal_selesai)->translatedFormat('l, d F Y');
                }

                return [
                    'id'             => $k->id_keg ?? $k->id_kegiatan ?? $index,
                    'nama'           => $k->nama_keg ?? '-',
                    'lokasi'         => $k->lokasi->nm_lokasi ?? '-',
                    'alamat'         => $k->lokasi->alamat ?? '-',
                    'koordinator'    => $k->koordinator->nama_karyawan ?? '-',
                    'jenis'          => $k->jenis->nama_jeniskeg ?? '-',
                    'peserta'        => number_format($k->jmlh_peserta ?? 0),
                    'status'         => $k->status ?? '-',
                    'lampiran'       => $k->lampiran ?? '-',
                    'kategori'       => $kategoriSlug,
                    'startDate'      => $tglMulai,
                    'endDate'        => $tglSelesai,
                    'tanggalLengkap' => $tglLabelLengkap,
                ];
            });
        @endphp

        const dbEvents = @json($formattedEvents);

        const monthNames = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        const todayReal = new Date();
        let calYear = todayReal.getFullYear();
        let calMonth = todayReal.getMonth(); // 0-indexed

        const monthYearLabel = document.getElementById('calMonthYearLabel');
        const calGridBody = document.getElementById('calGridBody');

        function renderCalendar() {
            if (!monthYearLabel || !calGridBody) return;
            monthYearLabel.innerText = `${monthNames[calMonth]} ${calYear}`;
            calGridBody.innerHTML = '';

            const firstDayOfWeek = new Date(calYear, calMonth, 1).getDay();
            const daysInMonth = new Date(calYear, calMonth + 1, 0).getDate();
            const daysInPrevMonth = new Date(calYear, calMonth, 0).getDate();

            let dayCounter = 1;
            let nextCounter = 1;

            for (let row = 0; row < 6; row++) {
                const tr = document.createElement('tr');
                tr.className = 'border-b-2 border-black min-h-[112px] h-28 relative';
                if (row === 5) tr.classList.remove('border-b-2');

                const weekDaysInfo = [];
                for (let col = 0; col < 7; col++) {
                    if (row === 0 && col < firstDayOfWeek) {
                        weekDaysInfo.push({ isCurrentMonth: false, day: daysInPrevMonth - (firstDayOfWeek - col - 1), dateStr: null });
                    } else if (dayCounter <= daysInMonth) {
                        const dateStr = `${calYear}-${String(calMonth + 1).padStart(2, '0')}-${String(dayCounter).padStart(2, '0')}`;
                        weekDaysInfo.push({ isCurrentMonth: true, day: dayCounter, dateStr: dateStr });
                        dayCounter++;
                    } else {
                        weekDaysInfo.push({ isCurrentMonth: false, day: nextCounter, dateStr: null });
                        nextCounter++;
                    }
                }

                const weekTracks = [];
                const eventsToRenderThisWeek = [];

                dbEvents.forEach(ev => {
                    let startCol = -1;
                    let endCol = -1;

                    for (let c = 0; c < 7; c++) {
                        const info = weekDaysInfo[c];
                        if (info.isCurrentMonth && info.dateStr) {
                            if (info.dateStr >= ev.startDate && info.dateStr <= ev.endDate) {
                                if (startCol === -1) startCol = c;
                                endCol = c;
                            }
                        }
                    }

                    if (startCol !== -1) {
                        let assignedLane = 0;
                        while (true) {
                            if (!weekTracks[assignedLane]) {
                                weekTracks[assignedLane] = [false, false, false, false, false, false, false];
                            }
                            let isCollision = false;
                            for (let c = startCol; c <= endCol; c++) {
                                if (weekTracks[assignedLane][c]) {
                                    isCollision = true;
                                    break;
                                }
                            }
                            if (!isCollision) break;
                            assignedLane++;
                        }

                        for (let c = startCol; c <= endCol; c++) {
                            weekTracks[assignedLane][c] = true;
                        }

                        eventsToRenderThisWeek.push({
                            event: ev,
                            startCol: startCol,
                            endCol: endCol,
                            lane: assignedLane
                        });
                    }
                });

                const tdElements = [];
                for (let col = 0; col < 7; col++) {
                    const info = weekDaysInfo[col];
                    const td = document.createElement('td');
                    td.className = 'p-2 align-top transition select-none ' + (col < 6 ? 'border-r-2 border-black ' : '');

                    if (!info.isCurrentMonth) {
                        td.classList.add('text-gray-400', 'bg-gray-50/50');
                        td.innerHTML = `<span>${info.day}</span>`;
                    } else {
                        td.classList.add('bg-white', 'relative', 'hover:bg-gray-50', 'cursor-pointer');
                        td.setAttribute('data-day', info.day);
                        td.setAttribute('data-date', info.dateStr);

                        const isRealToday = (
                            info.day === todayReal.getDate() && 
                            calMonth === todayReal.getMonth() && 
                            calYear === todayReal.getFullYear()
                        );

                        if (isRealToday) {
                            td.innerHTML = `<span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-black text-white font-bold text-xs">${info.day}</span>`;
                        } else {
                            td.innerHTML = `<span class="font-bold text-gray-900">${info.day}</span>`;
                        }

                        const matchingEventsToday = dbEvents.filter(ev => info.dateStr >= ev.startDate && info.dateStr <= ev.endDate);
                        td.addEventListener('click', function(e) {
                            if (e.target.closest('.cal-event')) return;
                            if (matchingEventsToday.length > 0) {
                                openDayEventsModal(info.day, matchingEventsToday);
                            }
                        });
                    }

                    tr.appendChild(td);
                    tdElements.push(td);
                }

                eventsToRenderThisWeek.forEach(item => {
                    const ev = item.event;
                    const startCol = item.startCol;
                    const spanCols = item.endCol - item.startCol + 1;
                    const targetTd = tdElements[startCol];

                    let bgStyle = 'bg-gray-300 text-gray-900';
                    if (ev.kategori === 'pengembangan-karir') bgStyle = 'bg-sky-600 text-white';
                    else if (ev.kategori === 'tes-cat') bgStyle = 'bg-emerald-600 text-white';
                    else if (ev.kategori === 'tes-casn') bgStyle = 'bg-gray-300 text-gray-900';
                    else if (ev.kategori === 'tes-non-asn') bgStyle = 'bg-gray-800 text-white';

                    const topOffset = 32 + (item.lane * 30);
                    const zIndex = 25 - item.lane;
                    const widthPercent = (spanCols * 100) - 10;

                    const badge = document.createElement('div');
                    badge.className = `cal-event absolute left-2 h-6 ${bgStyle} border-2 border-black rounded-full flex items-center justify-center shadow-xs cursor-pointer hover:opacity-90 transition`;
                    badge.style.top = `${topOffset}px`;
                    badge.style.width = `${widthPercent}%`;
                    badge.style.zIndex = zIndex;
                    badge.setAttribute('data-category', ev.kategori);
                    badge.setAttribute('title', `${ev.nama} (${ev.startDate} s/d ${ev.endDate})`);
                    badge.innerHTML = `<span class="text-xs font-bold tracking-wide truncate px-3">${ev.nama}</span>`;

                    badge.addEventListener('click', (e) => handleDirectEventClick(e, ev.id));
                    targetTd.appendChild(badge);
                });

                calGridBody.appendChild(tr);
                if (dayCounter > daysInMonth && row >= 4) break;
            }

            applyCalendarFilter();
        }

        function navigateMonth(direction) {
            calMonth += direction;
            if (calMonth < 0) {
                calMonth = 11;
                calYear--;
            } else if (calMonth > 11) {
                calMonth = 0;
                calYear++;
            }
            renderCalendar();
        }

        const dayModal = document.getElementById('dayEventsModal');
        const detailModal = document.getElementById('eventDetailModal');

        function openDayEventsModal(dayNum, events) {
            document.getElementById('dayModalTitle').innerText = `Daftar Kegiatan (${dayNum} ${monthNames[calMonth]} ${calYear})`;
            const container = document.getElementById('dayModalListContainer');
            container.innerHTML = '';

            events.forEach(item => {
                const card = document.createElement('div');
                card.className = 'border-2 border-black bg-white p-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3';
                card.innerHTML = `
                    <div>
                        <h4 class="font-bold text-gray-900 text-base">${item.nama}</h4>
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-1 text-xs sm:text-sm text-gray-700 mt-1">
                            <span>${item.lokasi}</span>
                            <span>${item.tanggalLengkap}</span>
                        </div>
                    </div>
                    <button type="button" 
                            onclick="openDetailFromDayModal(event, ${item.id})" 
                            class="self-end sm:self-center border-2 border-black bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-1 text-sm transition cursor-pointer">
                        Detail
                    </button>
                `;
                container.appendChild(card);
            });

            dayModal.classList.remove('hidden');
        }

        function closeDayEventsModal() {
            dayModal.classList.add('hidden');
        }

        function openDetailFromDayModal(e, eventId) {
            if (e) e.stopPropagation();
            closeDayEventsModal();
            handleDirectEventClick(null, eventId);
        }

        function handleDirectEventClick(e, eventId) {
            if (e) e.stopPropagation();
            const item = dbEvents.find(x => x.id === eventId);
            if (!item) return;

            document.getElementById('dtJudulModal').innerText = `Detail ${item.nama}`;
            document.getElementById('dtNamaKeg').innerText = item.nama;
            document.getElementById('dtKoordinator').innerText = item.koordinator;
            document.getElementById('dtJenis').innerText = item.jenis;
            document.getElementById('dtTanggalPelaksanaan').innerText = item.tanggalLengkap;
            document.getElementById('dtTitikLokasi').innerText = `${item.lokasi} (${item.alamat})`;
            document.getElementById('dtJumlahPeserta').innerText = item.peserta;
            document.getElementById('dtStatusKegiatan').innerText = item.status;
            
            const lampiranElem = document.getElementById('dtLampiranUrl');
            lampiranElem.innerText = item.lampiran;
            lampiranElem.href = (item.lampiran && item.lampiran !== '-') ? item.lampiran : '#';

            detailModal.classList.remove('hidden');
        }

        function closeEventDetailModal() {
            detailModal.classList.add('hidden');
        }

        const calBtn = document.getElementById('filterCalendarBtn');
        const calModal = document.getElementById('filterCalendarModal');
        const calCheckboxes = document.querySelectorAll('.cal-filter-checkbox');

        if (calBtn && calModal) {
            calBtn.addEventListener('click', (e) => { 
                e.stopPropagation(); 
                calModal.classList.toggle('hidden'); 
            });

            document.addEventListener('click', (e) => {
                if (!calModal.contains(e.target) && e.target !== calBtn) calModal.classList.add('hidden');
                if (e.target === dayModal) closeDayEventsModal();
                if (e.target === detailModal) closeEventDetailModal();
            });
        }

        function applyCalendarFilter() {
            const activeCats = Array.from(calCheckboxes).filter(cb => cb.checked).map(cb => cb.getAttribute('data-filter'));
            const events = document.querySelectorAll('.cal-event');
            events.forEach(ev => {
                const cat = ev.getAttribute('data-category');
                ev.style.display = activeCats.includes(cat) ? 'flex' : 'none';
            });
        }

        calCheckboxes.forEach(cb => cb.addEventListener('change', applyCalendarFilter));

        function resetCalendarFilter() {
            calCheckboxes.forEach(cb => cb.checked = true);
            applyCalendarFilter();
        }

        // ==========================================
        // DOKUMEN DOM LOADED (NAVBAR & HERO CAROUSEL)
        // ==========================================
        document.addEventListener('DOMContentLoaded', () => {
            renderCalendar();

            // Navbar Transparan ke Solid (#fca855)
            const navbar = document.getElementById('main-navbar');
            const heroSection = document.getElementById('hero-section');

            if (navbar && heroSection) {
                window.addEventListener('scroll', () => {
                    const heroHeight = heroSection.offsetHeight - 80;
                    if (window.scrollY > heroHeight) {
                        navbar.classList.remove('bg-transparent', 'py-4');
                        navbar.classList.add('bg-[#fca855]', 'shadow-md', 'py-2');
                    } else {
                        navbar.classList.add('bg-transparent', 'py-4');
                        navbar.classList.remove('bg-[#fca855]', 'shadow-md', 'py-2');
                    }
                });
            }

            // Hero Carousel Automatic
            let currentSlide = 1;
            let isTransitioning = false;
            const totalRealSlides = 3;
            const slider = document.getElementById('carouselSlider');
            const dots = document.querySelectorAll('.dot');
            let autoPlayInterval;

            if (slider) {
                const disableTransitions = () => { slider.style.transitionDuration = '0ms'; };
                const enableTransitions = () => { slider.style.transitionDuration = ''; };

                const setTransform = (index) => {
                    slider.style.transform = `translateX(-${index * 100}%)`;
                };

                const updateVisuals = (index) => {
                    let dotIndex = index - 1;
                    if (dotIndex < 0) dotIndex = totalRealSlides - 1;
                    if (dotIndex >= totalRealSlides) dotIndex = 0;

                    dots.forEach((dot, idx) => {
                        if (idx === dotIndex) { 
                            dot.classList.add('bg-white', 'scale-125'); 
                            dot.classList.remove('bg-white/50'); 
                        } else { 
                            dot.classList.remove('bg-white', 'scale-125'); 
                            dot.classList.add('bg-white/50'); 
                        }
                    });
                };

                const moveToIndex = (index) => {
                    if (isTransitioning) return;
                    isTransitioning = true;
                    currentSlide = index;
                    enableTransitions();
                    setTransform(currentSlide);
                    updateVisuals(currentSlide);
                };

                slider.addEventListener('transitionend', (e) => {
                    if (e.target !== slider) return;
                    isTransitioning = false;
                    if (currentSlide === 0) { 
                        currentSlide = totalRealSlides; 
                        disableTransitions(); 
                        setTransform(currentSlide); 
                        updateVisuals(currentSlide); 
                        void slider.offsetWidth; 
                    } else if (currentSlide === totalRealSlides + 1) { 
                        currentSlide = 1; 
                        disableTransitions(); 
                        setTransform(currentSlide); 
                        updateVisuals(currentSlide); 
                        void slider.offsetWidth; 
                    }
                });

                window.goToSlide = (realIndex) => { if (!isTransitioning) { moveToIndex(realIndex); resetInterval(); } };
                document.getElementById('btnNext').addEventListener('click', () => { if (!isTransitioning) { moveToIndex(currentSlide + 1); resetInterval(); } });
                document.getElementById('btnPrev').addEventListener('click', () => { if (!isTransitioning) { moveToIndex(currentSlide - 1); resetInterval(); } });

                const startInterval = () => { autoPlayInterval = setInterval(() => moveToIndex(currentSlide + 1), 6000); };
                const resetInterval = () => { clearInterval(autoPlayInterval); startInterval(); };

                disableTransitions();
                setTransform(currentSlide);
                updateVisuals(currentSlide);
                void slider.offsetWidth; 
                startInterval();
            }

            // Fade Slider Berita
            const newsSlides = document.querySelectorAll('.news-slide');
            const btnPrevFade = document.getElementById('btnPrevFade');
            const btnNextFade = document.getElementById('btnNextFade');
            let newsIndex = 0;

            if (newsSlides.length > 0) {
                const updateFadeSlider = () => {
                    newsSlides.forEach((slide, index) => {
                        if (index === newsIndex) {
                            slide.classList.remove('opacity-0', 'z-0', 'pointer-events-none');
                            slide.classList.add('opacity-100', 'z-10', 'pointer-events-auto');
                        } else {
                            slide.classList.remove('opacity-100', 'z-10', 'pointer-events-auto');
                            slide.classList.add('opacity-0', 'z-0', 'pointer-events-none');
                        }
                    });
                };

                if (btnNextFade) {
                    btnNextFade.addEventListener('click', () => {
                        newsIndex = (newsIndex + 1) % newsSlides.length;
                        updateFadeSlider();
                    });
                }

                if (btnPrevFade) {
                    btnPrevFade.addEventListener('click', () => {
                        newsIndex = (newsIndex - 1 + newsSlides.length) % newsSlides.length;
                        updateFadeSlider();
                    });
                }
            }
        });
    </script>
</body>
</html>