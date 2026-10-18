<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Judul dinamis -->
    <title>{{ $informasi->judul_berita }} | Pusat Informasi CAT BKN VIII</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Styling eksplisit untuk elemen WYSIWYG / HTML Konten */
        .konten-informasi h2 { font-size: 1.75rem !important; font-weight: 700 !important; margin-top: 1.5rem !important; margin-bottom: 0.75rem !important; color: #1f2937 !important; line-height: 1.3 !important; display: block !important; }
        .konten-informasi h3 { font-size: 1.375rem !important; font-weight: 700 !important; margin-top: 1.25rem !important; margin-bottom: 0.5rem !important; color: #374151 !important; line-height: 1.35 !important; display: block !important; }
        .konten-informasi h4 { font-size: 1.125rem !important; font-weight: 600 !important; margin-top: 1rem !important; margin-bottom: 0.5rem !important; color: #4b5563 !important; line-height: 1.4 !important; display: block !important; }
        .konten-informasi h5 { font-size: 1rem !important; font-weight: 600 !important; margin-top: 0.75rem !important; margin-bottom: 0.25rem !important; color: #4b5563 !important; display: block !important; }
        .konten-informasi h6 { font-size: 0.875rem !important; font-weight: 600 !important; margin-top: 0.75rem !important; margin-bottom: 0.25rem !important; color: #6b7280 !important; display: block !important; }
        .konten-informasi blockquote { border-left: 4px solid #3b82f6 !important; padding-left: 1rem !important; font-style: italic !important; color: #4b5563 !important; margin: 1.25rem 0 !important; display: block !important; }
        .konten-informasi ul { list-style-type: disc !important; padding-left: 1.5rem !important; margin: 0.75rem 0 !important; display: block !important; }
        .konten-informasi ol { list-style-type: decimal !important; padding-left: 1.5rem !important; margin: 0.75rem 0 !important; display: block !important; }
        .konten-informasi li { margin-bottom: 0.35rem !important; display: list-item !important; }
        .konten-informasi img { max-width: 100% !important; height: auto !important; border-radius: 0.5rem !important; margin: 1.5rem auto !important; display: block !important; border: 1px solid #e5e7eb !important; shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important; }
        .konten-informasi p { margin-bottom: 1rem !important; font-size: 1.05rem !important; line-height: 1.7 !important; color: #374151 !important; }
    </style>
</head>
<body class="bg-[#F8F9FA] min-h-screen font-sans text-gray-900 flex flex-col pt-24">

    <x-navbar />

    <main class="flex-grow w-full max-w-7xl mx-auto px-4 py-8 md:py-12">
        
        <!-- BREADCRUMB -->
        <nav class="flex text-sm text-gray-500 mb-6 overflow-hidden">
            <a href="{{ url('/') }}" class="hover:text-[#fca855] transition-colors shrink-0">Beranda</a>
            <span class="mx-2 shrink-0">/</span>
            <a href="{{ route('informasi.index') }}" class="hover:text-[#fca855] transition-colors shrink-0">Pusat Informasi</a>
            <span class="mx-2 shrink-0">/</span>
            <span class="text-gray-800 font-medium truncate">{{ \Illuminate\Support\Str::limit($informasi->judul_berita, 40) }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- KONTEN UTAMA (KIRI) -->
            <article class="lg:col-span-8 bg-white p-6 md:p-10 rounded-xl border border-gray-200 shadow-sm flex flex-col">
                
                <div class="mb-4">
                    <span class="inline-block px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-full border border-blue-100">
                        Informasi Resmi
                    </span>
                </div>

                <h1 class="text-2xl md:text-4xl font-bold text-gray-900 leading-snug mb-4">
                    {{ $informasi->judul_berita }}
                </h1>

                <!-- Meta Informasi -->
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

                <!-- THUMBNAIL UTAMA -->
                @if($informasi->thumbnail)
                <figure class="mb-8 rounded-lg overflow-hidden border border-gray-200 relative aspect-video bg-gray-50 flex items-center justify-center">
                    <img src="{{ asset('storage/' . $informasi->thumbnail) }}" alt="{{ $informasi->judul_berita }}" class="relative z-10 max-h-full max-w-full object-contain">
                    @if($informasi->caption_thumbnail)
                        <figcaption class="absolute bottom-0 inset-x-0 z-20 text-xs text-gray-700 italic p-2 text-center bg-gray-100/90 border-t border-gray-200">
                            {{ $informasi->caption_thumbnail }}
                        </figcaption>
                    @endif
                </figure>
                @endif

                <!-- ISI KONTEN WYSIWYG -->
                <div class="konten-informasi text-gray-700 leading-relaxed mb-8">
                    {!! $informasi->konten !!}
                </div>

                <!-- DOKUMEN LAMPIRAN URL -->
                @if($informasi->lampiran_url)
                <div class="mt-8 border-t border-gray-100 pt-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#fca855]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                        Dokumen Lampiran Resmi
                    </h3>
                    <div class="bg-blue-50/70 border border-blue-200 rounded-lg p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="p-2.5 bg-blue-100 rounded-lg text-blue-600 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div class="truncate">
                                <h4 class="text-sm font-bold text-gray-800 truncate">{{ basename($informasi->lampiran_url) }}</h4>
                                <p class="text-xs text-gray-500 mt-0.5">Klik tombol di samping untuk membuka atau mengunduh berkas.</p>
                            </div>
                        </div>
                        <a href="{{ $informasi->lampiran_url }}" target="_blank" class="px-4 py-2 bg-[#0a3d91] hover:bg-blue-900 text-white text-xs font-semibold rounded-md flex items-center gap-1.5 transition-colors shrink-0 shadow-sm">
                            <span>Buka Lampiran</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>
                </div>
                @endif

                <!-- BAGIKAN INFORMASI -->
                <div class="mt-10 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <span class="text-sm font-bold text-gray-800">Bagikan informasi ini:</span>
                    <div class="flex gap-2">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($informasi->judul_berita . ' - ' . url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-[#25D366] text-white flex items-center justify-center hover:-translate-y-1 transition-transform shadow-sm" title="Bagikan ke WhatsApp">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-9 h-9 rounded-full bg-[#1877F2] text-white flex items-center justify-center hover:-translate-y-1 transition-transform shadow-sm" title="Bagikan ke Facebook">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($informasi->judul_berita) }}" target="_blank" class="w-9 h-9 rounded-full bg-black text-white flex items-center justify-center hover:-translate-y-1 transition-transform shadow-sm" title="Bagikan ke X">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/></svg>
                        </a>
                        <button onclick="navigator.clipboard.writeText('{{ url()->current() }}'); alert('Tautan disalin!');" class="w-9 h-9 rounded-full bg-gray-100 text-gray-700 flex items-center justify-center hover:-translate-y-1 hover:bg-gray-200 transition-all shadow-sm" title="Salin Tautan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- NAVIGASI KEMBALI -->
                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-center mt-auto">
                    <a href="{{ route('informasi.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-[#0a3d91] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Pusat Informasi
                    </a>
                </div>
            </article>

            <!-- SIDEBAR (KANAN) -->
            <aside class="lg:col-span-4 space-y-6">
                <!-- BOX 1: TENTANG PUSAT INFORMASI -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 border-b pb-3 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#fca855]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tentang Pusat Informasi
                    </h2>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Halaman ini menyajikan warta resmi, pengumuman, serta edaran kebijakan rekrutmen yang dirilis secara sah oleh Panitia Seleksi Nasional demi keterbukaan informasi publik.
                    </p>
                </div>

                <!-- BOX 2: INFORMASI TERBARU (SIDEBAR) -->
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 border-b pb-3 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#0a3d91]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        Informasi Terbaru
                    </h2>
                    
                    <div class="space-y-4">
                        @if(isset($informasiTerbaru) && count($informasiTerbaru) > 0)
                            @foreach($informasiTerbaru as $terbaru)
                            <a href="{{ route('informasi.show', $terbaru->slug) }}" class="group flex gap-3 items-start pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                                <span class="text-xs font-semibold text-[#fca855] bg-orange-50 px-2 py-1 rounded shrink-0 mt-0.5">
                                    {{ \Carbon\Carbon::parse($terbaru->created_at)->format('d M') }}
                                </span>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-800 group-hover:text-[#0a3d91] transition-colors line-clamp-2 leading-snug">
                                        {{ $terbaru->judul_berita }}
                                    </h3>
                                </div>
                            </a>
                            @endforeach
                        @else
                            <p class="text-xs text-gray-400 italic">Belum ada informasi terbaru lainnya.</p>
                        @endif
                    </div>
                </div>

            </aside>
        </div>

        <!-- SEKSI BAWAH: INFORMASI RESMI LAINNYA -->
        <section class="mt-16 pt-10 border-t border-gray-200">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Informasi Resmi Lainnya</h2>
                    <p class="text-sm text-gray-500 mt-1">Pengumuman dan edaran resmi terbaru yang mungkin relevan untuk Anda pelajari.</p>
                </div>
                <a href="{{ route('informasi.index') }}" class="text-sm font-semibold text-[#0a3d91] hover:underline hidden sm:block">Lihat Semua Informasi &rarr;</a>
            </div>

            <!-- Grid 3 Kartu -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($informasiLainnya ?? [] as $lainnya)
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 flex flex-col">
                        @if($lainnya->thumbnail)
                            <img src="{{ asset('storage/' . $lainnya->thumbnail) }}" alt="{{ $lainnya->judul_berita }}" class="w-full h-40 object-cover border-b border-gray-100">
                        @else
                            <div class="w-full h-40 bg-gray-100 border-b border-gray-100 flex items-center justify-center text-gray-400 text-xs italic">
                                Tanpa Gambar
                            </div>
                        @endif
                        
                        <div class="p-5 flex flex-col flex-grow">
                            <span class="text-xs text-gray-400 mb-2">{{ \Carbon\Carbon::parse($lainnya->created_at)->translatedFormat('d F Y') }}</span>
                            <h3 class="font-semibold text-gray-900 leading-snug mb-3 line-clamp-2 hover:text-[#0a3d91] transition-colors">
                                {{ $lainnya->judul_berita }}
                            </h3>
                            <a href="{{ route('informasi.show', $lainnya->slug) }}" class="mt-auto text-xs font-bold text-[#0a3d91] hover:underline">Baca Selengkapnya &rarr;</a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-3 text-center py-10">
                        <p class="text-gray-500 text-sm">Belum ada informasi resmi lainnya untuk saat ini.</p>
                    </div>
                @endforelse
            </div>
        </section>

    </main>

    <x-footer />

</body>
</html>