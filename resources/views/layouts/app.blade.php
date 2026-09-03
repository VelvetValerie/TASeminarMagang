<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem Manajemen Kegiatan' }} - BKN Kanreg VIII</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="h-full flex overflow-hidden text-slate-800 antialiased">

    <!-- OVERLAY MOBILE BACKDROP -->
    <div id="mobileBackdrop" class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-xs hidden lg:hidden transition-opacity"></div>

    <!-- ==========================================
         SIDEBAR NAVIGATION
         ========================================== -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 flex flex-col transition-transform duration-300 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto shrink-0 border-r border-slate-800">
        
        <!-- LOGO BKN & IDENTITAS INSTANSI DI SIDEBAR -->
        <div class="h-20 flex items-center px-5 border-b border-slate-800 bg-slate-950/50">
            <div class="flex items-center space-x-3">
                <div class="p-1 bg-white rounded-xl shadow-sm shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/Logo_BKN.png') }}" 
                         onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/9/9f/Logo_BKN.png';" 
                         alt="Logo BKN" 
                         class="h-9 w-auto object-contain">
                </div>
                <div class="leading-tight min-w-0">
                    <h1 class="font-extrabold text-white text-xs tracking-tight uppercase truncate">KANREG VIII BKN</h1>
                    <p class="text-[10px] text-sky-400 font-semibold tracking-wider uppercase">Banjarmasin</p>
                </div>
            </div>
        </div>

        <!-- Menu Links Container -->
        <div class="flex-1 overflow-y-auto px-4 py-5 space-y-5">
            
            <!-- Group 1: Menu Utama -->
            <div>
                <p class="px-3 text-[11px] font-bold tracking-wider text-slate-400 uppercase mb-2">Utama</p>
                <nav class="space-y-1">
                    <a href="{{ url('/dashboard') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-semibold rounded-xl transition duration-150 {{ request()->is('dashboard') ? 'bg-sky-600 text-white shadow-sm shadow-sky-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 shrink-0 {{ request()->is('dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ url('/kalender') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-semibold rounded-xl transition duration-150 {{ request()->is('kalender') ? 'bg-sky-600 text-white shadow-sm shadow-sky-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 shrink-0 {{ request()->is('kalender') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Kalender Jadwal
                    </a>
                </nav>
            </div>

            <!-- Group 2: Pelaksanaan & Karyawan -->
            <div>
                <p class="px-3 text-[11px] font-bold tracking-wider text-slate-400 uppercase mb-2">Pelaksanaan</p>
                <nav class="space-y-1">
                    <a href="{{ url('/kegiatan') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-semibold rounded-xl transition duration-150 {{ request()->is('kegiatan') ? 'bg-sky-600 text-white shadow-sm shadow-sky-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 shrink-0 {{ request()->is('kegiatan') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        Kegiatan
                    </a>

                    <a href="{{ url('/riwayat-kerja') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-semibold rounded-xl transition duration-150 {{ request()->is('riwayat-kerja') ? 'bg-sky-600 text-white shadow-sm shadow-sky-600/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 shrink-0 {{ request()->is('riwayat-kerja') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Riwayat Kerja
                    </a>
                </nav>
            </div>

            <!-- Group 3: Dropdown Manajemen Data Kegiatan -->
            <div class="pt-2">
                <details class="group rounded-xl border border-slate-700/80 bg-slate-900/60 overflow-hidden transition"
                         {{ request()->is('jenis-kegiatan', 'titik-lokasi', 'instansi', 'riwayat-kegiatan') ? 'open' : '' }}>
                    <summary class="flex items-center justify-between px-4 py-3 text-xs sm:text-sm font-bold text-white bg-slate-800 hover:bg-slate-750 cursor-pointer transition list-none select-none">
                        <span class="w-full text-center leading-tight">
                            Manajemen<br>Data Kegiatan
                        </span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 group-open:rotate-180 shrink-0 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>

                    <div class="divide-y divide-slate-700/70 border-t border-slate-700 bg-slate-950/40">
                        <a href="{{ url('/jenis-kegiatan') }}" 
                           class="block py-2.5 px-4 text-center text-xs font-semibold transition {{ request()->is('jenis-kegiatan') ? 'bg-sky-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            Jenis Kegiatan
                        </a>
                        <a href="{{ url('/titik-lokasi') }}" 
                           class="block py-2.5 px-4 text-center text-xs font-semibold transition {{ request()->is('titik-lokasi') ? 'bg-sky-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            Titik Lokasi
                        </a>
                        <a href="{{ url('/instansi') }}" 
                           class="block py-2.5 px-4 text-center text-xs font-semibold transition {{ request()->is('instansi') ? 'bg-sky-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            Instansi
                        </a>
                        <a href="{{ url('/riwayat-kegiatan') }}" 
                           class="block py-2.5 px-4 text-center text-xs font-semibold transition {{ request()->is('riwayat-kegiatan') ? 'bg-sky-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            Riwayat Kegiatan
                        </a>
                    </div>
                </details>
            </div>

            <!-- Group 4: Dropdown Manajemen Data Master -->
            <div class="pt-2">
                <details class="group rounded-xl border border-slate-700/80 bg-slate-900/60 overflow-hidden transition"
                         {{ request()->is('master-user*', 'master-kegiatan*', 'master-lokasi*') ? 'open' : '' }}>
                    <summary class="flex items-center justify-between px-4 py-3 text-xs sm:text-sm font-bold text-white bg-slate-800 hover:bg-slate-750 cursor-pointer transition list-none select-none">
                        <span class="w-full text-center leading-tight">
                            Manajemen<br>Data Master
                        </span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200 group-open:rotate-180 shrink-0 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>

                    <div class="divide-y divide-slate-700/70 border-t border-slate-700 bg-slate-950/40">
                        <a href="{{ url('/master-user') }}" 
                           class="block py-2.5 px-4 text-center text-xs font-semibold transition {{ request()->is('master-user*') ? 'bg-sky-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            User
                        </a>
                        <a href="{{ url('/master-kegiatan') }}" 
                           class="block py-2.5 px-4 text-center text-xs font-semibold transition {{ request()->is('master-kegiatan*') ? 'bg-sky-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            Kegiatan
                        </a>
                        <a href="{{ url('/master-lokasi') }}" 
                           class="block py-2.5 px-4 text-center text-xs font-semibold transition {{ request()->is('master-lokasi*') ? 'bg-sky-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            Lokasi
                        </a>
                    </div>
                </details>
            </div>

        </div>

        <!-- Footer: Navigasi Cepat / Tombol ke Halaman Publik -->
        <div class="p-4 border-t border-slate-800 bg-slate-950/20 space-y-2">
            <a href="{{ route('landing') }}" class="flex items-center justify-center space-x-2 w-full px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Halaman Utama (Publik)</span>
            </a>

            <!-- Tombol Logout di Sidebar -->
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="flex items-center justify-center space-x-2 w-full px-3 py-2 rounded-xl border border-rose-900/50 bg-rose-950/20 hover:bg-rose-900/40 text-rose-300 hover:text-white text-xs font-semibold transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Keluar Sistem</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ==========================================
         MAIN CONTENT AREA
         ========================================== -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50">
        
        <!-- Top Header Bar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-30 shrink-0">
            <div class="flex items-center space-x-3">
                <!-- Hamburger Button (Mobile) -->
                <button id="mobileMenuBtn" class="p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 lg:hidden transition" aria-label="Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Dynamic Page Heading -->
                <div>
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 leading-tight">
                        @if(request()->is('dashboard')) Dashboard Ikhtisar
                        @elseif(request()->is('kalender')) Kalender Perencanaan Jadwal
                        @elseif(request()->is('kegiatan')) Manajemen Perencanaan Kegiatan
                        @elseif(request()->is('riwayat-kerja')) Rekapitulasi Riwayat Kerja Pegawai
                        @elseif(request()->is('jenis-kegiatan')) Master Kategori Jenis Kegiatan
                        @elseif(request()->is('titik-lokasi')) Master Data Titik Lokasi & Gedung
                        @elseif(request()->is('instansi')) Daftar Instansi Mitra Terdaftar
                        @elseif(request()->is('riwayat-kegiatan')) Rekapitulasi Riwayat Kegiatan Terlaksana
                        @elseif(request()->is('master-user*')) Manajemen Master Data Pengguna
                        @elseif(request()->is('master-kegiatan*')) Master Data Kegiatan
                        @elseif(request()->is('master-lokasi*')) Master Data Lokasi
                        @else Sistem Informasi BKN
                        @endif
                    </h2>
                </div>
            </div>

            <!-- Right Profile Info & Symmetrical Logout Button -->
            <div class="flex items-center gap-3 pl-4 border-l border-slate-250">
                <!-- Inisial Avatar -->
                <div class="w-9 h-9 rounded-xl bg-slate-900 text-white flex items-center justify-center font-bold text-xs shadow-xs uppercase shrink-0">
                    {{ substr(Auth::user()->username ?? 'AD', 0, 2) }}
                </div>
                
                <!-- Teks Akun -->
                <div class="hidden sm:flex flex-col justify-center leading-tight">
                    <span class="text-xs font-bold text-slate-900">
                        {{ Auth::user()->username ?? 'Administrator' }}
                    </span>
                    <span class="text-[11px] text-slate-500 capitalize">
                        {{ Auth::user()->role ?? 'Admin' }} Kanreg VIII
                    </span>
                </div>
            </div>
        </header>

        <!-- Main Body Scroll Container -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
            <div class="w-full space-y-6">
                @yield('content')
            </div>
        </main>

    </div>

    <!-- SCRIPT: MOBILE TOGGLE -->
    <script>
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        const mobileBackdrop = document.getElementById('mobileBackdrop');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            mobileBackdrop.classList.toggle('hidden');
        }

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', toggleSidebar);
        }
        if (mobileBackdrop) {
            mobileBackdrop.addEventListener('click', toggleSidebar);
        }
    </script>
</body>
</html>