@extends('layouts.app')

@section('content')
<style>
    div#previewKonten h2, #previewKonten h2 { font-size: 1.75rem !important; font-weight: 700 !important; margin-top: 1.35rem !important; margin-bottom: 0.5rem !important; color: #1f2937 !important; line-height: 1.3 !important; display: block !important; }
    div#previewKonten h3, #previewKonten h3 { font-size: 1.375rem !important; font-weight: 700 !important; margin-top: 1.15rem !important; margin-bottom: 0.5rem !important; color: #374151 !important; line-height: 1.35 !important; display: block !important; }
    div#previewKonten h4, #previewKonten h4 { font-size: 1.125rem !important; font-weight: 600 !important; margin-top: 1rem !important; margin-bottom: 0.5rem !important; color: #4b5563 !important; line-height: 1.4 !important; display: block !important; }
    div#previewKonten h5, #previewKonten h5 { font-size: 1rem !important; font-weight: 600 !important; margin-top: 0.75rem !important; margin-bottom: 0.25rem !important; color: #4b5563 !important; display: block !important; }
    div#previewKonten h6, #previewKonten h6 { font-size: 0.875rem !important; font-weight: 600 !important; margin-top: 0.75rem !important; margin-bottom: 0.25rem !important; color: #6b7280 !important; display: block !important; }
    div#previewKonten blockquote, #previewKonten blockquote { border-left: 4px solid #3b82f6 !important; padding-left: 1rem !important; font-style: italic !important; color: #4b5563 !important; margin: 1rem 0 !important; display: block !important; }
    div#previewKonten ul, #previewKonten ul { list-style-type: disc !important; padding-left: 1.5rem !important; margin: 0.75rem 0 !important; display: block !important; }
    div#previewKonten ol, #previewKonten ol { list-style-type: decimal !important; padding-left: 1.5rem !important; margin: 0.75rem 0 !important; display: block !important; }
    div#previewKonten ol[style*="lower-alpha"], #previewKonten ol[style*="lower-alpha"] { list-style-type: lower-alpha !important; }
    div#previewKonten ol[style*="lower-roman"], #previewKonten ol[style*="lower-roman"] { list-style-type: lower-roman !important; }
    div#previewKonten li, #previewKonten li { margin-bottom: 0.25rem !important; display: list-item !important; }
    div#previewKonten img, #previewKonten img { max-width: 100% !important; height: auto !important; border-radius: 0.5rem !important; margin: 1rem auto !important; display: block !important; }
    div#previewKonten p, #previewKonten p { margin-bottom: 0.75rem !important; font-size: 1rem !important; line-height: 1.625 !important; }
</style>

@php
    $userRole = Auth::user()->role;
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.informasi.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
            <ul class="list-disc pl-5 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.informasi.store') }}" method="POST" enctype="multipart/form-data" id="formInformasi">
        @csrf
        <div class="flex flex-col lg:flex-row gap-8 mb-12">
            <!-- KOLOM KIRI -->
            <div class="w-full lg:w-3/4 space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Judul Informasi <span class="text-red-500">*</span></label>
                    <input type="text" id="inputJudul" name="judul_berita" value="{{ old('judul_berita') }}" placeholder="Ketik judul berita di sini..." 
                        class="w-full text-xl md:text-2xl font-bold p-3 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors placeholder-gray-400" required autofocus>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Konten Informasi <span class="text-red-500">*</span></label>
                    
                    <!-- TOOLBOX FORMATTING -->
                    <div class="flex flex-wrap gap-1 bg-gray-50 border border-gray-300 p-2 rounded-t-md border-b-0" id="toolbarKonten">
                        <select id="formatHeader" class="text-xs border border-gray-300 rounded p-1 bg-white hover:bg-gray-100 cursor-pointer" onchange="applyHeader()">
                            <option value="">Header</option>
                            <option value="h2">Header 2</option>
                            <option value="h3">Header 3</option>
                            <option value="h4">Header 4</option>
                            <option value="h5">Header 5</option>
                            <option value="h6">Header 6</option>
                        </select>
                        
                        <div class="w-px h-6 bg-gray-300 mx-1 my-auto"></div>

                        <button type="button" onclick="formatText('<b>', '</b>')" class="px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-xs font-bold" title="Toggle Bold">B</button>
                        <button type="button" onclick="formatText('<i>', '</i>')" class="px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-xs italic" title="Toggle Italic">I</button>
                        <button type="button" onclick="formatText('<u>', '</u>')" class="px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-xs underline" title="Toggle Underline">U</button>
                        <button type="button" onclick="formatText('<s>', '</s>')" class="px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-xs line-through" title="Toggle Strikethrough">S</button>
                        
                        <div class="w-px h-6 bg-gray-300 mx-1 my-auto"></div>

                        <button type="button" onclick="formatText('<sup>', '</sup>')" class="px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-xs" title="Superscript">x&sup2;</button>
                        <button type="button" onclick="formatText('<sub>', '</sub>')" class="px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-xs" title="Subscript">x&sbquo;</button>
                        <button type="button" onclick="formatText('<blockquote>', '</blockquote>')" class="px-2 py-1 bg-white border border-gray-300 rounded hover:bg-gray-100 text-xs" title="Quote">&quot; Quote</button>

                        <div class="w-px h-6 bg-gray-300 mx-1 my-auto"></div>

                        <select id="formatList" class="text-xs border border-gray-300 rounded p-1 bg-white hover:bg-gray-100 cursor-pointer" onchange="applyList()">
                            <option value="">List</option>
                            <option value="ul">Dots (&bull;)</option>
                            <option value="ol-1">Angka (1, 2, 3)</option>
                            <option value="ol-a">Huruf (a, b, c)</option>
                            <option value="ol-i">Romawi (i, ii, iii)</option>
                        </select>

                        <div class="w-px h-6 bg-gray-300 mx-1 my-auto"></div>

                        <button type="button" onclick="openImageModal()" class="px-2.5 py-1 bg-blue-50 border border-blue-300 text-blue-700 rounded hover:bg-blue-100 flex items-center gap-1 text-xs font-semibold" title="Insert Image">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Image Galeri
                        </button>

                        <div class="w-px h-6 bg-gray-300 mx-1 my-auto"></div>

                        <!-- TOMBOL PREVIEW BARU -->
                        <button type="button" onclick="openPreviewModal()" class="px-2.5 py-1 bg-emerald-50 border border-emerald-300 text-emerald-700 rounded hover:bg-emerald-100 flex items-center gap-1 text-xs font-semibold" title="Live Preview">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Preview Tampilan
                        </button>
                    </div>

                    <textarea name="konten" id="inputKonten" rows="25" placeholder="Mulai menulis konten di sini..." 
    class="w-full p-4 bg-white border border-gray-300 rounded-b-md rounded-t-none border-t-0 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-gray-700 resize-y min-h-[720px]" required>{{ old('konten') }}</textarea>
                </div>
            </div>

            <!-- KOLOM KANAN -->
            <div class="w-full lg:w-1/4 space-y-6">
                <!-- Box Publikasi -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg font-bold text-gray-800">Publikasi</div>
                    <div class="p-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                            <select name="status" required class="w-full bg-white border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-500">
                                <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Konsep (Draft)</option>
                                @if($userRole != 'pegawai_humas')
                                    <option value="Terbit" {{ old('status') == 'Terbit' ? 'selected' : '' }}>Terbitkan</option>
                                @endif
                            </select>
                        </div>
                        <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                            Simpan Informasi
                        </button>
                    </div>
                </div>

                <!-- Box Thumbnail -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg font-bold text-gray-800">Thumbnail Informasi</div>
                    <div class="p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Unggah Gambar Utama <span class="text-red-500">*</span></label>
                        <input type="file" name="thumbnail" id="inputThumbnail" accept="image/*" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 bg-white border border-gray-300 rounded-md">
                        <p class="text-xs text-amber-600 mt-1 font-medium">* Disarankan rasio gambar 16:9 (contoh: 1280x720 / 1920x1080 px).</p>

                        <label class="block text-sm font-medium text-gray-700 mt-4 mb-1">Deskripsi Gambar (Caption) <span class="text-red-500">*</span></label>
                        <input type="text" id="inputCaption" name="caption_thumbnail" maxlength="150" value="{{ old('caption_thumbnail') }}" placeholder="Tulis caption gambar di sini (Maks. 150 karakter)..." class="w-full text-sm p-2 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:ring-2 focus:ring-blue-200" required>
                    </div>
                </div>

                <!-- Box Multi-Images -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg font-bold text-gray-800">Galeri Multi-Gambar</div>
                    <div class="p-4 space-y-3">
                        <label class="block text-sm font-medium text-gray-700">Pilih File Gambar</label>
                        <input type="file" id="inputMultiImages" multiple accept="image/*" class="w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 bg-white border border-gray-300 rounded-md">
                        <p class="text-xs text-amber-600 mt-1 font-medium">* Disarankan rasio gambar 16:9 agar tampilan seragam.</p>

                        <input type="file" name="multi_images[]" id="hiddenMultiImages" multiple class="hidden">

                        <div id="multiImageList" class="space-y-2 mt-3 max-h-48 overflow-y-auto pr-1">
                            <p class="text-xs text-gray-400 italic" id="emptyListNotice">Belum ada gambar yang dipilih.</p>
                        </div>
                    </div>
                </div>

                <!-- Box File Lampiran -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg font-bold text-gray-800">File Lampiran</div>
                    <div class="p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">URL Dokumen (Opsional)</label>
                        <input type="url" name="lampiran_url" id="inputLampiranUrl" value="{{ old('lampiran_url') }}" placeholder="https://drive.google.com/..." class="w-full bg-white border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-500 text-sm">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('modals')
<!-- MODAL LIVE PREVIEW -->
<div id="previewModal" class="hidden fixed inset-0 z-50 bg-gray-900/75 flex justify-center items-center backdrop-blur-sm p-4 sm:p-8">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-5xl h-full max-h-[90vh] flex flex-col border border-gray-100">
        <!-- Header Modal -->
        <div class="flex justify-between items-center p-4 border-b border-gray-100 shrink-0">
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Live Preview Tampilan
            </h3>
            <button type="button" onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600 text-3xl font-bold leading-none">&times;</button>
        </div>
        
        <!-- Konten Preview (Gunakan tag Preview lama Anda di sini) -->
        <div class="p-6 md:p-10 overflow-y-auto flex-1 bg-gray-50/30">
            <article class="bg-white p-6 md:p-10 rounded-xl border border-gray-200 shadow-sm flex flex-col max-w-4xl mx-auto">
                <h1 id="previewJudul" class="text-2xl md:text-4xl font-bold text-gray-900 leading-snug mb-4">
                    Judul Informasi Akan Muncul Di Sini...
                </h1>
                
                <div class="flex items-center gap-4 text-xs md:text-sm text-gray-500 pb-6 border-b border-gray-100 mb-6">
                    <span>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                    <span>•</span>
                    <span>Admin / Penulis</span>
                </div>

                <div id="previewThumbnailContainer" class="hidden mb-8 rounded-lg overflow-hidden border border-gray-200 relative aspect-video bg-gray-50 flex items-center justify-center">
                    <img id="previewThumbnailImage" src="" alt="Preview Thumbnail" class="relative z-10 max-h-full max-w-full object-contain">
                    <p id="previewThumbnailCaption" class="absolute bottom-0 inset-x-0 z-20 text-xs text-gray-700 italic p-2 text-center bg-gray-100/90 border-t border-gray-200">
                        <span id="captionText">Deskripsi gambar akan muncul di sini...</span>
                    </p>
                </div>

                <div id="previewKonten" class="text-gray-700 leading-relaxed">
                    <p class="text-gray-400 italic">Konten informasi akan diperbarui secara otomatis saat Anda mengetik di editor...</p>
                </div>

                <div id="previewLampiranContainer" class="mt-8 pt-6 border-t border-gray-100 hidden">
                    <div class="bg-blue-50/70 border border-blue-200 rounded-lg p-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-100 rounded-lg text-blue-600 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">Dokumen Lampiran Informasi</h4>
                                <p class="text-xs text-gray-500">Klik tombol di samping untuk mengunduh atau melihat dokumen lampiran.</p>
                            </div>
                        </div>
                        <a id="previewLampiranLink" href="#" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-md flex items-center gap-1.5 transition-colors shrink-0">
                            <span>Buka Lampiran</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>
@endpush

<!-- FLOAT WINDOW MODAL MULTI-IMAGE -->
@push('modals')
<div id="imageModal" class="hidden fixed inset-0 z-50 bg-gray-900/50 flex justify-center items-center backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl p-6 border border-gray-100">
        <div class="flex justify-between items-center pb-3 border-b border-gray-100 mb-4">
            <h3 class="text-lg font-bold text-gray-800">Pilih Gambar Dari Multi-Galeri</h3>
            <button type="button" onclick="closeImageModal()" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
        </div>
        <p class="text-xs text-gray-500 mb-3">Pilih gambar yang telah ditambahkan pada daftar Multi-Gambar untuk disisipkan ke posisi kursor editor.</p>
        
        <div class="mb-4 bg-blue-50/50 p-3 rounded-lg border border-blue-100">
            <label class="block text-xs font-bold text-gray-700 mb-1">Alternatif Teks / Alt Text Gambar (Opsional)</label>
            <input type="text" id="modalAltText" placeholder="Masukkan deskripsi gambar untuk atribut alt..." class="w-full text-xs p-2 bg-white border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-200 focus:border-blue-500">
            <p class="text-[11px] text-gray-400 mt-1">Teks ini akan otomatis dimasukkan ke dalam <code class="bg-gray-100 px-1 rounded text-red-500">alt="..."</code> pada tag &lt;img&gt;.</p>
        </div>

        <div id="modalGalleryGrid" class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-72 overflow-y-auto p-1 border border-gray-100 rounded-lg"></div>

        <div class="mt-5 flex justify-end">
            <button type="button" onclick="closeImageModal()" class="px-4 py-2 bg-gray-100 text-gray-700 text-xs font-semibold rounded-md hover:bg-gray-200">Tutup</button>
        </div>
    </div>
</div>
@endpush

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputJudul = document.getElementById('inputJudul');
        const inputKonten = document.getElementById('inputKonten');
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

        function updateLivePreview() {
            let rawText = inputKonten.value.trim();
            if (rawText !== '') {
                localBlobMap.forEach((blobUrl, fileName) => {
                    const regex = new RegExp(fileName.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g');
                    rawText = rawText.replace(regex, blobUrl);
                });
                previewKonten.innerHTML = rawText;
            } else {
                previewKonten.innerHTML = '<p class="text-gray-400 italic">Konten informasi akan diperbarui secara otomatis saat Anda mengetik di editor...</p>';
            }
        }

        function updateLampiranPreview() {
            if (!inputLampiranUrl || !previewLampiranContainer || !previewLampiranLink) return;
            const urlVal = inputLampiranUrl.value.trim();
            if (urlVal !== '') {
                previewLampiranLink.href = urlVal;
                previewLampiranContainer.classList.remove('hidden');
            } else {
                previewLampiranContainer.classList.add('hidden');
            }
        }

        inputJudul.addEventListener('input', function() {
            previewJudul.innerText = this.value.trim() !== '' ? this.value : 'Judul Informasi Akan Muncul Di Sini...';
        });

        inputCaption.addEventListener('input', function() {
            captionText.innerText = this.value.trim() !== '' ? this.value : 'Deskripsi gambar akan muncul di sini...';
        });

        inputKonten.addEventListener('input', updateLivePreview);

        if (inputLampiranUrl) {
            inputLampiranUrl.addEventListener('input', updateLampiranPreview);
            updateLampiranPreview();
        }

        inputThumbnail.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewThumbnailImage.src = e.target.result;
                    previewThumbnailContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                previewThumbnailContainer.classList.add('hidden');
            }
        });

        const inputMultiImages = document.getElementById('inputMultiImages');
        const hiddenMultiImages = document.getElementById('hiddenMultiImages');
        const multiImageList = document.getElementById('multiImageList');
        const emptyListNotice = document.getElementById('emptyListNotice');
        
        let selectedFiles = [];

        inputMultiImages.addEventListener('change', function() {
            const files = Array.from(this.files);
            files.forEach(file => {
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
                multiImageList.appendChild(emptyListNotice);
                syncHiddenInput();
                return;
            }

            selectedFiles.forEach((file, index) => {
                const item = document.createElement('div');
                item.className = 'flex items-center justify-between p-2 bg-gray-50 border border-gray-200 rounded-md text-xs';
                
                const fileInfo = document.createElement('div');
                fileInfo.className = 'flex items-center gap-2 truncate';
                
                const img = document.createElement('img');
                img.className = 'w-7 h-7 object-cover rounded border';
                img.src = localBlobMap.get(file.name) || '';
                
                const spanName = document.createElement('span');
                spanName.className = 'truncate font-medium text-gray-700';
                spanName.innerText = file.name;

                fileInfo.appendChild(img);
                fileInfo.appendChild(spanName);

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'text-red-500 hover:text-red-700 font-bold px-1 text-sm';
                removeBtn.innerHTML = '&times;';
                removeBtn.onclick = function() {
                    const removedFileName = selectedFiles[index].name;
                    localBlobMap.delete(removedFileName);
                    selectedFiles.splice(index, 1);

                    // Hapus elemen tag <img> gambar baru yang dibatalkan dari editor
                    if (removedFileName && inputKonten) {
                        const escapeFileName = removedFileName.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                        const imgPattern = new RegExp('<div[^>]*>\\s*<img[^>]*src="[^"]*' + escapeFileName + '"[^>]*>\\s*</div>|<img[^>]*src="[^"]*' + escapeFileName + '"[^>]*>', 'gi');
                        inputKonten.value = inputKonten.value.replace(imgPattern, '');
                    }

                    updateMultiImageUI();
                    updateLivePreview();
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

        function applyTextReplacement(replacementText, selectStart, selectEnd) {
            inputKonten.focus();
            if (typeof inputKonten.setRangeText === 'function') {
                inputKonten.setRangeText(replacementText, selectStart, selectEnd, 'select');
            } else {
                inputKonten.setSelectionRange(selectStart, selectEnd);
                document.execCommand('insertText', false, replacementText);
            }
        }

        window.formatText = function(tagStart, tagEnd) {
            const start = inputKonten.selectionStart;
            const end = inputKonten.selectionEnd;
            const text = inputKonten.value;
            const selectedText = text.substring(start, end);

            const cleanStartTag = tagStart.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            const cleanEndTag = tagEnd.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            const selfWrappedRegex = new RegExp('^' + cleanStartTag + '([\\s\\S]*)' + cleanEndTag + '$', 'i');

            const prefixTag = text.substring(Math.max(0, start - tagStart.length), start);
            const suffixTag = text.substring(end, end + tagEnd.length);

            if (selfWrappedRegex.test(selectedText)) {
                const unWrapped = selectedText.replace(selfWrappedRegex, '$1');
                applyTextReplacement(unWrapped, start, end);
                inputKonten.setSelectionRange(start, start + unWrapped.length);
            } else if (prefixTag.toLowerCase() === tagStart.toLowerCase() && suffixTag.toLowerCase() === tagEnd.toLowerCase()) {
                const replaceStart = start - tagStart.length;
                const replaceEnd = end + tagEnd.length;
                applyTextReplacement(selectedText, replaceStart, replaceEnd);
                inputKonten.setSelectionRange(replaceStart, replaceStart + selectedText.length);
            } else {
                const wrapped = tagStart + selectedText + tagEnd;
                applyTextReplacement(wrapped, start, end);
                if (selectedText.length === 0) {
                    const caretPos = start + tagStart.length;
                    inputKonten.setSelectionRange(caretPos, caretPos);
                } else {
                    inputKonten.setSelectionRange(start, start + wrapped.length);
                }
            }
            
            inputKonten.dispatchEvent(new Event('input'));
        };

        window.applyHeader = function() {
            const select = document.getElementById('formatHeader');
            const headerTag = select.value;
            if (!headerTag) return;

            const start = inputKonten.selectionStart;
            const end = inputKonten.selectionEnd;
            const text = inputKonten.value;
            const selectedText = text.substring(start, end);

            const innerHeadingRegex = /^<h[1-6][^>]*>([\s\S]*)<\/h[1-6]>$/i;

            if (innerHeadingRegex.test(selectedText)) {
                const innerText = selectedText.replace(innerHeadingRegex, '$1');
                const currentTagMatch = selectedText.match(/^<(h[1-6])/i);
                const currentTag = currentTagMatch ? currentTagMatch[1].toLowerCase() : '';

                if (currentTag === headerTag.toLowerCase()) {
                    applyTextReplacement(innerText, start, end);
                    inputKonten.setSelectionRange(start, start + innerText.length);
                } else {
                    const newWrapped = `<${headerTag}>${innerText}</${headerTag}>`;
                    applyTextReplacement(newWrapped, start, end);
                    inputKonten.setSelectionRange(start, start + newWrapped.length);
                }
            } else {
                const before = text.substring(0, start);
                const after = text.substring(end);
                const outerMatchBefore = before.match(/<h([1-6])>[^<]*$/i);
                const outerMatchAfter = after.match(/^[^<]*<\/h([1-6])>/i);

                if (outerMatchBefore && outerMatchAfter && outerMatchBefore[1] === outerMatchAfter[1]) {
                    const oldTagNum = outerMatchBefore[1];
                    const oldTagStart = `<h${oldTagNum}>`;
                    const oldTagEnd = `</h${oldTagNum}>`;

                    const fullStartPos = before.lastIndexOf(oldTagStart);
                    const fullEndPos = end + after.indexOf(oldTagEnd) + oldTagEnd.length;
                    const fullHeadingText = text.substring(fullStartPos, fullEndPos);
                    const innerText = fullHeadingText.replace(new RegExp(`^<h${oldTagNum}>([\\s\\S]*)</h${oldTagNum}>$`, 'i'), '$1');

                    if (`h${oldTagNum}` === headerTag.toLowerCase()) {
                        applyTextReplacement(innerText, fullStartPos, fullEndPos);
                        inputKonten.setSelectionRange(fullStartPos, fullStartPos + innerText.length);
                    } else {
                        const newWrapped = `<${headerTag}>${innerText}</${headerTag}>`;
                        applyTextReplacement(newWrapped, fullStartPos, fullEndPos);
                        inputKonten.setSelectionRange(fullStartPos, fullStartPos + newWrapped.length);
                    }
                } else {
                    const newWrapped = `<${headerTag}>${selectedText}</${headerTag}>`;
                    applyTextReplacement(newWrapped, start, end);
                    if (selectedText.length === 0) {
                        const caretPos = start + `<${headerTag}>`.length;
                        inputKonten.setSelectionRange(caretPos, caretPos);
                    } else {
                        inputKonten.setSelectionRange(start, start + newWrapped.length);
                    }
                }
            }

            select.value = "";
            inputKonten.dispatchEvent(new Event('input'));
        };

        window.applyList = function() {
            const select = document.getElementById('formatList');
            const val = select.value;
            if (!val) return;

            const start = inputKonten.selectionStart;
            const end = inputKonten.selectionEnd;
            let selectedText = inputKonten.value.substring(start, end);

            let listType = 'ul';
            let styleAttr = '';
            
            if (val === 'ul') {
                listType = 'ul';
                styleAttr = ' style="list-style-type: disc;"';
            } else if (val === 'ol-1') {
                listType = 'ol';
                styleAttr = ' style="list-style-type: decimal;"';
            } else if (val === 'ol-a') {
                listType = 'ol';
                styleAttr = ' style="list-style-type: lower-alpha;"';
            } else if (val === 'ol-i') {
                listType = 'ol';
                styleAttr = ' style="list-style-type: lower-roman;"';
            }

            let newHtml = '';
            const listRegex = /^<(ul|ol)([^>]*)>([\s\S]*)<\/\1>$/i;
            
            if (listRegex.test(selectedText.trim())) {
                const match = selectedText.trim().match(listRegex);
                const currentTag = match[1].toLowerCase();
                const currentAttr = match[2].toLowerCase();
                const innerContent = match[3].trim();
                
                let currentFormat = '';
                if (currentTag === 'ul') {
                    currentFormat = 'ul';
                } else if (currentTag === 'ol') {
                    if (currentAttr.includes('lower-alpha')) currentFormat = 'ol-a';
                    else if (currentAttr.includes('lower-roman')) currentFormat = 'ol-i';
                    else currentFormat = 'ol-1';
                }

                if (currentFormat === val) {
                    // TOGGLE OFF: Hapus tag <li> dan kembalikan ke teks biasa dengan enter
                    newHtml = innerContent
                        .replace(/<li[^>]*>([\s\S]*?)<\/li>/gi, '$1')
                        .split('\n')
                        .map(line => line.trim())
                        .filter(line => line !== '')
                        .join('\n');
                } else {
                    // REPLACE: Ganti format list ke format lain (misal Dots ke Angka)
                    newHtml = `<${listType}${styleAttr}>\n  ${innerContent}\n</${listType}>`;
                }
            } else {
                // CREATE NEW: Buat list baru dari teks yang diseleksi
                const lines = selectedText.split(/\r?\n/);
                let liItems = '';
                
                lines.forEach(line => {
                    const trimmedLine = line.trim();
                    if (trimmedLine.length > 0) {
                        if (/^<li>.*<\/li>$/i.test(trimmedLine)) {
                            liItems += `  ${trimmedLine}\n`;
                        } else {
                            liItems += `  <li>${trimmedLine}</li>\n`;
                        }
                    }
                });

                if (liItems === '') liItems = '  <li></li>\n';
                
                newHtml = `<${listType}${styleAttr}>\n${liItems}</${listType}>`;
            }

            // Terapkan fungsi replacement (agar Undo/Redo tetap berjalan jika di create.blade.php)
            if (typeof applyTextReplacement === 'function') {
                applyTextReplacement(newHtml, start, end);
            } else {
                // Fallback jika tidak ada custom applyTextReplacement
                inputKonten.focus();
                inputKonten.setRangeText(newHtml, start, end, 'select');
            }
            
            inputKonten.setSelectionRange(start, start + newHtml.length);
            inputKonten.dispatchEvent(new Event('input'));
            
            select.value = "";
        };

        window.insertImageTagToContent = function(srcUrl, altText) {
            const finalAlt = altText || 'Gambar Galeri';
            const imgTag = `<div class="my-4 flex justify-center">\n  <img src="${srcUrl}" class="max-w-full h-auto rounded-lg border border-gray-200 shadow-sm" alt="${finalAlt}" />\n</div>`;
            const start = inputKonten.selectionStart;
            const end = inputKonten.selectionEnd;
            applyTextReplacement(imgTag, start, end);
            inputKonten.dispatchEvent(new Event('input'));
        };

        window.openImageModal = function() {
            const modalGrid = document.getElementById('modalGalleryGrid');
            const modalAltInput = document.getElementById('modalAltText');
            modalGrid.innerHTML = '';
            if (modalAltInput) modalAltInput.value = '';

            if (selectedFiles.length === 0) {
                modalGrid.innerHTML = '<p class="col-span-3 text-center text-xs text-gray-400 py-6">Belum ada gambar di galeri multi-image. Tambahkan gambar terlebih dahulu pada panel kanan.</p>';
            } else {
                selectedFiles.forEach((file) => {
                    const card = document.createElement('div');
                    card.className = 'border border-gray-200 rounded-lg p-2 bg-gray-50 flex flex-col items-center gap-2';
                    
                    const img = document.createElement('img');
                    img.src = localBlobMap.get(file.name) || '';
                    img.className = 'w-full h-24 object-contain rounded border bg-white';

                    const btnSelect = document.createElement('button');
                    btnSelect.type = 'button';
                    btnSelect.className = 'w-full py-1 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700';
                    btnSelect.innerText = 'Sisipkan';
                    btnSelect.onclick = function() {
                        const customAlt = modalAltInput ? modalAltInput.value.trim() : '';
                        insertImageTagToContent(file.name, customAlt || file.name);
                        closeImageModal();
                    };

                    card.appendChild(img);
                    card.appendChild(btnSelect);
                    modalGrid.appendChild(card);
                });
            }

            document.getElementById('imageModal').classList.remove('hidden');
        };

        window.closeImageModal = function() {
            document.getElementById('imageModal').classList.add('hidden');
        };

        // ---- 1. SETUP UNDO / REDO HISTORY STACK ----
        let historyStack = [];
        let historyIndex = -1;
        let isUndoRedoAction = false;
        let typingTimer;

        function saveHistory() {
            if (isUndoRedoAction) return;
            const state = {
                value: inputKonten.value,
                selectionStart: inputKonten.selectionStart,
                selectionEnd: inputKonten.selectionEnd
            };
            
            // Cegah duplikasi mutlak beruntun
            if (historyStack.length > 0 && historyStack[historyIndex].value === state.value) return; 

            // Potong history kedepan jika user melakukan perubahan setelah Undo
            if (historyIndex < historyStack.length - 1) {
                historyStack = historyStack.slice(0, historyIndex + 1);
            }

            historyStack.push(state);
            historyIndex++;
            
            // Limitasi Memory
            if (historyStack.length > 50) {
                historyStack.shift();
                historyIndex--;
            }
        }

        function applyHistoryState(state) {
            if (!state) return;
            isUndoRedoAction = true;
            inputKonten.value = state.value;
            inputKonten.setSelectionRange(state.selectionStart, state.selectionEnd);
            updateLivePreview(); // Sinkronkan ke Preview
            isUndoRedoAction = false;
        }

        // Simpan titik mula
        saveHistory();

        // Event listener Undo / Redo
        inputKonten.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key.toLowerCase() === 'z') {
                e.preventDefault();
                if (historyIndex > 0) {
                    historyIndex--;
                    applyHistoryState(historyStack[historyIndex]);
                }
            } else if (e.ctrlKey && e.key.toLowerCase() === 'y') {
                e.preventDefault();
                if (historyIndex < historyStack.length - 1) {
                    historyIndex++;
                    applyHistoryState(historyStack[historyIndex]);
                }
            }
        });

        // Trigger Typing Delay agar history tersimpan saat ngetik normal
        inputKonten.addEventListener('input', function() {
            if (!isUndoRedoAction) {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(saveHistory, 500); 
            }
            updateLivePreview();
        });


        // ---- 2. MODIFIKASI FUNGSI TEKS REPLACEMENT (SYNC HISTORY) ----
        // Perbarui fungsi yang sudah ada ini:
        function applyTextReplacement(replacementText, selectStart, selectEnd) {
            inputKonten.focus();
            if (typeof inputKonten.setRangeText === 'function') {
                inputKonten.setRangeText(replacementText, selectStart, selectEnd, 'select');
            } else {
                inputKonten.setSelectionRange(selectStart, selectEnd);
                document.execCommand('insertText', false, replacementText);
            }
            saveHistory(); // Simpan history setiap kali tombol toolbox digunakan
        }

        // ---- 3. FUNGSI PEMBUKA/PENUTUP PREVIEW MODAL ----
        window.openPreviewModal = function() {
            document.getElementById('previewModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Kunci scroll layar utama
        };

        window.closePreviewModal = function() {
            document.getElementById('previewModal').classList.add('hidden');
            document.body.style.overflow = '';
        };
    });
</script>
@endpush