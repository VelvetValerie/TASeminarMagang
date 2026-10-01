<nav id="main-navbar" class="w-full fixed top-0 left-0 right-0 z-50 flex justify-between items-center px-8 py-2 bg-[#fca855]/80 shadow-md opacity-0 transition-all duration-500 ease-in-out">
    
    <!-- Container Logo -->
    <div id="logo-container" class="w-16 h-16 md:w-16 md:h-16 overflow-hidden flex-shrink-0 ml-8 transition-all duration-500 ease-in-out">
        <a href="/"><img src="/images/Logo_BKN.png" alt="Logo Instansi" class="w-full h-full object-contain"></a>
    </div>

    <div class="flex items-center space-x-3">
        <!-- BERANDA -->
        <a id="nav-beranda" href="/" class="nav-link px-4 py-2 relative text-lg font-medium text-white transition-colors duration-300 hover:text-white/80 after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:scale-x-0 after:bg-white after:transition-transform after:duration-300 after:origin-center hover:after:scale-x-100">
            Beranda
        </a>

        <!-- KALENDAR -->
        <a id="nav-kalender" href="/#kalender" class="nav-link px-4 py-2 relative text-lg font-medium text-white transition-colors duration-300 hover:text-white/80 after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:scale-x-0 after:bg-white after:transition-transform after:duration-300 after:origin-center hover:after:scale-x-100">
            Kalendar
        </a>
        
        <!-- PUBLIKASI -->
        <div class="relative group">
            <a id="nav-publikasi" href="/#publikasi" class="nav-link px-4 py-2 relative flex items-center gap-2 text-lg font-medium text-white transition-colors duration-300 hover:text-white/80 after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:scale-x-0 after:bg-white after:transition-transform after:duration-300 after:origin-center hover:after:scale-x-100">
                Publikasi
                <svg class="w-5 h-5 font-bold transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </a>

            <div class="absolute left-0 top-full mt-1 w-full min-w-[220px] rounded-lg bg-white opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 ease-in-out z-50 overflow-hidden shadow-xl border border-gray-100">
                <a href="/berita" class="block px-4 py-2.5 text-lg font-medium text-gray-700 transition-colors duration-300 hover:bg-orange-50 hover:text-[#fca855]">Berita</a>
            </div>
        </div>

        <!-- KONTAK -->
        <a id="nav-kontak" href="/#kontak" class="nav-link px-4 py-2 relative text-lg font-medium text-white transition-colors duration-300 hover:text-white/80 after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:scale-x-0 after:bg-white after:transition-transform after:duration-300 after:origin-center hover:after:scale-x-100">
            Kontak
        </a>

        <!-- INFORMASI -->
        <div class="relative group">
            <a id="nav-informasi" href="/informasi" class="nav-link px-4 py-2 relative flex items-center gap-2 text-lg font-medium text-white transition-colors duration-300 hover:text-white/80 after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:scale-x-0 after:bg-white after:transition-transform after:duration-300 after:origin-center hover:after:scale-x-100">
                Informasi
                <svg class="w-5 h-5 font-bold transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </a>

            <div class="absolute left-0 top-full mt-1 w-full min-w-[220px] rounded-lg bg-white opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 ease-in-out z-50 overflow-hidden shadow-xl border border-gray-100">
                <a href="/informasi/timeline" class="block px-4 py-2.5 text-lg font-medium text-gray-700 transition-colors duration-300 hover:bg-orange-50 hover:text-[#fca855]">Timeline</a>
                <a href="/informasi/timeline#casn" class="block px-4 py-2.5 text-lg font-medium text-gray-700 transition-colors duration-300 hover:bg-orange-50 hover:text-[#fca855]">CASN</a>
                <a href="/informasi/timeline#non-asn" class="block px-4 py-2.5 text-lg font-medium text-gray-700 transition-colors duration-300 hover:bg-orange-50 hover:text-[#fca855]">Non-ASN</a>
                <a href="/informasi/timeline#pengembangan-karir" class="block px-4 py-2.5 text-lg font-medium text-gray-700 transition-colors duration-300 hover:bg-orange-50 hover:text-[#fca855]">Pengembangan Karir</a>
                <a href="/informasi/timeline#sekolah-kedinasan" class="block px-4 py-2.5 text-lg font-medium text-gray-700 transition-colors duration-300 hover:bg-orange-50 hover:text-[#fca855]">Sekolah Kedinasan</a>
            </div>
        </div>
    </div>

    <!-- TAMPILAN AUTENTIKASI DINAMIS (AUTH / GUEST) -->
    <div>
        @auth
            <!-- TAMPILAN SAAT USER SUDAH LOGIN -->
            <div class="flex items-center gap-3">
                <!-- Tombol ke Dashboard -->
                <a href="{{ url('/dashboard') }}" 
                   class="px-5 py-2 border-2 border-white bg-white text-[#fca855] text-lg font-bold rounded-lg shadow-md transition-all duration-300 hover:bg-orange-50 hover:border-orange-100 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <!-- Badge Nama User & Tombol Logout -->
                <div class="flex items-center bg-black/20 backdrop-blur-sm border border-white/30 rounded-lg p-1">
                    <span class="px-3 text-white font-semibold text-sm hidden md:inline">
                        👤 {{ Auth::user()->username }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="inline m-0">
                        @csrf
                        <button type="submit" 
                                title="Keluar" 
                                class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-bold transition-all flex items-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @endauth

        @guest
            <!-- TAMPILAN SAAT PENGGUNA BELUM LOGIN -->
            <a class="px-7 py-2 border-2 border-white text-white text-lg font-medium rounded-lg transition-all duration-300 hover:text-[#fca855] hover:bg-white" 
               href="{{ route('login') }}">
                Login
            </a>
        @endguest
    </div>
</nav>

<script>
    (function() {
        const navbar = document.getElementById('main-navbar');
        const logo = document.getElementById('logo-container');
        const links = document.querySelectorAll('.nav-link');
        
        // Dapatkan URL saat ini
        const currentPath = window.location.pathname;
        const isHomePage = currentPath === '/' || currentPath === '/index.html';
        
        // 1. PENGATURAN MODE TRANSPARAN (Hanya di Beranda & Scroll di atas)
        if (isHomePage && window.scrollY < 50) { 
            navbar.classList.remove('bg-[#fca855]/80', 'shadow-md', 'py-2');
            navbar.classList.add('bg-transparent', 'py-4');
            
            if (logo) {
                logo.classList.remove('md:w-16', 'md:h-16');
                logo.classList.add('md:w-20', 'md:h-20');
            }
            
            links.forEach(link => {
                link.classList.remove('after:bg-white');
                link.classList.add('after:bg-orange-500');
            });
        }

        // 2. SISTEM URL-BASED ACTIVE LINK
        links.forEach(link => {
            const href = link.getAttribute('href');
            const linkId = link.getAttribute('id');
            let isActive = false;
            
            if (href.includes('#')) {
                if (linkId === 'nav-publikasi' && currentPath.startsWith('/berita')) {
                    isActive = true;
                }
            } else {
                if (href === '/' && isHomePage) {
                    isActive = true; 
                } else if (href !== '/' && currentPath.startsWith(href)) {
                    isActive = true;
                }
            }

            // Terapkan class jika aktif
            if (isActive) {
                link.classList.remove('after:scale-x-0');
                link.classList.add('after:scale-x-100');
            }
        });

        // 3. FADE-IN PEMUATAN HALAMAN
        setTimeout(() => {
            navbar.classList.remove('opacity-0');
            navbar.classList.add('opacity-100');
        }, 50);
    })();
</script>