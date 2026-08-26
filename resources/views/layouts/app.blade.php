<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'BKN System') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        summary::-webkit-details-marker {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-200 text-gray-900 font-sans min-h-screen flex">

    <!-- SIDEBAR GLOBAL -->
    <aside class="w-64 bg-[#e5e7eb] border-r-2 border-black flex flex-col p-4 shrink-0 min-h-screen">
        <div class="space-y-4">
            <!-- Header Sidebar -->
            <div class="border-2 border-black bg-white p-2.5 text-center font-bold text-gray-900">
                Kantor Regional BKN
            </div>

            <!-- Navigasi Menu Global -->
            <nav class="space-y-3">
                <!-- Grup 1: Menu Utama -->
                <div class="space-y-2">
                    <a href="{{ url('/dashboard') }}" 
                       class="block border-2 border-black py-2 px-4 text-center font-semibold transition {{ request()->is('dashboard') ? 'bg-gray-500 text-white' : 'bg-white text-gray-900 hover:bg-gray-100' }}">
                        Dashboard
                    </a>
                    <a href="{{ url('/kalender') }}" 
                       class="block border-2 border-black py-2 px-4 text-center font-semibold transition {{ request()->is('kalender') ? 'bg-gray-500 text-white' : 'bg-white text-gray-900 hover:bg-gray-100' }}">
                        Kalender
                    </a>
                </div>

                <!-- Grup 2: Operasional -->
                <div class="space-y-2 pt-1">
                    <a href="#" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                        Kegiatan
                    </a>
                    <a href="#" class="block border-2 border-black bg-white text-gray-900 font-semibold py-2 px-4 text-center hover:bg-gray-100 transition">
                        Riwayat Kerja
                    </a>
                </div>

                <!-- DROPDOWN 1: MANAJEMEN DATA KEGIATAN -->
                <div class="pt-1">
                    <details class="group border-2 border-black bg-white" {{ request()->is('riwayat-kegiatan*') || request()->is('jenis-kegiatan*') || request()->is('titik-lokasi*') || request()->is('instansi*') ? 'open' : '' }}>
                        <summary class="list-none py-2 px-3 bg-white-300 font-semibold text-gray-900 flex items-center justify-between text-xs sm:text-sm cursor-pointer hover:bg-gray-400 transition">
                            <span class="leading-tight text-center w-full">Manajemen<br>Data Kegiatan</span>
                            <svg class="w-4 h-4 transition-transform duration-200 group-open:rotate-180 shrink-0 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        
                        <!-- Submenu Manajemen Data Kegiatan Sesuai Gambar -->
                        <div class="border-t-2 border-black bg-white">
                            <a href="{{ url('/jenis-kegiatan') }}" 
                            class="block py-2 px-4 text-center text-sm font-medium border-b-2 border-black transition {{ request()->is('jenis-kegiatan*') ? 'bg-gray-400 text-gray-900 font-semibold' : 'text-gray-800 hover:bg-gray-100' }}">
                                Jenis Kegiatan
                            </a>
                            <a href="{{ url('/titik-lokasi') }}" class="block py-2 px-4 text-center text-sm font-medium border-b-2 border-black transition {{ request()->is('titik-lokasi*') ? 'bg-gray-400 text-gray-900 font-semibold' : 'text-gray-800 hover:bg-gray-100' }}">
                                            Titik Lokasi
                            </a>
                            <a href="{{ url('/instansi') }}" class="block py-2 px-4 text-center text-sm font-medium border-b-2 border-black transition {{ request()->is('instansi*') ? 'bg-gray-400 text-gray-900 font-semibold' : 'text-gray-800 hover:bg-gray-100' }}">
                                            Instansi
                            </a>
                            <a href="{{ url('/riwayat-kegiatan') }}" 
                               class="block py-2 px-4 text-center text-sm font-semibold transition {{ request()->is('riwayat-kegiatan') ? 'bg-gray-400 text-gray-900' : 'text-gray-800 hover:bg-gray-100' }}">
                                Riwayat Kegiatan
                            </a>
                        </div>
                    </details>
                </div>

                <!-- DROPDOWN 2: MANAJEMEN DATA MASTER -->
                <div class="pt-1">
                    <details class="group border-2 border-black bg-white" {{ request()->is('master-*') ? 'open' : '' }}>
                        <summary class="list-none py-2 px-3 bg-white-300 font-semibold text-gray-900 flex items-center justify-between text-xs sm:text-sm cursor-pointer hover:bg-gray-400 transition">
                            <span class="leading-tight text-center w-full">Manajemen<br>Data Master</span>
                            <svg class="w-4 h-4 transition-transform duration-200 group-open:rotate-180 shrink-0 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        
                        <!-- Submenu Manajemen Data Master Sesuai Gambar -->
                        <div class="border-t-2 border-black bg-white">
                            <a href="#" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 border-b-2 border-black hover:bg-gray-100 transition">
                                User
                            </a>
                            <a href="#" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 border-b-2 border-black hover:bg-gray-100 transition">
                                Kegiatan
                            </a>
                            <a href="#" class="block py-2 px-4 text-center text-sm font-medium text-gray-800 hover:bg-gray-100 transition">
                                Lokasi
                            </a>
                        </div>
                    </details>
                </div>

            </nav>
        </div>
    </aside>

    <!-- AREA KONTEN UTAMA -->
    <div class="flex-1 flex flex-col min-w-0 bg-[#f3f4f6]">
        <!-- Top Navbar -->
        <header class="h-16 bg-[#f3f4f6] border-b-2 border-black flex items-center justify-between px-6">
            <div class="border-2 border-black bg-white px-6 py-1.5 font-bold text-gray-900">
                Dashboard User
            </div>
            <div class="border-2 border-black bg-white px-8 py-1.5 font-semibold text-gray-900">
                Username
            </div>
        </header>

        <!-- Konten Halaman -->
        <main class="flex-1 p-6 overflow-y-auto space-y-6">
            @yield('content')
        </main>
    </div>

</body>
</html>