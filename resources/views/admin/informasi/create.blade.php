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
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-6">
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('admin.informasi.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 flex items-center gap-1 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm">
            <ul class="list-disc pl-5 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.informasi.store') }}" method="POST" enctype="multipart/form-data" id="formInformasi">
        @csrf
        <div class="flex flex-col lg:flex-row gap-6 mb-8">
            <!-- KOLOM KIRI -->
            <div class="w-full lg:w-3/4 space-y-4">
                <!-- Judul Informasi -->
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Informasi <span class="text-red-500">*</span></label>
                    <input type="text" id="inputJudul" name="judul_berita" value="{{ old('judul_berita') }}" placeholder="Ketik judul informasi di sini..." 
                        class="w-full text-xl md:text-xl font-bold p-2.5 bg-gray-50 border border-gray-300 rounded-md focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all placeholder-gray-400" required autofocus>
                </div>

                <!-- Editor Konten -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-3 border-b border-gray-100 bg-gray-50 rounded-t-lg">
                        <label class="block text-sm font-bold text-gray-700">Konten Informasi <span class="text-red-500">*</span></label>
                    </div>
                    
                    <!-- TOOLBOX FORMATTING -->
                    <div class="sticky -top-4 sm:-top-6 lg:-top-8 z-[50] flex flex-col gap-1.5 bg-white border-b border-gray-200 px-2.5 py-2 w-full shadow-sm" id="editorHeader">
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
                    <div class="relative w-full bg-white rounded-b-md focus-within:ring-2 focus-within:ring-blue-200">
                        <div id="visualEditor" contenteditable="true" spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off" class="content-editor-style clearfix w-full p-6 text-gray-800 min-h-[500px] outline-none leading-relaxed">{!! old('konten') !!}</div>
                        <textarea name="konten" id="inputKonten" rows="20" placeholder="Mulai menulis konten HTML di sini..." class="hidden w-full p-6 bg-gray-900 text-gray-100 font-mono resize-y min-h-[500px] outline-none">{{ old('konten') }}</textarea>
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
            </div>

            <!-- KOLOM KANAN -->
            <div class="w-full lg:w-1/4 space-y-6">
                <!-- Box Publikasi -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 font-bold text-gray-800 flex items-center justify-between">
                        <span>Publikasi</span>
                        <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full bg-gray-200 text-gray-700">Baru</span>
                    </div>
                    <div class="p-4 space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Status Awal <span class="text-red-500">*</span></label>
                            <select name="status" id="selectStatusPublikasi" required class="w-full text-sm bg-white border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-colors">
                                <option value="Draft" {{ old('status', 'Draft') == 'Draft' ? 'selected' : '' }}>Konsep (Draft)</option>
                                <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Ajukan Review (Pending)</option>
                                @if($userRole === 'admin')
                                    <option value="Terbit" {{ old('status') == 'Terbit' ? 'selected' : '' }}>Langsung Terbitkan</option>
                                @endif
                            </select>
                        </div>

                        <div class="space-y-2 pt-1">
                            <button type="submit" name="action_type" value="save_draft" class="w-full py-2 px-4 border border-gray-300 rounded-md shadow-xs text-xs font-bold text-gray-800 bg-gray-100 hover:bg-gray-200 transition-colors">
                                Simpan sebagai Draft
                            </button>

                            <button type="submit" name="action_type" value="submit_review" class="w-full py-2.5 px-4 border border-transparent rounded-md shadow-sm text-xs font-bold text-white bg-amber-500 hover:bg-amber-600 transition-colors">
                                Submit untuk Review (Pending)
                            </button>

                            @if($userRole === 'admin')
                                <button type="submit" name="action_type" value="publish" class="w-full py-2.5 px-4 border border-transparent rounded-md shadow-sm text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition-colors">
                                    Terbitkan Langsung
                                </button>
                            @endif
                        </div>

                        @if($userRole === 'pegawai_humas')
                            <p class="text-[11px] text-gray-500 leading-snug bg-amber-50 border border-amber-200 rounded p-2">
                                Simpan sebagai <b>Draft</b> jika masih menyusun, atau klik <b>Submit untuk Review</b> agar Admin dapat memeriksa dan menerbitkan informasi resmi.
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Box Thumbnail -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 font-bold text-gray-800">Thumbnail Informasi</div>
                    <div class="p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Unggah Gambar Utama <span class="text-red-500">*</span></label>
                        <input type="file" name="thumbnail" id="inputThumbnail" accept="image/jpeg, image/png, image/jpg, image/webp" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 bg-white border border-gray-300 rounded-md transition-colors">
                        <p class="text-[11px] text-amber-600 mt-1.5 font-medium">* Disarankan rasio 16:9 (contoh: 1280x720 px).</p>

                        <label class="block text-sm font-medium text-gray-700 mt-4 mb-1">Keterangan Gambar (Caption) <span class="text-red-500">*</span></label>
                        <input type="text" id="inputCaption" name="caption_thumbnail" maxlength="150" value="{{ old('caption_thumbnail') }}" placeholder="Tulis caption gambar di sini..." class="w-full text-sm p-2.5 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors" required>
                    </div>
                </div>

                <!-- Box Multi-Images -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 font-bold text-gray-800">Galeri Tambahan</div>
                    <div class="p-4 space-y-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih File Gambar</label>
                        <input type="file" id="inputMultiImages" multiple accept="image/jpeg, image/png, image/jpg, image/webp" class="w-full text-sm text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 bg-white border border-gray-300 rounded-md transition-colors">
                        
                        <input type="file" name="multi_images[]" id="hiddenMultiImages" multiple class="hidden">

                        <div id="multiImageList" class="space-y-2 mt-3 max-h-48 overflow-y-auto pr-1">
                            <p class="text-xs text-gray-400 italic text-center py-2 border border-dashed border-gray-200 rounded" id="emptyListNotice">Belum ada gambar terpilih.</p>
                        </div>
                    </div>
                </div>

                <!-- Box File Lampiran -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 font-bold text-gray-800">Dokumen Lampiran</div>
                    <div class="p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tautan Dokumen (Opsional)</label>
                        <input type="url" name="lampiran_url" id="inputLampiranUrl" value="{{ old('lampiran_url') }}" placeholder="https://drive.google.com/..." class="w-full bg-white border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 text-sm transition-colors">
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
                    Judul Informasi Akan Muncul Di Sini...
                </h1>
                
                <div class="flex items-center gap-4 text-sm text-gray-500 pb-6 border-b border-gray-100 mb-8">
                    <span>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                    <span>•</span>
                    <span>Admin / Penulis</span>
                </div>

                <div id="previewThumbnailContainer" class="hidden mb-10 rounded-xl overflow-hidden border border-gray-200 relative aspect-video bg-gray-100 flex items-center justify-center shadow-inner">
                    <img id="previewThumbnailImage" src="" alt="Preview Thumbnail" class="relative z-10 max-h-full max-w-full object-contain">
                    <p id="previewThumbnailCaption" class="absolute bottom-0 inset-x-0 z-20 text-sm text-gray-700 italic py-3 px-4 text-center bg-white/95 backdrop-blur-sm border-t border-gray-200">
                        <span id="captionText">Deskripsi gambar akan muncul di sini...</span>
                    </p>
                </div>

                <div id="previewKonten" class="content-editor-style clearfix text-gray-800 leading-relaxed">
                    <p class="text-gray-400 italic text-center py-10">Konten informasi akan diperbarui secara otomatis saat Anda mengetik di editor...</p>
                </div>

                <div id="previewLampiranContainer" class="mt-10 pt-8 border-t border-gray-200 hidden">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 flex items-center justify-between gap-4 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-blue-100 rounded-lg text-blue-600 shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-gray-900">Dokumen Lampiran Informasi</h4>
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
@endpush

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentMode = 'visual';
        
        const ui = {
            inputJudul: document.getElementById('inputJudul'),
            inputKonten: document.getElementById('inputKonten'),
            visualEditor: document.getElementById('visualEditor'),
            inputThumbnail: document.getElementById('inputThumbnail'),
            inputCaption: document.getElementById('inputCaption'),
            inputLampiranUrl: document.getElementById('inputLampiranUrl'),
            
            previewJudul: document.getElementById('previewJudul'),
            previewKonten: document.getElementById('previewKonten'),
            previewThumbnailContainer: document.getElementById('previewThumbnailContainer'),
            previewThumbnailImage: document.getElementById('previewThumbnailImage'),
            captionText: document.getElementById('captionText'),
            previewLampiranContainer: document.getElementById('previewLampiranContainer'),
            previewLampiranLink: document.getElementById('previewLampiranLink'),
            
            tooltip: document.getElementById('imageTooltip'),
        };
        
        const localBlobMap = new Map();
        const storageBaseUrl = "{{ rtrim(asset('storage'), '/') }}";
        let activeImage = null;
        let savedEditorRange = null;

        function saveEditorSelection() {
            if (currentMode !== 'visual') return;
            const sel = window.getSelection();
            if (!sel || sel.rangeCount === 0) return;
            const range = sel.getRangeAt(0);
            if (ui.visualEditor.contains(range.commonAncestorContainer)) {
                savedEditorRange = range.cloneRange();
            }
        }

        function insertBlockAtSavedCursor(htmlString) {
            const editor = ui.visualEditor;
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

        syncRawToVisual();

        ui.visualEditor.addEventListener('focus', function() {
            if (this.innerHTML.trim() === '' || this.innerHTML === '<br>') {
                document.execCommand('formatBlock', false, 'DIV');
            }
        });

        ui.visualEditor.addEventListener('keyup', function(e) {
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

        function resolveEditorImageUrl(rawSrc) {
            if (!rawSrc) return null;
            const cleaned = rawSrc.trim();
            if (cleaned.startsWith('blob:') || cleaned.startsWith('data:')) return cleaned;
            if (localBlobMap.has(cleaned)) return localBlobMap.get(cleaned);
            try {
                const decoded = decodeURIComponent(cleaned);
                if (localBlobMap.has(decoded)) return localBlobMap.get(decoded);
            } catch (e) {}
            const storageMatch = cleaned.match(/(?:^|\/)storage\/(.+)$/i);
            if (storageMatch && storageMatch[1]) {
                return storageBaseUrl + '/' + storageMatch[1].replace(/^\/+/, '');
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
                if (container === ui.previewKonten) {
                    img.classList.remove('editor-selected-img');
                }
                const currentSrc = img.getAttribute('src') || '';
                const fixedSrc = resolveEditorImageUrl(currentSrc);
                if (fixedSrc && fixedSrc !== currentSrc) {
                    img.setAttribute('src', fixedSrc);
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

        function syncVisualToRaw() {
            let html = ui.visualEditor.innerHTML;
            html = html.replace(/\s*outline(?:-(?:color|style|width|offset))?:\s*[^;"']*;?/gi, '');
            html = html.replace(/\beditor-selected-img\b/gi, '');
            localBlobMap.forEach((blobUrl, fileName) => {
                const escapedBlob = blobUrl.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const srcRegex = new RegExp(`(src=["'])${escapedBlob}(["'])`, 'g');
                html = html.replace(srcRegex, `$1${fileName}$2`);
            });
            html = formatHTML(html);

            if (ui.inputKonten.value !== html) {
                ui.inputKonten.value = html;
                updateLivePreview();
                saveHistory();
            }
        }

        function syncRawToVisual() {
            let rawText = ui.inputKonten.value;
            localBlobMap.forEach((blobUrl, fileName) => {
                const escapedName = fileName.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const encodedName = encodeURIComponent(fileName).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const srcRegex = new RegExp(`(src=["'])(?:${escapedName}|${encodedName})(["'])`, 'g');
                rawText = rawText.replace(srcRegex, `$1${blobUrl}$2`);
            });
            ui.visualEditor.innerHTML = rawText;
            normalizeEditorImages(ui.visualEditor);
            updateLivePreview();
        }

        function updateLivePreview() {
            let rawText = ui.inputKonten.value.trim();
            if (rawText) {
                localBlobMap.forEach((blobUrl, fileName) => {
                    const escapedName = fileName.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                    const encodedName = encodeURIComponent(fileName).replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                    const srcRegex = new RegExp(`(src=["'])(?:${escapedName}|${encodedName})(["'])`, 'g');
                    rawText = rawText.replace(srcRegex, `$1${blobUrl}$2`);
                });
                ui.previewKonten.innerHTML = rawText;
                normalizeEditorImages(ui.previewKonten);
            } else {
                ui.previewKonten.innerHTML = '<p class="text-gray-400 italic text-center py-10">Konten informasi akan diperbarui secara otomatis saat Anda mengetik di editor...</p>';
            }
        }

        ui.visualEditor.addEventListener('input', syncVisualToRaw);
        ui.inputKonten.addEventListener('input', syncRawToVisual);

        window.switchMode = function(mode) {
            currentMode = mode;
            const btnV = document.getElementById('btnModeVisual');
            const btnR = document.getElementById('btnModeRaw');
            
            if (mode === 'visual') {
                btnV.className = 'px-3 py-1.5 bg-white shadow-sm text-xs font-bold rounded text-gray-800 transition-all';
                if(btnR) btnR.className = 'px-3 py-1.5 text-xs font-bold rounded text-gray-600 hover:bg-gray-200 transition-all';
                syncRawToVisual();
                ui.inputKonten.classList.add('hidden');
                ui.visualEditor.classList.remove('hidden');
            } else {
                if(btnR) btnR.className = 'px-3 py-1.5 bg-white shadow-sm text-xs font-bold rounded text-gray-800 transition-all';
                btnV.className = 'px-3 py-1.5 text-xs font-bold rounded text-gray-600 hover:bg-gray-200 transition-all';
                syncVisualToRaw();
                ui.visualEditor.classList.add('hidden');
                ui.inputKonten.classList.remove('hidden');
            }
            ui.tooltip.classList.add('hidden');
        };

        // Helper untuk mencari elemen blok terdekat di dalam editor
        function getClosestEditorBlock(node, tagNames) {
            while (node && node !== ui.visualEditor) {
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
            return ui.visualEditor.textContent.replace(/\u200B/g, '').trim() === '';
        }

        // ------------------ MODE PENANDA FORMATTING (MS WORD STYLE) ------------------
        window.toggleFormatMarks = function() {
            const isActive = ui.visualEditor.classList.toggle('show-format-marks');
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
            if (!sel || !sel.anchorNode || !ui.visualEditor.contains(sel.anchorNode)) return;

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
        ui.visualEditor.addEventListener('keyup', () => {
            saveEditorSelection();
            updateActiveFormatIndicators();
        });
        ui.visualEditor.addEventListener('mouseup', () => {
            saveEditorSelection();
            updateActiveFormatIndicators();
        });

        function applyTextReplacement(replacementText, selectStart, selectEnd) {
            ui.inputKonten.focus();
            if (typeof ui.inputKonten.setRangeText === 'function') {
                ui.inputKonten.setRangeText(replacementText, selectStart, selectEnd, 'select');
            } else {
                ui.inputKonten.setSelectionRange(selectStart, selectEnd);
                document.execCommand('insertText', false, replacementText);
            }
        }

        window.formatText = function(tagStart, tagEnd, execCmd) {
            if (currentMode === 'visual') {
                ui.visualEditor.focus();
                const sel = window.getSelection();
                if (execCmd === 'formatBlock') {
                    const blockTag = tagStart.replace(/<|>/g, '').toUpperCase();
                    const existingBlock = sel && sel.anchorNode ? getClosestEditorBlock(sel.anchorNode, [blockTag]) : null;
                    
                    if (existingBlock) {
                        document.execCommand('formatBlock', false, 'DIV');
                        if (existingBlock.parentNode && existingBlock.parentNode.contains(existingBlock)) {
                            while (existingBlock.firstChild) {
                                existingBlock.parentNode.insertBefore(existingBlock.firstChild, existingBlock);
                            }
                            existingBlock.remove();
                        }
                    } else if (isCurrentLineEmpty(sel)) {
                        const tempId = 'tpl-' + Date.now();
                        document.execCommand('insertHTML', false, `<blockquote id="${tempId}">Ketik kutipan teks di sini...</blockquote>`);
                        const inserted = document.getElementById(tempId);
                        if (inserted) {
                            inserted.removeAttribute('id');
                            selectElementContents(inserted);
                        }
                    } else {
                        document.execCommand('formatBlock', false, blockTag);
                    }
                } else if (execCmd) {
                    const isAlreadyActive = (() => { try { return document.queryCommandState(execCmd); } catch (e) { return false; } })();
                    if (sel && sel.isCollapsed && !isAlreadyActive) {
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
            } else {
                const start = ui.inputKonten.selectionStart;
                const end = ui.inputKonten.selectionEnd;
                const text = ui.inputKonten.value;
                const selectedText = text.substring(start, end);
                
                if (selectedText.startsWith(tagStart) && selectedText.endsWith(tagEnd)) {
                    const unwrapped = selectedText.slice(tagStart.length, -tagEnd.length);
                    applyTextReplacement(unwrapped, start, end);
                    ui.inputKonten.setSelectionRange(start, start + unwrapped.length);
                } else {
                    const wrapped = tagStart + selectedText + tagEnd;
                    applyTextReplacement(wrapped, start, end);
                    ui.inputKonten.setSelectionRange(
                        selectedText ? start : start + tagStart.length,
                        selectedText ? start + wrapped.length : start + tagStart.length
                    );
                }
                syncRawToVisual();
            }
        };

        window.applyHeader = function() {
            const select = document.getElementById('formatHeader');
            const targetTag = (select.value || '').toUpperCase();
            if (!targetTag) return;

            if (currentMode === 'visual') {
                ui.visualEditor.focus();
                const sel = window.getSelection();
                const currentH = sel && sel.anchorNode ? getClosestEditorBlock(sel.anchorNode, ['H2', 'H3', 'H4', 'H5', 'H6']) : null;
                
                if (currentH && currentH.nodeName === targetTag) {
                    document.execCommand('formatBlock', false, 'DIV');
                } else if (!currentH && isCurrentLineEmpty(sel)) {
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
                const start = ui.inputKonten.selectionStart;
                const end = ui.inputKonten.selectionEnd;
                const selectedText = ui.inputKonten.value.substring(start, end);
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
                ui.visualEditor.focus();
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
                        document.execCommand(isUL ? 'insertUnorderedList' : 'insertOrderedList', false, null);
                    } else if (val === 'ul') {
                        document.execCommand('insertUnorderedList', false, null);
                    } else if (isUL && val.startsWith('ol-')) {
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
                        currentList.style.listStyleType = val === 'ol-a' ? 'lower-alpha' : (val === 'ol-i' ? 'lower-roman' : 'decimal');
                    }
                } else if (isCurrentLineEmpty(sel)) {
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
                const start = ui.inputKonten.selectionStart;
                const end = ui.inputKonten.selectionEnd;
                const tag = val === 'ul' ? 'ul' : 'ol';
                let style = '';
                if(val === 'ol-a') style = ' style="list-style-type: lower-alpha;"';
                if(val === 'ol-i') style = ' style="list-style-type: lower-roman;"';
                
                let liItems = `\n  <li>${ui.inputKonten.value.substring(start, end)}</li>\n`;
                applyTextReplacement(`\n<${tag}${style}>${liItems}</${tag}>\n`, start, end);
                syncRawToVisual();
            }
            select.value = "";
        };

        window.insertImageTagToContent = function(srcUrl, altText) {
            const finalAlt = altText || 'Gambar Informasi';
            const displaySrc = resolveEditorImageUrl(srcUrl) || srcUrl;
            const imgHtmlVisual = `\n<div style="clear: both; margin-bottom: 1rem;">\n<img src="${displaySrc}" class="max-w-full h-auto rounded-lg shadow-sm" alt="${finalAlt}" style="display: block; margin: 1.5rem auto; width: 100%;" draggable="true" />\n</div>\n`;
            const imgHtmlRaw = `\n<div style="clear: both; margin-bottom: 1rem;">\n<img src="${srcUrl}" class="max-w-full h-auto rounded-lg shadow-sm" alt="${finalAlt}" style="display: block; margin: 1.5rem auto; width: 100%;" draggable="true" />\n</div>\n`;
            
            if (currentMode === 'visual') {
                insertBlockAtSavedCursor(imgHtmlVisual);
                normalizeEditorImages(ui.visualEditor);
                syncVisualToRaw();
            } else {
                applyTextReplacement(imgHtmlRaw, ui.inputKonten.selectionStart, ui.inputKonten.selectionEnd);
                syncRawToVisual();
            }
        };

        window.insertSideBySideTagToContent = function(srcUrl, altText) {
            const finalAlt = altText || 'Gambar Informasi';
            const displaySrc = resolveEditorImageUrl(srcUrl) || srcUrl;
            const buildCard = (src) => `\n<div class="content-side-by-side" data-layout="side-by-side">\n    <div class="side-image-col" style="flex: 0 0 50%; max-width: 50%; width: 50%;">\n        <img src="${src}" class="max-w-full h-auto rounded-lg shadow-sm mx-auto" alt="${finalAlt}" style="width: 100%;" draggable="false" />\n    </div>\n    <div class="side-text-col text-gray-700 leading-relaxed min-h-[100px] outline-none" style="flex: 1 1 0%; min-width: 0;">\n        <p>Ketik teks atau penjelasan informasi di sini yang berdampingan dengan gambar...</p>\n    </div>\n</div>\n<p><br></p>\n`;
            
            if (currentMode === 'visual') {
                insertBlockAtSavedCursor(buildCard(displaySrc));
                normalizeEditorImages(ui.visualEditor);
                syncVisualToRaw();
            } else {
                applyTextReplacement(buildCard(srcUrl), ui.inputKonten.selectionStart, ui.inputKonten.selectionEnd);
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
                    initEditorCarousels(ui.visualEditor);
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
                initEditorCarousels(ui.visualEditor);
            } else {
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

        function ensureDirectBlockChildren(editorEl) {
            Array.from(editorEl.childNodes).forEach(node => {
                if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() !== '') {
                    const wrapper = document.createElement('div');
                    editorEl.insertBefore(wrapper, node);
                    wrapper.appendChild(node);
                }
            });
        }

        function getTopLevelImageBlock(img, extractIfMixed = false) {
            if (!img || !ui.visualEditor.contains(img)) return null;
            const sideCard = img.closest('.content-side-by-side');
            if (sideCard && ui.visualEditor.contains(sideCard)) return sideCard;
            const carouselCard = img.closest('.content-carousel');
            if (carouselCard && ui.visualEditor.contains(carouselCard)) return carouselCard;

            let el = img;
            while (el.parentNode && el.parentNode !== ui.visualEditor) {
                el = el.parentNode;
            }

            if (extractIfMixed && el !== img && el.textContent.replace(/\u200B/g, '').trim() !== '') {
                const wrapper = document.createElement('div');
                wrapper.style.clear = 'both';
                wrapper.style.marginBottom = '1rem';
                ui.visualEditor.insertBefore(wrapper, el);
                wrapper.appendChild(img);
                return wrapper;
            }

            return el;
        }

        window.moveActiveImageBlock = function(direction) {
            if (!activeImage) return;
            ensureDirectBlockChildren(ui.visualEditor);
            const block = getTopLevelImageBlock(activeImage, true);
            if (!block || block.parentNode !== ui.visualEditor) return;

            if (direction === 'up') {
                const prev = block.previousElementSibling;
                if (prev) {
                    ui.visualEditor.insertBefore(block, prev);
                    block.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    syncVisualToRaw();
                }
            } else if (direction === 'down') {
                const next = block.nextElementSibling;
                if (next) {
                    ui.visualEditor.insertBefore(block, next.nextSibling);
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

        let justFinishedPointerDrag = false;

        ui.visualEditor.addEventListener('click', function(e) {
            if (justFinishedPointerDrag) return;
            if (e.target.closest && e.target.closest('.carousel-btn, .carousel-dots')) return;
            const carouselHit = e.target.closest ? e.target.closest('.content-carousel') : null;
            const img = e.target.closest('img')
                || (carouselHit ? (carouselHit.querySelector('.carousel-slide.active img') || carouselHit.querySelector('img')) : null);
            if (img && ui.visualEditor.contains(img)) {
                selectEditorImage(img);
            } else if (!e.target.closest('#dockedImageToolbar')) {
                deselectActiveImage();
            }
        });

        ui.visualEditor.addEventListener('keydown', function(e) {
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

        ui.visualEditor.addEventListener('dragstart', function(e) {
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

        ui.visualEditor.addEventListener('mousedown', function(e) {
            if (e.button !== 0 || currentMode !== 'visual') return;
            if (e.target.closest && e.target.closest('.carousel-btn, .carousel-dots')) return;
            const carouselHit = e.target.closest ? e.target.closest('.content-carousel') : null;
            const img = (e.target.closest ? e.target.closest('img') : null)
                || (carouselHit ? (carouselHit.querySelector('.carousel-slide.active img') || carouselHit.querySelector('img')) : null);
            if (!img || !ui.visualEditor.contains(img)) return;

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
                ensureDirectBlockChildren(ui.visualEditor);
                ptrBlock = getTopLevelImageBlock(ptrImg, true);
                if (!ptrBlock || ptrBlock.parentNode !== ui.visualEditor) {
                    ptrImg = null;
                    ptrBlock = null;
                    ptrIsDragging = false;
                    return;
                }

                ui.visualEditor.setAttribute('contenteditable', 'false');
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

            const scrollContainer = ui.visualEditor.closest('main') || document.documentElement;
            if (e.clientY < 130) {
                scrollContainer.scrollTop -= 14;
            } else if (e.clientY > window.innerHeight - 90) {
                scrollContainer.scrollTop += 14;
            }

            const children = Array.from(ui.visualEditor.children).filter(
                el => el !== dropIndicator && el !== ptrBlock
            );

            if (children.length === 0) {
                if (dropIndicator.parentNode !== ui.visualEditor) ui.visualEditor.appendChild(dropIndicator);
                return;
            }

            let inserted = false;
            for (const child of children) {
                const rect = child.getBoundingClientRect();
                const midY = rect.top + (rect.height / 2);
                if (e.clientY < midY) {
                    if (child.previousSibling !== dropIndicator) {
                        ui.visualEditor.insertBefore(dropIndicator, child);
                    }
                    inserted = true;
                    break;
                }
            }

            if (!inserted) {
                if (ui.visualEditor.lastChild !== dropIndicator) {
                    ui.visualEditor.appendChild(dropIndicator);
                }
            }
        });

        window.addEventListener('mouseup', function() {
            if (!ptrImg) return;

            if (ptrIsDragging && ptrBlock) {
                if (dropIndicator.parentNode === ui.visualEditor) {
                    ui.visualEditor.insertBefore(ptrBlock, dropIndicator);
                    dropIndicator.remove();
                }

                ptrBlock.style.opacity = '1';
                ui.visualEditor.setAttribute('contenteditable', 'true');
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
            
            ui.visualEditor.focus();
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

        ui.inputJudul.addEventListener('input', e => { ui.previewJudul.innerText = e.target.value.trim() || 'Judul Informasi Akan Muncul Di Sini...'; });
        ui.inputCaption.addEventListener('input', e => { ui.captionText.innerText = e.target.value.trim() || 'Deskripsi gambar akan muncul di sini...'; });

        if (ui.inputLampiranUrl) {
            ui.inputLampiranUrl.addEventListener('input', e => {
                if(e.target.value.trim()) {
                    ui.previewLampiranLink.href = e.target.value.trim();
                    ui.previewLampiranContainer.classList.remove('hidden');
                } else {
                    ui.previewLampiranContainer.classList.add('hidden');
                }
            });
        }

        ui.inputThumbnail.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                ui.previewThumbnailImage.src = URL.createObjectURL(file);
                ui.previewThumbnailContainer.classList.remove('hidden');
            } else {
                ui.previewThumbnailContainer.classList.add('hidden');
            }
        });

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
            updateLivePreview();
            this.value = '';
        });

        function updateMultiImageUI() {
            multiImageList.innerHTML = '';
            if (selectedFiles.length === 0) {
                multiImageList.innerHTML = '<p class="text-xs text-gray-400 italic text-center py-2 border border-dashed border-gray-200 rounded" id="emptyListNotice">Belum ada gambar terpilih.</p>';
                syncHiddenInput();
                return;
            }

            selectedFiles.forEach((file, index) => {
                const item = document.createElement('div');
                item.className = 'flex items-center justify-between p-2 bg-blue-50 border border-blue-100 rounded-md shadow-sm';
                
                const fileInfo = document.createElement('div');
                fileInfo.className = 'flex items-center gap-3 truncate';
                
                const img = document.createElement('img');
                img.className = 'w-9 h-9 object-cover rounded bg-white border border-gray-200';
                img.src = localBlobMap.get(file.name) || '';
                
                const spanName = document.createElement('span');
                spanName.className = 'truncate text-sm font-medium text-gray-700';
                spanName.innerText = file.name;

                fileInfo.append(img, spanName);

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'text-red-500 hover:text-white hover:bg-red-500 p-1.5 rounded transition-colors';
                removeBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                removeBtn.onclick = () => removeSelectedFile(index);

                item.append(fileInfo, removeBtn);
                multiImageList.appendChild(item);
            });
            syncHiddenInput();
        }

        function removeSelectedFile(index) {
            const removedFileName = selectedFiles[index].name;
            localBlobMap.delete(removedFileName);
            selectedFiles.splice(index, 1);

            if (removedFileName && ui.inputKonten) {
                const escapeFileName = removedFileName.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                const imgPattern = new RegExp('<img[^>]*src="[^"]*' + escapeFileName + '"[^>]*>', 'gi');
                ui.inputKonten.value = ui.inputKonten.value.replace(imgPattern, '');
                
                ui.inputKonten.value = ui.inputKonten.value.replace(/<div style="clear: both; margin-bottom: 1rem;">\s*<\/div>/gi, '');

                syncRawToVisual(); 
            }
            updateMultiImageUI();
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
                    const src = useDisplaySrc ? (resolveEditorImageUrl(item.rawSrc) || item.displaySrc) : item.rawSrc;
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
                normalizeEditorImages(ui.visualEditor);
                syncVisualToRaw();
            } else {
                applyTextReplacement(buildCarousel(false), ui.inputKonten.selectionStart, ui.inputKonten.selectionEnd);
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

            if (selectedFiles.length === 0) {
                modalGrid.innerHTML = '<div class="col-span-full flex flex-col items-center justify-center py-10 text-gray-400"><svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg><p class="text-sm font-medium">Galeri kosong, tambahkan dari panel kanan.</p></div>';
            } else {
                const renderCards = () => {
                    modalGrid.innerHTML = '';
                    selectedFiles.forEach((file) => {
                        const rawSrc = file.name;
                        const displaySrc = localBlobMap.get(file.name) || '';
                        const selIdx = carouselSelectedItems.findIndex(x => x.rawSrc === rawSrc);
                        const isPicked = selIdx !== -1;

                        const card = document.createElement('div');
                        card.className = `relative border-2 rounded-lg p-2 bg-white flex flex-col gap-2.5 shadow-sm transition-all ${mode === 'carousel' ? 'cursor-pointer ' + (isPicked ? 'border-purple-600 ring-2 ring-purple-200 bg-purple-50/40' : 'border-gray-200 hover:border-purple-300') : 'border-gray-200 hover:border-blue-300'}`;
                        
                        const imgWrap = document.createElement('div');
                        imgWrap.className = 'relative w-full';

                        const img = document.createElement('img');
                        img.src = displaySrc;
                        img.className = 'w-full h-28 object-cover rounded bg-gray-50';
                        imgWrap.appendChild(img);

                        if (mode === 'carousel') {
                            const orderBadge = document.createElement('span');
                            orderBadge.className = `absolute top-1.5 right-1.5 w-6 h-6 rounded-full text-xs font-black flex items-center justify-center shadow ${isPicked ? 'bg-purple-600 text-white' : 'bg-white/90 text-gray-400 border border-gray-300'}`;
                            orderBadge.textContent = isPicked ? (selIdx + 1) : '+';
                            imgWrap.appendChild(orderBadge);

                            card.onclick = () => {
                                const existing = carouselSelectedItems.findIndex(x => x.rawSrc === rawSrc);
                                if (existing !== -1) {
                                    carouselSelectedItems.splice(existing, 1);
                                } else {
                                    carouselSelectedItems.push({ rawSrc, displaySrc, alt: file.name });
                                }
                                updateCarouselFooterUI();
                                renderCards();
                            };

                            const lbl = document.createElement('div');
                            lbl.className = `text-center text-xs font-bold py-1 rounded ${isPicked ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700'}`;
                            lbl.textContent = isPicked ? `Urutan #${selIdx + 1} (Klik batal)` : 'Pilih untuk Carousel';
                            card.append(imgWrap, lbl);
                        } else {
                            const btnSelect = document.createElement('button');
                            btnSelect.type = 'button';
                            btnSelect.className = 'w-full py-1.5 bg-blue-600 text-white text-sm font-bold rounded hover:bg-blue-700 transition-colors';
                            btnSelect.innerText = mode === 'side-by-side' ? 'Sisipkan + Teks' : 'Sisipkan';
                            btnSelect.onclick = () => {
                                const alt = modalAltInput && modalAltInput.value.trim() ? modalAltInput.value.trim() : file.name;
                                if (imageModalMode === 'side-by-side') {
                                    insertSideBySideTagToContent(file.name, alt);
                                } else {
                                    insertImageTagToContent(file.name, alt);
                                }
                                closeImageModal();
                            };
                            card.append(imgWrap, btnSelect);
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

        window.insertSideBySideModal = function() {
            window.openImageModal('side-by-side');
        };

        window.closeImageModal = () => {
            document.getElementById('imageModal').classList.add('hidden');
            imageModalMode = 'normal';
            carouselSelectedItems = [];
            updateCarouselFooterUI();
        };
        
        window.openPreviewModal = () => { 
            if(!ui.tooltip.classList.contains('hidden')) {
                ui.tooltip.classList.add('hidden'); 
            }
            deselectActiveImage();
            syncVisualToRaw();
            updateLivePreview();
            document.getElementById('previewModal').classList.remove('hidden'); 
            document.body.style.overflow = 'hidden'; 
        };
        
        window.closePreviewModal = () => { 
            document.getElementById('previewModal').classList.add('hidden'); 
            document.body.style.overflow = ''; 
        };

        let historyStack = [];
        let historyIndex = -1;
        function saveHistory() {
            if(ui.inputKonten.value === historyStack[historyIndex]?.value) return;
            historyStack = historyStack.slice(0, historyIndex + 1);
            historyStack.push({ value: ui.inputKonten.value });
            historyIndex++;
            if (historyStack.length > 50) { historyStack.shift(); historyIndex--; }
        }
    });
</script>
@endpush