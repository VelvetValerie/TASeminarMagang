@extends('layouts.app')

@push('styles')
<style>
    /* Proteksi lapis 1: CSS */
    #previewKonten img, #previewKonten image, #previewKonten picture, #previewKonten figure, #previewKonten svg {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        width: 0 !important;
        height: 0 !important;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-8">
    
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.berita.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        <span class="text-sm font-medium text-gray-400 italic">Cek Live Preview di bawah &darr;</span>
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

    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="flex flex-col lg:flex-row gap-8 mb-12">
            <!-- KOLOM KIRI -->
            <div class="w-full lg:w-3/4 space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Judul Berita</label>
                    <input type="text" id="inputJudul" name="judul_berita" value="{{ old('judul_berita') }}" placeholder="Ketik judul berita di sini..." 
                        class="w-full text-xl md:text-2xl font-bold p-3 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors placeholder-gray-400" required autofocus>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Konten Berita</label>
                    <textarea name="konten" id="inputKonten" rows="15" placeholder="Mulai menulis konten di sini..." 
                        class="w-full p-4 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:ring-2 focus:ring-blue-200 text-gray-700 resize-y" required>{{ old('konten') }}</textarea>
                </div>
            </div>

            <!-- KOLOM KANAN -->
            <div class="w-full lg:w-1/4 space-y-6">
                <!-- Box Publikasi -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg font-bold text-gray-800">Publikasi</div>
                    <div class="p-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full bg-white border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-500">
                                <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Konsep (Draft)</option>
                                <option value="Terbit" {{ old('status') == 'Terbit' ? 'selected' : '' }}>Terbitkan</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                            Simpan Berita
                        </button>
                    </div>
                </div>

                <!-- Box Gambar Thumbnail -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg font-bold text-gray-800">Thumbnail Berita</div>
                    <div class="p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Unggah Gambar Utama</label>
                        <input type="file" name="thumbnail" id="inputThumbnail" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 bg-white border border-gray-300 rounded-md">
                        <p class="text-xs text-gray-500 mt-2">Maksimal ukuran 2MB (JPG, PNG, WEBP).</p>
                    </div>
                </div>

                <!-- Box Lampiran / Media -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg font-bold text-gray-800">File Lampiran</div>
                    <div class="p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">URL Dokumen (Opsional)</label>
                        <input type="url" name="lampiran_url" value="{{ old('lampiran_url') }}" placeholder="https://drive.google.com/..." class="w-full bg-white border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-500">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- SECTION LIVE PREVIEW -->
    <div class="border-t-2 border-dashed border-gray-300 pt-8 mt-8">
        <div class="flex items-center gap-2 mb-6 text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            <h2 class="text-xl font-bold">Live Preview (Tampilan Portal)</h2>
        </div>
        
        <article class="bg-white p-6 md:p-10 rounded-xl border border-gray-200 shadow-sm flex flex-col max-w-4xl mx-auto">
            <h1 id="previewJudul" class="text-2xl md:text-4xl font-bold text-gray-900 leading-snug mb-4">
                Judul Berita Akan Muncul Di Sini...
            </h1>
            
            <div class="flex items-center gap-4 text-xs md:text-sm text-gray-500 pb-6 border-b border-gray-100 mb-6">
                <span>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                <span>•</span>
                <span>Admin / Penulis</span>
            </div>

            <!-- Pratinjau Thumbnail (Hidden secara default) -->
            <div id="previewThumbnailContainer" class="hidden mb-8 rounded-lg overflow-hidden border border-gray-100 relative">
                <img id="previewThumbnailImage" src="" alt="Preview Thumbnail" class="w-full h-auto object-cover max-h-[450px]">
                <p id="previewThumbnailCaption" class="text-xs text-gray-500 italic p-2 text-center bg-gray-50 border-t border-gray-200">
                    Ilustrasi: <span id="captionText">Judul Berita Akan Muncul Di Sini...</span>
                </p>
            </div>

            <div id="previewKonten" class="space-y-5 text-gray-700 leading-relaxed text-base md:text-lg">
                <p class="text-gray-400 italic">Konten berita akan diperbarui secara otomatis saat Anda mengetik di editor...</p>
            </div>
        </article>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputJudul = document.getElementById('inputJudul');
        const inputKonten = document.getElementById('inputKonten');
        const inputThumbnail = document.getElementById('inputThumbnail');
        
        const previewJudul = document.getElementById('previewJudul');
        const previewKonten = document.getElementById('previewKonten');
        const previewThumbnailContainer = document.getElementById('previewThumbnailContainer');
        const previewThumbnailImage = document.getElementById('previewThumbnailImage');
        const captionText = document.getElementById('captionText');

        // Fungsi proteksi lapis 2: Menghapus tag gambar pakai JS
        function hapusGambarDariString(htmlString) {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = htmlString;
            
            // Cari semua elemen yang berbau gambar dan hapus dari memory
            const images = tempDiv.querySelectorAll('img, picture, figure, image, svg');
            images.forEach(img => img.remove());
            
            return tempDiv.innerHTML;
        }

        inputJudul.addEventListener('input', function() {
            const val = this.value.trim() !== '' ? this.value : 'Judul Berita Akan Muncul Di Sini...';
            previewJudul.innerText = val;
            captionText.innerText = val;
        });

        inputKonten.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                // Bersihkan gambar dulu, baru ubah enter jadi <br>
                let kontenBersih = hapusGambarDariString(this.value);
                previewKonten.innerHTML = kontenBersih.replace(/\n/g, '<br>');
            } else {
                previewKonten.innerHTML = '<p class="text-gray-400 italic">Konten berita akan diperbarui secara otomatis saat Anda mengetik di editor...</p>';
            }
        });

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
    });
</script>
@endpush