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
    
    .content-editor-style img { max-width: 100%; height: auto; border-radius: 0.5rem; transition: all 0.2s ease; }
    .content-editor-style p, .content-editor-style div { margin-bottom: 0.75rem !important; font-size: 1rem !important; line-height: 1.625 !important; }
    
    /* Clearfix bantu agar elemen tidak tertimpa float gambar */
    .clearfix::after { content: ""; clear: both; display: table; }
</style>

@php
    $userRole = Auth::user()->role;
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-6">
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('admin.berita.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 flex items-center gap-1 transition-colors">
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

    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" id="formBerita">
        @csrf
        <div class="flex flex-col lg:flex-row gap-6 mb-8">
            <!-- KOLOM KIRI -->
            <div class="w-full lg:w-3/4 space-y-4">
                <!-- Judul Berita -->
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Judul Berita <span class="text-red-500">*</span></label>
                    <input type="text" id="inputJudul" name="judul_berita" value="{{ old('judul_berita') }}" placeholder="Ketik judul berita di sini..." 
                        class="w-full text-xl md:text-xl font-bold p-2.5 bg-gray-50 border border-gray-300 rounded-md focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all placeholder-gray-400" required autofocus>
                </div>

                <!-- Editor Konten -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-3 border-b border-gray-100 bg-gray-50 rounded-t-lg">
                        <label class="block text-sm font-bold text-gray-700">Konten Berita <span class="text-red-500">*</span></label>
                    </div>
                    
                    <!-- TOOLBOX FORMATTING -->
                    <div class="sticky top-0 z-[50] flex flex-wrap items-center justify-between bg-white border-b border-gray-200 p-3 w-full shadow-sm" id="editorHeader">
                        <div class="flex flex-wrap items-center gap-2 pb-2 mb-3 lg:pb-0 lg:mb-0" id="toolbarKonten">
                            <select id="formatHeader" class="text-sm border border-gray-300 rounded px-2 py-1.5 bg-gray-50 hover:bg-gray-100 cursor-pointer focus:ring-2 focus:ring-blue-200 focus:border-blue-500" onchange="applyHeader()">
                                <option value="">Format Heading</option>
                                <option value="h2">Heading 2</option>
                                <option value="h3">Heading 3</option>
                                <option value="h4">Heading 4</option>
                                <option value="h5">Heading 5</option>
                                <option value="h6">Heading 6</option>
                            </select>
                            
                            <div class="w-px h-6 bg-gray-300 mx-1"></div>

                            <div class="flex rounded-md shadow-sm">
                                <button type="button" onclick="formatText('<b>', '</b>', 'bold')" class="px-3 py-1.5 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 text-sm font-bold" title="Bold">B</button>
                                <button type="button" onclick="formatText('<i>', '</i>', 'italic')" class="px-3 py-1.5 bg-white border-t border-b border-r border-gray-300 hover:bg-gray-50 text-sm italic" title="Italic">I</button>
                                <button type="button" onclick="formatText('<u>', '</u>', 'underline')" class="px-3 py-1.5 bg-white border-t border-b border-r border-gray-300 hover:bg-gray-50 text-sm underline" title="Underline">U</button>
                                <button type="button" onclick="formatText('<s>', '</s>', 'strikeThrough')" class="px-3 py-1.5 bg-white border-t border-b border-r border-gray-300 rounded-r-md hover:bg-gray-50 text-sm line-through" title="Strikethrough">S</button>
                            </div>
                            
                            <div class="w-px h-6 bg-gray-300 mx-1"></div>

                            <div class="flex rounded-md shadow-sm">
                                <button type="button" onclick="formatText('<sup>', '</sup>', 'superscript')" class="px-2 py-1.5 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 text-sm" title="Superscript">x&sup2;</button>
                                <button type="button" onclick="formatText('<sub>', '</sub>', 'subscript')" class="px-2 py-1.5 bg-white border-t border-b border-r border-gray-300 hover:bg-gray-50 text-sm" title="Subscript">x&sbquo;</button>
                                <button type="button" onclick="formatText('<blockquote>', '</blockquote>', 'formatBlock')" class="px-3 py-1.5 bg-white border-t border-b border-r border-gray-300 rounded-r-md hover:bg-gray-50 text-sm" title="Quote">&quot; Kutipan</button>
                            </div>

                            <div class="w-px h-6 bg-gray-300 mx-1"></div>

                            <select id="formatList" class="text-sm border border-gray-300 rounded px-2 py-1.5 bg-gray-50 hover:bg-gray-100 cursor-pointer focus:ring-2 focus:ring-blue-200 focus:border-blue-500" onchange="applyList()">
                                <option value="">Jenis List</option>
                                <option value="ul">Bullet (&bull;)</option>
                                <option value="ol-1">Angka (1, 2)</option>
                                <option value="ol-a">Huruf (a, b)</option>
                                <option value="ol-i">Romawi (i, ii)</option>
                            </select>

                            <div class="w-px h-6 bg-gray-300 mx-1"></div>

                            <button type="button" onclick="openImageModal()" class="px-3 py-1.5 bg-blue-50 border border-blue-300 text-blue-700 rounded-md hover:bg-blue-100 flex items-center gap-1 text-sm font-semibold transition-colors" title="Insert Image">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Gambar
                            </button>
                        </div>
                        
                        <!-- TOMBOL MODE VIEW -->
                        <div class="flex items-center mt-2 p-1 bg-gray-100 rounded-md shrink-0 border border-gray-200">
                            <button type="button" id="btnModeVisual" onclick="switchMode('visual')" class="px-3 py-1.5 bg-white shadow-sm text-xs font-bold rounded text-gray-800 transition-all">Visual Editor</button>
                            <button type="button" onclick="openPreviewModal()" class="px-3 py-1.5 text-emerald-700 text-xs font-bold rounded hover:bg-gray-200 transition-all">Live Preview</button>
                            <button type="button" id="btnModeRaw" onclick="switchMode('raw')" class="px-3 py-1.5 text-xs font-bold rounded text-gray-600 hover:bg-gray-200 transition-all">Kode HTML</button>
                        </div>
                    </div>

                    <!-- AREA EDITOR -->
                    <div class="relative w-full bg-white rounded-b-md focus-within:ring-2 focus-within:ring-blue-200">
                        <div id="visualEditor" contenteditable="true" class="content-editor-style clearfix w-full p-6 text-gray-800 min-h-[500px] outline-none leading-relaxed">{!! old('konten') !!}</div>
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
                    <div class="p-4 border-b border-gray-100 bg-gray-50 font-bold text-gray-800">Publikasi</div>
                    <div class="p-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                            <select name="status" required class="w-full bg-white border border-gray-300 rounded-md p-2.5 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-colors">
                                <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Konsep (Draft)</option>
                                @if($userRole != 'pegawai_humas')
                                    <option value="Terbit" {{ old('status') == 'Terbit' ? 'selected' : '' }}>Terbitkan</option>
                                @endif
                            </select>
                        </div>
                        <button type="submit" class="w-full py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-200 transition-colors">
                            Simpan Berita
                        </button>
                    </div>
                </div>

                <!-- Box Thumbnail -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 font-bold text-gray-800">Thumbnail Berita</div>
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
                    Judul Berita Akan Muncul Di Sini...
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
                    <p class="text-gray-400 italic text-center py-10">Konten berita akan diperbarui secara otomatis saat Anda mengetik di editor...</p>
                </div>

                <div id="previewLampiranContainer" class="mt-10 pt-8 border-t border-gray-200 hidden">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 flex items-center justify-between gap-4 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-blue-100 rounded-lg text-blue-600 shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-gray-900">Dokumen Lampiran Berita</h4>
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
            <input type="text" id="modalAltText" placeholder="Contoh: Suasana rapat paripurna..." class="w-full text-sm p-2.5 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition-colors">
            <p class="text-xs text-gray-500 mt-2">Atribut alt penting untuk aksesibilitas dan SEO.</p>
        </div>

        <div id="modalGalleryGrid" class="grid grid-cols-2 md:grid-cols-3 gap-4 max-h-80 overflow-y-auto p-2 border border-gray-100 rounded-lg bg-gray-50"></div>

        <div class="mt-6 flex justify-end">
            <button type="button" onclick="closeImageModal()" class="px-5 py-2 bg-gray-100 text-gray-700 text-sm font-bold rounded-md hover:bg-gray-200 transition-colors">Batal</button>
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
        let activeImage = null;

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

        function syncVisualToRaw() {
            let html = ui.visualEditor.innerHTML;
            html = html.replace(/outline:\s*3px\s*solid\s*(rgb\(59,\s*130,\s*246\)|#3b82f6);?/gi, '');
            localBlobMap.forEach((blobUrl, fileName) => {
                const regex = new RegExp(blobUrl.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g');
                html = html.replace(regex, fileName);
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
                const regex = new RegExp(fileName.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g');
                rawText = rawText.replace(regex, blobUrl);
            });
            ui.visualEditor.innerHTML = rawText;
            updateLivePreview();
        }

        function updateLivePreview() {
            let rawText = ui.inputKonten.value.trim();
            if (rawText) {
                localBlobMap.forEach((blobUrl, fileName) => {
                    const regex = new RegExp(fileName.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g');
                    rawText = rawText.replace(regex, blobUrl);
                });
                ui.previewKonten.innerHTML = rawText;
            } else {
                ui.previewKonten.innerHTML = '<p class="text-gray-400 italic text-center py-10">Konten berita akan diperbarui secara otomatis saat Anda mengetik di editor...</p>';
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
                btnR.className = 'px-3 py-1.5 text-xs font-bold rounded text-gray-600 hover:bg-gray-200 transition-all';
                syncRawToVisual();
                ui.inputKonten.classList.add('hidden');
                ui.visualEditor.classList.remove('hidden');
            } else {
                btnR.className = 'px-3 py-1.5 bg-white shadow-sm text-xs font-bold rounded text-gray-800 transition-all';
                btnV.className = 'px-3 py-1.5 text-xs font-bold rounded text-gray-600 hover:bg-gray-200 transition-all';
                syncVisualToRaw();
                ui.visualEditor.classList.add('hidden');
                ui.inputKonten.classList.remove('hidden');
            }
            ui.tooltip.classList.add('hidden');
        };

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
                if (execCmd === 'formatBlock') {
                    document.execCommand('formatBlock', false, tagStart.replace(/<|>/g, ''));
                } else if (execCmd) {
                    document.execCommand(execCmd, false, null);
                }
                syncVisualToRaw();
            } else {
                const start = ui.inputKonten.selectionStart;
                const end = ui.inputKonten.selectionEnd;
                const selectedText = ui.inputKonten.value.substring(start, end);
                const wrapped = tagStart + selectedText + tagEnd;
                
                applyTextReplacement(wrapped, start, end);
                ui.inputKonten.setSelectionRange(
                    selectedText ? start : start + tagStart.length,
                    selectedText ? start + wrapped.length : start + tagStart.length
                );
                syncRawToVisual();
            }
        };

        window.applyHeader = function() {
            const select = document.getElementById('formatHeader');
            if (!select.value) return;

            if (currentMode === 'visual') {
                ui.visualEditor.focus();
                document.execCommand('formatBlock', false, select.value.toUpperCase());
                syncVisualToRaw();
            } else {
                const start = ui.inputKonten.selectionStart;
                const end = ui.inputKonten.selectionEnd;
                const selectedText = ui.inputKonten.value.substring(start, end);
                applyTextReplacement(`\n<${select.value}>\n${selectedText}\n</${select.value}>\n`, start, end);
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
                if (val === 'ul') {
                    document.execCommand('insertUnorderedList', false, null);
                } else {
                    document.execCommand('insertOrderedList', false, null);
                    setTimeout(() => {
                        let node = document.getSelection().anchorNode;
                        while(node && node.nodeName !== 'OL' && node.nodeName !== 'DIV') node = node.parentNode;
                        if (node && node.nodeName === 'OL') {
                            if (val === 'ol-a') node.style.listStyleType = 'lower-alpha';
                            if (val === 'ol-i') node.style.listStyleType = 'lower-roman';
                            if (val === 'ol-1') node.style.listStyleType = 'decimal';
                        }
                        syncVisualToRaw();
                    }, 10);
                }
                syncVisualToRaw();
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
            // REVISI PENTING: Gambar kini dibungkus dalam div block dengan properti clear: both
            // Ini menjamin secara mutlak bahwa gambar tidak akan pernah bisa bersebelahan 
            // dengan gambar lain dalam satu baris, meskipun user menghapus spasi/enter di antara mereka.
            const imgHtml = `\n<div style="clear: both; margin-bottom: 1rem;">\n<img src="${srcUrl}" class="max-w-full h-auto rounded-lg shadow-sm" alt="${altText || 'Gambar Berita'}" style="display: block; margin: 1.5rem auto; width: 100%;" />\n</div>\n`;
            
            if (currentMode === 'visual') {
                ui.visualEditor.focus();
                document.execCommand('insertHTML', false, imgHtml);
                syncVisualToRaw();
            } else {
                applyTextReplacement(imgHtml, ui.inputKonten.selectionStart, ui.inputKonten.selectionEnd);
                syncRawToVisual();
            }
        };

        ui.visualEditor.addEventListener('click', function(e) {
            if (e.target.tagName === 'IMG') {
                if (activeImage && activeImage !== e.target) {
                    activeImage.style.outline = 'none';
                }
                activeImage = e.target;
                activeImage.style.outline = '3px solid #3b82f6';
                
                const rect = activeImage.getBoundingClientRect();
                
                let topPos = rect.top - 65; 
                if (topPos < 60) topPos = rect.bottom + 15;
                
                ui.tooltip.style.top = topPos + 'px';
                ui.tooltip.style.left = Math.max(16, rect.left) + 'px';
                ui.tooltip.classList.remove('hidden');
            } else {
                if(activeImage) activeImage.style.outline = 'none';
                ui.tooltip.classList.add('hidden');
                activeImage = null;
            }
        });

        ui.visualEditor.addEventListener('keydown', function(e) {
            if ((e.key === 'Backspace' || e.key === 'Delete') && activeImage) {
                e.preventDefault();
                deleteActiveImage();
            }
        });

        window.addEventListener('scroll', () => { 
            if(!ui.tooltip.classList.contains('hidden')) {
                ui.tooltip.classList.add('hidden'); 
                if(activeImage) {
                    activeImage.style.outline = 'none';
                    activeImage = null;
                }
            }
        }, true);

        window.setImageSize = function(size) {
            if (!activeImage) return;
            activeImage.style.width = size === 'kecil' ? '25%' : size === 'sedang' ? '50%' : '100%';
            syncVisualToRaw();
        };

        window.setImageAlign = function(align) {
            if (!activeImage) return;
            if (align === 'tengah') {
                activeImage.style.display = 'block';
                activeImage.style.float = 'none';
                activeImage.style.margin = '1.5rem auto';
            } else {
                activeImage.style.display = 'inline';
                activeImage.style.float = align === 'kiri' ? 'left' : 'right';
                // Memberi ruang margin samping agar teks tidak menempel
                activeImage.style.margin = align === 'kiri' ? '0.25rem 1.25rem 0.5rem 0' : '0.25rem 0 0.5rem 1.25rem';
            }
            syncVisualToRaw();
        };

        window.insertClearfixAfterImage = function() {
            if (!activeImage) return;
            
            // Kita cari elemen induk pembungkus div dari gambar ini (jika ada)
            // agar div clearfix benar-benar disisipkan SETELAH seluruh blok gambar, bukan di dalam div-nya.
            let targetElement = activeImage;
            if (activeImage.parentNode && activeImage.parentNode.tagName === 'DIV' && activeImage.parentNode.style.clear === 'both') {
                targetElement = activeImage.parentNode;
            }

            const clearDiv = document.createElement('div');
            clearDiv.style.clear = 'both';
            clearDiv.innerHTML = '<br>';
            
            targetElement.parentNode.insertBefore(clearDiv, targetElement.nextSibling);
            
            const range = document.createRange();
            const sel = window.getSelection();
            range.setStart(clearDiv, 0);
            range.collapse(true);
            sel.removeAllRanges();
            sel.addRange(range);
            
            ui.visualEditor.focus();
            syncVisualToRaw();
            ui.tooltip.classList.add('hidden');
        };

        window.deleteActiveImage = function() {
            if (!activeImage) return;
            
            // Hapus juga div parent-nya (pembungkus gambar) jika ada
            if (activeImage.parentNode && activeImage.parentNode.tagName === 'DIV' && activeImage.parentNode.style.clear === 'both') {
                activeImage.parentNode.remove();
            } else {
                activeImage.remove();
            }

            ui.tooltip.classList.add('hidden');
            activeImage = null;
            syncVisualToRaw();
        };

        ui.inputJudul.addEventListener('input', e => { ui.previewJudul.innerText = e.target.value.trim() || 'Judul Berita Akan Muncul Di Sini...'; });
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
                multiImageList.innerHTML = '<p class="text-xs text-gray-400 italic text-center py-2 border border-dashed border-gray-200 rounded">Belum ada gambar terpilih.</p>';
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
                
                // Tambahan: bersihkan tag <div> kosong jika gambar di dalamnya terhapus
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

        window.openImageModal = function() {
            const modalGrid = document.getElementById('modalGalleryGrid');
            const modalAltInput = document.getElementById('modalAltText');
            modalGrid.innerHTML = '';
            if (modalAltInput) modalAltInput.value = '';

            if (selectedFiles.length === 0) {
                modalGrid.innerHTML = '<div class="col-span-full flex flex-col items-center justify-center py-10 text-gray-400"><svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg><p class="text-sm font-medium">Galeri kosong, tambahkan dari panel kanan.</p></div>';
            } else {
                selectedFiles.forEach((file) => {
                    const card = document.createElement('div');
                    card.className = 'border border-gray-200 rounded-lg p-2 bg-white flex flex-col gap-3 shadow-sm hover:border-blue-300 transition-colors';
                    
                    const img = document.createElement('img');
                    img.src = localBlobMap.get(file.name) || '';
                    img.className = 'w-full h-28 object-cover rounded bg-gray-50';

                    const btnSelect = document.createElement('button');
                    btnSelect.type = 'button';
                    btnSelect.className = 'w-full py-1.5 bg-blue-600 text-white text-sm font-bold rounded hover:bg-blue-700 transition-colors';
                    btnSelect.innerText = 'Sisipkan';
                    btnSelect.onclick = () => {
                        const blobUrl = localBlobMap.get(file.name) || file.name;
                        insertImageTagToContent(blobUrl, modalAltInput.value.trim() || file.name);
                        closeImageModal();
                    };

                    card.append(img, btnSelect);
                    modalGrid.appendChild(card);
                });
            }
            document.getElementById('imageModal').classList.remove('hidden');
        };

        window.closeImageModal = () => document.getElementById('imageModal').classList.add('hidden');
        
        window.openPreviewModal = () => { 
            if(!ui.tooltip.classList.contains('hidden')) {
                ui.tooltip.classList.add('hidden'); 
            }
            if(activeImage) {
                activeImage.style.outline = 'none';
                activeImage = null;
            }
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