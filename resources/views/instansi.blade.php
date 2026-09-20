@extends('layouts.app')

<title>Kantor Regional BKN - Instansi</title>

@section('content')
    <!-- KONTEN UTAMA: DAFTAR INSTANSI MITRA -->
    <section class="border-2 border-black bg-white p-4 md:p-6 flex flex-col min-h-[520px] shadow-sm">
        
        <!-- Header Kotak: Judul + Search Realtime & Sort Dropdown -->
        <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b-2 border-black relative">
            <h2 class="text-base md:text-lg font-bold text-gray-900">
                Daftar Instansi
            </h2>

            <!-- Kontrol Filter & Search Realtime -->
            <div class="flex items-center space-x-2">
                <!-- Search Input Box (Realtime JS Search) -->
                <div class="flex items-center border-2 border-black bg-gray-100 px-2 py-1">
                    <svg class="w-4 h-4 text-gray-700 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="searchInput" placeholder="cari nama instansi" class="bg-transparent text-sm focus:outline-none w-32 sm:w-48 text-gray-900">
                </div>

                <!-- Tombol Menu Sort List -->
                <div class="relative">
                    <button id="sortDropdownBtn" class="border-2 border-black p-1.5 hover:bg-gray-100 block transition cursor-pointer" title="Urutkan Instansi">
                        <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Popover Pilihan: A - Z & Z - A -->
                    <div id="sortMenu" class="hidden absolute right-0 top-full mt-1 w-32 border-2 border-black bg-white shadow-md z-20">
                        <button onclick="sortItems('az')" class="w-full text-center py-1.5 text-xs sm:text-sm font-medium text-gray-900 border-b-2 border-black hover:bg-gray-100 block cursor-pointer">
                            A - Z
                        </button>
                        <button onclick="sortItems('za')" class="w-full text-center py-1.5 text-xs sm:text-sm font-medium text-gray-900 hover:bg-gray-100 block cursor-pointer">
                            Z - A
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container Daftar Instansi -->
        <div id="instansiList" class="mt-4 border-2 border-black p-3 md:p-4 max-h-[460px] overflow-y-auto space-y-4">
            @forelse($instansi as $item)
                <div class="instansi-item border-2 border-black bg-white p-5 flex items-center min-h-[75px] hover:bg-gray-50 transition"
                     data-name="{{ $item->nm_instansi }}">
                    <p class="font-bold text-gray-900 text-sm md:text-base">
                        {{ $item->nm_instansi }}
                    </p>
                </div>
            @empty
                <p id="emptyMsg" class="text-center text-gray-500 py-8 text-sm font-semibold">Belum ada instansi mitra terdaftar.</p>
            @endforelse
        </div>
    </section>

    <!-- LOGIKA JAVASCRIPT: SEARCH REALTIME & SORTING -->
    <script>
        const searchInput = document.getElementById('searchInput');
        const sortDropdownBtn = document.getElementById('sortDropdownBtn');
        const sortMenu = document.getElementById('sortMenu');
        const instansiList = document.getElementById('instansiList');

        // Toggle Dropdown Menu Sort
        sortDropdownBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            sortMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            if (!sortMenu.classList.contains('hidden')) {
                sortMenu.classList.add('hidden');
            }
        });

        // Fitur Pencarian Realtime (Client-Side)
        searchInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            const items = instansiList.querySelectorAll('.instansi-item');
            
            items.forEach(item => {
                const name = item.getAttribute('data-name').toLowerCase();
                if (name.includes(query)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Fitur Pengurutan Realtime (A-Z dan Z-A)
        function sortItems(type) {
            const items = Array.from(instansiList.querySelectorAll('.instansi-item'));
            
            items.sort((a, b) => {
                const nameA = a.getAttribute('data-name').toLowerCase();
                const nameB = b.getAttribute('data-name').toLowerCase();

                if (type === 'az') {
                    return nameA.localeCompare(nameB);
                } else if (type === 'za') {
                    return nameB.localeCompare(nameA);
                }
            });

            items.forEach(item => instansiList.appendChild(item));
            sortMenu.classList.add('hidden');
        }
    </script>
@endsection