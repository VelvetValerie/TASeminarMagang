<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantor Regional BKN - Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        summary::-webkit-details-marker { display: none; }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 font-sans min-h-screen">

    <!-- NAVBAR UTAMA (Wireframe Navbar Header) -->
    <header class="sticky top-0 z-50 bg-white border-b-2 border-black px-4 lg:px-8 py-3 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            
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
                        <a href="#berita" class="block px-4 py-1 text-xs font-semibold hover:bg-gray-100 border-b border-gray-200">Berita Terkini</a>
                        <a href="#pengumuman" class="block px-4 py-1 text-xs font-semibold hover:bg-gray-100">Pengumuman</a>
                    </div>
                </details>
            </nav>

            <!-- Tombol Login Kanan (Menuju Dashboard Internal) -->
            <div>
                <a href="{{ url('/dashboard') }}" class="border-2 border-black bg-white hover:bg-gray-200 font-bold px-6 py-1 text-xs sm:text-sm transition">
                    Login
                </a>
            </div>

        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4 md:p-8 space-y-12">

        <!-- ==========================================
             1. SEKSI 1: HERO & SLIDER (Wireframe LP 1)
             ========================================== -->
        <section id="beranda" class="space-y-6 pt-2">
            <!-- Judul & Subjudul -->
            <div class="text-center space-y-1">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
                    Judul Laman Web
                </h1>
                <p class="text-sm md:text-base text-gray-700">
                    Subjudul Laman Web
                </p>
            </div>

            <!-- Banner Slider / Gallery -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                <!-- Sisi Kiri (Preview Slide Kiri) -->
                <div class="hidden md:block md:col-span-2 border-2 border-black bg-white p-8 text-center text-xs font-semibold text-gray-400 min-h-[220px]"></div>

                <!-- Banner Utama Tengah (Gambar Hyperlink) -->
                <a href="#publikasi" class="md:col-span-8 border-2 border-black bg-white p-12 min-h-[260px] flex items-center justify-center text-center font-bold text-base md:text-lg text-gray-900 hover:bg-gray-50 transition shadow-sm">
                    Gambar (Hyperlink)
                </a>

                <!-- Sisi Kanan (Preview Slide Kanan) -->
                <div class="hidden md:block md:col-span-2 border-2 border-black bg-white p-8 text-center text-xs font-semibold text-gray-400 min-h-[220px]"></div>
            </div>

            <!-- Indikator Dots Slider -->
            <div class="flex justify-center space-x-2 pt-2">
                <span class="w-3.5 h-3.5 rounded-full bg-black border border-black inline-block cursor-pointer"></span>
                <span class="w-3.5 h-3.5 rounded-full bg-white border border-black inline-block cursor-pointer"></span>
                <span class="w-3.5 h-3.5 rounded-full bg-white border border-black inline-block cursor-pointer"></span>
            </div>
        </section>

        <!-- ==========================================
             2. SEKSI 2: KALENDER UMUM (Wireframe LP 2)
             ========================================== -->
        <section id="kalender" class="border-2 border-black bg-white p-4 md:p-6 shadow-sm space-y-4">
            <!-- Header Kalender Kontrol -->
            <div class="flex flex-wrap items-center justify-between gap-4 pb-3 border-b-2 border-black">
                <div class="flex items-center space-x-2">
                    <button class="border-2 border-black p-1 hover:bg-gray-100 font-bold px-2.5 text-xs">&lt;</button>
                    <div class="border-2 border-black px-4 py-0.5 font-semibold text-xs">(Bulan)</div>
                    <button class="border-2 border-black p-1 hover:bg-gray-100 font-bold px-2.5 text-xs">&gt;</button>
                </div>

                <div class="bg-gray-200 border-2 border-black px-6 py-1 font-bold text-xs sm:text-sm text-center grow max-w-sm hidden sm:block">
                    Kalender Jadwal (Tahun) ver. umum
                </div>

                <button class="border-2 border-black p-1.5 hover:bg-gray-100 transition" title="Filter Jadwal">
                    <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                </button>
            </div>

            <!-- Tampilan Area Jadwal Publik -->
            <div class="border-2 border-black bg-white p-10 min-h-[300px] flex items-center justify-center text-center font-bold text-sm md:text-base text-gray-900">
                Tampilan Hari dan kegiatan yang terdaftar
            </div>
        </section>

        <!-- ==========================================
             3. SEKSI 3: INFORMASI & PUBLIKASI (Wireframe LP 3)
             ========================================== -->
        <section id="publikasi" class="space-y-4">
            <!-- Pilihan Menu Tombol Kategori -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <button class="border-2 border-black bg-white hover:bg-gray-100 py-2 font-bold text-xs sm:text-sm text-center transition">
                    Berita
                </button>
                <button class="border-2 border-black bg-white hover:bg-gray-100 py-2 font-bold text-xs sm:text-sm text-center transition">
                    Pengumuman
                </button>
                <button class="border-2 border-black bg-white hover:bg-gray-100 py-2 font-bold text-xs sm:text-sm text-center transition">
                    Section Item 3
                </button>
                <button class="border-2 border-black bg-white hover:bg-gray-100 py-2 font-bold text-xs sm:text-sm text-center transition">
                    Section Item 4
                </button>
            </div>

            <!-- Konten Dua Kolom Berita & Media -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-stretch">
                <!-- Kolom Kiri: Section Informasi -->
                <div class="lg:col-span-4 border-2 border-black bg-white p-6 min-h-[280px] flex items-center justify-center text-center font-bold text-sm md:text-base text-gray-900">
                    Section Informasi
                </div>

                <!-- Kolom Kanan: Gambar & Deskripsi -->
                <div class="lg:col-span-8 flex flex-col space-y-3">
                    <div class="border-2 border-black bg-white p-8 min-h-[200px] flex-1 flex items-center justify-center text-center font-bold text-sm md:text-base text-gray-900">
                        Section Gambar
                    </div>
                    <div class="border-2 border-black bg-white p-4 text-center font-semibold text-xs sm:text-sm text-gray-900">
                        Section Deskripsi
                    </div>
                </div>
            </div>

            <!-- Tombol CTA Bawah -->
            <div class="border-2 border-black bg-white p-3 text-center font-bold text-xs sm:text-sm text-gray-900 hover:bg-gray-50 cursor-pointer transition">
                Section Call to Action (CTA)
            </div>
        </section>

        <!-- ==========================================
             4. SEKSI 4: INFORMASI TEKSTUAL (Wireframe LP 4)
             ========================================== -->
        <section id="kontak" class="border-2 border-black bg-white p-4 md:p-6 shadow-sm space-y-4">
            <h2 class="text-center text-lg md:text-xl font-bold text-gray-900">
                Judul
            </h2>

            <!-- Dinding Teks Terformat -->
            <div class="border-2 border-black bg-white p-8 md:p-12 min-h-[220px] flex items-center justify-center text-center font-semibold text-sm md:text-base text-gray-800 leading-relaxed">
                Bagian Dinding Teks Terformat
            </div>
        </section>

    </main>

    <!-- FOOTER RESMI -->
    <footer class="mt-12 border-t-2 border-black bg-white p-4 text-center font-bold text-xs sm:text-sm text-gray-900">
        Footer
    </footer>

</body>
</html>