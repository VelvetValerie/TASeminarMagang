@extends('layouts.app')

@section('content')
<style>
    /* Styling khusus untuk Editor dan Preview agar konsisten */
    .content-editor-style h2 { font-size: 1.75rem !important; font-weight: 700 !important; margin: 1.35rem 0 0.5rem !important; color: #1f2937 !important; line-height: 1.3 !important; }
    .content-editor-style h3 { font-size: 1.375rem !important; font-weight: 700 !important; margin: 1.15rem 0 0.5rem !important; color: #374151 !important; line-height: 1.35 !important; }
    .content-editor-style h4 { font-size: 1.125rem !important; font-weight: 600 !important; margin: 1rem 0 0.5rem !important; color: #4b5563 !important; line-height: 1.4 !important; }
    .content-editor-style h5 { font-size: 1rem !important; font-weight: 600 !important; margin: 0.75rem 0 0.25rem !important; color: #4b5563 !important; }
    .content-editor-style h6 { font-size: 0.875rem !important; font-weight: 600 !important; margin: 0.75rem 0 0.25rem !important; color: #6b7280 !important; }
    .content-editor-style blockquote { border-left: 4px solid #3b82f6 !important; padding-left: 1rem !important; font-style: italic !important; color: #4b5563 !important; margin: 1rem 0 !important; }
    .content-editor-style ul { list-style-type: disc !important; padding-left: 1.5rem !important; margin: 0.75rem 0 !important; }
    .content-editor-style ol { list-style-type: decimal !important; padding-left: 1.5rem !important; margin: 0.75rem 0 !important; }
    .content-editor-style ol[style*="lower-alpha"] { list-style-type: lower-alpha !important; }
    .content-editor-style ol[style*="lower-roman"] { list-style-type: lower-roman !important; }
    .content-editor-style li { margin-bottom: 0.25rem !important; }
    
    .content-editor-style img { max-width: 100%; height: auto; border-radius: 0.5rem; transition: all 0.2s ease; cursor: pointer; }
    #visualEditor img { cursor: grab; }
    #visualEditor img:active { cursor: grabbing; }
    #visualEditor img.editor-selected-img { outline: 3px solid #3b82f6 !important; }
    #visualEditor .content-carousel:has(img.editor-selected-img) { outline: 3px solid #3b82f6 !important; outline-offset: 2px; }
    #visualEditor .content-carousel img.editor-selected-img { outline: none !important; }
    #previewKonten img, #previewKonten .content-carousel { outline: none !important; cursor: default !important; }
    .content-editor-style p, .content-editor-style div { margin-bottom: 0.75rem !important; font-size: 1rem !important; line-height: 1.625 !important; }
    .content-editor-style sup { font-size: 0.75em; vertical-align: super; }
    .content-editor-style sub { font-size: 0.75em; vertical-align: sub; }
    
    /* Layout Kontainer 2-Kolom: Gambar & Textbox Berdampingan */
    .content-editor-style .content-side-by-side {
        display: flex !important;
        flex-direction: row;
        align-items: center;
        gap: 1.5rem;
        margin: 1.5rem 0 !important;
        clear: both;
        transition: all 0.2s ease;
    }
    /* Garis bantu tipis HANYA saat di mode edit (#visualEditor) */
    #visualEditor .content-side-by-side {
        padding: 0.85rem;
        background-color: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 0.75rem;
    }
    #visualEditor .content-side-by-side:hover {
        border-color: #3b82f6;
    }
    /* Tanpa border & background saat Live Preview / Publish */
    #previewKonten .content-side-by-side {
        padding: 0 !important;
        background: transparent !important;
        border: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
    }
    .content-editor-style .content-side-by-side.image-right,
    .content-editor-style .content-side-by-side.md\:flex-row-reverse {
        flex-direction: row-reverse;
    }
    .content-editor-style .content-side-by-side.image-center {
        flex-direction: column !important;
        align-items: center !important;
    }
    .content-editor-style .content-side-by-side .side-image-col {
        flex: 0 0 50%;
        max-width: 50%;
        text-align: center;
        margin-bottom: 0 !important;
    }
    .content-editor-style .content-side-by-side .side-text-col {
        flex: 1 1 0%;
        min-width: 0;
        margin-bottom: 0 !important;
    }
    .content-editor-style .content-side-by-side.image-center .side-text-col {
        width: 100%;
    }
    .content-editor-style .content-side-by-side .side-image-col img {
        margin: 0 auto;
        width: 100%;
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
    }
    @media (max-width: 767px) {
        .content-editor-style .content-side-by-side {
            flex-direction: column !important;
        }
        .content-editor-style .content-side-by-side .side-image-col,
        .content-editor-style .content-side-by-side .side-text-col {
            flex: 1 1 100% !important;
            max-width: 100% !important;
            width: 100% !important;
        }
    }
    
    /* Indikator Garis Snap Drag & Drop Antar Baris */
    .editor-drop-line {
        height: 4px;
        background: linear-gradient(90deg, #2563eb, #60a5fa, #2563eb);
        border-radius: 9999px;
        margin: 6px 0 !important;
        box-shadow: 0 0 10px rgba(37, 99, 235, 0.75);
        pointer-events: none;
        position: relative;
        animation: pulseDropLine 0.8s infinite alternate;
    }
    .editor-drop-line::before,
    .editor-drop-line::after {
        content: "";
        position: absolute;
        top: 50%;
        width: 10px;
        height: 10px;
        border-radius: 9999px;
        background: #2563eb;
        border: 2px solid #ffffff;
        box-shadow: 0 0 6px rgba(37, 99, 235, 0.8);
        transform: translateY(-50%);
    }
    .editor-drop-line::before { left: -2px; }
    .editor-drop-line::after { right: -2px; }
    @keyframes pulseDropLine {
        from { opacity: 0.8; transform: scaleY(0.95); }
        to { opacity: 1; transform: scaleY(1.25); }
    }
    .editor-drag-ghost {
        position: fixed;
        z-index: 9999;
        pointer-events: none;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 10px;
        background: rgba(15, 23, 42, 0.9);
        color: #ffffff;
        font-size: 11px;
        font-weight: 600;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(4px);
    }
    .editor-drag-ghost img {
        width: 32px;
        height: 24px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid rgba(255, 255, 255, 0.35);
    }

    /* Styling Multi-Image Carousel (Kontainer Persentase Tersendiri — Editor & Preview) */
    .content-editor-style .content-carousel {
        position: relative;
        display: block;
        width: 50%;
        max-width: 100%;
        aspect-ratio: 16 / 9;
        overflow: hidden;
        border-radius: 0.75rem;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        margin-top: 1.5rem !important;
        margin-bottom: 1.5rem !important;
        margin-left: auto;
        margin-right: auto;
        clear: both;
        user-select: none;
    }
    .content-editor-style .content-carousel .carousel-track { position: relative; width: 100%; height: 100%; margin: 0 !important; }
    .content-editor-style .content-carousel .carousel-slide { display: none; width: 100%; height: 100%; margin: 0 !important; }
    .content-editor-style .content-carousel .carousel-slide.active { display: flex; align-items: center; justify-content: center; }
    .content-editor-style .content-carousel .carousel-slide img {
        width: 100% !important;
        height: 100% !important;
        max-width: 100% !important;
        max-height: 100% !important;
        object-fit: contain;
        margin: 0 !important;
        float: none !important;
        display: block !important;
        border-radius: 0 !important;
    }
    .content-editor-style .content-carousel .carousel-btn {
        position: absolute; top: 50%; transform: translateY(-50%);
        width: 32px; height: 32px; border-radius: 9999px;
        background: rgba(15, 23, 42, 0.7); color: #fff; border: 1px solid rgba(255,255,255,0.25);
        display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 14px; z-index: 10;
    }
    .content-editor-style .content-carousel .carousel-btn:hover { background: rgba(15, 23, 42, 0.92); }
    .content-editor-style .content-carousel .carousel-prev { left: 8px; }
    .content-editor-style .content-carousel .carousel-next { right: 8px; }
    .content-editor-style .content-carousel .carousel-dots {
        position: absolute; bottom: 8px; left: 50%; transform: translateX(-50%);
        display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 6px; padding: 4px 10px;
        max-width: calc(100% - 20px);
        background: rgba(15, 23, 42, 0.5); border-radius: 9999px; margin-bottom: 0 !important; z-index: 10;
    }
    .content-editor-style .content-carousel .carousel-dot { width: 8px; height: 8px; border-radius: 9999px; background: rgba(255,255,255,0.5); cursor: pointer; transition: all 0.2s ease; }
    .content-editor-style .content-carousel .carousel-dot.active { background: #fff; width: 20px; }
    .content-editor-style .content-carousel .carousel-counter {
        position: absolute; top: 8px; right: 8px; background: rgba(15, 23, 42, 0.75); color: #fff;
        font-size: 11px !important; font-weight: 700; padding: 2px 9px; border-radius: 9999px; margin-bottom: 0 !important; z-index: 10;
    }
    .content-editor-style .content-side-by-side .side-image-col .content-carousel {
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 auto !important;
    }
    @media (max-width: 767px) {
        .content-editor-style .content-carousel {
            width: 100% !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
    }
    
    /* Clearfix bantu agar elemen tidak tertimpa float gambar */
    .clearfix::after { content: ""; clear: both; display: table; }

    /* Mode Penanda Formatting (seperti Microsoft Word ¶) */
    #visualEditor.show-format-marks p,
    #visualEditor.show-format-marks > div:not(.content-side-by-side):not(.editor-drop-line) {
        position: relative;
        outline: 1px dotted #cbd5e1;
        outline-offset: 2px;
        border-radius: 3px;
    }
    #visualEditor.show-format-marks p::after,
    #visualEditor.show-format-marks > div:not(.content-side-by-side):not(.editor-drop-line)::after {
        content: " ¶";
        color: #94a3b8;
        font-size: 0.75rem;
        font-weight: 400;
        user-select: none;
        pointer-events: none;
    }
    #visualEditor.show-format-marks h2,
    #visualEditor.show-format-marks h3,
    #visualEditor.show-format-marks h4,
    #visualEditor.show-format-marks h5,
    #visualEditor.show-format-marks h6 {
        outline: 1px dashed #3b82f6;
        outline-offset: 3px;
        background-color: rgba(59, 130, 246, 0.05);
        border-radius: 4px;
        padding-right: 2.5rem;
        position: relative;
    }
    #visualEditor.show-format-marks h2::after { content: "H2"; position: absolute; right: 4px; top: 4px; font-size: 10px; font-weight: 700; color: #2563eb; background: #dbeafe; padding: 1px 5px; border-radius: 3px; line-height: 1.2; }
    #visualEditor.show-format-marks h3::after { content: "H3"; position: absolute; right: 4px; top: 4px; font-size: 10px; font-weight: 700; color: #2563eb; background: #dbeafe; padding: 1px 5px; border-radius: 3px; line-height: 1.2; }
    #visualEditor.show-format-marks h4::after { content: "H4"; position: absolute; right: 4px; top: 4px; font-size: 10px; font-weight: 700; color: #2563eb; background: #dbeafe; padding: 1px 5px; border-radius: 3px; line-height: 1.2; }
    #visualEditor.show-format-marks h5::after { content: "H5"; position: absolute; right: 4px; top: 4px; font-size: 10px; font-weight: 700; color: #2563eb; background: #dbeafe; padding: 1px 5px; border-radius: 3px; line-height: 1.2; }
    #visualEditor.show-format-marks h6::after { content: "H6"; position: absolute; right: 4px; top: 4px; font-size: 10px; font-weight: 700; color: #2563eb; background: #dbeafe; padding: 1px 5px; border-radius: 3px; line-height: 1.2; }
    #visualEditor.show-format-marks blockquote {
        outline: 1px dashed #8b5cf6;
        outline-offset: 2px;
        background-color: rgba(139, 92, 246, 0.05);
        position: relative;
        padding-right: 4.5rem !important;
    }
    #visualEditor.show-format-marks blockquote::after {
        content: "KUTIPAN";
        position: absolute;
        right: 6px;
        top: 6px;
        font-size: 9px;
        font-style: normal;
        font-weight: 700;
        color: #6d28d9;
        background: #ede9fe;
        padding: 1px 5px;
        border-radius: 3px;
    }
    #visualEditor.show-format-marks ul,
    #visualEditor.show-format-marks ol {
        outline: 1px dashed #10b981;
        outline-offset: 2px;
        background-color: rgba(16, 185, 129, 0.04);
        border-radius: 4px;
    }
    #visualEditor.show-format-marks li::after {
        content: " ¶";
        color: #10b981;
        font-size: 0.7rem;
        user-select: none;
    }
    #visualEditor.show-format-marks b,
    #visualEditor.show-format-marks strong {
        background-color: rgba(250, 204, 21, 0.22);
        border-bottom: 1px dotted #ca8a04;
        border-radius: 2px;
    }
    #visualEditor.show-format-marks i,
    #visualEditor.show-format-marks em {
        background-color: rgba(56, 189, 248, 0.18);
        border-bottom: 1px dotted #0284c7;
        border-radius: 2px;
    }
    #visualEditor.show-format-marks u {
        background-color: rgba(168, 85, 247, 0.14);
        border-radius: 2px;
    }
    #visualEditor.show-format-marks s,
    #visualEditor.show-format-marks strike {
        background-color: rgba(244, 63, 94, 0.14);
        border-radius: 2px;
    }
    #visualEditor.show-format-marks sup,
    #visualEditor.show-format-marks sub {
        background-color: rgba(249, 115, 22, 0.18);
        border-radius: 2px;
        padding: 0 2px;
    }
    #visualEditor.show-format-marks .content-side-by-side {
        outline: 1px dashed #f59e0b;
        position: relative;
    }
    #visualEditor.show-format-marks .content-side-by-side::before {
        content: "2-KOLOM (GAMBAR + TEKS)";
        position: absolute;
        top: -9px;
        left: 10px;
        font-size: 9px;
        font-weight: 700;
        color: #b45309;
        background: #fef3c7;
        border: 1px solid #fcd34d;
        padding: 0 6px;
        border-radius: 4px;
    }
    #visualEditor.show-format-marks .content-side-by-side:has(.content-carousel)::before {
        content: "2-KOLOM (CAROUSEL + TEKS)";
    }
</style>

@php
    $userRole = Auth::user()->role;
    $lockedHumas = $isLockedForHumas ?? ($userRole === 'pegawai_humas' && $informasi->status === 'Pending');
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <a href="{{ request('from') === 'draft' && $userRole === 'admin' ? route('admin.berita.draft') : route('admin.informasi.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        
        @if($informasi->status === 'Terbit')
            <a href="{{ route('informasi.show', $informasi->slug) }}" target="_blank" class="text-sm font-bold text-blue-600 hover:underline">
                Lihat di Portal Publik &rarr;
            </a>
        @endif
    </div>

    @if(session('error'))
        <div class="mb-4 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-md text-sm font-semibold text-rose-800">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
            <ul class="list-disc pl-5 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- BANNER CATATAN REVISI / STATUS PENGAJUAN -->
    @if($informasi->status === 'Revisi' && !empty($informasi->komentar_revisi) && $informasi->komentar_revisi !== 'TELAH DIREVISI')
        <div class="mb-5 bg-rose-50 border-2 border-rose-400 rounded-xl p-4 shadow-sm">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div class="flex-1">
                    <h3 class="text-sm font-extrabold text-rose-900 uppercase tracking-wide">Informasi Resmi Dikembalikan untuk Revisi oleh Admin</h3>
                    <p class="text-sm text-rose-800 mt-1 whitespace-pre-line font-medium bg-white/80 p-3 rounded-lg border border-rose-200">{{ $informasi->komentar_revisi }}</p>
                    @if($userRole === 'pegawai_humas')
                        <p class="text-xs text-rose-700 mt-2 font-semibold">Silakan perbaiki konten di bawah ini, lalu klik tombol <b>"Kirim Revisi ke Admin (Pending)"</b> di panel kanan.</p>
                    @endif
                </div>
            </div>
        </div>
    @elseif($informasi->komentar_revisi === 'TELAH DIREVISI' && $informasi->status === 'Pending')
        <div class="mb-5 bg-emerald-50 border-2 border-emerald-400 rounded-xl p-4 shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h3 class="text-sm font-extrabold text-emerald-900 uppercase">TELAH DIREVISI — Menunggu Peninjauan Ulang Admin</h3>
                <p class="text-xs text-emerald-800 mt-0.5">Pengajuan ini telah diperbaiki oleh Pegawai Humas dan diajukan ulang dengan status <b>Pending</b>.</p>
            </div>
        </div>
    @endif

    @if($lockedHumas)
        <div class="mb-5 bg-amber-50 border-2 border-amber-400 rounded-xl p-4 shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            <div>
                <h3 class="text-sm font-extrabold text-amber-900 uppercase">Menunggu Peninjauan Admin (Status: Pending)</h3>
                <p class="text-xs text-amber-800 mt-0.5">Konten ini sedang terkunci selama proses peninjauan Admin. Anda dapat mengedit kembali apabila Admin mengembalikannya dengan status <b>Revisi</b>.</p>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.informasi.update', $informasi->slug) }}" method="POST" enctype="multipart/form-data" id="formInformasi">
        @csrf
        @method('PUT')
        <input type="hidden" name="from_page" value="{{ request('from') }}">
        
        <!-- Penampung file gambar yang akan dihapus dari server saat form disubmit -->
        <div id="deletedImagesContainer"></div>
        
        <div class="flex flex-col lg:flex-row gap-8 mb-12">
            <!-- KOLOM KIRI -->
            <div class="w-full lg:w-3/4 space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Judul Informasi <span class="text-red-500">*</span></label>
                    <input type="text" id="inputJudul" name="judul_berita" value="{{ old('judul_berita', $informasi->judul_berita) }}" placeholder="Tambahkan judul..." 
                        class="w-full text-xl md:text-2xl font-bold p-3 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors placeholder-gray-400" required autofocus>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Konten Informasi <span class="text-red-500">*</span></label>
                    
                    <!-- TOOLBOX FORMATTING -->
                    <div class="sticky -top-4 sm:-top-6 lg:-top-8 z-[50] flex flex-col gap-1.5 bg-white border border-gray-200 px-2.5 py-2 w-full shadow-sm rounded-t-md" id="editorHeader">
                        <div class="flex flex-wrap items-center justify-between gap-1.5 w-full">
                            <div class="flex flex-wrap items-center gap-1.5" id="toolbarKonten">
                                <select id="formatHeader" class="text-xs border border-gray-300 rounded px-2 py-1 bg-gray-50 hover:bg-gray-100 cursor-pointer focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-colors" onchange="applyHeader()">
                                    <option value="">Heading</option>
                                    <option value="h2">Heading 2</option>
                                    <option value="h3">Heading 3</option>
                                    <option value="h4">Heading 4</option>
                                    <option value="h5">Heading 5</option>
                                    <option value="h6">Heading 6</option>
                                </select>
                                
                                <div class="flex rounded shadow-xs">
                                    <button type="button" id="btnFmtBold" onclick="formatText('<b>', '</b>', 'bold')" class="px-2 py-1 bg-white border border-gray-300 rounded-l hover:bg-gray-50 text-xs font-bold transition-colors" title="Tebal (Bold)">B</button>
                                    <button type="button" id="btnFmtItalic" onclick="formatText('<i>', '</i>', 'italic')" class="px-2 py-1 bg-white border-t border-b border-r border-gray-300 hover:bg-gray-50 text-xs italic transition-colors" title="Miring (Italic)">I</button>
                                    <button type="button" id="btnFmtUnderline" onclick="formatText('<u>', '</u>', 'underline')" class="px-2 py-1 bg-white border-t border-b border-r border-gray-300 hover:bg-gray-50 text-xs underline transition-colors" title="Garis Bawah (Underline)">U</button>
                                    <button type="button" id="btnFmtStrike" onclick="formatText('<s>', '</s>', 'strikeThrough')" class="px-2 py-1 bg-white border-t border-b border-r border-gray-300 rounded-r hover:bg-gray-50 text-xs line-through transition-colors" title="Coret (Strikethrough)">S</button>
                                </div>

                                <div class="flex rounded shadow-xs">
                                    <button type="button" id="btnFmtSup" onclick="formatText('<sup>', '</sup>', 'superscript')" class="px-2 py-1 bg-white border border-gray-300 rounded-l hover:bg-gray-50 text-xs transition-colors" title="Superscript">x&sup2;</button>
                                    <button type="button" id="btnFmtSub" onclick="formatText('<sub>', '</sub>', 'subscript')" class="px-2 py-1 bg-white border-t border-b border-r border-gray-300 hover:bg-gray-50 text-xs transition-colors" title="Subscript">x&sbquo;</button>
                                    <button type="button" id="btnFmtQuote" onclick="formatText('<blockquote>', '</blockquote>', 'formatBlock')" class="px-2 py-1 bg-white border-t border-b border-r border-gray-300 rounded-r hover:bg-gray-50 text-xs transition-colors" title="Kutipan (Quote)">&quot; Kutipan</button>
                                </div>

                                <select id="formatList" class="text-xs border border-gray-300 rounded px-2 py-1 bg-gray-50 hover:bg-gray-100 cursor-pointer focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-colors" onchange="applyList()">
                                    <option value="">List</option>
                                    <option value="ul">Bullet (&bull;)</option>
                                    <option value="ol-1">Angka (1, 2)</option>
                                    <option value="ol-a">Huruf (a, b)</option>
                                    <option value="ol-i">Romawi (i, ii)</option>
                                </select>

                                <button type="button" onclick="openImageModal()" class="px-2 py-1 bg-blue-50 border border-blue-300 text-blue-700 rounded hover:bg-blue-100 flex items-center gap-1 text-xs font-semibold transition-colors" title="Sisipkan Gambar">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Gambar
                                </button>

                                <button type="button" onclick="insertSideBySideModal()" class="px-2 py-1 bg-amber-50 border border-amber-300 text-amber-800 rounded hover:bg-amber-100 flex items-center gap-1 text-xs font-semibold transition-colors" title="Sisipkan Gambar Berdampingan dengan Textbox">
                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path></svg>
                                    + Teks
                                </button>

                                <button type="button" onclick="openCarouselModal()" class="px-2 py-1 bg-purple-50 border border-purple-300 text-purple-800 rounded hover:bg-purple-100 flex items-center gap-1 text-xs font-semibold transition-colors" title="Sisipkan Multi-Gambar Carousel (Slider Geser)">
                                    <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 18h16M7 10h10v4H7z"></path></svg>
                                    Carousel
                                </button>

                                <button type="button" id="btnToggleFormatMarks" onclick="toggleFormatMarks()" class="px-2 py-1 bg-white border border-gray-300 text-gray-600 rounded hover:bg-gray-100 text-xs font-bold transition-colors" title="Mode Penanda Format (seperti Microsoft Word ¶)">
                                    &para;
                                </button>
                            </div>
                            
                            <!-- TOMBOL MODE VIEW -->
                            <div class="flex items-center p-0.5 bg-gray-100 rounded shrink-0 border border-gray-200">
                                <button type="button" id="btnModeVisual" onclick="switchMode('visual')" class="px-2.5 py-1 bg-white shadow-xs text-[11px] font-bold rounded text-gray-800 transition-all">Visual</button>
                                <button type="button" onclick="openPreviewModal()" class="px-2.5 py-1 text-emerald-700 text-[11px] font-bold rounded hover:bg-gray-200 transition-all">Preview</button>
                            </div>
                        </div>

                        <!-- DOCKED IMAGE TOOLBAR RINGKAS (1 BARIS, BEBAS AUTOCORRECT) -->
                        <div id="dockedImageToolbar" class="hidden w-full bg-blue-50/95 border border-blue-200 px-2 py-1 flex flex-wrap items-center justify-between gap-1.5 rounded text-[11px] transition-all">
                            <div class="flex flex-wrap items-center gap-1.5">
                                <span class="inline-flex items-center gap-1 font-bold text-blue-800 bg-blue-100 px-1.5 py-0.5 rounded" title="Opsi Format Gambar Aktif">
                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span id="dockedToolbarTypeLabel">Gambar</span>
                                </span>

                                <!-- UKURAN -->
                                <div class="flex items-center bg-white border border-gray-300 rounded overflow-hidden">
                                    <button type="button" onclick="setImageSize('kecil')" class="px-1.5 py-0.5 hover:bg-gray-100 font-semibold border-r border-gray-200" title="Ukuran Kecil (25%)">25%</button>
                                    <button type="button" onclick="setImageSize('sedang')" class="px-1.5 py-0.5 hover:bg-gray-100 font-semibold border-r border-gray-200" title="Ukuran Sedang (50%)">50%</button>
                                    <button type="button" onclick="setImageSize('besar')" class="px-1.5 py-0.5 hover:bg-gray-100 font-semibold" title="Ukuran Besar (100%)">100%</button>
                                </div>

                                <!-- PERATAAN -->
                                <div class="flex items-center bg-white border border-gray-300 rounded overflow-hidden">
                                    <button type="button" onclick="setImageAlign('kiri')" class="px-1.5 py-0.5 hover:bg-gray-100 font-semibold border-r border-gray-200" title="Rata Kiri">Kiri</button>
                                    <button type="button" onclick="setImageAlign('tengah')" class="px-1.5 py-0.5 hover:bg-gray-100 font-semibold border-r border-gray-200" title="Rata Tengah">Tengah</button>
                                    <button type="button" onclick="setImageAlign('kanan')" class="px-1.5 py-0.5 hover:bg-gray-100 font-semibold" title="Rata Kanan">Kanan</button>
                                </div>

                                <!-- PINDAH BARIS NAIK/TURUN -->
                                <div class="flex items-center bg-white border border-gray-300 rounded overflow-hidden">
                                    <button type="button" onclick="moveActiveImageBlock('up')" class="px-1.5 py-0.5 hover:bg-blue-50 text-blue-700 font-bold border-r border-gray-200" title="Pindah ke Baris Atas">&uarr;</button>
                                    <button type="button" onclick="moveActiveImageBlock('down')" class="px-1.5 py-0.5 hover:bg-blue-50 text-blue-700 font-bold" title="Pindah ke Baris Bawah">&darr;</button>
                                </div>

                                <!-- SANDINGKAN TEKS -->
                                <button type="button" id="btnToggleSideBySide" onclick="convertActiveImageToSideBySide()" class="px-2 py-0.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded flex items-center gap-1 transition-colors" title="Sandingkan Gambar dengan Textbox 2-Kolom">
                                    <span id="labelSideBySide">+ Teks</span>
                                </button>

                                <!-- BARIS BARU -->
                                <button type="button" onclick="insertClearfixAfterImage()" class="px-1.5 py-0.5 bg-white hover:bg-gray-100 border border-gray-300 font-semibold rounded" title="Buat baris baru di bawah gambar">&crarr; Baris</button>
                            </div>

                            <div class="flex items-center gap-1">
                                <button type="button" onclick="deleteActiveImage()" class="px-1.5 py-0.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded transition-colors flex items-center gap-0.5" title="Hapus Gambar">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                <button type="button" onclick="deselectActiveImage()" class="px-1.5 py-0.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded" title="Tutup Opsi">&#10005;</button>
                            </div>
                        </div>
                    </div>

                    <!-- AREA EDITOR -->
                    <div class="relative w-full border border-gray-300 rounded-b-md bg-white focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-200">
                        <div id="visualEditor" contenteditable="true" spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off" class="content-editor-style clearfix w-full p-6 text-gray-800 min-h-[500px] outline-none leading-relaxed">{!! old('konten', $informasi->konten) !!}</div>
                        <textarea name="konten" id="inputKonten" rows="20" class="hidden w-full p-6 bg-gray-900 text-gray-100 font-mono resize-y min-h-[500px] outline-none">{{ old('konten', $informasi->konten) }}</textarea>
                    </div>

                    <!-- FLOATING TOOLTIP GAMBAR -->
                    <div id="imageTooltip" class="hidden fixed z-[100] bg-white border border-gray-200 shadow-xl rounded-md p-2 flex flex-wrap gap-3 transition-opacity">
                        <div class="flex flex-col gap-1 border-r pr-3">
                            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Ukuran</span>
                            <div class="flex gap-1">
                                <button type="button" onclick="setImageSize('kecil')" class="px-2 py-1 text-xs bg-gray-100 hover:bg-gray-200 rounded font-medium transition-colors">Kecil</button>
                                <button type="button" onclick="setImageSize('sedang')" class="px-2 py-1 text-xs bg-gray-100 hover:bg-gray-200 rounded font-medium transition-colors">Sedang</button>
                                <button type="button" onclick="setImageSize('besar')" class="px-2 py-1 text-xs bg-gray-100 hover:bg-gray-200 rounded font-medium transition-colors">Besar</button>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1 border-r pr-3">
                            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Perataan</span>
                            <div class="flex gap-1">
                                <button type="button" onclick="setImageAlign('kiri')" class="px-2 py-1 text-xs bg-gray-100 hover:bg-gray-200 rounded font-medium transition-colors">Kiri</button>
                                <button type="button" onclick="setImageAlign('tengah')" class="px-2 py-1 text-xs bg-gray-100 hover:bg-gray-200 rounded font-medium transition-colors">Tengah</button>
                                <button type="button" onclick="setImageAlign('kanan')" class="px-2 py-1 text-xs bg-gray-100 hover:bg-gray-200 rounded font-medium transition-colors">Kanan</button>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1 border-r pr-3">
                            <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Layout</span>
                            <button type="button" onclick="insertClearfixAfterImage()" class="px-2 py-1 text-xs bg-gray-100 hover:bg-gray-200 rounded font-medium transition-colors flex items-center gap-1" title="Buat baris baru di bawah gambar">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg> 
                                Baris Baru
                            </button>
                        </div>
                        <div class="flex flex-col justify-center pl-1">
                            <button type="button" onclick="deleteActiveImage()" class="px-3 py-1.5 text-xs bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 rounded font-bold transition-colors">Hapus</button>
                        </div>
                    </div>
                </div>

                <!-- MANAJEMEN GAMBAR TERLAMPIR -->
                @php
                    $galleryImages = is_array($informasi->multi_images) ? $informasi->multi_images : (json_decode($informasi->multi_images, true) ?? []);
                @endphp
                <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                    <h4 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Manajemen Gambar Terlampir Di Server
                    </h4>

                    <div id="galleryAlert" class="hidden mb-3 p-3 rounded-md text-xs font-semibold transition-all duration-300"></div>
                    
                    <div id="galleryWrapper">
                        @if(!empty($galleryImages))
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="galleryContainer">
                                @foreach($galleryImages as $index => $imgPath)
                                    <div class="img-card-item relative group border border-gray-200 rounded-lg overflow-hidden bg-gray-50 flex flex-col justify-between" data-path="{{ $imgPath }}">
                                        <div class="relative aspect-video overflow-hidden bg-gray-100 flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $imgPath) }}" alt="Gallery Image" class="max-h-full max-w-full object-contain">
                                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 p-2">
                                                <button type="button" onclick="insertImageFromCard('{{ asset('storage/' . $imgPath) }}', '{{ basename($imgPath) }}')" class="p-1.5 bg-blue-600 text-white rounded text-xs font-medium hover:bg-blue-700">Sisipkan</button>
                                                <button type="button" onclick="openDeleteImageModal('{{ $imgPath }}', '{{ basename($imgPath) }}', this)" class="p-1.5 bg-red-600 text-white rounded text-xs font-medium hover:bg-red-700">Hapus</button>
                                            </div>
                                        </div>
                                        <div class="p-1.5 bg-white border-t border-gray-100 text-[10px] text-gray-500 truncate" title="{{ basename($imgPath) }}">{{ basename($imgPath) }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-gray-400 italic" id="emptyGalleryNotice">Belum ada gambar tambahan yang tersimpan di galeri informasi ini.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- KOLOM KANAN -->
            <div class="w-full lg:w-1/4 space-y-6">
                <!-- Box Publikasi & Review -->
                @php
                    $statusBadgeStyle = match($informasi->status) {
                        'Terbit'  => 'bg-emerald-100 text-emerald-800 border border-emerald-300',
                        'Pending' => 'bg-amber-100 text-amber-900 border border-amber-300',
                        'Revisi'  => 'bg-rose-100 text-rose-800 border border-rose-300',
                        default   => 'bg-gray-200 text-gray-800 border border-gray-300',
                    };
                @endphp
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 font-bold text-gray-800 flex items-center justify-between gap-2">
                        <span>Status Publikasi</span>
                        <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-full {{ $statusBadgeStyle }}">
                            {{ $informasi->status }}
                        </span>
                    </div>
                    <div class="p-4 space-y-3">
                        @if($userRole === 'admin')
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Ubah Status <span class="text-red-500">*</span></label>
                                <select name="status" id="adminStatusSelect" onchange="toggleAdminRevisiField()" required class="w-full text-sm bg-white border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-500">
                                    <option value="Draft" {{ old('status', $informasi->status) == 'Draft' ? 'selected' : '' }}>Konsep (Draft)</option>
                                    <option value="Pending" {{ old('status', $informasi->status) == 'Pending' ? 'selected' : '' }}>Menunggu Review (Pending)</option>
                                    <option value="Revisi" {{ old('status', $informasi->status) == 'Revisi' ? 'selected' : '' }}>Tolak / Minta Revisi</option>
                                    <option value="Terbit" {{ old('status', $informasi->status) == 'Terbit' ? 'selected' : '' }}>Setujui &amp; Terbitkan</option>
                                </select>
                            </div>

                            <div id="adminRevisiBox" class="{{ old('status', $informasi->status) == 'Revisi' ? '' : 'hidden' }} space-y-1.5 bg-rose-50 border border-rose-200 p-2.5 rounded-md">
                                <label class="block text-xs font-bold text-rose-800">Alasan / Catatan Revisi <span class="text-rose-600">*</span></label>
                                <textarea name="komentar_revisi" id="adminKomentarRevisi" rows="3" placeholder="Tuliskan bagian yang perlu direvisi oleh Humas..."
                                          class="w-full text-xs p-2 bg-white border border-rose-300 rounded focus:outline-none focus:ring-2 focus:ring-rose-300">{{ old('komentar_revisi', ($informasi->komentar_revisi === 'TELAH DIREVISI' ? '' : $informasi->komentar_revisi)) }}</textarea>
                            </div>

                            <div class="text-xs text-gray-500 bg-gray-50 p-2 rounded border border-gray-100">
                                Penulis: <b>{{ $informasi->penulis->username ?? 'Administrator' }}</b><br>
                                Terakhir diubah: {{ \Carbon\Carbon::parse($informasi->updated_at)->format('d M Y, H:i') }}
                            </div>

                            <div class="space-y-2 pt-1">
                                <button type="submit" class="w-full py-2 px-4 rounded-md shadow-xs text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                    Simpan Perubahan
                                </button>

                                @if($informasi->status !== 'Terbit')
                                    <button type="submit" name="action_type" value="approve_publish" class="w-full py-2 px-4 rounded-md shadow-xs text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-colors">
                                        Terima &amp; Terbitkan (Accept)
                                    </button>
                                @endif

                                <button type="button" onclick="triggerAdminReject()" class="w-full py-2 px-4 rounded-md shadow-xs text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 transition-colors">
                                    Tolak &amp; Minta Revisi (Reject)
                                </button>
                            </div>
                        @else
                            <input type="hidden" name="status" value="{{ $informasi->status }}">
                            <div class="text-xs text-gray-600 bg-gray-50 p-2.5 rounded border border-gray-200 space-y-1">
                                <div>Status saat ini: <b class="uppercase">{{ $informasi->status }}</b></div>
                                <div>Terakhir diubah: {{ \Carbon\Carbon::parse($informasi->updated_at)->format('d M Y, H:i') }}</div>
                            </div>

                            @if($lockedHumas)
                                <div class="p-3 rounded-md bg-amber-50 border border-amber-300 text-xs text-amber-900 font-semibold">
                                    Sedang ditinjau Admin (Pending). Perubahan dinonaktifkan hingga proses peninjauan selesai.
                                </div>
                            @elseif($informasi->status === 'Draft')
                                <div class="space-y-2 pt-1">
                                    <button type="submit" name="action_type" value="save_draft" class="w-full py-2 px-4 border border-gray-300 rounded-md text-xs font-bold text-gray-800 bg-gray-100 hover:bg-gray-200 transition-colors">
                                        Simpan Draft
                                    </button>
                                    <button type="submit" name="action_type" value="submit_review" class="w-full py-2.5 px-4 rounded-md shadow-sm text-xs font-bold text-white bg-amber-500 hover:bg-amber-600 transition-colors">
                                        Submit ke Admin (Pending)
                                    </button>
                                </div>
                            @elseif($informasi->status === 'Revisi')
                                <div class="space-y-2 pt-1">
                                    <button type="submit" name="action_type" value="save_draft" class="w-full py-2 px-4 border border-gray-300 rounded-md text-xs font-bold text-gray-800 bg-gray-100 hover:bg-gray-200 transition-colors">
                                        Simpan Sementara
                                    </button>
                                    <button type="submit" name="action_type" value="submit_review" class="w-full py-2.5 px-4 rounded-md shadow-sm text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-colors">
                                        Kirim Revisi ke Admin (Pending)
                                    </button>
                                    <p class="text-[11px] text-gray-500 leading-snug">
                                        Mengirim revisi akan mengubah status menjadi <b>Pending</b> dan menandai catatan revisi sebagai <b>TELAH DIREVISI</b>.
                                    </p>
                                </div>
                            @else
                                <button type="submit" class="w-full py-2 px-4 rounded-md shadow-sm text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                    Perbarui Informasi
                                </button>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Box Thumbnail -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg font-bold text-gray-800">Thumbnail Informasi</div>
                    <div class="p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Unggah Thumbnail Baru</label>
                        <input type="file" name="thumbnail" id="inputThumbnail" accept="image/jpeg, image/png, image/jpg, image/webp" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 bg-white border border-gray-300 rounded-md">
                        <p class="text-xs text-amber-600 mt-1 font-medium">* Disarankan rasio gambar 16:9.</p>

                        <label class="block text-sm font-medium text-gray-700 mt-4 mb-1">Deskripsi Gambar (Caption)</label>
                        <input type="text" id="inputCaption" name="caption_thumbnail" maxlength="150" value="{{ old('caption_thumbnail', $informasi->caption_thumbnail) }}" class="w-full text-sm p-2 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:ring-2 focus:ring-blue-200">

                        @if($informasi->thumbnail)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <span class="block text-xs font-semibold text-gray-600 mb-2">Thumbnail Saat Ini:</span>
                            <div class="relative aspect-video overflow-hidden rounded border border-gray-200 bg-gray-50 flex items-center justify-center p-2">
                                <img src="{{ asset('storage/' . $informasi->thumbnail) }}" alt="Current Thumbnail" class="max-h-full max-w-full object-contain rounded">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Box Multi-Images Baru -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg font-bold text-gray-800">Tambah Galeri Gambar Baru</div>
                    <div class="p-4 space-y-3">
                        <label class="block text-sm font-medium text-gray-700">Pilih File Gambar Baru</label>
                        <input type="file" id="inputMultiImages" multiple accept="image/jpeg, image/png, image/jpg, image/webp" class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 bg-white border border-gray-300 rounded-md">

                        <input type="file" name="multi_images[]" id="hiddenMultiImages" multiple class="hidden">

                        <div id="multiImageList" class="space-y-2 mt-3 max-h-48 overflow-y-auto pr-1">
                            <p class="text-xs text-gray-400 italic" id="emptyListNotice">Belum ada gambar baru dipilih.</p>
                        </div>
                    </div>
                </div>

                <!-- Box File Lampiran -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg font-bold text-gray-800">File Lampiran</div>
                    <div class="p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">URL Dokumen (Opsional)</label>
                        <input type="url" name="lampiran_url" id="inputLampiranUrl" value="{{ old('lampiran_url', $informasi->lampiran_url) }}" placeholder="https://drive.google.com/..." class="w-full bg-white border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 text-sm">
                        @if($informasi->lampiran_url)
                            <a href="{{ $informasi->lampiran_url }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-2 inline-block font-medium">Buka Tautan Saat Ini &nearr;</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('modals')
<!-- MODAL LIVE PREVIEW -->
<div id="previewModal" class="hidden fixed inset-0 z-[70] bg-gray-900/80 flex justify-center items-center backdrop-blur-sm p-4 sm:p-8 transition-opacity">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-5xl h-full max-h-[90vh] flex flex-col border border-gray-200">
        <!-- Header Modal -->
        <div class="flex justify-between items-center p-5 border-b border-gray-100 shrink-0 bg-gray-50 rounded-t-xl">
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Tampilan Publikasi (Preview)
            </h3>
            <button type="button" onclick="closePreviewModal()" class="text-gray-400 hover:text-red-500 text-3xl font-bold leading-none transition-colors">&times;</button>
        </div>
        
        <!-- Konten Preview -->
        <div class="p-6 md:p-10 overflow-y-auto flex-1 bg-gray-50/50">
            <article class="bg-white p-8 md:p-12 rounded-xl border border-gray-200 shadow-sm flex flex-col max-w-4xl mx-auto">
                <h1 id="previewJudul" class="text-3xl md:text-4xl font-bold text-gray-900 leading-snug mb-4">
                    {{ old('judul_berita', $informasi->judul_berita) ?: 'Judul Informasi Akan Muncul Di Sini...' }}
                </h1>
                
                <div class="flex items-center gap-4 text-sm text-gray-500 pb-6 border-b border-gray-100 mb-8">
                    <span>{{ \Carbon\Carbon::parse($informasi->created_at)->translatedFormat('d F Y') }}</span>
                    <span>•</span>
                    <span>Admin / Penulis</span>
                </div>

                <div id="previewThumbnailContainer" class="{{ $informasi->thumbnail ? '' : 'hidden' }} mb-10 rounded-xl overflow-hidden border border-gray-200 relative aspect-video bg-gray-100 flex items-center justify-center shadow-inner">
                    <img id="previewThumbnailImage" src="{{ $informasi->thumbnail ? asset('storage/' . $informasi->thumbnail) : '' }}" alt="Preview Thumbnail" class="relative z-10 max-h-full max-w-full object-contain">
                    <p id="previewThumbnailCaption" class="absolute bottom-0 inset-x-0 z-20 text-sm text-gray-700 italic py-3 px-4 text-center bg-white/95 backdrop-blur-sm border-t border-gray-200">
                        <span id="captionText">{{ old('caption_thumbnail', $informasi->caption_thumbnail ?? '') ?: 'Deskripsi gambar akan muncul di sini...' }}</span>
                    </p>
                </div>

                <div id="previewKonten" class="content-editor-style clearfix text-gray-800 leading-relaxed">
                    {!! old('konten', $informasi->konten) ?: '<p class="text-gray-400 italic text-center py-10">Konten informasi akan diperbarui secara otomatis saat Anda mengetik di editor...</p>' !!}
                </div>

                <div id="previewLampiranContainer" class="mt-10 pt-8 border-t border-gray-200 hidden">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 flex items-center justify-between gap-4 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-blue-100 rounded-lg text-blue-600 shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-gray-900">Dokumen Lampiran</h4>
                                <p class="text-sm text-gray-600 mt-1">Klik tombol di samping untuk melihat dokumen lampiran.</p>
                            </div>
                        </div>
                        <a id="previewLampiranLink" href="#" target="_blank" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg flex items-center gap-2 transition-colors shrink-0 shadow-sm">
                            Buka Lampiran
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>

<!-- MODAL PILIH GAMBAR DARI GALERI -->
<div id="imageModal" class="hidden fixed inset-0 z-[70] bg-gray-900/80 flex justify-center items-center backdrop-blur-sm p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-3xl p-6 border border-gray-200">
        <div class="flex justify-between items-center pb-4 border-b border-gray-100 mb-5">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Sisipkan Gambar ke Editor</h3>
                <p class="text-sm text-gray-500 mt-1">Pilih gambar dari daftar galeri yang telah Anda tambahkan.</p>
            </div>
            <button type="button" onclick="closeImageModal()" class="text-gray-400 hover:text-red-500 text-2xl font-bold transition-colors">&times;</button>
        </div>
        
        <div class="mb-5 bg-blue-50/50 p-4 rounded-lg border border-blue-100">
            <label class="block text-sm font-bold text-gray-800 mb-1.5">Teks Alternatif (Alt Text) Opsional</label>
            <input type="text" id="modalAltText" placeholder="Contoh: Suasana kegiatan..." class="w-full text-sm p-2.5 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-colors">
            <p class="text-xs text-gray-500 mt-2">Atribut alt penting untuk aksesibilitas dan SEO.</p>
        </div>

        <div id="modalGalleryGrid" class="grid grid-cols-2 md:grid-cols-3 gap-4 max-h-80 overflow-y-auto p-2 border border-gray-100 rounded-lg bg-gray-50"></div>

        <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
            <div id="carouselFooterInfo" class="hidden flex flex-wrap items-center gap-3">
                <div class="text-xs font-semibold text-purple-800 bg-purple-50 border border-purple-200 px-3 py-1.5 rounded-md">
                    Dipilih: <span id="carouselSelectedCount" class="font-black">0</span> gambar (minimal 2)
                </div>
                <label class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-700 cursor-pointer select-none">
                    <input type="checkbox" id="carouselWithTextbox" class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                    <span>Sandingkan dengan Textbox (+ Teks)</span>
                </label>
            </div>
            <div class="flex items-center gap-2 ml-auto">
                <button type="button" id="btnInsertCarouselConfirm" onclick="confirmInsertCarousel()" disabled class="hidden px-4 py-2 bg-purple-600 disabled:bg-purple-300 disabled:cursor-not-allowed text-white text-sm font-bold rounded-md hover:bg-purple-700 transition-colors">
                    Sisipkan Carousel
                </button>
                <button type="button" onclick="closeImageModal()" class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-bold rounded-md hover:bg-gray-200 transition-colors">Batal</button>
            </div>
        </div>
    </div>
</div>

<div id="deleteImageModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm">
    <div class="relative w-full max-w-sm bg-white rounded-lg shadow-xl p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Gambar Galeri</h3>
        <p class="text-sm text-gray-600 mb-6">Yakin ingin menghapus gambar <strong id="delete_image_name" class="text-gray-900"></strong> dari server?</p>
        <div class="flex justify-end gap-3">
            <button type="button" onclick="closeDeleteImageModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded hover:bg-gray-200 transition">Batal</button>
            <button type="button" id="btnConfirmDeleteImage" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700 transition">Ya, Hapus</button>
        </div>
    </div>
</div>
@endpush

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentMode = 'visual'; 
        
        const inputJudul = document.getElementById('inputJudul');
        const inputKonten = document.getElementById('inputKonten');
        const visualEditor = document.getElementById('visualEditor');
        const inputThumbnail = document.getElementById('inputThumbnail');
        const inputCaption = document.getElementById('inputCaption');
        const inputLampiranUrl = document.getElementById('inputLampiranUrl');
        
        const previewJudul = document.getElementById('previewJudul');
        const previewKonten = document.getElementById('previewKonten');
        const previewThumbnailContainer = document.getElementById('previewThumbnailContainer');
        const previewThumbnailImage = document.getElementById('previewThumbnailImage');
        const captionText = document.getElementById('captionText');
        const previewLampiranContainer = document.getElementById('previewLampiranContainer');
        const previewLampiranLink = document.getElementById('previewLampiranLink');
        
        const localBlobMap = new Map();
        const storageBaseUrl = "{{ rtrim(asset('storage'), '/') }}";
        let activeImage = null;
        let savedEditorRange = null;

        function saveEditorSelection() {
            if (currentMode !== 'visual') return;
            const sel = window.getSelection();
            if (!sel || sel.rangeCount === 0) return;
            const range = sel.getRangeAt(0);
            if (visualEditor.contains(range.commonAncestorContainer)) {
                savedEditorRange = range.cloneRange();
            }
        }

        function insertBlockAtSavedCursor(htmlString) {
            const editor = visualEditor;
            const temp = document.createElement('div');
            temp.innerHTML = htmlString.trim();
            const rawNodes = Array.from(temp.childNodes).filter(
                n => !(n.nodeType === Node.TEXT_NODE && n.textContent.trim() === '')
            );
            if (rawNodes.length === 0) return;

            const lastRaw = rawNodes[rawNodes.length - 1];
            let trailingP = (lastRaw && lastRaw.nodeType === Node.ELEMENT_NODE && lastRaw.tagName === 'P' && lastRaw.textContent.trim() === '')
                ? lastRaw
                : null;
            const mainNodes = trailingP ? rawNodes.slice(0, -1) : rawNodes;
            const firstInserted = mainNodes[0] || rawNodes[0];

            const insertNodesBefore = (nodes, refNode) => {
                nodes.forEach(n => editor.insertBefore(n, refNode || null));
            };

            let focusTarget = null;
            const hasValidRange = savedEditorRange && editor.contains(savedEditorRange.endContainer);

            if (!hasValidRange) {
                insertNodesBefore(mainNodes, null);
                if (!trailingP) {
                    trailingP = document.createElement('p');
                    trailingP.innerHTML = '<br>';
                }
                editor.appendChild(trailingP);
                focusTarget = trailingP;
            } else if (savedEditorRange.endContainer === editor) {
                const refNode = editor.childNodes[savedEditorRange.endOffset] || null;
                insertNodesBefore(mainNodes, refNode);
                if (!trailingP && !refNode) {
                    trailingP = document.createElement('p');
                    trailingP.innerHTML = '<br>';
                }
                if (trailingP) {
                    editor.insertBefore(trailingP, refNode);
                    focusTarget = trailingP;
                } else {
                    focusTarget = refNode;
                }
            } else {
                let topBlock = savedEditorRange.endContainer;
                while (topBlock && topBlock.parentNode !== editor) {
                    topBlock = topBlock.parentNode;
                }

                if (!topBlock) {
                    insertNodesBefore(mainNodes, null);
                    if (!trailingP) {
                        trailingP = document.createElement('p');
                        trailingP.innerHTML = '<br>';
                    }
                    editor.appendChild(trailingP);
                    focusTarget = trailingP;
                } else if (topBlock.nodeType === Node.TEXT_NODE) {
                    const offset = savedEditorRange.endOffset;
                    const text = topBlock.textContent || '';
                    const beforeText = text.slice(0, offset);
                    const afterText = text.slice(offset);
                    const nextSibling = topBlock.nextSibling;
                    topBlock.remove();

                    if (beforeText.trim() !== '') {
                        const beforeDiv = document.createElement('div');
                        beforeDiv.textContent = beforeText;
                        editor.insertBefore(beforeDiv, nextSibling);
                    }
                    insertNodesBefore(mainNodes, nextSibling);
                    if (afterText.trim() !== '') {
                        const afterDiv = document.createElement('div');
                        afterDiv.textContent = afterText;
                        editor.insertBefore(afterDiv, nextSibling);
                        focusTarget = afterDiv;
                    } else {
                        if (!trailingP) {
                            trailingP = document.createElement('p');
                            trailingP.innerHTML = '<br>';
                        }
                        editor.insertBefore(trailingP, nextSibling);
                        focusTarget = trailingP;
                    }
                } else {
                    const tag = topBlock.tagName;
                    const isSpecialBlock = topBlock.classList.contains('content-carousel') || topBlock.classList.contains('content-side-by-side');
                    const isEmptyBlock = !isSpecialBlock
                        && ['P', 'DIV'].includes(tag)
                        && topBlock.textContent.replace(/\u200B/g, '').trim() === ''
                        && !topBlock.querySelector('img, .content-carousel, .content-side-by-side');

                    if (isEmptyBlock) {
                        const nextSibling = topBlock.nextSibling;
                        insertNodesBefore(mainNodes, topBlock);
                        topBlock.remove();
                        if (!nextSibling) {
                            if (!trailingP) {
                                trailingP = document.createElement('p');
                                trailingP.innerHTML = '<br>';
                            }
                            editor.insertBefore(trailingP, null);
                            focusTarget = trailingP;
                        } else if (trailingP) {
                            editor.insertBefore(trailingP, nextSibling);
                            focusTarget = trailingP;
                        } else {
                            focusTarget = nextSibling;
                        }
                    } else if (!isSpecialBlock && ['P', 'DIV', 'H2', 'H3', 'H4', 'H5', 'H6', 'BLOCKQUOTE'].includes(tag)) {
                        const beforeRange = document.createRange();
                        beforeRange.selectNodeContents(topBlock);
                        beforeRange.setEnd(savedEditorRange.endContainer, savedEditorRange.endOffset);
                        const hasBefore = beforeRange.toString().replace(/\u200B/g, '').trim().length > 0
                            || !!beforeRange.cloneContents().querySelector('img');

                        const afterRange = document.createRange();
                        afterRange.selectNodeContents(topBlock);
                        afterRange.setStart(savedEditorRange.endContainer, savedEditorRange.endOffset);
                        const hasAfter = afterRange.toString().replace(/\u200B/g, '').trim().length > 0
                            || !!afterRange.cloneContents().querySelector('img');

                        if (!hasBefore && hasAfter) {
                            insertNodesBefore(mainNodes, topBlock);
                            focusTarget = topBlock;
                        } else if (hasBefore && !hasAfter) {
                            const nextSibling = topBlock.nextSibling;
                            insertNodesBefore(mainNodes, nextSibling);
                            if (trailingP || !nextSibling) {
                                if (!trailingP) {
                                    trailingP = document.createElement('p');
                                    trailingP.innerHTML = '<br>';
                                }
                                editor.insertBefore(trailingP, nextSibling);
                                focusTarget = trailingP;
                            } else {
                                focusTarget = nextSibling;
                            }
                        } else if (hasBefore && hasAfter) {
                            const afterFrag = afterRange.extractContents();
                            const afterBlock = document.createElement(tag);
                            afterBlock.appendChild(afterFrag);
                            const nextSibling = topBlock.nextSibling;
                            insertNodesBefore(mainNodes, nextSibling);
                            editor.insertBefore(afterBlock, nextSibling);
                            focusTarget = afterBlock;
                        } else {
                            const nextSibling = topBlock.nextSibling;
                            insertNodesBefore(mainNodes, topBlock);
                            topBlock.remove();
                            if (trailingP || !nextSibling) {
                                if (!trailingP) {
                                    trailingP = document.createElement('p');
                                    trailingP.innerHTML = '<br>';
                                }
                                editor.insertBefore(trailingP, nextSibling);
                                focusTarget = trailingP;
                            } else {
                                focusTarget = nextSibling;
                            }
                        }
                    } else {
                        const nextSibling = topBlock.nextSibling;
                        insertNodesBefore(mainNodes, nextSibling);
                        if (trailingP || !nextSibling) {
                            if (!trailingP) {
                                trailingP = document.createElement('p');
                                trailingP.innerHTML = '<br>';
                            }
                            editor.insertBefore(trailingP, nextSibling);
                            focusTarget = trailingP;
                        } else {
                            focusTarget = nextSibling;
                        }
                    }
                }
            }

            if (focusTarget && editor.contains(focusTarget)) {
                editor.focus();
                try {
                    const newRange = document.createRange();
                    newRange.setStart(focusTarget, 0);
                    newRange.collapse(true);
                    const sel = window.getSelection();
                    sel.removeAllRanges();
                    sel.addRange(newRange);
                    savedEditorRange = newRange.cloneRange();
                } catch (e) {}
            }

            if (firstInserted && firstInserted.scrollIntoView) {
                firstInserted.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        let serverImages = [
            @foreach($galleryImages as $imgPath)
                { url: "{{ asset('storage/' . $imgPath) }}", name: "{{ basename($imgPath) }}", path: "{{ $imgPath }}" },
            @endforeach
        ];

        syncRawToVisual();

        visualEditor.addEventListener('focus', function() {
            if (this.innerHTML.trim() === '' || this.innerHTML === '<br>') {
                document.execCommand('formatBlock', false, 'DIV');
            }
        });

        visualEditor.addEventListener('keyup', function(e) {
            if (this.innerHTML.trim() === '' || this.innerHTML === '<br>') {
                document.execCommand('formatBlock', false, 'DIV');
            }
            if (e.key === 'Enter') {
                syncVisualToRaw();
            }
        });

        function formatHTML(html) {
            return html
                .replace(/(<(div|p|ul|ol|li|h[1-6]|br|blockquote)[^>]*>)/gi, '\n$1')
                .replace(/(<\/(div|p|ul|ol|li|h[1-6]|blockquote)>)/gi, '$1\n')
                .replace(/\n(<li)/gi, '\n  $1')
                .replace(/\n\s*\n/g, '\n')
                .replace(/<div[^>]*><br style="clear:\s*both;?"><\/div>/gi, '\n<div style="clear: both;"><br></div>\n')
                .trim();
        }

        // ------------------ NORMALISASI & PERBAIKAN RENDER GAMBAR WYSIWYG ------------------
        function resolveServerImageUrl(rawSrc) {
            if (!rawSrc) return null;
            const cleaned = rawSrc.trim();
            if (cleaned.startsWith('blob:') || cleaned.startsWith('data:')) return cleaned;

            // 1. Cek localBlobMap (file baru yang belum diupload ke server)
            if (localBlobMap.has(cleaned)) return localBlobMap.get(cleaned);
            try {
                const decoded = decodeURIComponent(cleaned);
                if (localBlobMap.has(decoded)) return localBlobMap.get(decoded);
            } catch (e) {}

            // 2. Jika URL mengandung /storage/, arahkan ke origin/host aktif saat ini
            const storageMatch = cleaned.match(/(?:^|\/)storage\/(.+)$/i);
            if (storageMatch && storageMatch[1]) {
                return storageBaseUrl + '/' + storageMatch[1].replace(/^\/+/, '');
            }

            // 3. Cocokkan dengan daftar serverImages berdasarkan nama file atau slug
            if (typeof serverImages !== 'undefined' && Array.isArray(serverImages) && serverImages.length > 0) {
                const baseCandidate = cleaned.split('/').pop().split('?')[0];
                let decodedCandidate = baseCandidate;
                try { decodedCandidate = decodeURIComponent(baseCandidate); } catch (e) {}
                const slugCandidate = decodedCandidate.replace(/\.[^/.]+$/, '').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');

                for (const sImg of serverImages) {
                    if (sImg.url === cleaned || sImg.path === cleaned || sImg.name === baseCandidate || sImg.name === decodedCandidate) {
                        return sImg.url;
                    }
                    if (slugCandidate && sImg.name.toLowerCase().includes(slugCandidate)) {
                        return sImg.url;
                    }
                }
            }

            return cleaned;
        }

        function initEditorCarousels(container) {
            if (!container) return;
            container.querySelectorAll('.content-carousel').forEach(carousel => {
                const slides = Array.from(carousel.querySelectorAll('.carousel-slide'));
                const dots = Array.from(carousel.querySelectorAll('.carousel-dot'));
                const counter = carousel.querySelector('.carousel-counter');
                if (slides.length === 0) return;

                let idx = slides.findIndex(s => s.classList.contains('active'));
                if (idx < 0) idx = 0;

                const show = (n) => {
                    idx = (n + slides.length) % slides.length;
                    slides.forEach((s, i) => s.classList.toggle('active', i === idx));
                    dots.forEach((d, i) => d.classList.toggle('active', i === idx));
                    if (counter) counter.textContent = `${idx + 1} / ${slides.length}`;
                };
                show(idx);

                const prevBtn = carousel.querySelector('.carousel-prev');
                const nextBtn = carousel.querySelector('.carousel-next');
                if (prevBtn) prevBtn.onclick = (e) => { e.preventDefault(); e.stopPropagation(); show(idx - 1); };
                if (nextBtn) nextBtn.onclick = (e) => { e.preventDefault(); e.stopPropagation(); show(idx + 1); };
                dots.forEach((d, i) => { d.onclick = (e) => { e.preventDefault(); e.stopPropagation(); show(i); }; });
            });
        }

        function normalizeEditorImages(container) {
            if (!container) return;
            container.querySelectorAll('img').forEach(img => {
                img.setAttribute('draggable', 'false');
                img.style.outline = '';
                if (container === previewKonten) {
                    img.classList.remove('editor-selected-img');
                }
                const currentSrc = img.getAttribute('src') || '';
                const fixedSrc = resolveServerImageUrl(currentSrc);
                if (fixedSrc && fixedSrc !== currentSrc) {
                    img.setAttribute('src', fixedSrc);
                }
                if (!img.dataset.fallbackBound) {
                    img.dataset.fallbackBound = '1';
                    img.addEventListener('error', function() {
                        const altName = (this.getAttribute('alt') || '').trim();
                        const retry = resolveServerImageUrl(altName);
                        if (retry && retry !== this.getAttribute('src') && (retry.startsWith('http') || retry.startsWith('/') || retry.startsWith('blob:'))) {
                            this.setAttribute('src', retry);
                        }
                    });
                }
            });
            container.querySelectorAll('.content-carousel').forEach(carousel => {
                if (carousel.style.width === 'fit-content') {
                    const mw = carousel.style.maxWidth;
                    carousel.style.width = (mw && mw !== '100%') ? mw : '50%';
                    carousel.style.maxWidth = '100%';
                }
                carousel.querySelectorAll('img').forEach(cImg => {
                    cImg.style.width = '';
                    cImg.style.height = '';
                    cImg.style.float = '';
                    cImg.style.margin = '';
                });
            });
            initEditorCarousels(container);
        }

        // ------------------ SYNC ENGINE ------------------
        function syncVisualToRaw() {
            let html = visualEditor.innerHTML;
            html = html.replace(/\s*outline(?:-(?:color|style|width|offset))?:\s*[^;"']*;?/gi, '');
            html = html.replace(/\beditor-selected-img\b/gi, '');
            html = html.replace(/\s*data-fallback-bound="1"/gi, '');
            
            localBlobMap.forEach((blobUrl, fileName) => {
                const escapedBlob = blobUrl.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const srcRegex = new RegExp(`(src=["'])${escapedBlob}(["'])`, 'g');
                html = html.replace(srcRegex, `$1${fileName}$2`);
            });
            
            html = formatHTML(html);

            if (inputKonten.value !== html) {
                inputKonten.value = html;
                updateLivePreview();
                saveHistory();
            }
        }

        function syncRawToVisual() {
            let rawText = inputKonten.value;
            localBlobMap.forEach((blobUrl, fileName) => {
                const escapedName = fileName.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const encodedName = encodeURIComponent(fileName).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const srcRegex = new RegExp(`(src=["'])(?:${escapedName}|${encodedName})(["'])`, 'g');
                rawText = rawText.replace(srcRegex, `$1${blobUrl}$2`);
            });
            visualEditor.innerHTML = rawText;
            normalizeEditorImages(visualEditor);
            updateLivePreview();
        }

        function updateLivePreview() {
            let rawText = inputKonten.value.trim();
            if (rawText !== '') {
                localBlobMap.forEach((blobUrl, fileName) => {
                    const escapedName = fileName.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                    const encodedName = encodeURIComponent(fileName).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                    const srcRegex = new RegExp(`(src=["'])(?:${escapedName}|${encodedName})(["'])`, 'g');
                    rawText = rawText.replace(srcRegex, `$1${blobUrl}$2`);
                });
                previewKonten.innerHTML = rawText;
                normalizeEditorImages(previewKonten);
            } else {
                previewKonten.innerHTML = '<p class="text-gray-400 italic text-center py-10">Konten informasi akan diperbarui secara otomatis saat Anda mengetik di editor...</p>';
            }
        }

        visualEditor.addEventListener('input', syncVisualToRaw);
        inputKonten.addEventListener('input', syncRawToVisual);

        // ------------------ MODE SWITCHER ------------------
        window.switchMode = function(mode) {
            currentMode = mode;
            const btnV = document.getElementById('btnModeVisual');
            
            if (mode === 'visual') {
                btnV.className = 'px-3 py-1.5 bg-white shadow-sm text-xs font-bold rounded text-gray-800 transition-all';
                syncRawToVisual();
                inputKonten.classList.add('hidden');
                visualEditor.classList.remove('hidden');
            } else {
                btnV.className = 'px-3 py-1.5 text-xs font-bold rounded text-gray-600 hover:bg-gray-200 transition-all';
                syncVisualToRaw();
                visualEditor.classList.add('hidden');
                inputKonten.classList.remove('hidden');
            }
            document.getElementById('imageTooltip').classList.add('hidden');
        };

        // Helper untuk mencari elemen blok terdekat di dalam editor
        function getClosestEditorBlock(node, tagNames) {
            while (node && node !== visualEditor) {
                if (node.nodeType === Node.ELEMENT_NODE && tagNames.includes(node.nodeName.toUpperCase())) {
                    return node;
                }
                node = node.parentNode;
            }
            return null;
        }

        // Helper seleksi teks di dalam elemen agar pengguna bisa langsung mengetik menimpa template
        function selectElementContents(el) {
            if (!el) return;
            const range = document.createRange();
            range.selectNodeContents(el);
            const sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);
        }

        function isCurrentLineEmpty(sel) {
            if (!sel || !sel.anchorNode) return true;
            if (!sel.isCollapsed) return false;
            const block = getClosestEditorBlock(sel.anchorNode, ['P', 'DIV', 'H2', 'H3', 'H4', 'H5', 'H6', 'BLOCKQUOTE', 'LI']);
            if (block) {
                return block.textContent.replace(/\u200B/g, '').trim() === '';
            }
            return visualEditor.textContent.replace(/\u200B/g, '').trim() === '';
        }

        // ------------------ MODE PENANDA FORMATTING (MS WORD STYLE) ------------------
        window.toggleFormatMarks = function() {
            const isActive = visualEditor.classList.toggle('show-format-marks');
            const btn = document.getElementById('btnToggleFormatMarks');
            if (btn) {
                if (isActive) {
                    btn.classList.remove('bg-white', 'text-gray-600', 'border-gray-300');
                    btn.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600', 'shadow-xs');
                } else {
                    btn.classList.add('bg-white', 'text-gray-600', 'border-gray-300');
                    btn.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600', 'shadow-xs');
                }
            }
        };

        function setFormatBtnActive(btnId, active) {
            const btn = document.getElementById(btnId);
            if (!btn) return;
            if (active) {
                btn.classList.add('bg-blue-100', 'text-blue-700', 'border-blue-400');
                btn.classList.remove('bg-white');
            } else {
                btn.classList.remove('bg-blue-100', 'text-blue-700', 'border-blue-400');
                btn.classList.add('bg-white');
            }
        }

        function updateActiveFormatIndicators() {
            if (currentMode !== 'visual') return;
            const sel = window.getSelection();
            if (!sel || !sel.anchorNode || !visualEditor.contains(sel.anchorNode)) return;

            try {
                setFormatBtnActive('btnFmtBold', document.queryCommandState('bold'));
                setFormatBtnActive('btnFmtItalic', document.queryCommandState('italic'));
                setFormatBtnActive('btnFmtUnderline', document.queryCommandState('underline'));
                setFormatBtnActive('btnFmtStrike', document.queryCommandState('strikeThrough'));
                setFormatBtnActive('btnFmtSup', document.queryCommandState('superscript'));
                setFormatBtnActive('btnFmtSub', document.queryCommandState('subscript'));
            } catch (e) {}

            const inQuote = !!getClosestEditorBlock(sel.anchorNode, ['BLOCKQUOTE']);
            setFormatBtnActive('btnFmtQuote', inQuote);

            const headerEl = getClosestEditorBlock(sel.anchorNode, ['H2', 'H3', 'H4', 'H5', 'H6']);
            const headerSelect = document.getElementById('formatHeader');
            if (headerSelect) {
                headerSelect.classList.toggle('border-blue-500', !!headerEl);
                headerSelect.classList.toggle('bg-blue-50', !!headerEl);
                headerSelect.classList.toggle('text-blue-700', !!headerEl);
            }

            const listEl = getClosestEditorBlock(sel.anchorNode, ['UL', 'OL']);
            const listSelect = document.getElementById('formatList');
            if (listSelect) {
                listSelect.classList.toggle('border-emerald-500', !!listEl);
                listSelect.classList.toggle('bg-emerald-50', !!listEl);
                listSelect.classList.toggle('text-emerald-700', !!listEl);
            }
        }

        document.addEventListener('selectionchange', () => {
            saveEditorSelection();
            updateActiveFormatIndicators();
        });
        visualEditor.addEventListener('keyup', () => {
            saveEditorSelection();
            updateActiveFormatIndicators();
        });
        visualEditor.addEventListener('mouseup', () => {
            saveEditorSelection();
            updateActiveFormatIndicators();
        });

        // ------------------ FORMATTING TEKS KUSTOM ------------------
        function applyTextReplacement(replacementText, selectStart, selectEnd) {
            inputKonten.focus();
            if (typeof inputKonten.setRangeText === 'function') {
                inputKonten.setRangeText(replacementText, selectStart, selectEnd, 'select');
            } else {
                inputKonten.setSelectionRange(selectStart, selectEnd);
                document.execCommand('insertText', false, replacementText);
            }
        }

        window.formatText = function(tagStart, tagEnd, execCmd) {
            if (currentMode === 'visual') {
                visualEditor.focus();
                const sel = window.getSelection();
                if (execCmd === 'formatBlock') {
                    const blockTag = tagStart.replace(/<|>/g, '').toUpperCase();
                    const existingBlock = sel && sel.anchorNode ? getClosestEditorBlock(sel.anchorNode, [blockTag]) : null;
                    
                    if (existingBlock) {
                        // TOGGLE OFF: Jika format yang sama ditekan ulang, unformat/kembalikan ke DIV biasa
                        document.execCommand('formatBlock', false, 'DIV');
                        if (existingBlock.parentNode && existingBlock.parentNode.contains(existingBlock)) {
                            while (existingBlock.firstChild) {
                                existingBlock.parentNode.insertBefore(existingBlock.firstChild, existingBlock);
                            }
                            existingBlock.remove();
                        }
                    } else if (isCurrentLineEmpty(sel)) {
                        // Sisipkan contoh template kutipan pada baris kosong dan langsung sorot
                        const tempId = 'tpl-' + Date.now();
                        document.execCommand('insertHTML', false, `<blockquote id="${tempId}">Ketik kutipan teks di sini...</blockquote>`);
                        const inserted = document.getElementById(tempId);
                        if (inserted) {
                            inserted.removeAttribute('id');
                            selectElementContents(inserted);
                        }
                    } else {
                        // TOGGLE ON: Terapkan format blok (seperti blockquote)
                        document.execCommand('formatBlock', false, blockTag);
                    }
                } else if (execCmd) {
                    const isAlreadyActive = (() => { try { return document.queryCommandState(execCmd); } catch (e) { return false; } })();
                    if (sel && sel.isCollapsed && !isAlreadyActive) {
                        // Sisipkan teks contoh template yang otomatis tersorot saat tidak ada teks diblok
                        const placeholders = {
                            bold: ['b', 'Teks tebal'],
                            italic: ['i', 'Teks miring'],
                            underline: ['u', 'Teks bergaris bawah'],
                            strikeThrough: ['s', 'Teks dicoret'],
                            superscript: ['sup', 'pangkat'],
                            subscript: ['sub', 'indeks']
                        };
                        const tpl = placeholders[execCmd];
                        if (tpl) {
                            const tempId = 'tpl-' + Date.now();
                            document.execCommand('insertHTML', false, `<${tpl[0]} id="${tempId}">${tpl[1]}</${tpl[0]}>`);
                            const inserted = document.getElementById(tempId);
                            if (inserted) {
                                inserted.removeAttribute('id');
                                selectElementContents(inserted);
                            }
                        } else {
                            document.execCommand(execCmd, false, null);
                        }
                    } else {
                        document.execCommand(execCmd, false, null);
                    }
                }
                syncVisualToRaw();
                updateActiveFormatIndicators();
                return;
            }

            const start = inputKonten.selectionStart;
            const end = inputKonten.selectionEnd;
            const text = inputKonten.value;
            const selectedText = text.substring(start, end);
            
            // Toggle off jika di mode teks mentah sudah terbungkus tag yang sama
            if (selectedText.startsWith(tagStart) && selectedText.endsWith(tagEnd)) {
                const unwrapped = selectedText.slice(tagStart.length, -tagEnd.length);
                applyTextReplacement(unwrapped, start, end);
                inputKonten.setSelectionRange(start, start + unwrapped.length);
            } else {
                const wrapped = tagStart + selectedText + tagEnd;
                applyTextReplacement(wrapped, start, end);
                if (selectedText.length === 0) {
                    inputKonten.setSelectionRange(start + tagStart.length, start + tagStart.length);
                } else {
                    inputKonten.setSelectionRange(start, start + wrapped.length);
                }
            }
            syncRawToVisual();
        };

        window.applyHeader = function() {
            const select = document.getElementById('formatHeader');
            const targetTag = (select.value || '').toUpperCase();
            if (!targetTag) return;

            if (currentMode === 'visual') {
                visualEditor.focus();
                const sel = window.getSelection();
                const currentH = sel && sel.anchorNode ? getClosestEditorBlock(sel.anchorNode, ['H2', 'H3', 'H4', 'H5', 'H6']) : null;
                
                if (currentH && currentH.nodeName === targetTag) {
                    // TOGGLE OFF: Kembalikan heading ke paragraf / div biasa
                    document.execCommand('formatBlock', false, 'DIV');
                } else if (!currentH && isCurrentLineEmpty(sel)) {
                    // Sisipkan template heading pada baris kosong & langsung sorot
                    const tagLower = targetTag.toLowerCase();
                    const level = targetTag.replace('H', '');
                    const tempId = 'tpl-' + Date.now();
                    document.execCommand('insertHTML', false, `<${tagLower} id="${tempId}">Judul Heading ${level}</${tagLower}>`);
                    const inserted = document.getElementById(tempId);
                    if (inserted) {
                        inserted.removeAttribute('id');
                        selectElementContents(inserted);
                    }
                } else {
                    document.execCommand('formatBlock', false, targetTag);
                }
                syncVisualToRaw();
                updateActiveFormatIndicators();
            } else {
                const start = inputKonten.selectionStart;
                const end = inputKonten.selectionEnd;
                const selectedText = inputKonten.value.substring(start, end);
                const tag = targetTag.toLowerCase();
                const pattern = new RegExp(`^<${tag}>([\\s\\S]*?)<\\/${tag}>$`, 'i');
                if (pattern.test(selectedText.trim())) {
                    const unwrapped = selectedText.replace(new RegExp(`^\\s*<${tag}>\\s*|\\s*<\\/${tag}>\\s*$`, 'gi'), '');
                    applyTextReplacement(unwrapped, start, end);
                } else {
                    applyTextReplacement(`\n<${tag}>\n${selectedText}\n</${tag}>\n`, start, end);
                }
                syncRawToVisual();
            }
            select.value = "";
        };

        window.applyList = function() {
            const select = document.getElementById('formatList');
            const val = select.value;
            if (!val) return;

            if (currentMode === 'visual') {
                visualEditor.focus();
                const sel = window.getSelection();
                const currentList = sel && sel.anchorNode ? getClosestEditorBlock(sel.anchorNode, ['UL', 'OL']) : null;
                
                if (currentList) {
                    const isUL = currentList.nodeName === 'UL';
                    const currentStyle = (currentList.style.listStyleType || 'decimal').toLowerCase();
                    
                    let isSameType = false;
                    if (val === 'ul' && isUL) isSameType = true;
                    if (!isUL) {
                        if (val === 'ol-1' && (currentStyle === 'decimal' || !currentList.style.listStyleType)) isSameType = true;
                        if (val === 'ol-a' && currentStyle === 'lower-alpha') isSameType = true;
                        if (val === 'ol-i' && currentStyle === 'lower-roman') isSameType = true;
                    }

                    if (isSameType) {
                        // TOGGLE OFF: Un-list kembali ke teks normal
                        document.execCommand(isUL ? 'insertUnorderedList' : 'insertOrderedList', false, null);
                    } else if (val === 'ul') {
                        // Ubah dari OL ke UL
                        document.execCommand('insertUnorderedList', false, null);
                    } else if (isUL && val.startsWith('ol-')) {
                        // Ubah dari UL ke OL
                        document.execCommand('insertOrderedList', false, null);
                        setTimeout(() => {
                            const newOl = sel && sel.anchorNode ? getClosestEditorBlock(sel.anchorNode, ['OL']) : null;
                            if (newOl) {
                                newOl.style.listStyleType = val === 'ol-a' ? 'lower-alpha' : (val === 'ol-i' ? 'lower-roman' : 'decimal');
                            }
                            syncVisualToRaw();
                            updateActiveFormatIndicators();
                        }, 10);
                    } else {
                        // Tetap OL, ubah jenis penomoran tanpa menghapus list
                        currentList.style.listStyleType = val === 'ol-a' ? 'lower-alpha' : (val === 'ol-i' ? 'lower-roman' : 'decimal');
                    }
                } else if (isCurrentLineEmpty(sel)) {
                    // Buat list baru dengan contoh template item pada baris kosong & langsung sorot
                    const tempId = 'tpl-' + Date.now();
                    const tag = val === 'ul' ? 'ul' : 'ol';
                    const styleAttr = val === 'ol-a' ? ' style="list-style-type: lower-alpha;"' : (val === 'ol-i' ? ' style="list-style-type: lower-roman;"' : '');
                    document.execCommand('insertHTML', false, `<${tag}${styleAttr}><li id="${tempId}">Item daftar...</li></${tag}>`);
                    const insertedLi = document.getElementById(tempId);
                    if (insertedLi) {
                        insertedLi.removeAttribute('id');
                        selectElementContents(insertedLi);
                    }
                } else {
                    // Buat list baru dari teks yang ada
                    if (val === 'ul') {
                        document.execCommand('insertUnorderedList', false, null);
                    } else {
                        document.execCommand('insertOrderedList', false, null);
                        setTimeout(() => {
                            const newOl = sel && sel.anchorNode ? getClosestEditorBlock(sel.anchorNode, ['OL']) : null;
                            if (newOl) {
                                newOl.style.listStyleType = val === 'ol-a' ? 'lower-alpha' : (val === 'ol-i' ? 'lower-roman' : 'decimal');
                            }
                            syncVisualToRaw();
                            updateActiveFormatIndicators();
                        }, 10);
                    }
                }
                syncVisualToRaw();
                updateActiveFormatIndicators();
            } else {
                const start = inputKonten.selectionStart;
                const end = inputKonten.selectionEnd;
                const tag = val === 'ul' ? 'ul' : 'ol';
                let style = '';
                if(val === 'ol-a') style = ' style="list-style-type: lower-alpha;"';
                if(val === 'ol-i') style = ' style="list-style-type: lower-roman;"';
                
                let liItems = `\n  <li>${inputKonten.value.substring(start, end)}</li>\n`;
                applyTextReplacement(`\n<${tag}${style}>${liItems}</${tag}>\n`, start, end);
                syncRawToVisual();
            }
            select.value = "";
        };

        // ------------------ MANAJEMEN GAMBAR DI EDITOR ------------------
        window.insertImageTagToContent = function(srcUrl, altText) {
            const finalAlt = altText || 'Gambar Informasi';
            const displaySrc = resolveServerImageUrl(srcUrl) || srcUrl;
            const imgHtmlVisual = `\n<div style="clear: both; margin-bottom: 1rem;">\n<img src="${displaySrc}" class="max-w-full h-auto rounded-lg shadow-sm" alt="${finalAlt}" style="display: block; margin: 1.5rem auto; width: 100%;" draggable="true" />\n</div>\n`;
            const imgHtmlRaw = `\n<div style="clear: both; margin-bottom: 1rem;">\n<img src="${srcUrl}" class="max-w-full h-auto rounded-lg shadow-sm" alt="${finalAlt}" style="display: block; margin: 1.5rem auto; width: 100%;" draggable="true" />\n</div>\n`;
            
            if (currentMode === 'visual') {
                insertBlockAtSavedCursor(imgHtmlVisual);
                normalizeEditorImages(visualEditor);
                syncVisualToRaw();
            } else {
                applyTextReplacement(imgHtmlRaw, inputKonten.selectionStart, inputKonten.selectionEnd);
                syncRawToVisual();
            }
        };

        window.insertSideBySideTagToContent = function(srcUrl, altText) {
            const finalAlt = altText || 'Gambar Informasi';
            const displaySrc = resolveServerImageUrl(srcUrl) || srcUrl;
            const buildCard = (src) => `\n<div class="content-side-by-side" data-layout="side-by-side">\n    <div class="side-image-col" style="flex: 0 0 50%; max-width: 50%; width: 50%;">\n        <img src="${src}" class="max-w-full h-auto rounded-lg shadow-sm mx-auto" alt="${finalAlt}" style="width: 100%;" draggable="false" />\n    </div>\n    <div class="side-text-col text-gray-700 leading-relaxed min-h-[100px] outline-none" style="flex: 1 1 0%; min-width: 0;">\n        <p>Ketik teks atau penjelasan informasi di sini yang berdampingan dengan gambar...</p>\n    </div>\n</div>\n<p><br></p>\n`;
            
            if (currentMode === 'visual') {
                insertBlockAtSavedCursor(buildCard(displaySrc));
                normalizeEditorImages(visualEditor);
                syncVisualToRaw();
            } else {
                applyTextReplacement(buildCard(srcUrl), inputKonten.selectionStart, inputKonten.selectionEnd);
                syncRawToVisual();
            }
        };

        function selectEditorImage(img) {
            if (activeImage && activeImage !== img) {
                activeImage.classList.remove('editor-selected-img');
                activeImage.style.outline = '';
            }
            activeImage = img || null;
            if (activeImage) {
                activeImage.style.outline = '';
                activeImage.classList.add('editor-selected-img');
            }
            updateDockedToolbarState();
        }

        window.convertActiveImageToSideBySide = function() {
            if (!activeImage) return;
            const sideCard = activeImage.closest('.content-side-by-side');
            const carouselCard = activeImage.closest('.content-carousel');
            
            if (sideCard) {
                // UNWRAP KEMBALI KE GAMBAR / CAROUSEL BIASA
                const carousel = sideCard.querySelector('.content-carousel');
                const img = sideCard.querySelector('img');
                const textContent = sideCard.querySelector('.side-text-col')?.innerHTML || '';
                const extraTextDiv = document.createElement('div');
                extraTextDiv.innerHTML = textContent;

                if (carousel) {
                    carousel.style.width = '50%';
                    carousel.style.maxWidth = '100%';
                    carousel.style.marginLeft = 'auto';
                    carousel.style.marginRight = 'auto';

                    sideCard.parentNode.insertBefore(carousel, sideCard);
                    sideCard.parentNode.insertBefore(extraTextDiv, sideCard);
                    sideCard.remove();

                    const activeSlideImg = carousel.querySelector('.carousel-slide.active img') || carousel.querySelector('img');
                    if (activeSlideImg) selectEditorImage(activeSlideImg);
                    initEditorCarousels(visualEditor);
                } else {
                    const standaloneImgDiv = document.createElement('div');
                    standaloneImgDiv.style.clear = 'both';
                    standaloneImgDiv.style.marginBottom = '1rem';
                    if (img) {
                        img.style.display = 'block';
                        img.style.margin = '1.5rem auto';
                        img.style.width = '100%';
                        img.className = 'max-w-full h-auto rounded-lg shadow-sm';
                        standaloneImgDiv.appendChild(img);
                    }
                    
                    sideCard.parentNode.insertBefore(standaloneImgDiv, sideCard);
                    sideCard.parentNode.insertBefore(extraTextDiv, sideCard);
                    sideCard.remove();
                    
                    if (img) {
                        selectEditorImage(img);
                    }
                }
            } else if (carouselCard) {
                const card = document.createElement('div');
                card.className = 'content-side-by-side';
                card.setAttribute('data-layout', 'side-by-side');

                carouselCard.style.width = '100%';
                carouselCard.style.maxWidth = '100%';
                carouselCard.style.marginLeft = 'auto';
                carouselCard.style.marginRight = 'auto';

                card.innerHTML = `
                    <div class="side-image-col" style="flex: 0 0 50%; max-width: 50%; width: 50%;"></div>
                    <div class="side-text-col text-gray-700 leading-relaxed min-h-[100px] outline-none" style="flex: 1 1 0%; min-width: 0;">
                        <p>Ketik teks atau penjelasan informasi di sini yang berdampingan dengan carousel...</p>
                    </div>
                `;

                carouselCard.parentNode.insertBefore(card, carouselCard);
                card.querySelector('.side-image-col').appendChild(carouselCard);

                selectEditorImage(activeImage);
                initEditorCarousels(visualEditor);
            } else {
                // WRAP MENJADI KONTEN 2-KOLOM BERDAMPINGAN (BERSIH TANPA BORDER SAAT PUBLISH)
                const parentWrapper = (activeImage.parentNode && activeImage.parentNode.tagName === 'DIV' && activeImage.parentNode.style.clear === 'both' && activeImage.parentNode.textContent.trim() === '') 
                    ? activeImage.parentNode 
                    : activeImage;
                    
                const card = document.createElement('div');
                card.className = 'content-side-by-side';
                card.setAttribute('data-layout', 'side-by-side');
                
                activeImage.style.float = 'none';
                activeImage.style.margin = '0 auto';
                activeImage.style.width = '100%';
                activeImage.style.display = 'block';
                
                card.innerHTML = `
                    <div class="side-image-col" style="flex: 0 0 50%; max-width: 50%; width: 50%;"></div>
                    <div class="side-text-col text-gray-700 leading-relaxed min-h-[100px] outline-none" style="flex: 1 1 0%; min-width: 0;">
                        <p>Ketik teks atau penjelasan informasi di sini yang berdampingan dengan gambar...</p>
                    </div>
                `;
                
                parentWrapper.parentNode.insertBefore(card, parentWrapper);
                card.querySelector('.side-image-col').appendChild(activeImage);
                if (parentWrapper !== activeImage) {
                    parentWrapper.remove();
                }
                
                selectEditorImage(activeImage);
            }
            syncVisualToRaw();
            updateDockedToolbarState();
        };

        window.updateDockedToolbarState = function() {
            const dockedBar = document.getElementById('dockedImageToolbar');
            const labelSideBySide = document.getElementById('labelSideBySide');
            const btnToggleSideBySide = document.getElementById('btnToggleSideBySide');
            const typeLabel = document.getElementById('dockedToolbarTypeLabel');
            
            if (!dockedBar) return;
            
            if (activeImage) {
                dockedBar.classList.remove('hidden');
                const inCarousel = !!activeImage.closest('.content-carousel');
                const sideCard = activeImage.closest('.content-side-by-side');
                if (typeLabel) {
                    typeLabel.textContent = inCarousel ? (sideCard ? 'Carousel + Teks' : 'Carousel') : 'Gambar';
                }
                if (btnToggleSideBySide) {
                    btnToggleSideBySide.classList.remove('hidden');
                }
                if (sideCard) {
                    if (labelSideBySide) labelSideBySide.textContent = 'Pisahkan';
                    if (btnToggleSideBySide) {
                        btnToggleSideBySide.classList.remove('bg-amber-500', 'hover:bg-amber-600');
                        btnToggleSideBySide.classList.add('bg-slate-600', 'hover:bg-slate-700');
                    }
                } else {
                    if (labelSideBySide) labelSideBySide.textContent = '+ Teks';
                    if (btnToggleSideBySide) {
                        btnToggleSideBySide.classList.remove('bg-slate-600', 'hover:bg-slate-700');
                        btnToggleSideBySide.classList.add('bg-amber-500', 'hover:bg-amber-600');
                    }
                }
            } else {
                dockedBar.classList.add('hidden');
            }
        };

        // Bungkus teks lepas langsung di dalam visualEditor agar setiap baris bisa menjadi target snap
        function ensureDirectBlockChildren(editorEl) {
            Array.from(editorEl.childNodes).forEach(node => {
                if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() !== '') {
                    const wrapper = document.createElement('div');
                    editorEl.insertBefore(wrapper, node);
                    wrapper.appendChild(node);
                }
            });
        }

        // Helper mendapatkan blok tingkat atas dari sebuah gambar (memisahkan gambar dari paragraf teks jika menempel)
        function getTopLevelImageBlock(img, extractIfMixed = false) {
            if (!img || !visualEditor.contains(img)) return null;
            const sideCard = img.closest('.content-side-by-side');
            if (sideCard && visualEditor.contains(sideCard)) return sideCard;
            const carouselCard = img.closest('.content-carousel');
            if (carouselCard && visualEditor.contains(carouselCard)) return carouselCard;

            let el = img;
            while (el.parentNode && el.parentNode !== visualEditor) {
                el = el.parentNode;
            }

            if (extractIfMixed && el !== img && el.textContent.replace(/\u200B/g, '').trim() !== '') {
                const wrapper = document.createElement('div');
                wrapper.style.clear = 'both';
                wrapper.style.marginBottom = '1rem';
                visualEditor.insertBefore(wrapper, el);
                wrapper.appendChild(img);
                return wrapper;
            }

            return el;
        }

        window.moveActiveImageBlock = function(direction) {
            if (!activeImage) return;
            ensureDirectBlockChildren(visualEditor);
            const block = getTopLevelImageBlock(activeImage, true);
            if (!block || block.parentNode !== visualEditor) return;

            if (direction === 'up') {
                const prev = block.previousElementSibling;
                if (prev) {
                    visualEditor.insertBefore(block, prev);
                    block.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    syncVisualToRaw();
                }
            } else if (direction === 'down') {
                const next = block.nextElementSibling;
                if (next) {
                    visualEditor.insertBefore(block, next.nextSibling);
                    block.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    syncVisualToRaw();
                }
            }
        };

        window.deselectActiveImage = function() {
            if (activeImage) {
                activeImage.classList.remove('editor-selected-img');
                activeImage.style.outline = '';
                activeImage = null;
            }
            updateDockedToolbarState();
        };
        
        window.insertImageFromCard = function(srcUrl, defaultAlt) {
            insertImageTagToContent(srcUrl, defaultAlt);
        };

        let justFinishedPointerDrag = false;

        visualEditor.addEventListener('click', function(e) {
            if (justFinishedPointerDrag) return;
            if (e.target.closest && e.target.closest('.carousel-btn, .carousel-dots')) return;
            const carouselHit = e.target.closest ? e.target.closest('.content-carousel') : null;
            const img = e.target.closest('img')
                || (carouselHit ? (carouselHit.querySelector('.carousel-slide.active img') || carouselHit.querySelector('img')) : null);
            if (img && visualEditor.contains(img)) {
                selectEditorImage(img);
            } else if (!e.target.closest('#dockedImageToolbar')) {
                deselectActiveImage();
            }
        });

        visualEditor.addEventListener('keydown', function(e) {
            if ((e.key === 'Backspace' || e.key === 'Delete') && activeImage) {
                e.preventDefault();
                deleteActiveImage();
            }
        });

        // ------------------ POINTER-EVENT DRAG & SNAP (100% BEBAS GANGGUAN CONTENTEDITABLE) ------------------
        let dropIndicator = document.getElementById('editorDropIndicator');
        if (!dropIndicator) {
            dropIndicator = document.createElement('div');
            dropIndicator.id = 'editorDropIndicator';
            dropIndicator.className = 'editor-drop-line';
        }

        // Blokir native HTML5 image-drag di contenteditable agar tidak bentrok
        visualEditor.addEventListener('dragstart', function(e) {
            if (e.target && e.target.closest && e.target.closest('img')) {
                e.preventDefault();
            }
        });

        let ptrImg = null;
        let ptrBlock = null;
        let ptrStartX = 0;
        let ptrStartY = 0;
        let ptrIsDragging = false;
        let ptrGhost = null;

        visualEditor.addEventListener('mousedown', function(e) {
            if (e.button !== 0 || currentMode !== 'visual') return;
            if (e.target.closest && e.target.closest('.carousel-btn, .carousel-dots')) return;
            const carouselHit = e.target.closest ? e.target.closest('.content-carousel') : null;
            const img = (e.target.closest ? e.target.closest('img') : null)
                || (carouselHit ? (carouselHit.querySelector('.carousel-slide.active img') || carouselHit.querySelector('img')) : null);
            if (!img || !visualEditor.contains(img)) return;

            e.preventDefault();
            ptrImg = img;
            ptrBlock = getTopLevelImageBlock(img, false);
            ptrStartX = e.clientX;
            ptrStartY = e.clientY;
            ptrIsDragging = false;
        });

        window.addEventListener('mousemove', function(e) {
            if (!ptrImg) return;

            if (!ptrIsDragging) {
                const dist = Math.hypot(e.clientX - ptrStartX, e.clientY - ptrStartY);
                if (dist < 6) return;

                ptrIsDragging = true;
                ensureDirectBlockChildren(visualEditor);
                ptrBlock = getTopLevelImageBlock(ptrImg, true);
                if (!ptrBlock || ptrBlock.parentNode !== visualEditor) {
                    ptrImg = null;
                    ptrBlock = null;
                    ptrIsDragging = false;
                    return;
                }

                visualEditor.setAttribute('contenteditable', 'false');
                document.body.style.userSelect = 'none';
                document.body.style.cursor = 'grabbing';
                ptrBlock.style.opacity = '0.3';

                ptrGhost = document.createElement('div');
                ptrGhost.className = 'editor-drag-ghost';
                const label = ptrBlock.classList.contains('content-side-by-side')
                    ? (ptrBlock.querySelector('.content-carousel') ? 'Geser Blok Carousel + Teks' : 'Geser Blok Gambar + Teks')
                    : (ptrBlock.classList.contains('content-carousel') ? 'Geser Blok Carousel' : 'Geser Gambar ke Baris Tujuan');
                ptrGhost.innerHTML = `<img src="${ptrImg.src}" alt="" /><span>${label}</span>`;
                document.body.appendChild(ptrGhost);
            }

            if (ptrGhost) {
                ptrGhost.style.left = (e.clientX + 14) + 'px';
                ptrGhost.style.top = (e.clientY + 14) + 'px';
            }

            const scrollContainer = visualEditor.closest('main') || document.documentElement;
            if (e.clientY < 130) {
                scrollContainer.scrollTop -= 14;
            } else if (e.clientY > window.innerHeight - 90) {
                scrollContainer.scrollTop += 14;
            }

            const children = Array.from(visualEditor.children).filter(
                el => el !== dropIndicator && el !== ptrBlock
            );

            if (children.length === 0) {
                if (dropIndicator.parentNode !== visualEditor) visualEditor.appendChild(dropIndicator);
                return;
            }

            let inserted = false;
            for (const child of children) {
                const rect = child.getBoundingClientRect();
                const midY = rect.top + (rect.height / 2);
                if (e.clientY < midY) {
                    if (child.previousSibling !== dropIndicator) {
                        visualEditor.insertBefore(dropIndicator, child);
                    }
                    inserted = true;
                    break;
                }
            }

            if (!inserted) {
                if (visualEditor.lastChild !== dropIndicator) {
                    visualEditor.appendChild(dropIndicator);
                }
            }
        });

        window.addEventListener('mouseup', function() {
            if (!ptrImg) return;

            if (ptrIsDragging && ptrBlock) {
                if (dropIndicator.parentNode === visualEditor) {
                    visualEditor.insertBefore(ptrBlock, dropIndicator);
                    dropIndicator.remove();
                }

                ptrBlock.style.opacity = '1';
                visualEditor.setAttribute('contenteditable', 'true');
                document.body.style.userSelect = '';
                document.body.style.cursor = '';

                if (ptrGhost) {
                    ptrGhost.remove();
                    ptrGhost = null;
                }

                ptrImg.style.transition = 'all 0.25s ease';
                selectEditorImage(ptrImg);

                justFinishedPointerDrag = true;
                setTimeout(() => { justFinishedPointerDrag = false; }, 60);

                syncVisualToRaw();
            } else {
                selectEditorImage(ptrImg);
            }

            ptrImg = null;
            ptrBlock = null;
            ptrIsDragging = false;
        });

        window.setImageSize = function(size) {
            if (!activeImage) return;
            const sideCard = activeImage.closest('.content-side-by-side');
            const carouselCard = activeImage.closest('.content-carousel');
            if (sideCard) {
                const imgCol = sideCard.querySelector('.side-image-col');
                const textCol = sideCard.querySelector('.side-text-col');
                if (imgCol && textCol) {
                    const isCentered = sideCard.classList.contains('image-center');
                    const pct = size === 'kecil' ? '25%' : (size === 'sedang' ? '50%' : (isCentered ? '100%' : '65%'));
                    imgCol.className = 'side-image-col';
                    imgCol.style.flex = isCentered ? '0 0 auto' : `0 0 ${pct}`;
                    imgCol.style.maxWidth = pct;
                    imgCol.style.width = pct;
                    textCol.className = 'side-text-col text-gray-700 leading-relaxed min-h-[100px] outline-none';
                    textCol.style.flex = '1 1 0%';
                    textCol.style.minWidth = '0';
                    if (carouselCard) {
                        carouselCard.style.width = '100%';
                        carouselCard.style.maxWidth = '100%';
                    } else {
                        activeImage.style.width = '100%';
                    }
                }
            } else if (carouselCard) {
                carouselCard.style.width = size === 'kecil' ? '25%' : (size === 'sedang' ? '50%' : '100%');
                carouselCard.style.maxWidth = '100%';
                carouselCard.querySelectorAll('img').forEach(cImg => {
                    cImg.style.width = '';
                    cImg.style.height = '';
                });
            } else {
                activeImage.style.width = size === 'kecil' ? '25%' : size === 'sedang' ? '50%' : '100%';
            }
            syncVisualToRaw();
        };

        window.setImageAlign = function(align) {
            if (!activeImage) return;
            const sideCard = activeImage.closest('.content-side-by-side');
            const carouselCard = activeImage.closest('.content-carousel');
            if (sideCard) {
                const imgCol = sideCard.querySelector('.side-image-col');
                if (align === 'kanan') {
                    sideCard.classList.add('image-right');
                    sideCard.classList.remove('image-center', 'md:flex-row');
                    if (imgCol && imgCol.style.maxWidth === '100%') {
                        imgCol.style.flex = '0 0 65%';
                        imgCol.style.maxWidth = '65%';
                        imgCol.style.width = '65%';
                    } else if (imgCol && imgCol.style.maxWidth) {
                        imgCol.style.flex = `0 0 ${imgCol.style.maxWidth}`;
                    }
                } else if (align === 'tengah') {
                    sideCard.classList.add('image-center');
                    sideCard.classList.remove('image-right', 'md:flex-row-reverse');
                    if (imgCol) {
                        imgCol.style.flex = '0 0 auto';
                    }
                } else {
                    sideCard.classList.remove('image-right', 'md:flex-row-reverse', 'image-center');
                    if (imgCol && imgCol.style.maxWidth === '100%') {
                        imgCol.style.flex = '0 0 65%';
                        imgCol.style.maxWidth = '65%';
                        imgCol.style.width = '65%';
                    } else if (imgCol && imgCol.style.maxWidth) {
                        imgCol.style.flex = `0 0 ${imgCol.style.maxWidth}`;
                    }
                }
            } else if (carouselCard) {
                if (align === 'kiri') {
                    carouselCard.style.marginLeft = '0';
                    carouselCard.style.marginRight = 'auto';
                } else if (align === 'kanan') {
                    carouselCard.style.marginLeft = 'auto';
                    carouselCard.style.marginRight = '0';
                } else {
                    carouselCard.style.marginLeft = 'auto';
                    carouselCard.style.marginRight = 'auto';
                }
            } else {
                if (align === 'tengah') {
                    activeImage.style.display = 'block';
                    activeImage.style.float = 'none';
                    activeImage.style.margin = '1.5rem auto';
                } else {
                    activeImage.style.display = 'inline';
                    activeImage.style.float = align === 'kiri' ? 'left' : 'right';
                    activeImage.style.margin = align === 'kiri' ? '0.25rem 1.25rem 0.5rem 0' : '0.25rem 0 0.5rem 1.25rem';
                }
            }
            syncVisualToRaw();
        };
        
        window.insertClearfixAfterImage = function() {
            if (!activeImage) return;
            const sideCard = activeImage.closest('.content-side-by-side');
            const carouselCard = activeImage.closest('.content-carousel');
            let targetElement = sideCard || carouselCard || activeImage;
            if (!sideCard && !carouselCard && activeImage.parentNode && activeImage.parentNode.tagName === 'DIV' && activeImage.parentNode.style.clear === 'both') {
                targetElement = activeImage.parentNode;
            }

            const clearDiv = document.createElement('div');
            clearDiv.style.clear = 'both';
            clearDiv.innerHTML = '<p><br></p>';
            
            targetElement.parentNode.insertBefore(clearDiv, targetElement.nextSibling);
            
            const range = document.createRange();
            const sel = window.getSelection();
            range.setStart(clearDiv, 0);
            range.collapse(true);
            sel.removeAllRanges();
            sel.addRange(range);
            
            visualEditor.focus();
            syncVisualToRaw();
        };

        window.deleteActiveImage = function() {
            if (!activeImage) return;
            const sideCard = activeImage.closest('.content-side-by-side');
            const carouselCard = activeImage.closest('.content-carousel');
            if (sideCard) {
                sideCard.remove();
            } else if (carouselCard) {
                carouselCard.remove();
            } else if (activeImage.parentNode && activeImage.parentNode.tagName === 'DIV' && activeImage.parentNode.style.clear === 'both') {
                activeImage.parentNode.remove();
            } else {
                activeImage.remove();
            }
            
            deselectActiveImage();
            syncVisualToRaw();
        };

        // ------------------ MISC LISTENERS ------------------
        inputJudul.addEventListener('input', function() { previewJudul.innerText = this.value.trim() || 'Judul Informasi Akan Muncul Di Sini...'; });
        inputCaption.addEventListener('input', function() { captionText.innerText = this.value.trim() || 'Deskripsi gambar akan muncul di sini...'; });

        if (inputLampiranUrl) {
            inputLampiranUrl.addEventListener('input', function() {
                if(this.value.trim() !== '') {
                    previewLampiranLink.href = this.value.trim();
                    previewLampiranContainer.classList.remove('hidden');
                } else { previewLampiranContainer.classList.add('hidden'); }
            });
            inputLampiranUrl.dispatchEvent(new Event('input'));
        }

        if(inputThumbnail) {
            inputThumbnail.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewThumbnailImage.src = e.target.result;
                        previewThumbnailContainer.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // ------------------ GALERI GAMBAR BARU (LOCAL) ------------------
        const inputMultiImages = document.getElementById('inputMultiImages');
        const hiddenMultiImages = document.getElementById('hiddenMultiImages');
        const multiImageList = document.getElementById('multiImageList');
        let selectedFiles = [];

        inputMultiImages.addEventListener('change', function() {
            Array.from(this.files).forEach(file => {
                if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                    selectedFiles.push(file);
                    localBlobMap.set(file.name, URL.createObjectURL(file));
                }
            });
            updateMultiImageUI();
            this.value = '';
        });

        function updateMultiImageUI() {
            multiImageList.innerHTML = '';
            if (selectedFiles.length === 0) {
                if (document.getElementById('emptyListNotice')) {
                    multiImageList.appendChild(document.getElementById('emptyListNotice'));
                }
                syncHiddenInput();
                return;
            }

            selectedFiles.forEach((file, index) => {
                const item = document.createElement('div');
                item.className = 'flex items-center justify-between p-2 bg-blue-50 border border-blue-100 rounded-md shadow-sm text-xs';
                
                const fileInfo = document.createElement('div');
                fileInfo.className = 'flex items-center gap-2 truncate';
                
                const img = document.createElement('img');
                img.className = 'w-7 h-7 object-cover rounded border bg-white border-gray-200';
                img.src = localBlobMap.get(file.name) || '';
                
                const spanName = document.createElement('span');
                spanName.className = 'truncate font-medium text-gray-700 text-sm';
                spanName.innerText = file.name;

                fileInfo.appendChild(img);
                fileInfo.appendChild(spanName);

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'text-red-500 hover:text-white hover:bg-red-500 font-bold p-1.5 rounded transition-colors text-sm';
                removeBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                removeBtn.onclick = function() {
                    const removedFileName = selectedFiles[index].name;
                    localBlobMap.delete(removedFileName);
                    selectedFiles.splice(index, 1);

                    if (removedFileName && inputKonten) {
                        const escapeFileName = removedFileName.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                        const imgPattern = new RegExp('<img[^>]*src="[^"]*' + escapeFileName + '"[^>]*>', 'gi');
                        inputKonten.value = inputKonten.value.replace(imgPattern, '');
                        
                        inputKonten.value = inputKonten.value.replace(/<div style="clear: both; margin-bottom: 1rem;">\s*<\/div>/gi, '');

                        syncRawToVisual(); 
                    }
                    updateMultiImageUI();
                };

                item.appendChild(fileInfo);
                item.appendChild(removeBtn);
                multiImageList.appendChild(item);
            });
            syncHiddenInput();
        }

        function syncHiddenInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(file => dt.items.add(file));
            hiddenMultiImages.files = dt.files;
        }

        let imageModalMode = 'normal';
        let carouselSelectedItems = [];

        function updateCarouselFooterUI() {
            const info = document.getElementById('carouselFooterInfo');
            const countSpan = document.getElementById('carouselSelectedCount');
            const confirmBtn = document.getElementById('btnInsertCarouselConfirm');
            if (!info || !confirmBtn) return;

            if (imageModalMode === 'carousel') {
                info.classList.remove('hidden');
                confirmBtn.classList.remove('hidden');
                if (countSpan) countSpan.textContent = carouselSelectedItems.length;
                confirmBtn.disabled = carouselSelectedItems.length < 2;
                confirmBtn.textContent = carouselSelectedItems.length >= 2
                    ? `Sisipkan Carousel (${carouselSelectedItems.length} Gambar)`
                    : 'Sisipkan Carousel';
            } else {
                info.classList.add('hidden');
                confirmBtn.classList.add('hidden');
            }
        }

        window.insertCarouselToContent = function(items, customAlt, withTextbox = false) {
            if (!items || items.length < 2) return;
            const buildCarousel = (useDisplaySrc) => {
                const slidesHtml = items.map((item, idx) => {
                    const src = useDisplaySrc ? (resolveServerImageUrl(item.rawSrc) || item.displaySrc) : item.rawSrc;
                    const alt = customAlt ? `${customAlt} (${idx + 1})` : (item.alt || `Slide ${idx + 1}`);
                    return `        <div class="carousel-slide${idx === 0 ? ' active' : ''}"><img src="${src}" alt="${alt}" draggable="false" /></div>`;
                }).join('\n');
                const dotsHtml = items.map((_, idx) => `<span class="carousel-dot${idx === 0 ? ' active' : ''}" data-index="${idx}"></span>`).join('');
                const carouselBox = `<div class="content-carousel" data-carousel="true" contenteditable="false" style="width: ${withTextbox ? '100%' : '50%'}; max-width: 100%; margin-left: auto; margin-right: auto;">\n    <div class="carousel-track">\n${slidesHtml}\n    </div>\n    <button type="button" class="carousel-btn carousel-prev" aria-label="Sebelumnya">&#10094;</button>\n    <button type="button" class="carousel-btn carousel-next" aria-label="Berikutnya">&#10095;</button>\n    <div class="carousel-dots">${dotsHtml}</div>\n    <div class="carousel-counter">1 / ${items.length}</div>\n</div>`;
                if (withTextbox) {
                    return `\n<div class="content-side-by-side" data-layout="side-by-side">\n    <div class="side-image-col" style="flex: 0 0 50%; max-width: 50%; width: 50%;">\n${carouselBox}\n    </div>\n    <div class="side-text-col text-gray-700 leading-relaxed min-h-[100px] outline-none" style="flex: 1 1 0%; min-width: 0;">\n        <p>Ketik teks atau penjelasan informasi di sini yang berdampingan dengan carousel...</p>\n    </div>\n</div>\n<p><br></p>\n`;
                }
                return `\n${carouselBox}\n<p><br></p>\n`;
            };

            if (currentMode === 'visual') {
                insertBlockAtSavedCursor(buildCarousel(true));
                normalizeEditorImages(visualEditor);
                syncVisualToRaw();
            } else {
                applyTextReplacement(buildCarousel(false), inputKonten.selectionStart, inputKonten.selectionEnd);
                syncRawToVisual();
            }
        };

        window.confirmInsertCarousel = function() {
            if (carouselSelectedItems.length < 2) return;
            const modalAltInput = document.getElementById('modalAltText');
            const customAlt = modalAltInput ? modalAltInput.value.trim() : '';
            const withTextboxEl = document.getElementById('carouselWithTextbox');
            const withTextbox = withTextboxEl ? withTextboxEl.checked : false;
            window.insertCarouselToContent(carouselSelectedItems, customAlt, withTextbox);
            closeImageModal();
        };

        window.openImageModal = function(mode = 'normal') {
            saveEditorSelection();
            imageModalMode = mode;
            carouselSelectedItems = [];
            const withTextboxEl = document.getElementById('carouselWithTextbox');
            if (withTextboxEl) withTextboxEl.checked = false;
            const modalTitle = document.querySelector('#imageModal h3');
            if (modalTitle) {
                modalTitle.textContent = mode === 'carousel'
                    ? 'Pilih Multi-Gambar untuk Carousel (Minimal 2)'
                    : (mode === 'side-by-side' ? 'Sisipkan Gambar Berdampingan dengan Teks' : 'Sisipkan Gambar ke Editor');
            }
            const modalGrid = document.getElementById('modalGalleryGrid');
            const modalAltInput = document.getElementById('modalAltText');
            modalGrid.innerHTML = '';
            if (modalAltInput) modalAltInput.value = '';
            updateCarouselFooterUI();

            if (serverImages.length === 0 && selectedFiles.length === 0) {
                modalGrid.innerHTML = '<div class="col-span-full flex flex-col items-center justify-center py-10 text-gray-400"><svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg><p class="text-sm font-medium">Galeri kosong.</p></div>';
            } else {
                const allItems = [
                    ...serverImages.map(imgData => ({ rawSrc: imgData.url, displaySrc: imgData.url, alt: imgData.name, badge: 'Server', badgeCls: 'bg-green-100 text-green-700' })),
                    ...selectedFiles.map(file => ({ rawSrc: file.name, displaySrc: localBlobMap.get(file.name) || '', alt: file.name, badge: 'Baru', badgeCls: 'bg-amber-100 text-amber-700' }))
                ];

                const renderCards = () => {
                    modalGrid.innerHTML = '';
                    allItems.forEach(item => {
                        const selIdx = carouselSelectedItems.findIndex(x => x.rawSrc === item.rawSrc);
                        const isPicked = selIdx !== -1;

                        const card = document.createElement('div');
                        card.className = `relative border-2 rounded-lg p-2 bg-white flex flex-col items-center gap-2.5 shadow-sm transition-all ${mode === 'carousel' ? 'cursor-pointer ' + (isPicked ? 'border-purple-600 ring-2 ring-purple-200 bg-purple-50/40' : 'border-gray-200 hover:border-purple-300') : 'border-gray-200 hover:border-blue-300'}`;

                        const imgContainer = document.createElement('div');
                        imgContainer.className = 'relative w-full';

                        const img = document.createElement('img');
                        img.src = item.displaySrc;
                        img.className = 'w-full h-24 object-contain rounded border bg-gray-50';

                        const badge = document.createElement('span');
                        badge.className = `absolute top-1 left-1 text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm ${item.badgeCls}`;
                        badge.innerText = item.badge;

                        imgContainer.appendChild(img);
                        imgContainer.appendChild(badge);

                        if (mode === 'carousel') {
                            const orderBadge = document.createElement('span');
                            orderBadge.className = `absolute top-1 right-1 w-6 h-6 rounded-full text-xs font-black flex items-center justify-center shadow ${isPicked ? 'bg-purple-600 text-white' : 'bg-white/90 text-gray-400 border border-gray-300'}`;
                            orderBadge.textContent = isPicked ? (selIdx + 1) : '+';
                            imgContainer.appendChild(orderBadge);

                            card.onclick = () => {
                                const existing = carouselSelectedItems.findIndex(x => x.rawSrc === item.rawSrc);
                                if (existing !== -1) {
                                    carouselSelectedItems.splice(existing, 1);
                                } else {
                                    carouselSelectedItems.push({ rawSrc: item.rawSrc, displaySrc: item.displaySrc, alt: item.alt });
                                }
                                updateCarouselFooterUI();
                                renderCards();
                            };

                            const lbl = document.createElement('div');
                            lbl.className = `w-full text-center text-xs font-bold py-1 rounded ${isPicked ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700'}`;
                            lbl.textContent = isPicked ? `Urutan #${selIdx + 1} (Klik batal)` : 'Pilih untuk Carousel';
                            card.appendChild(imgContainer);
                            card.appendChild(lbl);
                        } else {
                            const btnSelect = document.createElement('button');
                            btnSelect.type = 'button';
                            btnSelect.className = 'w-full py-1.5 bg-blue-600 text-white text-xs font-bold rounded hover:bg-blue-700 transition-colors';
                            btnSelect.innerText = mode === 'side-by-side' ? 'Sisipkan + Teks' : 'Sisipkan';
                            btnSelect.onclick = function() {
                                const alt = modalAltInput && modalAltInput.value.trim() ? modalAltInput.value.trim() : item.alt;
                                if (imageModalMode === 'side-by-side') {
                                    insertSideBySideTagToContent(item.rawSrc, alt);
                                } else {
                                    insertImageTagToContent(item.rawSrc, alt);
                                }
                                closeImageModal();
                            };
                            card.appendChild(imgContainer);
                            card.appendChild(btnSelect);
                        }

                        modalGrid.appendChild(card);
                    });
                };
                renderCards();
            }
            document.getElementById('imageModal').classList.remove('hidden');
        };

        window.openCarouselModal = function() {
            window.openImageModal('carousel');
        };

        window.closeImageModal = function() {
            document.getElementById('imageModal').classList.add('hidden');
            imageModalMode = 'normal';
            carouselSelectedItems = [];
            updateCarouselFooterUI();
        };
        window.insertSideBySideModal = function() { openImageModal('side-by-side'); };

        window.toggleAdminRevisiField = function() {
            const sel = document.getElementById('adminStatusSelect');
            const box = document.getElementById('adminRevisiBox');
            const txt = document.getElementById('adminKomentarRevisi');
            if (!sel || !box) return;
            if (sel.value === 'Revisi') {
                box.classList.remove('hidden');
                if (txt) txt.setAttribute('required', 'required');
            } else {
                box.classList.add('hidden');
                if (txt) txt.removeAttribute('required');
            }
        };

        window.triggerAdminReject = function() {
            const sel = document.getElementById('adminStatusSelect');
            const box = document.getElementById('adminRevisiBox');
            const txt = document.getElementById('adminKomentarRevisi');
            if (sel) sel.value = 'Revisi';
            if (box) box.classList.remove('hidden');
            if (txt) {
                txt.setAttribute('required', 'required');
                if (txt.value.trim().length >= 3) {
                    const form = document.getElementById('formInformasi');
                    if (form) {
                        const act = document.createElement('input');
                        act.type = 'hidden';
                        act.name = 'action_type';
                        act.value = 'reject_revisi';
                        form.appendChild(act);
                        form.submit();
                    }
                } else {
                    txt.focus();
                    txt.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        };

        @if($lockedHumas)
            visualEditor.setAttribute('contenteditable', 'false');
            visualEditor.classList.add('bg-gray-50', 'opacity-80', 'cursor-not-allowed');
            const judulEl = document.getElementById('inputJudul');
            if (judulEl) judulEl.setAttribute('readonly', 'readonly');
        @endif
        
        window.openPreviewModal = function() { 
            if(!document.getElementById('imageTooltip').classList.contains('hidden')) {
                document.getElementById('imageTooltip').classList.add('hidden'); 
            }
            deselectActiveImage();
            syncVisualToRaw();
            updateLivePreview();
            document.getElementById('previewModal').classList.remove('hidden'); 
            document.body.style.overflow = 'hidden'; 
        };
        
        window.closePreviewModal = function() { document.getElementById('previewModal').classList.add('hidden'); document.body.style.overflow = ''; };

        // ------------------ SERVER IMAGE DELETE (PRESERVED STATE) ------------------
        let activeDeletePath = null;
        let activeDeleteCardElement = null;

        window.openDeleteImageModal = function(filePath, fileName, buttonEl) {
            activeDeletePath = filePath;
            activeDeleteCardElement = buttonEl ? buttonEl.closest('.img-card-item') : null;
            document.getElementById('delete_image_name').innerText = fileName;
            document.getElementById('deleteImageModal').classList.remove('hidden');
        };

        window.closeDeleteImageModal = function() {
            activeDeletePath = null;
            activeDeleteCardElement = null;
            document.getElementById('deleteImageModal').classList.add('hidden');
        };

        function showGalleryAlert(message, type = 'success') {
            const alertBox = document.getElementById('galleryAlert');
            if (!alertBox) return;
            alertBox.className = type === 'success' 
                ? "mb-3 p-3 rounded-md text-sm font-semibold bg-green-50 border border-green-200 text-green-700 flex items-center justify-between shadow-sm"
                : "mb-3 p-3 rounded-md text-sm font-semibold bg-red-50 border border-red-200 text-red-700 flex items-center justify-between shadow-sm";
            alertBox.innerHTML = `<span>${message}</span><button type="button" onclick="this.parentElement.classList.add('hidden')" class="font-bold ml-2 hover:opacity-70">&times;</button>`;
            alertBox.classList.remove('hidden');
            setTimeout(() => alertBox.classList.add('hidden'), 5000);
        }

        document.getElementById('btnConfirmDeleteImage').addEventListener('click', function() {
            if (!activeDeletePath) return;

            const deletedInput = document.createElement('input');
            deletedInput.type = 'hidden';
            deletedInput.name = 'deleted_images[]';
            deletedInput.value = activeDeletePath;
            document.getElementById('deletedImagesContainer').appendChild(deletedInput);

            if (activeDeleteCardElement) activeDeleteCardElement.remove();

            const normDeletePath = activeDeletePath.replace(/\\/g, '/');
            const fileName = normDeletePath.split('/').pop();
            
            if (fileName && inputKonten) {
                const escapeFileName = fileName.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const imgPattern = new RegExp('<img[^>]*src="[^"]*' + escapeFileName + '"[^>]*>', 'gi');
                inputKonten.value = inputKonten.value.replace(imgPattern, '');
                inputKonten.value = inputKonten.value.replace(/<div style="clear: both; margin-bottom: 1rem;">\s*<\/div>/gi, '');
                
                syncRawToVisual(); 
            }

            serverImages = serverImages.filter(img => img.path.replace(/\\/g, '/') !== normDeletePath);

            closeDeleteImageModal();
            showGalleryAlert("Gambar dihapus sementara dari galeri. Klik 'Perbarui Informasi' untuk menghapus permanen.", 'success');
            
            const galleryContainer = document.getElementById('galleryContainer');
            if(galleryContainer && galleryContainer.children.length === 0) {
                document.getElementById('galleryWrapper').innerHTML = '<p class="text-xs text-gray-400 italic" id="emptyGalleryNotice">Belum ada gambar tambahan yang tersimpan di galeri informasi ini.</p>';
            }
        });

        let historyStack = [];
        let historyIndex = -1;
        function saveHistory() {
            if(inputKonten.value === historyStack[historyIndex]?.value) return;
            historyStack = historyStack.slice(0, historyIndex + 1);
            historyStack.push({ value: inputKonten.value });
            historyIndex++;
            if (historyStack.length > 50) { historyStack.shift(); historyIndex--; }
        }
    });
</script>
@endpush