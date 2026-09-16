<nav id="main-navbar" class="fixed top-0 inset-x-0 w-full z-50 flex justify-between items-center px-6 md:px-12 py-4 transition-all duration-300 bg-transparent">
    <div class="h-12 overflow-hidden flex-shrink-0 flex items-center">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/Logo_BKN.png') }}" 
                onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/9/9f/Logo_BKN.png';" 
                alt="Logo BKN" class="h-10 w-auto object-contain bg-white p-1 border-2 border-black">
            <span class="text-white font-black text-sm tracking-wider uppercase hidden sm:block drop-shadow">KANREG VIII BKN</span>
        </a>
    </div>

    <div class="hidden md:flex items-center space-x-2">
        <a href="{{ url('/') }}#hero-section" class="px-4 py-2 text-base font-semibold text-white transition hover:text-white/80">Beranda</a>
        <a href="{{ url('/') }}#kalender" class="px-4 py-2 text-base font-semibold text-white transition hover:text-white/80">Kalender</a>
        <a href="{{ url('/') }}#publikasi" class="px-4 py-2 text-base font-semibold text-white transition hover:text-white/80">Publikasi</a>
        <a href="{{ url('/') }}#kontak" class="px-4 py-2 text-base font-semibold text-white transition hover:text-white/80">Kontak</a>
    </div>

    <div class="flex items-center gap-2">
        @auth
            <a href="{{ route('dashboard') }}" class="border-2 border-black bg-white hover:bg-gray-200 font-bold px-4 py-1.5 text-xs sm:text-sm transition">
                {{ Auth::user()->username }}
            </a>
        @else
            <a href="{{ route('login') }}" class="px-6 py-2 border-2 border-white text-white font-bold text-sm transition hover:bg-white hover:text-black">
                Login
            </a>
        @endauth
    </div>
</nav>