<nav id="main-navbar" class="w-full fixed top-0 left-0 right-0 z-50 grid grid-cols-[1fr_auto_1fr] items-center px-6 lg:px-12 py-2 bg-[#fca855]/80 shadow-md opacity-0 transition-all duration-500 ease-in-out">
    
    <!-- 1. SISI KIRI: LOGO INSTANSI -->
    <div class="flex items-center justify-start min-w-0">
        <div id="logo-container" class="w-16 h-16 md:w-16 md:h-16 overflow-hidden flex-shrink-0 transition-all duration-500 ease-in-out">
            <a href="/" class="block w-full h-full"><img src="/images/Logo_BKN.png" alt="Logo Instansi" class="w-full h-full object-contain"></a>
        </div>
    </div>

    <!-- 2. SISI TENGAH: MENU OPSI KONSISTEN (TIDAK BERGESER) -->
    <div class="flex items-center justify-center space-x-1 md:space-x-2 lg:space-x-3">
        <!-- BERANDA -->
        <a id="nav-beranda" href="/" class="nav-link px-3 lg:px-4 py-2 relative text-lg font-medium text-white transition-colors duration-300 hover:text-white/80 after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:scale-x-0 after:bg-white after:transition-transform after:duration-300 after:origin-center hover:after:scale-x-100">
            Beranda
        </a>

        <!-- KALENDAR -->
        <a id="nav-kalender" href="/#kalender" class="nav-link px-3 lg:px-4 py-2 relative text-lg font-medium text-white transition-colors duration-300 hover:text-white/80 after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:scale-x-0 after:bg-white after:transition-transform after:duration-300 after:origin-center hover:after:scale-x-100">
            Kalendar
        </a>
        
        <!-- PUBLIKASI -->
        <div class="relative group">
            <a id="nav-publikasi" href="/#publikasi" class="nav-link px-3 lg:px-4 py-2 relative flex items-center gap-1.5 text-lg font-medium text-white transition-colors duration-300 hover:text-white/80 after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:scale-x-0 after:bg-white after:transition-transform after:duration-300 after:origin-center hover:after:scale-x-100">
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
        <a id="nav-kontak" href="/#kontak" class="nav-link px-3 lg:px-4 py-2 relative text-lg font-medium text-white transition-colors duration-300 hover:text-white/80 after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:scale-x-0 after:bg-white after:transition-transform after:duration-300 after:origin-center hover:after:scale-x-100">
            Kontak
        </a>

        <!-- INFORMASI -->
        <div class="relative group">
            <a id="nav-informasi" href="/informasi" class="nav-link px-3 lg:px-4 py-2 relative flex items-center gap-1.5 text-lg font-medium text-white transition-colors duration-300 hover:text-white/80 after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:scale-x-0 after:bg-white after:transition-transform after:duration-300 after:origin-center hover:after:scale-x-100">
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

    <!-- 3. SISI KANAN: TAMPILAN AUTENTIKASI DINAMIS (AUTH / GUEST) -->
    <div class="flex items-center justify-end min-w-0">
        @auth
            <!-- DROPDOWN PROFIL TERPADU (SIMPLIFIED DASHBOARD & USER) -->
            <div class="relative group" id="user-profile-menu">
                <button type="button" 
                        id="user-profile-btn"
                        class="flex items-center gap-2 px-3 py-1.5 md:px-4 md:py-2 rounded-lg border-2 border-white/80 bg-white/10 hover:bg-white hover:text-[#fca855] text-white transition-all duration-300 shadow-sm cursor-pointer group/btn focus:outline-none">
                    
                    <!-- Avatar / Foto Profil atau Ikon -->
                    <div class="w-7 h-7 rounded-full overflow-hidden bg-white/20 group-hover/btn:bg-[#fca855]/20 flex items-center justify-center flex-shrink-0 text-current transition-colors">
                        @if(Auth::user()->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists(Auth::user()->foto))
                            <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="{{ Auth::user()->username }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        @endif
                    </div>

                    <!-- Username Ringkas (Truncate jika panjang) -->
                    <span class="max-w-[100px] md:max-w-[130px] truncate text-sm md:text-base font-semibold tracking-wide text-current">
                        {{ Auth::user()->username }}
                    </span>

                    <!-- Chevron Icon -->
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180 flex-shrink-0 text-current" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- DROPDOWN MENU -->
                <div id="user-profile-dropdown"
                     class="absolute right-0 top-full pt-1.5 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 ease-in-out z-50">
                    <div class="rounded-xl bg-white shadow-xl border border-gray-100 py-1.5 overflow-hidden">
                        <!-- Info User Header -->
                        <div class="px-4 py-2.5 border-b border-gray-100 bg-orange-50/50">
                            <p class="text-[11px] font-medium text-gray-500 uppercase tracking-wider">Login sebagai</p>
                            <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->username }}</p>
                            @if(isset(Auth::user()->role))
                                <span class="inline-block mt-1 text-[10px] font-bold px-2 py-0.5 bg-orange-100 text-orange-700 rounded-full uppercase tracking-wider">
                                    {{ str_replace('_', ' ', Auth::user()->role) }}
                                </span>
                            @endif
                        </div>

                        <!-- Menu Dashboard -->
                        <a href="{{ url('/dashboard') }}" 
                           class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-gray-700 transition-colors duration-200 hover:bg-orange-50 hover:text-[#fca855]">
                            <svg class="w-4 h-4 text-[#fca855]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 00-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>

                        <!-- Menu Pengaturan Profil -->
                        <a href="{{ route('profile.index') }}" 
                           class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-gray-700 transition-colors duration-200 hover:bg-orange-50 hover:text-[#fca855]">
                            <svg class="w-4 h-4 text-[#fca855]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Pengaturan Profil
                        </a>

                        <!-- Divider -->
                        <div class="border-t border-gray-100 my-1"></div>

                        <!-- Tombol Logout -->
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-red-600 transition-colors duration-200 hover:bg-red-50 text-left cursor-pointer">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
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
        
        const currentPath = window.location.pathname;
        const isHomePage = currentPath === '/' || currentPath === '/index.html';
        
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

            if (isActive) {
                link.classList.remove('after:scale-x-0');
                link.classList.add('after:scale-x-100');
            }
        });

        // Click handler untuk Profile Dropdown di mobile / touch
        const userProfileBtn = document.getElementById('user-profile-btn');
        const userProfileDropdown = document.getElementById('user-profile-dropdown');
        if (userProfileBtn && userProfileDropdown) {
            userProfileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                userProfileDropdown.classList.toggle('opacity-0');
                userProfileDropdown.classList.toggle('invisible');
            });
            document.addEventListener('click', function(e) {
                if (!userProfileBtn.contains(e.target) && !userProfileDropdown.contains(e.target)) {
                    userProfileDropdown.classList.add('opacity-0', 'invisible');
                }
            });
        }

        setTimeout(() => {
            navbar.classList.remove('opacity-0');
            navbar.classList.add('opacity-100');
        }, 50);
    })();
</script>
