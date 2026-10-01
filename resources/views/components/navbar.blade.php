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

    <a class="px-7 py-2 border-2 border-white text-white text-lg font-medium rounded-lg transition-all duration-300 hover:text-[#fca855] hover:bg-white" href="/login">Login</a>
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
                // Jangan nyalakan link yang memiliki target '#', 
                // KECUALI tombol Publikasi saat pengguna berada di path /berita
                if (linkId === 'nav-publikasi' && currentPath.startsWith('/berita')) {
                    isActive = true;
                }
            } else {
                // Aturan untuk link normal tanpa '#'
                if (href === '/' && isHomePage) {
                    // Khusus Beranda, hanya menyala jika benar-benar di root
                    isActive = true; 
                } else if (href !== '/' && currentPath.startsWith(href)) {
                    // Menyala untuk path yang sesuai (misal: /informasi/timeline menyalakan /informasi)
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