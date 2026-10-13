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

    <main class="flex-grow w-full max-w-7xl mx-auto px-4 py-8 md:py-12">
        <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6 border-b border-gray-200 pb-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 tracking-tight">Pusat Informasi Terkini</h1>
                <p class="text-gray-500 mt-2 text-sm md:text-base">Temukan pengumuman, berita, dan edaran terbaru dari instansi.</p>
            </div>
            
            <!-- FORM PENCARIAN LARAVEL -->
            <form action="{{ route('berita.index') }}" method="GET" class="flex gap-2 w-full md:w-auto items-center">
                <div class="relative w-full md:w-72">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari informasi..." class="px-4 py-2 pr-10 w-full bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#fca855] focus:border-[#fca855] transition-all text-sm">
                </div>
                <button type="submit" class="px-5 py-2 bg-[#0a3d91] text-white text-sm font-medium rounded-md hover:bg-blue-900 transition-colors shadow-sm">Cari</button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($berita as $item)
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 flex flex-col">
                    <!-- Gunakan thumbnail default jika tidak ada gambar -->
                    <img src="{{ $item->thumbnail ?? 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" alt="Ilustrasi" class="w-full h-48 md:h-52 object-cover">
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="font-semibold text-lg text-gray-900 leading-snug mb-3 line-clamp-2">{{ $item->judul_berita }}</h3>
                        <div class="flex items-center gap-4 text-xs font-medium text-gray-500 mb-4">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                        <!-- Strip tags untuk mengambil teks murni dari Editor WYSIWYG -->
                        <p class="text-sm text-gray-600 mb-6 line-clamp-3">{{ Str::limit(strip_tags($item->konten), 120) }}</p>
                        <a href="{{ route('berita.show', $item->slug) }}" class="mt-auto inline-block bg-[#0a3d91] text-white text-sm font-medium px-5 py-2.5 rounded-md hover:bg-blue-900 transition-colors w-max">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center">
                    <p class="text-gray-500 font-medium">Maaf, informasi yang Anda cari tidak ditemukan atau belum ada publikasi.</p>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION LARAVEL -->
        <div class="mt-8">
            {{ $berita->links() }} 
        </div>
    </main>

    <x-footer />
</body>
</html>