<div class="max-w-[1400px] mx-auto w-full py-12" id="timeline-interaktif">
    <div class="text-center mb-10 md:mb-14" data-aos="fade-down">
        <h2 class="text-4xl font-bold text-gray-900 mb-3 tracking-tight">Timeline / Alur Pelaksanaan</h2>
        <p class="text-lg text-gray-600">Rangkaian Kegiatan Seleksi Terpadu BKN</p>
    </div>

    <!-- Panel Tombol Navigasi Kategori -->
    <div class="flex flex-wrap justify-center gap-3 mb-10 px-4" id="category-tabs" data-aos="fade-in" data-aos-delay="200" data-aos-anchor="#timeline-interaktif">
        <button onclick="renderTimeline('casn')" id="btn-casn" class="timeline-tab px-6 py-3 rounded-full font-bold text-sm md:text-base transition-all duration-300 bg-orange-500 text-white shadow-lg shadow-orange-500/30 scale-105">CASN (CPNS & PPPK)</button>
        <button onclick="renderTimeline('nonasn')" id="btn-nonasn" class="timeline-tab px-6 py-3 rounded-full font-bold text-sm md:text-base transition-all duration-300 bg-white text-gray-600 border border-gray-200 hover:bg-gray-50">Non-ASN</button>
        <button onclick="renderTimeline('karir')" id="btn-karir" class="timeline-tab px-6 py-3 rounded-full font-bold text-sm md:text-base transition-all duration-300 bg-white text-gray-600 border border-gray-200 hover:bg-gray-50">Pengembangan Karir</button>
        <button onclick="renderTimeline('dikdin')" id="btn-dikdin" class="timeline-tab px-6 py-3 rounded-full font-bold text-sm md:text-base transition-all duration-300 bg-white text-gray-600 border border-gray-200 hover:bg-gray-50">Sekolah Kedinasan</button>
    </div>

    <!-- Kontainer Timeline dengan Arrow Navigasi Kategori -->
    <div class="relative w-full group/slider mt-12 px-4 md:px-12" data-aos="fade-right" data-aos-delay="400" data-aos-anchor="#timeline-interaktif">
        
        <!-- Tombol Panah Kiri (Ganti Kategori Sebelumnya) -->
        <button id="btn-prev-category" class="absolute left-0 md:left-2 top-1/2 -translate-y-1/2 z-40 bg-white text-gray-800 p-3 md:p-4 rounded-full shadow-xl border border-gray-200 opacity-0 group-hover/slider:opacity-100 transition-all duration-300 hover:bg-orange-50 hover:text-orange-500 hover:scale-110 focus:outline-none -translate-x-4 group-hover/slider:translate-x-0 cursor-pointer">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <!-- Area Timeline Dasar (Ukuran ramping, md:overflow-visible agar tooltip tembus batas) -->
        <div class="bg-white rounded-3xl p-6 py-30 md:px-12 md:py-36 relative shadow-2xl border border-gray-100 overflow-x-auto md:overflow-visible custom-scrollbar flex items-center">
            
            <!-- Garis Utama Gradien -->
            <div class="absolute top-1/2 left-8 right-8 md:left-12 md:right-12 h-2 bg-gradient-to-r from-orange-400 via-yellow-400 to-blue-500 rounded-full -translate-y-1/2 z-0 min-w-[900px]"></div>
            
            <!-- Area Render Poin Timeline -->
            <div id="timeline-nodes-container" class="relative z-10 w-full flex justify-between items-center min-w-[900px] mx-auto transition-opacity duration-300">
                <!-- Poin-poin disuntikkan lewat JavaScript -->
            </div>
            
        </div>

        <button id="btn-next-category" class="absolute right-0 md:right-2 top-1/2 -translate-y-1/2 z-40 bg-white text-gray-800 p-3 md:p-4 rounded-full shadow-xl border border-gray-200 opacity-0 group-hover/slider:opacity-100 transition-all duration-300 hover:bg-blue-50 hover:text-blue-600 hover:scale-110 focus:outline-none translate-x-4 group-hover/slider:translate-x-0 cursor-pointer">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
        </button>
        
    </div>
</div>

<script>
    const svgIcons = {
        speaker: `<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>`,
        user: `<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>`,
        clipboard: `<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>`,
        computer: `<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>`,
        academic: `<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7"/></svg>`,
        badge: `<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>`,
        users: `<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>`,
        doc: `<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>`
    };

    const timelineData = {
        casn: [
            { title: "Pengumuman Formasi", desc: "Kementerian/Lembaga/Pemda mengumumkan alokasi kebutuhan jabatan.", color: "orange", icon: "speaker" },
            { title: "Pembuatan Akun", desc: "Pelamar membuat akun terpusat menggunakan NIK dan memilih formasi di SSCASN.", color: "orange", icon: "user" },
            { title: "Seleksi Administrasi", desc: "Verifikasi dokumen oleh instansi. Terdapat masa sanggah jika pelamar Tidak Memenuhi Syarat (TMS).", color: "yellow", icon: "clipboard" },
            { title: "SKD / SK PPPK", desc: "Ujian kompetensi berbasis CAT BKN. Skor langsung tampil setelah ujian (real-time).", color: "blue", icon: "computer" },
            { title: "Seleksi Bidang (SKB)", desc: "Hanya peserta lolos passing grade SKD (maksimal 3x formasi) yang ikut tes lanjutan instansi.", color: "blue", icon: "academic" },
            { title: "Integrasi & Pemberkasan", desc: "Penggabungan nilai SKD & SKB, pengumuman akhir, dan pengisian Daftar Riwayat Hidup untuk NIP.", color: "blue", icon: "badge" }
        ],
        nonasn: [
            { title: "Pra-pendaftaran", desc: "Instansi asal melakukan verifikasi masa kerja tenaga honorer dan pemetaan ke database BKN.", color: "orange", icon: "users" },
            { title: "Pendaftaran Formasi", desc: "Tenaga Non-ASN mendaftar pada formasi PPPK khusus afirmasi di instansi masing-masing.", color: "yellow", icon: "doc" },
            { title: "Seleksi Administrasi", desc: "Fokus pada validasi Surat Keputusan (SK) pengabdian dan kesesuaian latar belakang pendidikan.", color: "yellow", icon: "clipboard" },
            { title: "Seleksi Kompetensi", desc: "Ujian CAT BKN berfokus pada kompetensi teknis, manajerial, dan sosiokultural tanpa tes wawasan kebangsaan.", color: "blue", icon: "computer" },
            { title: "Pengumuman Akhir", desc: "Pemeringkatan sesama kelompok Non-ASN, dilanjutkan pengisian DRH dan penetapan NI PPPK.", color: "blue", icon: "badge" }
        ],
        karir: [
            { title: "Usulan Kolektif", desc: "ASN tidak mendaftar mandiri. Biro Kepegawaian instansi mendata pegawai yang memenuhi syarat.", color: "orange", icon: "users" },
            { title: "Verifikasi BKN", desc: "Pengecekan keabsahan Izin Belajar, riwayat kinerja, dan SK kepangkatan terakhir.", color: "yellow", icon: "clipboard" },
            { title: "Pelaksanaan Ujian", desc: "Ujian teori (CAT BKN) terkait tata kelola pemerintahan, manajemen kepegawaian, dan kebijakan publik.", color: "blue", icon: "computer" },
            { title: "Presentasi Makalah", desc: "Tahapan khusus peserta Ujian Dinas Tingkat II (untuk Golongan IV) mempresentasikan makalah di depan penguji.", color: "blue", icon: "academic" },
            { title: "Proses Kenaikan", desc: "Penerbitan Sertifikat (STLUD/UPI) sebagai dasar usulan SK Kenaikan Pangkat pegawai.", color: "blue", icon: "badge" }
        ],
        dikdin: [
            { title: "Pendaftaran Terpusat", desc: "Pendaftaran di portal Dikdin BKN. Pelamar mutlak hanya boleh memilih 1 Sekolah Kedinasan.", color: "orange", icon: "computer" },
            { title: "Seleksi Administrasi", desc: "Verifikasi ijazah/rapor dan persyaratan dokumen fisik dasar oleh panitia instansi pembina.", color: "yellow", icon: "clipboard" },
            { title: "SKD CAT BKN", desc: "Ujian dasar sistem gugur massal. Nilai harus memenuhi passing grade (Ambang Batas).", color: "blue", icon: "computer" },
            { title: "Seleksi Lanjutan", desc: "Tahap variatif oleh instansi: Tes Kebugaran (Samapta), Psikotes, TPA spesifik, dan Wawancara mental.", color: "blue", icon: "academic" },
            { title: "Pantukhir", desc: "Sidang Panitia Penentu Akhir yang menggabungkan seluruh hasil seleksi untuk kuota final.", color: "blue", icon: "badge" }
        ]
    };

    const colorConfig = {
        orange: { border: "border-orange-500", bg: "bg-orange-500", line: "bg-orange-400", text: "text-orange-500" },
        yellow: { border: "border-yellow-500", bg: "bg-yellow-500", line: "bg-yellow-400", text: "text-yellow-500" },
        blue: { border: "border-blue-500", bg: "bg-blue-600", line: "bg-blue-500", text: "text-blue-600" }
    };

    const categoryKeys = ['casn', 'nonasn', 'karir', 'dikdin'];
    let currentCategoryIndex = 0;

    function renderTimeline(category) {
        currentCategoryIndex = categoryKeys.indexOf(category);

        document.querySelectorAll('.timeline-tab').forEach(btn => {
            btn.className = "timeline-tab px-6 py-3 rounded-full font-bold text-sm md:text-base transition-all duration-300 bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 cursor-pointer";
        });
        
        const activeBtn = document.getElementById(`btn-${category}`);
        if(activeBtn) {
            activeBtn.className = "timeline-tab px-6 py-3 rounded-full font-bold text-sm md:text-base transition-all duration-300 bg-orange-500 text-white shadow-lg shadow-orange-500/30 scale-105 cursor-pointer";
        }

        const container = document.getElementById('timeline-nodes-container');
        
        // Transisi halus saat pergantian tab
        container.classList.add('opacity-0');
        
        setTimeout(() => {
            container.innerHTML = ''; 
            const data = timelineData[category];

            data.forEach((item, index) => {
                const isTop = index % 2 === 0;
                const c = colorConfig[item.color];
                
                const posClass = isTop ? "bottom-full mb-6 group-hover:-translate-y-3" : "top-full mt-6 group-hover:translate-y-3";
                const lineHtml = isTop ? `<div class="w-1 h-6 ${c.line} mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>` : `<div class="w-1 h-6 ${c.line} mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>`;

                const nodeHtml = `
                    <div class="relative flex flex-col items-center justify-center group cursor-help w-48 flex-shrink-0">
                        
                        <div class="absolute ${posClass} flex flex-col items-center transition-all duration-300 opacity-0 group-hover:opacity-100 invisible group-hover:visible z-[100] w-64 drop-shadow-2xl">
                            ${isTop ? '' : lineHtml}
                            <div class="bg-white p-4 rounded-2xl shadow-xl border-2 ${c.border} text-center">
                                <h4 class="font-bold text-gray-800 mb-1 text-sm border-b pb-1">${item.title}</h4>
                                <p class="text-xs text-gray-600 leading-relaxed">${item.desc}</p>
                            </div>
                            ${isTop ? lineHtml : ''}
                        </div>

                        <div class="w-12 h-12 rounded-full bg-white border-4 ${c.border} shadow-md flex items-center justify-center relative z-20 group-hover:scale-125 transition-transform duration-300 ${c.text}">
                            ${svgIcons[item.icon]}
                        </div>
                        
                        <div class="absolute ${isTop ? 'top-full mt-4' : 'bottom-full mb-4'} font-semibold text-gray-700 text-center w-full whitespace-nowrap text-sm">
                            ${item.title}
                        </div>
                    </div>
                `;
                
                container.innerHTML += nodeHtml;
            });
            container.classList.remove('opacity-0');
        }, 300);
    }

    document.addEventListener("DOMContentLoaded", () => {
        renderTimeline('casn');

        const btnPrev = document.getElementById('btn-prev-category');
        const btnNext = document.getElementById('btn-next-category');

        if (btnPrev && btnNext) {
            btnPrev.addEventListener('click', (e) => {
                e.preventDefault();
                currentCategoryIndex = currentCategoryIndex - 1;
                if (currentCategoryIndex < 0) {
                    currentCategoryIndex = categoryKeys.length - 1;
                }
                renderTimeline(categoryKeys[currentCategoryIndex]);
            });

            btnNext.addEventListener('click', (e) => {
                e.preventDefault();
                currentCategoryIndex = currentCategoryIndex + 1;
                if (currentCategoryIndex >= categoryKeys.length) {
                    currentCategoryIndex = 0;
                }
                renderTimeline(categoryKeys[currentCategoryIndex]);
            });
        }
    });
</script>