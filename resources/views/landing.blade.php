<x-layouts.app title="Beranda | Portal CAT BKN VIII">
    
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        .filter-dropdown-container:hover .filter-dropdown,
        .filter-dropdown-container:focus-within .filter-dropdown {
            opacity: 1; visibility: visible;
        }
    </style>

    <!-- SECTION CAROUSEL FULL WIDTH (NAVBAR TRANSPARAN DI ATASNYA) -->
    <section id="carousel" class="relative w-full overflow-hidden group mb-16 h-[480px] md:h-[720px] bg-gray-900">
        <div id="carouselSlider" class="flex w-full h-full absolute inset-0 transition-all duration-1000 ease-in-out opacity-0" style="transform: translateX(-100%);">
            
            <!-- [CLONE] Slide 3 -->
            <div class="slide-item w-full h-full flex-shrink-0 relative overflow-hidden bg-gray-800">
                <img src="/images/samplegambar3.jpg" alt="Slide 3" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/20"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 z-10 pt-20">
                    <h2 class="font-bold text-white text-3xl md:text-5xl drop-shadow-lg">Headline Berita Utama 3</h2>
                </div>
            </div>

            <!-- [REAL] Slide 1: HERO UTAMA (Judul Laman) -->
            <div class="slide-item w-full h-full flex-shrink-0 relative overflow-hidden bg-gray-900">
                <img src="/images/samplegambar1.jpg" alt="Slide 1" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/30"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 z-10 pt-20">
                    <h1 class="text-4xl md:text-6xl font-black text-white mb-3 tracking-tight drop-shadow-md">Portal Informasi Karir</h1>
                    <p class="text-lg md:text-2xl text-gray-200 font-medium max-w-2xl drop-shadow">Sistem Informasi Seleksi Terpadu</p>
                </div>
            </div>

            <!-- [REAL] Slide 2 -->
            <div class="slide-item w-full h-full flex-shrink-0 relative overflow-hidden bg-gray-800">
                <img src="/images/samplegambar2.jpg" alt="Slide 2" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/20"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 z-10 pt-20">
                    <h2 class="font-bold text-white text-3xl md:text-5xl drop-shadow-lg">Headline Utama 2</h2>
                </div>
            </div>

            <!-- [REAL] Slide 3 -->
            <div class="slide-item w-full h-full flex-shrink-0 relative overflow-hidden bg-gray-800">
                <img src="/images/samplegambar3.jpg" alt="Slide 3" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-black/20"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 z-10 pt-20">
                    <h2 class="font-bold text-white text-3xl md:text-5xl drop-shadow-lg">Headline Utama 3</h2>
                </div>
            </div>

            <!-- [CLONE] Slide 1 -->
            <div class="slide-item w-full h-full flex-shrink-0 relative overflow-hidden bg-gray-900">
                <img src="/images/samplegambar1.jpg" alt="Slide 1" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/30"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-6 z-10 pt-20">
                    <h1 class="text-4xl md:text-6xl font-black text-white mb-3 tracking-tight drop-shadow-md">Portal Informasi Karir</h1>
                    <p class="text-lg md:text-2xl text-gray-200 font-medium max-w-2xl drop-shadow">Sistem Informasi Seleksi Terpadu</p>
                </div>
            </div>

        </div>

        <!-- Tombol Navigasi Carousel -->
        <button id="btnPrev" class="absolute left-0 top-0 bottom-0 w-[10%] bg-gradient-to-r from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-white cursor-pointer z-20 outline-none border-none">
            <svg class="w-10 h-10 md:w-14 md:h-14 drop-shadow-md" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button id="btnNext" class="absolute right-0 top-0 bottom-0 w-[10%] bg-gradient-to-l from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center text-white cursor-pointer z-20 outline-none border-none">
            <svg class="w-10 h-10 md:w-14 md:h-14 drop-shadow-md" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
        </button>

        <!-- Indicator Dots Slide -->
        <div class="absolute bottom-6 left-0 right-0 flex justify-center gap-3 z-30" id="carouselDots">
            <button class="dot w-3.5 h-3.5 md:w-4 md:h-4 rounded-full border-2 border-white bg-white transition-all transform scale-125 shadow-md" onclick="goToSlide(1)"></button>
            <button class="dot w-3.5 h-3.5 md:w-4 md:h-4 rounded-full border-2 border-white bg-white/50 hover:bg-white transition-all shadow-md" onclick="goToSlide(2)"></button>
            <button class="dot w-3.5 h-3.5 md:w-4 md:h-4 rounded-full border-2 border-white bg-white/50 hover:bg-white transition-all shadow-md" onclick="goToSlide(3)"></button>
        </div>
    </section>

    <!-- SECTION AGENDA & KALENDER -->
    <section class="mb-16 w-[calc(100%-2rem)] max-w-[1400px] mx-auto scroll-mt-28" id="kalender" data-aos="unfold-paper">
        <h2 class="text-3xl font-bold text-gray-900 mb-6 pb-2 text-center">Kalender Umum</h2>
        <x-kalender />
    </section>

    <!-- SECTION PUSAT INFORMASI -->
    <section class="mb-16 w-[calc(100%-2rem)] max-w-[1400px] mx-auto scroll-mt-28" id="publikasi">
        <h2 class="text-3xl font-bold text-gray-900 mb-6 pb-2 text-center" data-aos="fade-down" data-aos-anchor="#publikasi">Pusat Informasi</h2>
        <x-publikasi />
    </section>

    <!-- SECTION TIMELINE -->
    <section class="mb-16 w-[calc(100%-2rem)] max-w-[1400px] mx-auto scroll-mt-20" id="timeline">
        <x-timeline />
    </section>

    <!-- SECTION KONTAK -->
    <section class="mb-16 w-[calc(100%-2rem)] max-w-[1400px] mx-auto scroll-mt-28" id="kontak">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 pb-2 text-center" data-aos="fade-up" data-aos-anchor="#kontak">Hubungi Kami</h2>
        
        <div class="flex flex-wrap justify-center gap-6">
            <div data-aos="fade-up" data-aos-delay="100" data-aos-anchor="#kontak" class="bg-white flex-1 min-w-[200px] h-56 flex flex-col items-center justify-center text-center p-6 hover:-translate-y-2 transition-all duration-300 rounded-3xl shadow-xl border border-gray-100">
                <svg class="w-12 h-12 mb-4 text-orange-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"></path></svg>
                <h3 class="text-xl font-bold mb-2">Alamat</h3>
                <p class="text-sm text-gray-600">Jl. Hasan Basri No. 1<br>Banjarbaru, Kalimantan Selatan</p>
            </div>
            
            <div data-aos="fade-up" data-aos-delay="200" data-aos-anchor="#kontak" class="bg-white flex-1 min-w-[200px] h-56 flex flex-col items-center justify-center text-center p-6 hover:-translate-y-2 transition-all duration-300 rounded-3xl shadow-xl border border-gray-100">
                <svg class="w-12 h-12 mb-4 text-yellow-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
                <h3 class="text-xl font-bold mb-2">Email</h3>
                <p class="text-sm text-gray-600">bantuan@instansi.go.id<br>info@instansi.go.id</p>
            </div>
            
            <div data-aos="fade-up" data-aos-delay="300" data-aos-anchor="#kontak" class="bg-white flex-1 min-w-[200px] h-56 flex flex-col items-center justify-center text-center p-6 hover:-translate-y-2 transition-all duration-300 rounded-3xl shadow-xl border border-gray-100">
                <svg class="w-12 h-12 mb-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.896-1.596-5.48-4.18-7.077-7.077l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"></path></svg>
                <h3 class="text-xl font-bold mb-2">Telepon</h3>
                <p class="text-sm text-gray-600">(0511) 1234-5678<br>0812-3456-7890</p>
            </div>
            
            <div data-aos="fade-up" data-aos-delay="400" data-aos-anchor="#kontak" class="bg-white flex-1 min-w-[200px] h-56 flex flex-col items-center justify-center text-center p-6 hover:-translate-y-2 transition-all duration-300 rounded-3xl shadow-xl border border-gray-100">
                <svg class="w-12 h-12 mb-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"></path></svg>
                <h3 class="text-xl font-bold mb-2">Konsultasi</h3>
                <p class="text-sm text-gray-600">Senin - Jumat<br>08:00 - 15:00 WITA</p>
            </div>
            
        </div>
    </section>

    <!-- SCRIPT CAROUSEL & SCROLL NAVBAR -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // TRANSISI NAVBAR TRANSPARAN KE SOLID & PEMUTARAN WARNA GARIS BAWAH / LOGO
            const navbar = document.getElementById('main-navbar');
            const carouselSection = document.getElementById('carousel');

            if (navbar && carouselSection) {
                const logoContainer = document.getElementById('logo-container');
                const navLinks = document.querySelectorAll('.nav-link');

                // 1. MATIKAN TRANSISI SEMENTARA SAAT LOAD
                // Agar perubahan dari solid bawaan ke transparan terjadi seketika tanpa dianimasikan
                navbar.style.transition = 'none';
                if (logoContainer) logoContainer.style.transition = 'none';
                
                const handleNavbarScroll = () => {
                    const carouselHeight = carouselSection.offsetHeight - 80;

                    if (window.scrollY < carouselHeight) {
                        // State: Transparan
                        navbar.classList.remove('bg-[#fca855]/80', 'shadow-md', 'py-2');
                        navbar.classList.add('bg-transparent', 'py-4');

                        if (logoContainer) {
                            logoContainer.classList.add('md:w-20', 'md:h-20');
                            logoContainer.classList.remove('md:w-16', 'md:h-16');
                        }

                        navLinks.forEach(link => {
                            link.classList.remove('after:bg-white');
                            link.classList.add('after:bg-orange-500');
                        });
                    } else {
                        // State: Solid
                        navbar.classList.add('bg-[#fca855]/80', 'shadow-md', 'py-2');
                        navbar.classList.remove('bg-transparent', 'py-4');

                        if (logoContainer) {
                            logoContainer.classList.remove('md:w-20', 'md:h-20');
                            logoContainer.classList.add('md:w-16', 'md:h-16');
                        }

                        navLinks.forEach(link => {
                            link.classList.remove('after:bg-orange-500');
                            link.classList.add('after:bg-white');
                        });
                    }
                };

                // 2. Eksekusi state awal (Instan, tanpa animasi)
                handleNavbarScroll();

                // 3. NYALAKAN KEMBALI TRANSISI
                // Menggunakan requestAnimationFrame ganda untuk memastikan browser 
                // sudah selesai menggambar state awal sebelum animasi diaktifkan ulang
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        navbar.style.transition = '';
                        if (logoContainer) logoContainer.style.transition = '';
                    });
                });

                // 4. Pasang ke listener scroll agar saat user mulai scroll, animasinya mulus
                window.addEventListener('scroll', handleNavbarScroll);
            }

            // CAROUSEL
            let currentSlide = 1;
            let isTransitioning = false;
            const totalRealSlides = 3;
            const slider = document.getElementById('carouselSlider');
            const dots = document.querySelectorAll('.dot');
            let autoPlayInterval;
            
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

            // Kunci posisi awal seketika tanpa transisi
            disableTransitions();
            setTransform(currentSlide);
            updateVisuals(currentSlide);
            void slider.offsetWidth; // Memicu reflow browser
            
            // MUNCULKAN CAROUSEL (FADE-IN)
            // Setelah posisi terkunci di Slide 1, ubah opasitas agar memudar masuk
            setTimeout(() => {
                slider.classList.remove('opacity-0');
                slider.classList.add('opacity-100');
                enableTransitions(); // Kembalikan transisi untuk efek geser selanjutnya
            }, 50);
            startInterval();
        });
    </script>
</x-layouts.app>