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
        <a href="/berita" class="text-center w-full py-2 mt-auto border-2 border-black text-sm font-bold hover:bg-gray-100 transition-colors">Lihat Semua</a>
    </div>

    <div class="md:w-[72%] aspect-video border-2 border-black relative group/news bg-black overflow-hidden" id="newsFadeContainer">
        
        <div class="news-slide absolute inset-0 transition-opacity duration-700 ease-in-out opacity-100 z-10 pointer-events-auto">
            <img src="assets/images/sample-carousel1.jpg" alt="Thumbnail" class="absolute inset-0 w-full h-full object-cover">
            
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent pointer-events-none"></div>

            <div class="absolute bottom-0 inset-x-0 p-6 flex flex-col justify-end">
                <div class="marquee-container mb-2">
                    <h3 class="text-xl md:text-2xl font-black text-white marquee-text drop-shadow-md cursor-default">
                        Persiapan Mengikuti Seleksi Kompetensi Dasar (SKD) Tahun 2026 yang Akan Dilaksanakan Secara Serentak di Seluruh Wilayah
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
                        <div class="absolute bottom-0 inset-x-0 h-10 bg-gradient-to-t from-[#0a0a0a]/90 to-transparent pointer-events-none"></div>
                    </div>
                    
                    <a href="/berita/detail" class="absolute bottom-0 right-0 z-20 py-1.5 px-4 bg-white/90 hover:bg-white text-black font-bold text-xs transition-colors shadow-lg border border-transparent hover:border-black backdrop-blur-sm translate-y-1/4">
                        Baca selengkapnya...
                    </a>
                </div>
            </div>
        </div>

        <div class="news-slide absolute inset-0 transition-opacity duration-700 ease-in-out opacity-0 z-0 pointer-events-none">
            <img src="assets/images/sample-carousel2.jpg alt="Thumbnail" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent pointer-events-none"></div>
            
            <div class="absolute bottom-0 inset-x-0 p-6 flex flex-col justify-end">
                <div class="marquee-container mb-2">
                    <h3 class="text-xl md:text-2xl font-black text-white marquee-text drop-shadow-md cursor-default">
                        Pengumuman Hasil Verifikasi Sanggah Kelulusan Administrasi Calon Aparatur Sipil Negara Tahun Anggaran 2026
                    </h3>
                </div>
                <div class="relative">
                    <div class="h-[105px] overflow-hidden text-gray-300 text-sm leading-relaxed relative z-0">
                        <p>Berdasarkan hasil verifikasi ulang dokumen yang diajukan pada masa sanggah, panitia seleksi nasional telah merilis daftar nama peserta yang berhak melanjutkan ke tahap selanjutnya. Peserta diwajibkan mencetak ulang kartu pendaftaran dan memantau jadwal seleksi secara berkala melalui portal resmi.</p>
                        <div class="absolute bottom-0 inset-x-0 h-10 bg-gradient-to-t from-[#0a0a0a]/90 to-transparent pointer-events-none"></div>
                    </div>
                    <button class="absolute bottom-0 right-0 z-20 py-1.5 px-4 bg-white/90 hover:bg-white text-black font-bold text-xs transition-colors shadow-lg border border-transparent hover:border-black backdrop-blur-sm translate-y-1/4">
                        Baca selengkapnya...
                    </button>
                </div>
            </div>
        </div>

        <button id="btnPrevFade" class="absolute left-0 top-1/2 -translate-y-1/2 w-12 h-14 bg-black/40 hover:bg-black/80 text-white flex items-center justify-center opacity-0 group-hover/news:opacity-100 transition-all duration-300 z-30 focus:outline-none backdrop-blur-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button id="btnNextFade" class="absolute right-0 top-1/2 -translate-y-1/2 w-12 h-14 bg-black/40 hover:bg-black/80 text-white flex items-center justify-center opacity-0 group-hover/news:opacity-100 transition-all duration-300 z-30 focus:outline-none backdrop-blur-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
        </button>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slides = document.querySelectorAll('.news-slide');
        const btnPrev = document.getElementById('btnPrevFade');
        const btnNext = document.getElementById('btnNextFade');
        let currentIndex = 0;

        if (slides.length === 0) return;

        const updateFadeSlider = () => {
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

        btnNext.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % slides.length;
            updateFadeSlider();
        });

        btnPrev.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            updateFadeSlider();
        });
    });
</script>