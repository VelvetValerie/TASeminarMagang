<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Judul dinamis -->
    <title>{{ $informasi->judul_berita }} | Pusat Informasi CAT BKN VIII</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .konten-berita img {
            display: none !important;
        }
    </style>
</head>
<body class="bg-[#F8F9FA] min-h-screen font-sans text-gray-900 flex flex-col pt-24">

    <x-navbar />

    <main class="flex-grow w-full max-w-7xl mx-auto px-4 py-8 md:py-12">
        
        <!-- BREADCRUMB -->
        <nav class="flex text-sm text-gray-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-[#fca855] transition-colors">Beranda</a>
            <span class="mx-2">/</span>
            <!-- Rute kembali ke halaman pusat informasi -->
            <a href="{{ route('informasi.index') }}" class="hover:text-[#fca855] transition-colors">Pusat Informasi</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-medium truncate">{{ \Illuminate\Support\Str::limit($informasi->judul_berita, 40) }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <article class="lg:col-span-8 bg-white p-6 md:p-10 rounded-xl border border-gray-200 shadow-sm flex flex-col">
                <h1 class="text-2xl md:text-4xl font-bold text-gray-900 leading-snug mb-4">
                    {{ $informasi->judul_berita }}
                </h1>

                <div class="flex items-center gap-4 text-xs md:text-sm text-gray-500 pb-6 border-b border-gray-100 mb-6">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($informasi->created_at)->translatedFormat('d F Y') }}
                    </span>
                    <span>•</span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        {{ $informasi->penulis->username ?? 'Administrator' }}
                    </span>
                </div>

                @if($informasi->thumbnail)
                <figure class="mb-8 rounded-lg overflow-hidden border border-gray-100 flex flex-col">
                    <img src="{{ asset('storage/' . $informasi->thumbnail) }}" alt="{{ $informasi->judul_berita }}" class="w-full h-auto object-cover max-h-[450px]">
                    <figcaption class="text-xs text-gray-500 italic p-2 text-center bg-gray-50 border-t border-gray-200">
                        Ilustrasi: {{ $informasi->caption_thumbnail ?? '-' }}
                    </figcaption>
                </figure>
                @endif

                <div class="konten-berita space-y-5 text-gray-700 leading-relaxed text-base md:text-lg">
                    {!! $informasi->konten !!}
                </div>

                @if($informasi->lampiran_url)
                <div class="mt-8 border-t border-gray-100 pt-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#fca855]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                        Lampiran Dokumen
                    </h3>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors group">
                            <div class="flex items-center gap-4 overflow-hidden">
                                <div class="flex-shrink-0 w-10 h-10 bg-red-100 text-red-600 rounded-md flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="truncate">
                                    <p class="text-sm font-semibold text-gray-800 truncate group-hover:text-[#0a3d91] transition-colors">
                                        {{ basename($informasi->lampiran_url) }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5">Dokumen Terlampir</p>
                                </div>
                            </div>
                            <!-- Jika lampiran berupa eksternal link URL, cukup pakai href="{{ $informasi->lampiran_url }}" -->
                            <a href="{{ $informasi->lampiran_url }}" target="_blank" class="flex-shrink-0 ml-4 px-4 py-2 bg-[#0a3d91] text-white text-sm font-medium rounded-md hover:bg-blue-900 transition-colors flex items-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Buka Tautan
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-center mt-auto">
                    <!-- Rute kembali -->
                    <a href="{{ route('informasi.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-[#0a3d91] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Pusat Informasi
                    </a>
                </div>
            </article>

            <!-- SIDEBAR -->
            <aside class="lg:col-span-4 space-y-8">
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 border-b pb-3 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#fca855]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tentang Pusat Informasi
                    </h2>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Halaman ini menyajikan warta resmi, pengumuman, serta edaran kebijakan rekrutmen yang dirilis secara sah oleh Panitia Seleksi Nasional demi keterbukaan informasi publik.
                    </p>
                </div>
            </aside>
        </div>
    </main>

    <x-footer />
</body>
</html>