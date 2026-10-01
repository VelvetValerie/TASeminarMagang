<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Informasi CAT BKN VIII</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F8F9FA] min-h-screen font-sans text-gray-900 flex flex-col pt-24">

    <x-navbar />

    <!-- MAIN CONTENT -->
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 py-8 md:py-12">
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6 border-b border-gray-200 pb-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">Pusat Informasi Terkini</h1>
                <p class="text-gray-500 mt-2 text-sm md:text-base">Temukan pengumuman, berita, dan edaran terbaru dari instansi.</p>
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
    // Data Dummy
    const allData = Array.from({ length: 11 }, (_, i) => ({
        id: i + 1,
        kategori: i % 3 === 0 ? 'Berita' : (i % 2 === 0 ? 'Edaran' : 'Pengumuman'),
        tanggal: `${14 - (i%5)}/09/2026`,
        judul: `Informasi Penting dan Terkini Bagian ke-${i + 1} Terkait Kebijakan ASN 2026`,
        deskripsi: 'Kupang – Humas BKN, Dalam arahannya memimpin Apel Kekuatan Gabungan Pemerintah Kota Kupang di Lapangan Upacara Kantor Wali...',
        gambar: 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' 
    }));

    let filteredData = [...allData];
    const itemsPerPage = 9;
    let currentPage = 1;

    // Fungsi Render Grid
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
                <img src="${item.gambar}" alt="Ilustrasi" class="w-full h-48 md:h-52 object-cover">
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="font-semibold text-lg text-gray-900 leading-snug mb-3 line-clamp-2">${item.judul}</h3>
                    <div class="flex items-center gap-4 text-xs font-medium text-gray-500 mb-4">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            ${item.tanggal}
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                            ${item.kategori}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-6 line-clamp-3">${item.deskripsi}</p>
                    <a href="/berita/detail" class="mt-auto inline-block bg-[#0a3d91] text-white text-sm font-medium px-5 py-2.5 rounded-md hover:bg-blue-900 transition-colors w-max">
                        Baca Selengkapnya
                    </a>
                </div>
            </div>
        `).join('');
    }

    // Fungsi Render Paginasi
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

    // Fungsi Ganti Halaman
    window.changePage = function(newPage) {
        const totalPages = Math.ceil(filteredData.length / itemsPerPage);
        if (newPage < 1 || newPage > totalPages) return;
        currentPage = newPage;
        renderGrid(currentPage);
        renderPagination();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    // Fungsi Logika Pencarian
    function handleSearch() {
        const query = document.getElementById('searchInput').value.toLowerCase().trim();
        
        // Jika kolom pencarian kosong, kembalikan ke data awal
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

    // Deklarasi Elemen
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const clearSearchBtn = document.getElementById('clearSearchBtn');

    // Event Listener: Saat pengguna mengetik di kolom pencarian
    searchInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            clearSearchBtn.classList.remove('hidden'); // Munculkan tombol X
        } else {
            clearSearchBtn.classList.add('hidden'); // Sembunyikan tombol X
            handleSearch(); // Reset data otomatis saat kolom kosong
        }
    });

    // Event Listener: Saat tombol X diklik
    clearSearchBtn.addEventListener('click', function() {
        searchInput.value = ''; // Kosongkan input
        clearSearchBtn.classList.add('hidden'); // Sembunyikan tombol X
        handleSearch(); // Reset data
        searchInput.focus(); // Kembalikan fokus kursor ke kolom input
    });

    // Event Listener: Tombol Cari diklik
    searchBtn.addEventListener('click', handleSearch);

    // Event Listener: Tombol Enter ditekan
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            handleSearch();
        }
    });

    // Inisialisasi awal saat halaman dimuat
    renderGrid(currentPage);
    renderPagination();
</script>
</body>
</html>