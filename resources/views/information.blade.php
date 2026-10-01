<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Informasi CAT BKN VIII</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F8F9FA] min-h-screen font-sans text-gray-900 flex flex-col pt-36">

    <x-navbar />

    <!-- MAIN CONTENT -->
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 py-8">
        
        <!-- BREADCRUMB -->
        <nav class="flex text-sm text-gray-500 mb-6">
            <a href="/" class="hover:text-[#fca855] transition-colors">Beranda</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium">Informasi</span>
        </nav>

        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6 border-b border-gray-200 pb-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">Daftar Informasi Terkini</h1>
                <p class="text-gray-500 mt-2 text-sm md:text-base">Kumpulan pembaruan, panduan, dan alur seleksi instansi secara lengkap.</p>
            </div>
            
            <div class="flex gap-2 w-full md:w-auto items-center">
                <div class="relative w-full md:w-72">
                    <input type="text" id="searchInput" placeholder="Cari informasi..." class="px-4 py-2 pr-10 w-full bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#fca855] focus:border-[#fca855] transition-all text-sm">
                    <button id="clearSearchBtn" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#fca855] hidden p-1 focus:outline-none transition-colors" title="Hapus pencarian">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <button id="searchBtn" class="px-5 py-2 bg-[#0a3d91] text-white text-sm font-medium rounded-md hover:bg-blue-900 transition-colors shadow-sm">Cari</button>
            </div>
        </div>

        <!-- CONTAINER GRID -->
        <div id="infoGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <!-- Card di-render melalui JS -->
        </div>

        <!-- PAGINATION -->
        <div class="flex justify-center items-center gap-2" id="paginationControls">
            <!-- Kontrol Paginasi di-render melalui JS -->
        </div>

    </main>

    <x-footer />

<script>
    // Data List Informasi 
    const allData = [
        {
            id: 1,
            kategori: 'Timeline Seleksi',
            tanggal: '29/09/2026',
            judul: 'Timeline & Alur Pelaksanaan Seleksi Terpadu',
            deskripsi: 'Jadwal lengkap dan rincian alur pelaksanaan seleksi mulai dari CASN, Non-ASN, Pengembangan Karir, hingga Sekolah Kedinasan tahun ini.',
            gambar: '../images/information_dummy.png',
            link: '/informasi/timeline' 
        },
        {
            id: 2,
            kategori: 'Panduan',
            tanggal: '30/09/2026',
            judul: 'Panduan Lengkap Pembuatan Akun SSCASN',
            deskripsi: 'Langkah demi langkah cara mendaftar, membuat akun, dan melengkapi data profil pada portal resmi pendaftaran CPNS dan PPPK.',
            gambar: 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
            link: '#'
        }
    ];

    let filteredData = [...allData];
    const itemsPerPage = 6;
    let currentPage = 1;

    function renderGrid(page) {
        const gridContainer = document.getElementById('infoGrid');
        
        if (filteredData.length === 0) {
            gridContainer.innerHTML = `
                <div class="col-span-full py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <p class="text-gray-500 font-medium">Maaf, informasi yang Anda cari tidak ditemukan.</p>
                </div>
            `;
            return;
        }

        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const paginatedData = filteredData.slice(startIndex, endIndex);

        gridContainer.innerHTML = paginatedData.map(item => `
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 flex flex-col">
                <img src="${item.gambar}" alt="${item.judul}" class="w-full h-48 md:h-52 object-cover">
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="font-semibold text-lg text-gray-900 leading-snug mb-3 line-clamp-2">${item.judul}</h3>
                    <div class="flex items-center gap-4 text-xs font-medium text-gray-500 mb-4">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            ${item.tanggal}
                        </span>
                        <span class="flex items-center gap-1.5 px-2 py-1 bg-orange-50 rounded text-orange-600">
                            ${item.kategori}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-6 line-clamp-3">${item.deskripsi}</p>
                    <!-- Tautan mengarah ke halaman baca informasi spesifik -->
                    <a href="${item.link}" class="mt-auto inline-block bg-[#0a3d91] text-white text-sm font-medium px-5 py-2.5 rounded-md hover:bg-blue-900 transition-colors w-max">
                        Baca Selengkapnya
                    </a>
                </div>
            </div>
        `).join('');
    }

    function renderPagination() {
        const totalPages = Math.ceil(filteredData.length / itemsPerPage);
        const paginationContainer = document.getElementById('paginationControls');
        
        if (totalPages <= 1) {
            paginationContainer.innerHTML = '';
            return;
        }

        let html = '';
        html += `<button onclick="changePage(${currentPage - 1})" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 transition-colors" ${currentPage === 1 ? 'disabled' : ''}>Prev</button>`;

        for (let i = 1; i <= totalPages; i++) {
            const isActive = i === currentPage;
            html += `<button onclick="changePage(${i})" class="w-10 py-2 border ${isActive ? 'border-[#fca855] bg-[#fca855] text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'} rounded-md text-sm font-medium shadow-sm transition-colors">${i}</button>`;
        }

        html += `<button onclick="changePage(${currentPage + 1})" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 transition-colors" ${currentPage === totalPages ? 'disabled' : ''}>Next</button>`;

        paginationContainer.innerHTML = html;
    }

    window.changePage = function(newPage) {
        const totalPages = Math.ceil(filteredData.length / itemsPerPage);
        if (newPage < 1 || newPage > totalPages) return;
        currentPage = newPage;
        renderGrid(currentPage);
        renderPagination();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    function handleSearch() {
        const query = document.getElementById('searchInput').value.toLowerCase().trim();
        
        if (query === '') {
            filteredData = [...allData];
        } else {
            filteredData = allData.filter(item => 
                item.judul.toLowerCase().includes(query) || 
                item.deskripsi.toLowerCase().includes(query) ||
                item.kategori.toLowerCase().includes(query)
            );
        }
        
        currentPage = 1; 
        renderGrid(currentPage);
        renderPagination();
    }

    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const clearSearchBtn = document.getElementById('clearSearchBtn');

    searchInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            clearSearchBtn.classList.remove('hidden'); 
        } else {
            clearSearchBtn.classList.add('hidden'); 
            handleSearch(); 
        }
    });

    clearSearchBtn.addEventListener('click', function() {
        searchInput.value = ''; 
        clearSearchBtn.classList.add('hidden'); 
        handleSearch(); 
        searchInput.focus(); 
    });

    searchBtn.addEventListener('click', handleSearch);
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            handleSearch();
        }
    });

    renderGrid(currentPage);
    renderPagination();
</script>
</body>
</html>