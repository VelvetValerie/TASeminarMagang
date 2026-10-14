@php
    // --- QUERY UNTUK TAB BERITA ---
    $beritaList = \App\Models\Berita::where('kategori_publikasi', 'Berita')
                        ->where('status', 'Terbit')
                        ->latest()
                        ->take(5)
                        ->get();
    
    $sidebarBerita = $beritaList->take(4); // Ambil 4 teratas untuk daftar samping

    // --- QUERY UNTUK TAB INFORMASI RESMI ---
    $infoList = \App\Models\Berita::where('kategori_publikasi', 'Informasi Resmi')
                        ->where('status', 'Terbit')
                        ->latest()
                        ->take(5)
                        ->get();
                        
    $sidebarInfo = $infoList->take(4); // Ambil 4 teratas untuk daftar samping

    // Array warna border untuk variasi visual
    $borderColors = ['border-orange-500', 'border-yellow-500', 'border-blue-500', 'border-green-500'];
@endphp

<style>
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

<!-- TOMBOL TOGGLE TAB -->
<div class="flex justify-center w-full mb-8" data-aos="fade-up">
    <div class="bg-gray-100 p-1.5 rounded-full flex gap-1 shadow-inner border border-gray-200">
        <button id="tabBerita" class="px-6 py-2.5 rounded-full text-sm font-bold bg-white text-blue-700 shadow-sm transition-all focus:outline-none">
            Berita Terkini
        </button>
        <button id="tabInfo" class="px-6 py-2.5 rounded-full text-sm font-bold text-gray-500 hover:text-gray-800 transition-all focus:outline-none">
            Informasi Resmi
        </button>
    </div>
</div>

<!-- ============================================== -->
<!-- 1. KONTEN TAB BERITA                           -->
<!-- ============================================== -->
<div id="contentBerita" class="flex flex-col md:flex-row gap-6 w-full items-stretch transition-opacity duration-500 opacity-100">

    <!-- Kolom Kiri: Daftar Berita -->
    <div data-aos="fade-right" class="md:w-[28%] bg-white p-6 flex flex-col shrink-0 overflow-hidden rounded-3xl shadow-xl border border-gray-100">
        <h3 class="text-lg font-bold border-b-2 border-gray-100 pb-3 text-center bg-white z-10">Berita Terbaru</h3>
        <div class="flex flex-col gap-4 mt-5 overflow-y-auto pr-1">
            @forelse($sidebarBerita as $index => $item)
                <div class="border-l-4 {{ $borderColors[$index % count($borderColors)] }} pl-3">
                    <p class="text-xs text-gray-500 font-medium">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</p>
                    <a href="{{ route('berita.show', $item->slug) }}" class="text-sm font-semibold hover:text-gray-800 transition-colors leading-tight mt-0.5 block line-clamp-2">
                        {{ $item->judul_berita }}
                    </a>
                </div>
            @empty
                <div class="text-center py-4 text-sm text-gray-400 italic">Belum ada berita terbaru.</div>
            @endforelse
        </div>
        <a href="{{ route('berita.index') }}" class="text-center w-full py-2.5 mt-auto border border-gray-200 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors shadow-sm">Lihat Semua Berita</a>
    </div>

    <!-- Kolom Kanan: Carousel Berita -->
    <div data-aos="fade-left" class="md:w-[72%] aspect-video relative group/news bg-black overflow-hidden rounded-3xl shadow-xl border border-gray-100" id="carouselBerita">
        @forelse($beritaList as $index => $item)
            <div class="slide-berita absolute inset-0 transition-opacity duration-700 ease-in-out {{ $index === 0 ? 'opacity-100 z-10 pointer-events-auto' : 'opacity-0 z-0 pointer-events-none' }}">
                <img src="{{ $item->thumbnail ? asset('storage/' . $item->thumbnail) : '/images/samplegambar1.jpg' }}" alt="Thumbnail" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent pointer-events-none"></div>

                <div class="absolute bottom-0 inset-x-0 p-6 flex flex-col justify-end">
                    <div class="marquee-container mb-2">
                        <h3 class="text-xl md:text-2xl font-black text-white marquee-text drop-shadow-md cursor-default">{{ $item->judul_berita }}</h3>
                    </div>
                    <div class="relative">
                        <div class="h-[105px] overflow-hidden text-gray-300 text-sm leading-relaxed relative z-0">
                            <p class="mb-1 text-justify pr-2">{!! Str::limit(strip_tags($item->konten), 250) !!}</p>
                            <div class="absolute bottom-0 inset-x-0 h-10 bg-gradient-to-t from-[#0a0a0a]/90 to-transparent pointer-events-none"></div>
                        </div>
                        <a href="{{ route('berita.show', $item->slug) }}" class="absolute bottom-0 right-0 z-20 py-2 px-5 bg-white/95 hover:bg-white text-black font-bold text-xs transition-colors shadow-lg rounded-tl-2xl backdrop-blur-sm">Baca selengkapnya...</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="slide-berita absolute inset-0 transition-opacity duration-700 ease-in-out opacity-100 z-10 pointer-events-auto flex items-center justify-center">
                <div class="text-white font-semibold italic">Belum ada berita yang diterbitkan.</div>
            </div>
        @endforelse

        @if(count($beritaList) > 1)
            <button id="prevBerita" class="absolute left-0 top-1/2 -translate-y-1/2 w-12 h-14 bg-black/40 hover:bg-black/80 text-white flex items-center justify-center opacity-0 group-hover/news:opacity-100 transition-all duration-300 z-30 focus:outline-none backdrop-blur-sm rounded-r-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button id="nextBerita" class="absolute right-0 top-1/2 -translate-y-1/2 w-12 h-14 bg-black/40 hover:bg-black/80 text-white flex items-center justify-center opacity-0 group-hover/news:opacity-100 transition-all duration-300 z-30 focus:outline-none backdrop-blur-sm rounded-l-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
            </button>
        @endif
    </div>
</div>

<!-- ============================================== -->
<!-- 2. KONTEN TAB INFORMASI RESMI                  -->
<!-- ============================================== -->
<div id="contentInfo" class="hidden flex-col md:flex-row gap-6 w-full items-stretch transition-opacity duration-500 opacity-0">

    <!-- Kolom Kiri: Daftar Informasi -->
    <div class="md:w-[28%] bg-white p-6 flex flex-col shrink-0 overflow-hidden rounded-3xl shadow-xl border border-gray-100">
        <h3 class="text-lg font-bold border-b-2 border-gray-100 pb-3 text-center bg-white z-10">Pengumuman Terbaru</h3>
        <div class="flex flex-col gap-4 mt-5 overflow-y-auto pr-1">
            @forelse($sidebarInfo as $index => $item)
                <div class="border-l-4 {{ $borderColors[$index % count($borderColors)] }} pl-3">
                    <p class="text-xs text-gray-500 font-medium">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</p>
                    <a href="{{ route('informasi.show', $item->slug) }}" class="text-sm font-semibold hover:text-gray-800 transition-colors leading-tight mt-0.5 block line-clamp-2">
                        {{ $item->judul_berita }}
                    </a>
                </div>
            @empty
                <div class="text-center py-4 text-sm text-gray-400 italic">Belum ada informasi terbaru.</div>
            @endforelse
        </div>
        <a href="{{ route('informasi.index') }}" class="text-center w-full py-2.5 mt-auto border border-gray-200 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors shadow-sm">Lihat Pusat Informasi</a>
    </div>

    <!-- Kolom Kanan: Carousel Informasi -->
    <div class="md:w-[72%] aspect-video relative group/news bg-black overflow-hidden rounded-3xl shadow-xl border border-gray-100" id="carouselInfo">
        @forelse($infoList as $index => $item)
            <div class="slide-info absolute inset-0 transition-opacity duration-700 ease-in-out {{ $index === 0 ? 'opacity-100 z-10 pointer-events-auto' : 'opacity-0 z-0 pointer-events-none' }}">
                <img src="{{ $item->thumbnail ? asset('storage/' . $item->thumbnail) : '/images/samplegambar2.jpg' }}" alt="Thumbnail" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent pointer-events-none"></div>

                <div class="absolute bottom-0 inset-x-0 p-6 flex flex-col justify-end">
                    <div class="marquee-container mb-2">
                        <h3 class="text-xl md:text-2xl font-black text-white marquee-text drop-shadow-md cursor-default">{{ $item->judul_berita }}</h3>
                    </div>
                    <div class="relative">
                        <div class="h-[105px] overflow-hidden text-gray-300 text-sm leading-relaxed relative z-0">
                            <p class="mb-1 text-justify pr-2">{!! Str::limit(strip_tags($item->konten), 250) !!}</p>
                            <div class="absolute bottom-0 inset-x-0 h-10 bg-gradient-to-t from-[#0a0a0a]/90 to-transparent pointer-events-none"></div>
                        </div>
                        <a href="{{ route('informasi.show', $item->slug) }}" class="absolute bottom-0 right-0 z-20 py-2 px-5 bg-white/95 hover:bg-white text-black font-bold text-xs transition-colors shadow-lg rounded-tl-2xl backdrop-blur-sm">Baca selengkapnya...</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="slide-info absolute inset-0 transition-opacity duration-700 ease-in-out opacity-100 z-10 pointer-events-auto flex items-center justify-center">
                <div class="text-white font-semibold italic">Belum ada informasi resmi yang diterbitkan.</div>
            </div>
        @endforelse

        @if(count($infoList) > 1)
            <button id="prevInfo" class="absolute left-0 top-1/2 -translate-y-1/2 w-12 h-14 bg-black/40 hover:bg-black/80 text-white flex items-center justify-center opacity-0 group-hover/news:opacity-100 transition-all duration-300 z-30 focus:outline-none backdrop-blur-sm rounded-r-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button id="nextInfo" class="absolute right-0 top-1/2 -translate-y-1/2 w-12 h-14 bg-black/40 hover:bg-black/80 text-white flex items-center justify-center opacity-0 group-hover/news:opacity-100 transition-all duration-300 z-30 focus:outline-none backdrop-blur-sm rounded-l-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
            </button>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- LOGIKA TAB TOGGLE ---
        const tabBerita = document.getElementById('tabBerita');
        const tabInfo = document.getElementById('tabInfo');
        const contentBerita = document.getElementById('contentBerita');
        const contentInfo = document.getElementById('contentInfo');

        function switchTab(activeTab, inactiveTab, showContent, hideContent) {
            // Ubah gaya tab
            activeTab.classList.add('bg-white', 'text-blue-700', 'shadow-sm');
            activeTab.classList.remove('text-gray-500', 'hover:text-gray-800');
            
            inactiveTab.classList.remove('bg-white', 'text-blue-700', 'shadow-sm');
            inactiveTab.classList.add('text-gray-500', 'hover:text-gray-800');

            // Sembunyikan konten lama dengan transisi
            hideContent.classList.remove('opacity-100');
            hideContent.classList.add('opacity-0');
            
            setTimeout(() => {
                hideContent.classList.remove('flex');
                hideContent.classList.add('hidden');
                
                showContent.classList.remove('hidden');
                showContent.classList.add('flex');
                
                // Beri jeda kecil sebelum memunculkan konten baru agar transisinya halus
                setTimeout(() => {
                    showContent.classList.remove('opacity-0');
                    showContent.classList.add('opacity-100');
                }, 50);
            }, 300);
        }

        tabBerita.addEventListener('click', () => switchTab(tabBerita, tabInfo, contentBerita, contentInfo));
        tabInfo.addEventListener('click', () => switchTab(tabInfo, tabBerita, contentInfo, contentBerita));


        // --- LOGIKA CAROUSEL (Dibuat Reusable) ---
        function initCarousel(slideClassName, btnNextId, btnPrevId) {
            const slides = document.querySelectorAll('.' + slideClassName);
            const btnNext = document.getElementById(btnNextId);
            const btnPrev = document.getElementById(btnPrevId);
            let currentIndex = 0;

            if (slides.length <= 1) return;

            const updateSlider = () => {
                slides.forEach((slide, index) => {
                    if (index === currentIndex) {
                        slide.classList.remove('opacity-0', 'z-0', 'pointer-events-none');
                        slide.classList.add('opacity-100', 'z-10', 'pointer-events-auto');
                    } else {
                        slide.classList.remove('opacity-100', 'z-10', 'pointer-events-auto');
                        slide.classList.add('opacity-0', 'z-0', 'pointer-events-none');
                    }
                });
            };

            if (btnNext) {
                btnNext.addEventListener('click', () => {
                    currentIndex = (currentIndex + 1) % slides.length;
                    updateSlider();
                });
            }

            if (btnPrev) {
                btnPrev.addEventListener('click', () => {
                    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
                    updateSlider();
                });
            }
        }

        // Inisialisasi kedua carousel
        initCarousel('slide-berita', 'nextBerita', 'prevBerita');
        initCarousel('slide-info', 'nextInfo', 'prevInfo');
    });
</script>