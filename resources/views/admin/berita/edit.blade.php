@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 py-8">
    
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.berita.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        <a href="{{ route('berita.show', $berita->slug) }}" target="_blank" class="text-sm font-medium text-blue-600 hover:underline">
            Lihat Pratinjau Tampilan &rarr;
        </a>
    </div>

    <!-- Error Handling -->
    @if ($errors->any())
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
            <ul class="list-disc pl-5 text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.berita.update', $berita->slug) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- KOLOM KIRI: Judul & Editor (75%) -->
            <div class="w-full lg:w-3/4 space-y-6">
                
                <!-- Input Judul -->
                <div>
                    <input type="text" name="judul_berita" value="{{ old('judul_berita', $berita->judul_berita) }}" placeholder="Tambahkan judul..." 
                        class="w-full text-3xl font-bold p-4 border-0 border-b-2 border-transparent hover:border-gray-200 focus:border-blue-500 focus:ring-0 bg-transparent transition-colors placeholder-gray-400" required>
                </div>

                <!-- Input Konten -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <textarea name="konten" id="editor" rows="20" placeholder="Mulai menulis konten di sini..." 
                        class="w-full p-4 border-0 focus:ring-0 text-gray-700 resize-y" required>{{ old('konten', $berita->konten) }}</textarea>
                </div>

            </div>

            <!-- KOLOM KANAN: Sidebar Setting (25%) -->
            <div class="w-full lg:w-1/4 space-y-6">
                
                <!-- Box Publikasi -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg font-semibold text-gray-800">
                        Perbarui Status
                    </div>
                    <div class="p-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Publikasi</label>
                            <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="Draft" {{ old('status', $berita->status) == 'Draft' ? 'selected' : '' }}>Konsep (Draft)</option>
                                <option value="Terbit" {{ old('status', $berita->status) == 'Terbit' ? 'selected' : '' }}>Terbitkan</option>
                            </select>
                        </div>
                        
                        <div class="text-xs text-gray-500 bg-gray-50 p-2 rounded border border-gray-100">
                            Terakhir diubah: {{ \Carbon\Carbon::parse($berita->updated_at)->format('d M Y, H:i') }}
                        </div>

                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Perbarui Berita
                        </button>
                    </div>
                </div>

                <!-- Box Lampiran / Media -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 rounded-t-lg font-semibold text-gray-800">
                        File Lampiran (Opsional)
                    </div>
                    <div class="p-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">URL Dokumen</label>
                        <input type="url" name="lampiran_url" value="{{ old('lampiran_url', $berita->lampiran_url) }}" placeholder="https://drive.google.com/..." 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @if($berita->lampiran_url)
                            <a href="{{ $berita->lampiran_url }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-2 inline-block font-medium">Buka Tautan Saat Ini &nearr;</a>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection