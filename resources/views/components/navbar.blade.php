<nav id="main-navbar" class="fixed top-0 inset-x-0 w-full z-50 flex justify-between items-center px-6 md:px-12 py-4 transition-all duration-300 bg-transparent">
    <!-- Logo & Title -->
    <div class="h-12 overflow-hidden flex-shrink-0 flex items-center">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/Logo_BKN.png') }}" 
                onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/9/9f/Logo_BKN.png';" 
                alt="Logo BKN" class="h-10 w-auto object-contain bg-white p-1 border-2 border-black">
            <span class="text-white font-black text-sm tracking-wider uppercase hidden sm:block drop-shadow">KANREG VIII BKN</span>
        </a>
    </div>

    <!-- Menu Links -->
    <div class="hidden md:flex items-center space-x-2">
        <a href="{{ url('/') }}#hero-section" class="px-4 py-2 text-base font-semibold text-white transition hover:text-white/80">Beranda</a>
        <a href="{{ url('/') }}#kalender" class="px-4 py-2 text-base font-semibold text-white transition hover:text-white/80">Kalender</a>
        <a href="{{ url('/') }}#publikasi" class="px-4 py-2 text-base font-semibold text-white transition hover:text-white/80">Publikasi</a>
        <a href="{{ url('/') }}#kontak" class="px-4 py-2 text-base font-semibold text-white transition hover:text-white/80">Kontak</a>
    </div>

    <!-- Status Auth: Username, Circle Status & Logout Button -->
    <div class="flex items-center gap-2">
        @auth
            <!-- Tombol Dashboard dengan Circle Status -->
            <a href="{{ route('dashboard') }}" class="border-2 border-black bg-white hover:bg-gray-200 font-bold px-4 py-1.5 text-xs sm:text-sm transition inline-flex items-center gap-2 shadow-xs">
                <!-- Circle Status Hijau (Aktif/Online) -->
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse inline-block"></span>
                <span class="max-w-[140px] sm:max-w-none truncate text-gray-900">{{ Auth::user()->username }}</span>
            </a>

            <!-- Form & Tombol Logout -->
            <form method="POST" action="{{ route('logout') }}" class="inline m-0">
                @csrf
                <button type="submit" class="border-2 border-black bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold px-3 py-1.5 text-xs sm:text-sm transition cursor-pointer shadow-xs flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"></path>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        @else
            <!-- Tombol Login (Tampil Saat Guest) -->
            <a href="{{ route('login') }}" class="px-6 py-2 border-2 border-white text-white font-bold text-sm transition hover:bg-white hover:text-black shadow-xs">
                Login
            </a>
        @endauth
    </div>
</nav>