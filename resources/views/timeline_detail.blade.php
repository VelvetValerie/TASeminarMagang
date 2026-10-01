<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Timeline | Pusat Informasi CAT BKN VIII</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F8F9FA] min-h-screen font-sans text-gray-900 flex flex-col pt-24">

    <x-navbar />

    <!-- MAIN CONTAINER -->
    <main class="flex-grow w-full max-w-6xl mx-auto px-4 py-8 md:py-12">
        
        <!-- BREADCRUMB -->
        <nav class="flex text-sm text-gray-500 mb-6">
            <a href="/" class="hover:text-[#fca855] transition-colors">Beranda</a>
            <span class="mx-2">/</span>
            <a href="/informasi" class="hover:text-[#fca855] transition-colors">Informasi</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium">Timeline Pelaksanaan</span>
        </nav>

        <article class="bg-white p-6 md:p-12 rounded-2xl border border-gray-200 shadow-sm flex flex-col w-full">
            
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-snug mb-8 text-center">
                Timeline & Alur Pelaksanaan Seleksi Terpadu
            </h1>

            <!-- SECTION PERALIHAN JENIS TIMELINE -->
            <div class="flex flex-wrap justify-center gap-3 mb-16 pb-8 border-b border-gray-100" id="tab-container">
                <button onclick="switchTab('casn')" id="btn-casn" class="tab-btn px-6 py-3 rounded-full font-bold text-sm md:text-base transition-all duration-300 bg-orange-500 text-white shadow-lg shadow-orange-500/30 scale-105">CASN (CPNS & PPPK)</button>
                <button onclick="switchTab('nonasn')" id="btn-nonasn" class="tab-btn px-6 py-3 rounded-full font-bold text-sm md:text-base transition-all duration-300 bg-white text-gray-600 border border-gray-200 hover:bg-gray-50">Non-ASN</button>
                <button onclick="switchTab('karir')" id="btn-karir" class="tab-btn px-6 py-3 rounded-full font-bold text-sm md:text-base transition-all duration-300 bg-white text-gray-600 border border-gray-200 hover:bg-gray-50">Pengembangan Karir</button>
                <button onclick="switchTab('dikdin')" id="btn-dikdin" class="tab-btn px-6 py-3 rounded-full font-bold text-sm md:text-base transition-all duration-300 bg-white text-gray-600 border border-gray-200 hover:bg-gray-50">Sekolah Kedinasan</button>
            </div>

            <!-- TIMELINE GRAFIS (Sesuai Lampiran Kedua / Keempat - Tanpa Scrollbar Horizontal) -->
            <div class="relative w-full mb-16 px-2 md:px-10">
                <div class="absolute -bottom-6 left-10 right-10 h-1.5 bg-gray-200 rounded-full"></div>

                <div class="w-full relative py-12 flex items-center justify-between">
                    <div class="absolute top-1/2 left-8 right-8 h-1.5 bg-gradient-to-r from-orange-400 via-yellow-400 to-blue-500 -translate-y-1/2 z-0"></div>
                    
                    <div class="relative flex flex-col items-center flex-1 z-10">
                        <div class="w-10 h-10 md:w-14 md:h-14 rounded-full bg-white border-[3px] md:border-4 border-orange-500 flex items-center justify-center text-orange-500 z-20 shadow-sm">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                        </div>
                        <div class="absolute top-full mt-3 md:mt-4 font-bold text-gray-800 text-center text-[10px] md:text-xs leading-tight break-words w-20 md:w-28" id="node1-label">Pengumuman<br>Formasi</div>
                    </div>

                    <div class="relative flex flex-col items-center flex-1 z-10">
                        <div class="absolute bottom-full mb-3 md:mb-4 font-bold text-gray-800 text-center text-[10px] md:text-xs leading-tight break-words w-20 md:w-28" id="node2-label">Pembuatan<br>Akun</div>
                        <div class="w-10 h-10 md:w-14 md:h-14 rounded-full bg-white border-[3px] md:border-4 border-orange-500 flex items-center justify-center text-orange-500 z-20 shadow-sm">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    </div>

                    <div class="relative flex flex-col items-center flex-1 z-10">
                        <div class="w-10 h-10 md:w-14 md:h-14 rounded-full bg-white border-[3px] md:border-4 border-yellow-500 flex items-center justify-center text-yellow-500 z-20 shadow-sm">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <div class="absolute top-full mt-3 md:mt-4 font-bold text-gray-800 text-center text-[10px] md:text-xs leading-tight break-words w-20 md:w-28" id="node3-label">Seleksi<br>Administrasi</div>
                    </div>

                    <div class="relative flex flex-col items-center flex-1 z-10">
                        <div class="absolute bottom-full mb-3 md:mb-4 font-bold text-gray-800 text-center text-[10px] md:text-xs leading-tight break-words w-20 md:w-28" id="node4-label">SKD /<br>SK PPPK</div>
                        <div class="w-10 h-10 md:w-14 md:h-14 rounded-full bg-white border-[3px] md:border-4 border-blue-500 flex items-center justify-center text-blue-600 z-20 shadow-sm">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                    </div>

                    <div class="relative flex flex-col items-center flex-1 z-10">
                        <div class="w-10 h-10 md:w-14 md:h-14 rounded-full bg-white border-[3px] md:border-4 border-blue-500 flex items-center justify-center text-blue-600 z-20 shadow-sm">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7"/></svg>
                        </div>
                        <div class="absolute top-full mt-3 md:mt-4 font-bold text-gray-800 text-center text-[10px] md:text-xs leading-tight break-words w-20 md:w-28" id="node5-label">Seleksi<br>Bidang (SKB)</div>
                    </div>

                    <div class="relative flex flex-col items-center flex-1 z-10">
                        <div class="absolute bottom-full mb-3 md:mb-4 font-bold text-gray-800 text-center text-[10px] md:text-xs leading-tight break-words w-20 md:w-28" id="node6-label">Integrasi &<br>Pemberkasan</div>
                        <div class="w-10 h-10 md:w-14 md:h-14 rounded-full bg-white border-[3px] md:border-4 border-blue-500 flex items-center justify-center text-blue-600 z-20 shadow-sm">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BREAKDOWN TAHAPAN TIMELINE DINAMIS -->
            <div class="space-y-8" id="content-section">
                <!-- Konten disuntikkan via JS -->
            </div>

            <!-- BAGIAN ATURAN & KETENTUAN (BAWAH) -->
            <div class="mt-14 bg-red-50 border-l-4 border-red-500 p-6 md:p-8 rounded-r-xl">
                <h3 class="text-xl font-bold text-red-800 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Aturan & Tata Tertib Pelaksanaan Seleksi
                </h3>
                <ul class="space-y-3 text-red-900/90 list-disc list-inside">
                    <li>Peserta <strong>diwajibkan</strong> membawa KTP asli (atau Suket Dukcapil) dan Kartu Peserta Ujian yang dicetak berwarna.</li>
                    <li>Hadir di lokasi ujian paling lambat <strong>90 menit</strong> sebelum jadwal untuk registrasi dan pemeriksaan.</li>
                    <li>Pakaian wajib: Kemeja putih polos, bawahan bahan kain formal hitam, dan sepatu tertutup gelap.</li>
                    <li>Dilarang keras membawa peralatan elektronik dan perhiasan logam ke ruang ujian. Pelanggaran berakibat pada <strong>diskualifikasi</strong>.</li>
                </ul>
            </div>

        </article>
    </main>

    <x-footer />

    <!-- SCRIPT LOGIKA KONTEN TIMELINE -->
    <script>
        const timelineData = {
            casn: {
                title: "Rincian Tahapan CASN",
                labels: ["Pengumuman<br>Formasi", "Pembuatan<br>Akun", "Seleksi<br>Administrasi", "SKD /<br>SK PPPK", "Seleksi<br>Bidang (SKB)", "Integrasi &<br>Pemberkasan"],
                steps: [
                    { title: "Pengumuman Formasi", desc: "Kementerian, Lembaga, dan Pemerintah Daerah mengumumkan alokasi kebutuhan jabatan secara serentak." },
                    { title: "Pembuatan Akun", desc: "Pelamar diwajibkan membuat akun terpusat menggunakan NIK dan memilih satu formasi di portal SSCASN." },
                    { title: "Seleksi Administrasi", desc: "Panitia memverifikasi dokumen unggahan. Tersedia masa sanggah bagi pelamar dengan status Tidak Memenuhi Syarat." },
                    { title: "SKD / SK PPPK", desc: "Pelaksanaan ujian kompetensi dasar menggunakan fasilitas CAT BKN secara real-time." },
                    { title: "Seleksi Bidang (SKB)", desc: "Tahap lanjutan bagi peserta lolos ambang batas SKD dengan peringkat maksimal 3 kali jumlah formasi." },
                    { title: "Integrasi & Pemberkasan", desc: "Penggabungan nilai SKD dan SKB untuk pengumuman kelulusan, dilanjutkan dengan pengisian DRH." }
                ]
            },
            nonasn: {
                title: "Rincian Tahapan Non-ASN",
                labels: ["Pengumuman<br>Lowongan", "Pendaftaran &<br>Submit Data", "Seleksi<br>Berkas", "Uji<br>Kompetensi", "Wawancara<br>Akhir", "Penandatanganan<br>Kontrak"],
                steps: [
                    { title: "Pengumuman Lowongan", desc: "Instansi merilis kebutuhan tenaga Non-ASN/Honorer sesuai DPA/DIPA tahun berjalan." },
                    { title: "Pendaftaran & Submit Data", desc: "Pengumpulan berkas portofolio dan riwayat pengalaman kerja secara terpusat." },
                    { title: "Seleksi Berkas", desc: "Penilaian kesesuaian kualifikasi akademik dan relevansi pengalaman kerja calon." },
                    { title: "Uji Kompetensi", desc: "Tes tertulis atau praktik langsung sesuai dengan bidang keahlian yang dibutuhkan instansi." },
                    { title: "Wawancara Akhir", desc: "Wawancara kesesuaian kultur dan komitmen target kinerja oleh Pejabat Pembuat Komitmen." },
                    { title: "Penandatanganan Kontrak", desc: "Penetapan SK dan penandatanganan perjanjian kerja untuk masa periode tertentu." }
                ]
            },
            karir: {
                title: "Rincian Tahapan Pengembangan Karir",
                labels: ["Pemetaan<br>Potensi", "Pengusulan<br>Instansi", "Verifikasi<br>BKN", "Uji<br>Asesmen", "Penetapan<br>Hasil", "Penempatan /<br>Promosi"],
                steps: [
                    { title: "Pemetaan Potensi", desc: "Instansi melakukan penilaian kinerja rutin dan pemetaan matriks talenta ASN." },
                    { title: "Pengusulan Instansi", desc: "PPK Instansi mengusulkan nama kandidat untuk uji kompetensi perpindahan/promosi jabatan." },
                    { title: "Verifikasi BKN", desc: "Tim BKN memvalidasi kelengkapan syarat administratif dan riwayat disiplin ASN." },
                    { title: "Uji Asesmen", desc: "Pelaksanaan tes manajerial, sosial kultural, dan teknis oleh asesor bersertifikat." },
                    { title: "Penetapan Hasil", desc: "Rapat pleno penentuan kelayakan kandidat untuk direkomendasikan menduduki JPT/JA/JF." },
                    { title: "Penempatan / Promosi", desc: "Pelantikan dan pengambilan sumpah jabatan baru berdasarkan rekomendasi akhir." }
                ]
            },
            dikdin: {
                title: "Rincian Tahapan Sekolah Kedinasan",
                labels: ["Pendaftaran<br>DIKDIN", "Seleksi<br>Administrasi", "Ujian<br>SKD", "Kesehatan &<br>Kesamaptaan", "Wawancara<br>Khusus", "Pantukhir &<br>Orientasi"],
                steps: [
                    { title: "Pendaftaran DIKDIN", desc: "Registrasi online melalui portal Sistem Seleksi Sekolah Kedinasan BKN (DIKDIN)." },
                    { title: "Seleksi Administrasi", desc: "Verifikasi ijazah, rapor, dan dokumen prasyarat spesifik tiap sekolah ikatan dinas." },
                    { title: "Ujian SKD", desc: "Tes Wawasan Kebangsaan, Tes Intelegensia Umum, dan Tes Karakteristik Pribadi via CAT." },
                    { title: "Kesehatan & Kesamaptaan", desc: "Pemeriksaan medis menyeluruh dan ujian fisik/kebugaran oleh panitia instansi terkait." },
                    { title: "Wawancara Khusus", desc: "Penggalian profil psikologis, integritas, dan mental ideologi calon taruna/praja." },
                    { title: "Pantukhir & Orientasi", desc: "Sidang penentuan akhir kelulusan dan persiapan masa dasar pembinaan fisik/mental." }
                ]
            }
        };

        // Peta penghubung antara URL hash (#) dengan ID kategori tab
        const hashToTabMap = {
            '#casn': 'casn',
            '#non-asn': 'nonasn',
            '#pengembangan-karir': 'karir',
            '#sekolah-kedinasan': 'dikdin'
        };

        function switchTab(type, updateUrl = true) {
            // Update Active Buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-orange-500', 'text-white', 'shadow-lg', 'shadow-orange-500/30', 'scale-105');
                btn.classList.add('bg-white', 'text-gray-600');
            });
            const activeBtn = document.getElementById(`btn-${type}`);
            if(activeBtn) {
                activeBtn.classList.remove('bg-white', 'text-gray-600');
                activeBtn.classList.add('bg-orange-500', 'text-white', 'shadow-lg', 'shadow-orange-500/30', 'scale-105');
            }

            // Update Timeline Labels in Graphic
            const data = timelineData[type];
            for(let i=1; i<=6; i++) {
                const labelElement = document.getElementById(`node${i}-label`);
                if(labelElement) labelElement.innerHTML = data.labels[i-1];
            }

            // Update Breakdown Content
            const contentSection = document.getElementById('content-section');
            let breakdownHtml = `<h2 class="text-2xl font-bold text-gray-900 border-b-2 border-gray-100 pb-3">${data.title}</h2><div class="grid grid-cols-1 md:grid-cols-2 gap-8">`;
            
            const colorClasses = ['orange', 'orange', 'yellow', 'blue', 'blue', 'blue'];
            
            data.steps.forEach((step, index) => {
                const color = colorClasses[index];
                breakdownHtml += `
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-${color}-100 text-${color}-600 font-bold flex items-center justify-center text-lg">${index + 1}</div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">${step.title}</h3>
                            <p class="text-gray-600 leading-relaxed text-sm">${step.desc}</p>
                        </div>
                    </div>
                `;
            });
            breakdownHtml += `</div>`;
            contentSection.innerHTML = breakdownHtml;

            // Jika dipanggil dari klik tombol, perbarui URL hash tanpa reload halaman
            if (updateUrl) {
                const targetHash = Object.keys(hashToTabMap).find(key => hashToTabMap[key] === type);
                if (targetHash) {
                    history.pushState(null, null, targetHash);
                }
            }
        }

        // Fungsi pendeteksi Hash URL untuk inisialisasi awal & deteksi perubahan
        function handleHashChange() {
            const currentHash = window.location.hash;
            // Jika hash valid ada di peta, buka tab terkait. Jika tidak, default ke 'casn'.
            if (hashToTabMap[currentHash]) {
                switchTab(hashToTabMap[currentHash], false);
            } else {
                switchTab('casn', false);
            }
        }

        // Event listener memantau klik navigasi back/forward atau klik URL tag # di navbar
        window.addEventListener('hashchange', handleHashChange);

        // Eksekusi saat halaman pertama kali dimuat
        handleHashChange();
    </script>
</body>
</html>