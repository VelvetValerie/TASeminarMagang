@extends('layouts.app')

@section('title', 'Peninjauan Publikasi - Kanreg VIII BKN')

@section('content')
<style>
    .preview-content-style h2 { font-size: 1.5rem !important; font-weight: 700 !important; margin: 1.15rem 0 0.5rem !important; color: #1f2937 !important; }
    .preview-content-style h3 { font-size: 1.25rem !important; font-weight: 700 !important; margin: 1rem 0 0.5rem !important; color: #374151 !important; }
    .preview-content-style blockquote { border-left: 4px solid #3b82f6 !important; padding-left: 1rem !important; font-style: italic !important; color: #4b5563 !important; margin: 1rem 0 !important; }
    .preview-content-style ul { list-style-type: disc !important; padding-left: 1.5rem !important; margin: 0.75rem 0 !important; }
    .preview-content-style ol { list-style-type: decimal !important; padding-left: 1.5rem !important; margin: 0.75rem 0 !important; }
    .preview-content-style ol[style*="lower-alpha"] { list-style-type: lower-alpha !important; }
    .preview-content-style ol[style*="lower-roman"] { list-style-type: lower-roman !important; }
    .preview-content-style img { max-width: 100%; height: auto; border-radius: 0.5rem; }
    .preview-content-style p, .preview-content-style div { margin-bottom: 0.75rem; line-height: 1.65; }
    .preview-content-style .content-side-by-side { display: flex !important; align-items: center; gap: 1.5rem; margin: 1.25rem 0 !important; padding: 0 !important; border: none !important; background: transparent !important; clear: both; }
    .preview-content-style .content-side-by-side.image-right, .preview-content-style .content-side-by-side.md\:flex-row-reverse { flex-direction: row-reverse; }
    .preview-content-style .content-side-by-side.image-center { flex-direction: column !important; }
    .preview-content-style .content-side-by-side .side-image-col { flex: 0 0 50%; max-width: 50%; text-align: center; margin-bottom: 0 !important; }
    .preview-content-style .content-side-by-side .side-text-col { flex: 1 1 0%; min-width: 0; margin-bottom: 0 !important; }
    .preview-content-style .content-carousel { position: relative; overflow: hidden; border-radius: 0.75rem; background: #0f172a; margin: 1.25rem 0 !important; clear: both; }
    .preview-content-style .content-carousel .carousel-slide { display: none; width: 100%; }
    .preview-content-style .content-carousel .carousel-slide.active { display: block; }
    .preview-content-style .content-carousel .carousel-slide img { width: 100%; max-height: 400px; object-fit: contain; margin: 0 auto; border-radius: 0; display: block; }
    .preview-content-style .content-carousel .carousel-btn { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(15,23,42,0.7); color: #fff; border: none; width: 34px; height: 34px; border-radius: 9999px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 16px; z-index: 10; }
    .preview-content-style .content-carousel .carousel-prev { left: 10px; }
    .preview-content-style .content-carousel .carousel-next { right: 10px; }
    .preview-content-style .content-carousel .carousel-dots { position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); display: flex; gap: 6px; z-index: 10; }
    .preview-content-style .content-carousel .carousel-dot { width: 8px; height: 8px; border-radius: 9999px; background: rgba(255,255,255,0.45); cursor: pointer; }
    .preview-content-style .content-carousel .carousel-dot.active { background: #fff; width: 20px; }
    .preview-content-style .content-carousel .carousel-counter { position: absolute; top: 10px; right: 10px; background: rgba(15,23,42,0.75); color: #fff; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 9999px; z-index: 10; }
</style>

<div class="container mx-auto px-4 py-6 max-w-7xl space-y-5">

    <!-- HEADER LAMAN -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b-2 border-black pb-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 uppercase tracking-tight">
                Peninjauan &amp; Persetujuan Publikasi
            </h1>
            <p class="text-xs sm:text-sm font-semibold text-gray-600 mt-0.5">
                Laman khusus Administrator untuk memeriksa pengajuan dari Humas, menerbitkan (Accept), atau mengembalikan untuk revisi (Reject)
            </p>
        </div>
        <div class="flex items-center gap-2 text-xs font-extrabold">
            <span class="border-2 border-black bg-amber-200 text-amber-950 px-3 py-1.5 rounded-lg">
                Pending: {{ $countPending ?? 0 }}
            </span>
            <span class="border-2 border-black bg-rose-200 text-rose-950 px-3 py-1.5 rounded-lg">
                Revisi: {{ $countRevisi ?? 0 }}
            </span>
            <span class="border-2 border-black bg-slate-200 text-slate-900 px-3 py-1.5 rounded-lg">
                Draft: {{ $countDraft ?? 0 }}
            </span>
        </div>
    </div>

    <!-- NOTIFIKASI SUKSES / ERROR -->
    @if(session('success'))
        <div class="border-2 border-black bg-emerald-100 p-3 text-xs sm:text-sm font-bold text-emerald-900 flex items-center justify-between shadow-xs">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="font-black text-emerald-900 ml-3">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="border-2 border-black bg-rose-100 p-3 text-xs sm:text-sm font-bold text-rose-900">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- TAB STATUS NAVIGASI -->
    <div class="flex flex-wrap items-center gap-2">
        @php
            $currentTab = $tab ?? 'Pending';
            $tabs = [
                'Pending' => ['label' => 'Menunggu Review (Pending)', 'count' => $countPending ?? 0, 'active' => 'bg-amber-400 text-black', 'badge' => 'bg-black text-amber-300'],
                'Revisi'  => ['label' => 'Dalam Revisi', 'count' => $countRevisi ?? 0, 'active' => 'bg-rose-500 text-white', 'badge' => 'bg-white text-rose-700'],
                'Draft'   => ['label' => 'Konsep (Draft)', 'count' => $countDraft ?? 0, 'active' => 'bg-slate-700 text-white', 'badge' => 'bg-white text-slate-800'],
                'Semua'   => ['label' => 'Semua Belum Terbit', 'count' => ($countPending ?? 0) + ($countRevisi ?? 0) + ($countDraft ?? 0), 'active' => 'bg-blue-600 text-white', 'badge' => 'bg-white text-blue-700'],
            ];
        @endphp

        @foreach($tabs as $tabKey => $meta)
            <a href="{{ route('admin.berita.draft', array_merge(request()->except('page'), ['tab' => $tabKey])) }}"
               class="inline-flex items-center gap-2 border-2 border-black px-3.5 py-2 text-xs font-black uppercase tracking-wide transition shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] {{ $currentTab === $tabKey ? $meta['active'] : 'bg-white text-gray-800 hover:bg-gray-100' }}">
                <span>{{ $meta['label'] }}</span>
                <span class="px-1.5 py-0.5 text-[10px] rounded-full font-black {{ $currentTab === $tabKey ? $meta['badge'] : 'bg-gray-200 text-gray-800' }}">
                    {{ $meta['count'] }}
                </span>
            </a>
        @endforeach
    </div>

    <!-- KOTAK UTAMA -->
    <div class="border-2 border-black bg-white p-4 md:p-6 relative shadow-sm space-y-4">

        <!-- KONTROL PENCARIAN, KATEGORI & URUTAN -->
        <form method="GET" action="{{ route('admin.berita.draft') }}" class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b-2 border-black">
            <input type="hidden" name="tab" value="{{ $currentTab }}">

            <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul berita / informasi..."
                       class="w-full sm:w-72 border-2 border-black px-3 py-1.5 text-xs sm:text-sm font-semibold focus:outline-none bg-gray-50 focus:bg-white">
                <select name="kategori" onchange="this.form.submit()" class="border-2 border-black px-3 py-1.5 text-xs sm:text-sm font-bold bg-white focus:outline-none">
                    <option value="">Semua Kategori</option>
                    <option value="Berita" {{ request('kategori') == 'Berita' ? 'selected' : '' }}>Berita</option>
                    <option value="Informasi Resmi" {{ request('kategori') == 'Informasi Resmi' ? 'selected' : '' }}>Informasi Resmi</option>
                </select>
                <button type="submit" class="border-2 border-black bg-slate-900 text-white px-3 py-1.5 text-xs font-bold uppercase hover:bg-slate-800">Cari</button>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs font-bold uppercase text-gray-700">Urutkan:</span>
                <select name="sort" onchange="this.form.submit()" class="border-2 border-black px-3 py-1.5 text-xs sm:text-sm font-bold bg-white focus:outline-none">
                    <option value="terbaru" {{ ($sort ?? '') == 'terbaru' ? 'selected' : '' }}>Terbaru Diperbarui</option>
                    <option value="terlama" {{ ($sort ?? '') == 'terlama' ? 'selected' : '' }}>Terlama Dibuat</option>
                    <option value="az" {{ ($sort ?? '') == 'az' ? 'selected' : '' }}>Judul A - Z</option>
                </select>
            </div>
        </form>

        <!-- TABEL DAFTAR PENGAJUAN -->
        <div class="border-2 border-black overflow-x-auto">
            <table class="w-full border-collapse border-black min-w-[820px] text-left">
                <thead>
                    <tr class="border-b-2 border-black bg-gray-100 font-bold text-xs uppercase tracking-wider text-gray-900">
                        <th class="border-r-2 border-black p-3 text-center w-12">No</th>
                        <th class="border-r-2 border-black p-3">Judul &amp; Informasi Pengajuan</th>
                        <th class="border-r-2 border-black p-3 text-center w-36">Kategori</th>
                        <th class="border-r-2 border-black p-3 text-center w-36">Status</th>
                        <th class="p-3 text-center w-64">Tindakan Persetujuan</th>
                    </tr>
                </thead>
                <tbody class="text-xs sm:text-sm font-semibold divide-y-2 divide-black">
                    @forelse ($drafts as $i => $item)
                        @php
                            $isInfo = ($item->kategori_publikasi ?? 'Berita') === 'Informasi Resmi';
                            $editUrl = $isInfo
                                ? route('admin.informasi.edit', $item->slug) . '?from=draft'
                                : route('admin.berita.edit', $item->slug) . '?from=draft';
                            $previewPayload = [
                                'judul'      => $item->judul_berita,
                                'kategori'   => $item->kategori_publikasi ?? 'Berita',
                                'penulis'    => $item->penulis->username ?? 'Humas',
                                'tanggal'    => \Carbon\Carbon::parse($item->updated_at)->format('d M Y, H:i') . ' WITA',
                                'thumbnail'  => $item->thumbnail ? asset('storage/' . $item->thumbnail) : '',
                                'caption'    => $item->caption_thumbnail ?? '',
                                'konten'     => $item->konten ?? '',
                                'lampiran'   => $item->lampiran_url ?? '',
                                'status'     => $item->status,
                                'komentar'   => $item->komentar_revisi ?? '',
                            ];
                        @endphp
                        <tr class="border-b-2 border-black hover:bg-amber-50/40 transition">
                            <td class="border-r-2 border-black p-3 text-center font-bold text-gray-600">
                                {{ $drafts->firstItem() + $i }}
                            </td>
                            <td class="border-r-2 border-black p-3">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="font-black text-gray-900 text-sm sm:text-base leading-snug">
                                        {{ $item->judul_berita }}
                                    </span>
                                    @if($item->komentar_revisi === 'TELAH DIREVISI')
                                        <span class="inline-flex items-center gap-1 border border-emerald-700 bg-emerald-100 text-emerald-900 px-2 py-0.5 text-[10px] font-black uppercase rounded-full">
                                            TELAH DIREVISI
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 font-medium mt-1 flex flex-wrap items-center gap-x-3 gap-y-1">
                                    <span>Penulis: <b class="text-gray-800">{{ $item->penulis->username ?? 'Administrator' }}</b></span>
                                    <span>Diperbarui: <b>{{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y, H:i') }} WITA</b></span>
                                </div>

                                @if($item->status === 'Revisi' && !empty($item->komentar_revisi) && $item->komentar_revisi !== 'TELAH DIREVISI')
                                    <div class="mt-2 p-2 rounded border border-rose-300 bg-rose-50 text-xs text-rose-900">
                                        <span class="font-extrabold uppercase text-[10px] text-rose-700 block mb-0.5">Catatan Revisi Admin:</span>
                                        <p class="font-medium leading-snug">{{ $item->komentar_revisi }}</p>
                                    </div>
                                @endif
                            </td>
                            <td class="border-r-2 border-black p-3 text-center">
                                @if($isInfo)
                                    <span class="inline-block border-2 border-black bg-sky-200 text-sky-950 px-2.5 py-0.5 text-[11px] font-black uppercase rounded-full">
                                        Informasi Resmi
                                    </span>
                                @else
                                    <span class="inline-block border-2 border-black bg-slate-200 text-slate-900 px-2.5 py-0.5 text-[11px] font-black uppercase rounded-full">
                                        Berita
                                    </span>
                                @endif
                            </td>
                            <td class="border-r-2 border-black p-3 text-center">
                                @if($item->status === 'Pending')
                                    <span class="inline-block border-2 border-black bg-amber-300 text-amber-950 px-2.5 py-0.5 text-[11px] font-black uppercase rounded-full">
                                        Pending
                                    </span>
                                @elseif($item->status === 'Revisi')
                                    <span class="inline-block border-2 border-black bg-rose-200 text-rose-950 px-2.5 py-0.5 text-[11px] font-black uppercase rounded-full">
                                        Revisi
                                    </span>
                                @else
                                    <span class="inline-block border-2 border-black bg-gray-200 text-gray-800 px-2.5 py-0.5 text-[11px] font-black uppercase rounded-full">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="p-3">
                                <div class="flex flex-wrap items-center justify-center gap-1.5">
                                    <!-- PREVIEW CEPAT -->
                                    <button type="button"
                                            data-preview="{{ htmlspecialchars(json_encode($previewPayload), ENT_QUOTES, 'UTF-8') }}"
                                            onclick="openReviewPreviewModal(this)"
                                            class="inline-flex items-center gap-1 border-2 border-black bg-white hover:bg-gray-100 text-gray-900 font-extrabold px-2.5 py-1 text-[11px] uppercase transition cursor-pointer"
                                            title="Pratinjau Konten">
                                        Preview
                                    </button>

                                    <!-- BUKA EDITOR -->
                                    <a href="{{ $editUrl }}"
                                       class="inline-flex items-center gap-1 border-2 border-black bg-sky-200 hover:bg-sky-300 text-sky-950 font-extrabold px-2.5 py-1 text-[11px] uppercase transition cursor-pointer"
                                       title="Buka di Editor">
                                        Edit
                                    </a>

                                    <!-- TERIMA (PUBLISH) -->
                                    <button type="button"
                                            onclick="openApproveModal('{{ $item->id_berita }}', '{{ addslashes($item->judul_berita) }}')"
                                            class="inline-flex items-center gap-1 border-2 border-black bg-emerald-400 hover:bg-emerald-500 text-black font-extrabold px-2.5 py-1 text-[11px] uppercase transition cursor-pointer"
                                            title="Setujui dan Terbitkan Sekarang">
                                        Terima
                                    </button>

                                    <!-- TOLAK (REVISI) -->
                                    <button type="button"
                                            onclick="openRejectModal('{{ $item->id_berita }}', '{{ addslashes($item->judul_berita) }}')"
                                            class="inline-flex items-center gap-1 border-2 border-black bg-rose-500 hover:bg-rose-600 text-white font-extrabold px-2.5 py-1 text-[11px] uppercase transition cursor-pointer"
                                            title="Kembalikan untuk Revisi">
                                        Revisi
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500 font-bold">
                                Tidak ada publikasi pada tab "{{ $currentTab }}" saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINASI -->
        @if($drafts->hasPages())
            <div class="pt-2">
                {{ $drafts->appends(request()->query())->links() }}
            </div>
        @endif

    </div>
</div>
@endsection

@push('modals')
<!-- MODAL KONFIRMASI TERIMA / PUBLISH -->
<div id="approveModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs">
    <div class="w-full max-w-md bg-white border-2 border-black rounded-lg shadow-2xl p-6">
        <h3 class="text-lg font-black text-gray-900 uppercase mb-2">
            Setujui &amp; Terbitkan Publikasi
        </h3>
        <p class="text-sm text-gray-600 mb-5">
            Anda akan menyetujui dan menerbitkan publikasi <strong id="approve_judul" class="text-gray-900"></strong> ke portal publik. Lanjutkan?
        </p>
        <form id="approveForm" method="POST" class="flex justify-end gap-2">
            @csrf
            <button type="button" onclick="closeApproveModal()" class="px-4 py-2 text-xs font-bold uppercase border-2 border-black bg-gray-100 hover:bg-gray-200">Batal</button>
            <button type="submit" class="px-4 py-2 text-xs font-black uppercase border-2 border-black bg-emerald-500 hover:bg-emerald-600 text-white">Ya, Terbitkan Sekarang</button>
        </form>
    </div>
</div>

<!-- MODAL TOLAK / MINTA REVISI -->
<div id="rejectModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-xs">
    <div class="w-full max-w-lg bg-white border-2 border-black rounded-lg shadow-2xl p-6">
        <h3 class="text-lg font-black text-rose-700 uppercase mb-1">
            Kembalikan Untuk Revisi (Reject)
        </h3>
        <p class="text-xs sm:text-sm text-gray-600 mb-4">
            Publikasi <strong id="reject_judul" class="text-gray-900"></strong> akan diubah statusnya menjadi <span class="font-bold text-rose-700">Revisi</span>. Berikan alasan / catatan perbaikan yang jelas untuk Pegawai Humas:
        </p>
        <form id="rejectForm" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-black uppercase text-gray-800 mb-1">Alasan / Catatan Revisi <span class="text-rose-600">*</span></label>
                <textarea name="komentar_revisi" id="reject_komentar" rows="4" required minlength="3"
                          placeholder="Contoh: Mohon perbaiki penulisan tanggal pelaksanaan pada paragraf kedua dan tambahkan foto dokumentasi kegiatan..."
                          class="w-full border-2 border-black p-3 text-sm rounded focus:outline-none focus:ring-2 focus:ring-rose-300"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 text-xs font-bold uppercase border-2 border-black bg-gray-100 hover:bg-gray-200">Batal</button>
                <button type="submit" class="px-4 py-2 text-xs font-black uppercase border-2 border-black bg-rose-600 hover:bg-rose-700 text-white">Kirim Catatan Revisi</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL PREVIEW KONTEN PENGAJUAN -->
<div id="reviewPreviewModal" class="hidden fixed inset-0 z-[95] bg-gray-900/80 flex justify-center items-center backdrop-blur-sm p-4 sm:p-8">
    <div class="bg-white border-2 border-black rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col">
        <div class="flex justify-between items-center p-4 border-b-2 border-black bg-gray-50 rounded-t-xl">
            <div>
                <span id="rpKategori" class="inline-block px-2.5 py-0.5 text-[10px] font-black uppercase border border-black rounded-full bg-sky-200 text-sky-950 mb-1">Berita</span>
                <h3 id="rpJudul" class="text-lg font-black text-gray-900 leading-snug">Judul Publikasi</h3>
                <p id="rpMeta" class="text-xs text-gray-500 mt-0.5"></p>
            </div>
            <button type="button" onclick="closeReviewPreviewModal()" class="text-gray-600 hover:text-black font-black text-xl px-2">&times;</button>
        </div>
        <div class="p-6 overflow-y-auto flex-1 space-y-4">
            <div id="rpKomentarBox" class="hidden p-3 rounded-lg border-2 border-black text-xs"></div>
            <div id="rpThumbBox" class="hidden rounded-lg overflow-hidden border border-gray-200 bg-gray-50">
                <img id="rpThumbImg" src="" alt="Thumbnail" class="w-full max-h-80 object-cover">
                <div id="rpThumbCap" class="px-3 py-1.5 text-xs text-gray-600 italic bg-gray-100 border-t border-gray-200"></div>
            </div>
            <div id="rpKonten" class="preview-content-style text-gray-800"></div>
            <div id="rpLampiranBox" class="hidden pt-3 border-t border-gray-200">
                <a id="rpLampiranLink" href="#" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-700 hover:underline">Buka Lampiran Dokumen &nearr;</a>
            </div>
        </div>
        <div class="p-3 border-t-2 border-black bg-gray-50 rounded-b-xl flex justify-end">
            <button type="button" onclick="closeReviewPreviewModal()" class="px-4 py-1.5 text-xs font-black uppercase border-2 border-black bg-white hover:bg-gray-100">Tutup Pratinjau</button>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function openApproveModal(id, judul) {
        document.getElementById('approve_judul').innerText = `"${judul}"`;
        document.getElementById('approveForm').action = `/admin/berita/${id}/approve`;
        document.getElementById('approveModal').classList.remove('hidden');
    }
    function closeApproveModal() {
        document.getElementById('approveModal').classList.add('hidden');
    }

    function openRejectModal(id, judul) {
        document.getElementById('reject_judul').innerText = `"${judul}"`;
        document.getElementById('rejectForm').action = `/admin/berita/${id}/reject`;
        document.getElementById('reject_komentar').value = '';
        document.getElementById('rejectModal').classList.remove('hidden');
        setTimeout(() => document.getElementById('reject_komentar').focus(), 50);
    }
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }

    function initPreviewCarousels(container) {
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
            if (prevBtn) prevBtn.onclick = () => show(idx - 1);
            if (nextBtn) nextBtn.onclick = () => show(idx + 1);
            dots.forEach((d, i) => { d.onclick = () => show(i); });
        });
    }

    function openReviewPreviewModal(btn) {
        const data = JSON.parse(btn.getAttribute('data-preview'));
        document.getElementById('rpKategori').innerText = data.kategori;
        document.getElementById('rpJudul').innerText = data.judul;
        document.getElementById('rpMeta').innerText = `Penulis: ${data.penulis} • Diperbarui: ${data.tanggal} • Status: ${data.status}`;

        const kBox = document.getElementById('rpKomentarBox');
        if (data.komentar === 'TELAH DIREVISI') {
            kBox.className = 'p-3 rounded-lg border-2 border-emerald-600 bg-emerald-50 text-emerald-900 text-xs font-bold';
            kBox.innerText = 'TELAH DIREVISI — Pengajuan ini telah diperbaiki oleh Humas dan diajukan ulang.';
            kBox.classList.remove('hidden');
        } else if (data.komentar) {
            kBox.className = 'p-3 rounded-lg border-2 border-rose-500 bg-rose-50 text-rose-900 text-xs font-semibold';
            kBox.innerHTML = `<span class="font-black uppercase block mb-0.5">Catatan Revisi Sebelumnya:</span>${data.komentar}`;
            kBox.classList.remove('hidden');
        } else {
            kBox.classList.add('hidden');
        }

        const tBox = document.getElementById('rpThumbBox');
        if (data.thumbnail) {
            document.getElementById('rpThumbImg').src = data.thumbnail;
            document.getElementById('rpThumbCap').innerText = data.caption || '';
            tBox.classList.remove('hidden');
        } else {
            tBox.classList.add('hidden');
        }

        const kontenEl = document.getElementById('rpKonten');
        kontenEl.innerHTML = data.konten || '<p class="text-gray-400 italic">Tidak ada konten.</p>';
        initPreviewCarousels(kontenEl);

        const lBox = document.getElementById('rpLampiranBox');
        if (data.lampiran) {
            document.getElementById('rpLampiranLink').href = data.lampiran;
            lBox.classList.remove('hidden');
        } else {
            lBox.classList.add('hidden');
        }

        document.getElementById('reviewPreviewModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeReviewPreviewModal() {
        document.getElementById('reviewPreviewModal').classList.add('hidden');
        document.body.style.overflow = '';
    }
</script>
@endpush
