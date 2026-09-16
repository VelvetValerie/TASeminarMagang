<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Informasi | Portal BKN Kanreg VIII</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col pt-24">

    <!-- Include Navbar -->
    @include('components.navbar') {{-- Atau sesuaikan include navbar Anda --}}

    <main class="flex-grow w-full max-w-7xl mx-auto px-4 py-8 md:py-12">
        
        <!-- HEADER & PENCARIAN NEO-BRUTALIST -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4 border-b-2 border-black pb-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-black text-gray-900 uppercase tracking-tight">Pusat Informasi Terkini</h1>
                <p class="text-gray-700 mt-1 text-sm sm:text-base font-medium">Pengumuman resmi, edaran, dan warta kepegawaian BKN Kanreg VIII.</p>
            </div>
            
            <div class="flex gap-2 w-full md:w-auto">
                <input type="text" id="searchInput" placeholder="Cari informasi..." class="px-3 py-2 w-full md:w-72 bg-white border-2 border-black font-semibold text-sm focus:outline-none focus:bg-gray-50">
                <button onclick="filterSearch()" class="px-5 py-2 bg-slate-900 text-white font-bold text-sm border-2 border-black hover:bg-slate-800 transition cursor-pointer">Cari</button>
            </div>
        </div>

        <!-- CONTAINER GRID PUBLIC -->
        <div id="infoGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <!-- Card di-render melalui JS -->
        </div>

        <!-- PAGINATION NEO-BRUTALIST -->
        <div class="flex justify-center items-center gap-2" id="paginationControls"></div>
    </main>

    <script>
        const allData = Array.from({ length: 11 }, (_, i) => ({
            id: i + 1,
            kategori: i % 3 === 0 ? 'Berita' : (i % 2 === 0 ? 'Edaran' : 'Pengumuman'),
            tanggal: `${14 - (i%5)}/09/2026`,
            judul: `Informasi Penting Bagian ke-${i + 1} Terkait Kebijakan ASN 2026`,
            deskripsi: 'BKN Kanreg VIII merilis pedoman resmi terkait tata cara pelaksanaan dan verifikasi berkas kepegawaian...',
            gambar: 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' 
        }));

        const itemsPerPage = 9;
        let currentPage = 1;

        function renderGrid(page) {
            const startIndex = (page - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const paginatedData = allData.slice(startIndex, endIndex);

            const gridContainer = document.getElementById('infoGrid');
            gridContainer.innerHTML = paginatedData.map(item => `
                <div class="bg-white border-2 border-black p-4 flex flex-col justify-between shadow-xs hover:shadow-md transition">
                    <div>
                        <div class="border-2 border-black mb-3 overflow-hidden h-48">
                            <img src="${item.gambar}" alt="Gambar Berita" class="w-full h-full object-cover">
                        </div>
                        <div class="flex items-center justify-between text-xs font-bold border-b-2 border-black pb-2 mb-2">
                            <span class="bg-gray-200 border border-black px-2 py-0.5 text-gray-900 uppercase">${item.kategori}</span>
                            <span class="text-gray-600">${item.tanggal}</span>
                        </div>
                        <h3 class="font-bold text-base text-gray-900 leading-snug mb-2 line-clamp-2">${item.judul}</h3>
                        <p class="text-xs text-gray-700 font-medium mb-4 line-clamp-3">${item.deskripsi}</p>
                    </div>
                    <a href="{{ url('/berita/detail') }}" class="block text-center border-2 border-black bg-sky-600 hover:bg-sky-700 text-white font-bold py-2 text-xs uppercase transition">
                        Baca Selengkapnya
                    </a>
                </div>
            `).join('');
        }

        function renderPagination() {
            const totalPages = Math.ceil(allData.length / itemsPerPage);
            const paginationContainer = document.getElementById('paginationControls');
            let html = '';

            html += `<button onclick="changePage(${currentPage - 1})" class="border-2 border-black px-3 py-1 bg-white font-bold text-xs uppercase hover:bg-gray-100 ${currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'}" ${currentPage === 1 ? 'disabled' : ''}>Prev</button>`;

            for (let i = 1; i <= totalPages; i++) {
                const isActive = i === currentPage;
                html += `<button onclick="changePage(${i})" class="border-2 border-black w-8 py-1 ${isActive ? 'bg-black text-white' : 'bg-white text-gray-900 hover:bg-gray-100'} font-bold text-xs cursor-pointer">${i}</button>`;
            }

            html += `<button onclick="changePage(${currentPage + 1})" class="border-2 border-black px-3 py-1 bg-white font-bold text-xs uppercase hover:bg-gray-100 ${currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'}" ${currentPage === totalPages ? 'disabled' : ''}>Next</button>`;

            paginationContainer.innerHTML = html;
        }

        window.changePage = function(newPage) {
            const totalPages = Math.ceil(allData.length / itemsPerPage);
            if (newPage < 1 || newPage > totalPages) return;
            currentPage = newPage;
            renderGrid(currentPage);
            renderPagination();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };

        renderGrid(currentPage);
        renderPagination();
    </script>
</body>
</html>