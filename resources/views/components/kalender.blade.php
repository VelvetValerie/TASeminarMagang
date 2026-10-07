<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    
    .filter-dropdown-container:hover .filter-dropdown,
    .filter-dropdown-container:focus-within .filter-dropdown {
        opacity: 1; visibility: visible;
    }
</style>

<div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-6 md:p-8 relative">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b-2 border-gray-100 pb-4">
        <div>
            <h3 class="text-2xl md:text-3xl font-bold text-gray-900">Agenda Jadwal</h3>
            <p class="text-sm text-gray-500 mt-1">Pantau seluruh rangkaian jadwal dan kegiatan terkini</p>
        </div>
        
        <div class="relative filter-dropdown-container z-50">
            <button class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 transition-colors flex items-center gap-2 font-medium text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter Kategori
            </button>
            <div class="filter-dropdown absolute right-0 top-full mt-2 w-80 bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 invisible transition-all duration-200 p-5">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tampilkan Jenis Kegiatan:</h4>
                    <button type="button" class="btn-reset-filter text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">Reset</button>
                </div>
                
                <!-- 11 Filter Jenis Kegiatan -->
                <div class="space-y-3">
                    <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                        <input type="checkbox" value="Pengembangan Karier (UDIN/UPKP)" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                        <span class="text-sm font-medium leading-tight">Pengembangan Karier (UDIN/UPKP)</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                        <input type="checkbox" value="SKD CPNS" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                        <span class="text-sm font-medium leading-tight">SKD CPNS</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                        <input type="checkbox" value="SKB CPNS" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                        <span class="text-sm font-medium leading-tight">SKB CPNS</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                        <input type="checkbox" value="PPPK" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                        <span class="text-sm font-medium leading-tight">PPPK</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                        <input type="checkbox" value="SKD Sekolah Kedinasan" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                        <span class="text-sm font-medium leading-tight">SKD Sekolah Kedinasan</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                        <input type="checkbox" value="Seleksi Lanjutan Sekolah Kedinasan" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                        <span class="text-sm font-medium leading-tight">Seleksi Lanjutan Sekolah Kedinasan</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                        <input type="checkbox" value="Seleksi Selain ASN (BLUD, perangkat desa, dll)" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                        <span class="text-sm font-medium leading-tight">Seleksi Selain ASN</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                        <input type="checkbox" value="Seleksi Lainnya (uji kompetensi, beasiswa, dll)" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                        <span class="text-sm font-medium leading-tight">Seleksi Lainnya</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                        <input type="checkbox" value="Sertifikasi CAT" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                        <span class="text-sm font-medium leading-tight">Sertifikasi CAT</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                        <input type="checkbox" value="Simulasi CAT" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                        <span class="text-sm font-medium leading-tight">Simulasi CAT</span>
                    </label>
                    <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                        <input type="checkbox" value="KDKMP dan KNMP" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                        <span class="text-sm font-medium leading-tight">KDKMP dan KNMP</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between mb-6 bg-gray-50 border border-gray-200 rounded-xl p-3 relative z-40">
        <button id="btnPrevMonth" class="p-2 bg-white border border-gray-200 rounded-lg hover:border-gray-400 transition-colors shrink-0 shadow-sm">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        
        <div class="flex-1 flex justify-between items-center overflow-hidden px-2 md:px-8">
            <span id="prevMonthLabel" class="flex-1 text-right text-sm md:text-base font-medium cursor-pointer text-gray-400 hover:text-black transition-colors hidden sm:block truncate pr-2 md:pr-4"></span>
            <div class="flex flex-col items-center justify-center flex-none w-40 md:w-48">
                <span id="currMonthLabel" class="text-black font-bold text-base md:text-lg whitespace-nowrap"></span>
                <div class="h-1 w-1/2 bg-[#F97316] mt-1 rounded-full"></div>
            </div>
            <span id="nextMonthLabel" class="flex-1 text-left text-sm md:text-base font-medium cursor-pointer text-gray-400 hover:text-black transition-colors hidden sm:block truncate pl-2 md:pl-4"></span>
        </div>
        
        <button id="btnNextMonth" class="p-2 bg-white border border-gray-200 rounded-lg hover:border-gray-400 transition-colors shrink-0 shadow-sm">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>

    <div id="calendarGridContainer" class="w-full relative z-30"></div>

    <div class="mt-6 flex justify-end relative z-30">
        <button id="btnOpenModal" class="p-2.5 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 hover:-translate-y-1 transition-all flex items-center justify-center group" title="Lihat selengkapnya">
            <span class="mr-2 text-sm font-bold">Lihat Semua Jadwal</span>
            <svg class="w-5 h-5 text-gray-700 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"></path>
            </svg>
        </button>
    </div>
</div>

@push('modals')
<div id="calendarModalOverlay" class="hidden fixed inset-0 z-100 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6 transition-opacity duration-300">
    <div class="bg-white w-full max-w-[95vw] md:max-w-7xl max-h-[95vh] rounded-2xl shadow-2xl flex flex-col relative overflow-hidden transform scale-100 transition-transform">
        
        <!-- Header Modal dengan Tambahan Filter -->
        <div class="flex-shrink-0 p-6 border-b border-gray-200 flex justify-between items-center bg-white relative z-50">
            <div><h2 class="text-xl md:text-3xl font-bold text-gray-900">Agenda Jadwal Lengkap</h2></div>
            
            <div class="flex items-center gap-3">
                <div class="relative filter-dropdown-container">
                    <button class="px-3 py-2 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 transition-colors flex items-center gap-2 font-medium text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <span class="hidden sm:inline">Filter</span>
                    </button>
                    <!-- Dropdown Filter Modal -->
                    <div class="filter-dropdown absolute right-0 top-full mt-2 w-80 bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 invisible transition-all duration-200 p-5 z-[60]">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tampilkan Jenis Kegiatan:</h4>
                            <button type="button" class="btn-reset-filter text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors">Reset</button>
                        </div>
                        <div class="space-y-3">
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                                <input type="checkbox" value="Pengembangan Karier (UDIN/UPKP)" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                                <span class="text-sm font-medium leading-tight">Pengembangan Karier (UDIN/UPKP)</span>
                            </label>
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                                <input type="checkbox" value="SKD CPNS" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                                <span class="text-sm font-medium leading-tight">SKD CPNS</span>
                            </label>
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                                <input type="checkbox" value="SKB CPNS" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                                <span class="text-sm font-medium leading-tight">SKB CPNS</span>
                            </label>
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                                <input type="checkbox" value="PPPK" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                                <span class="text-sm font-medium leading-tight">PPPK</span>
                            </label>
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                                <input type="checkbox" value="SKD Sekolah Kedinasan" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                                <span class="text-sm font-medium leading-tight">SKD Sekolah Kedinasan</span>
                            </label>
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                                <input type="checkbox" value="Seleksi Lanjutan Sekolah Kedinasan" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                                <span class="text-sm font-medium leading-tight">Seleksi Lanjutan Sekolah Kedinasan</span>
                            </label>
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                                <input type="checkbox" value="Seleksi Selain ASN (BLUD, perangkat desa, dll)" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                                <span class="text-sm font-medium leading-tight">Seleksi Selain ASN</span>
                            </label>
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                                <input type="checkbox" value="Seleksi Lainnya (uji kompetensi, beasiswa, dll)" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                                <span class="text-sm font-medium leading-tight">Seleksi Lainnya</span>
                            </label>
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                                <input type="checkbox" value="Sertifikasi CAT" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                                <span class="text-sm font-medium leading-tight">Sertifikasi CAT</span>
                            </label>
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                                <input type="checkbox" value="Simulasi CAT" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                                <span class="text-sm font-medium leading-tight">Simulasi CAT</span>
                            </label>
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                                <input type="checkbox" value="KDKMP dan KNMP" checked class="category-filter mt-0.5 w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                                <span class="text-sm font-medium leading-tight">KDKMP dan KNMP</span>
                            </label>
                        </div>
                    </div>
                </div>

                <button id="btnCloseModal" class="p-2 bg-gray-100 border-2 border-transparent hover:border-black text-gray-700 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
        
        <div class="flex-grow overflow-y-auto bg-gray-50 p-4 md:p-8 custom-scrollbar relative z-30">
            <div class="max-w-6xl mx-auto"><div id="modalCalendarGridContainer" class="w-full"></div></div>
        </div>
    </div>
</div>
@endpush

@push('modals')
<div id="dayEventsModal" class="hidden fixed inset-0 z-[150] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity">
    <div class="relative w-full max-w-lg bg-white rounded-xl p-5">
        <button id="btnCloseDayModal" class="absolute top-4 right-4 p-1 text-gray-400 hover:text-black transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <h3 id="dayModalTitle" class="text-lg font-bold text-gray-900 border-b-2 border-gray-100 pb-3 mb-4 pr-8">Daftar Kegiatan</h3>
        <div id="dayModalListContainer" class="max-h-[350px] overflow-y-auto space-y-3 custom-scrollbar pr-2"></div>
    </div>
</div>
@endpush

@push('modals')
<div id="eventDetailModal" class="hidden fixed inset-0 z-200 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity">
    <div class="relative w-full max-w-md bg-white rounded-xl p-5">
        <button id="btnCloseDetailModal" class="absolute top-4 right-4 p-1 text-gray-400 hover:text-black transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <h3 class="text-lg font-bold text-gray-900 border-b-2 border-gray-100 pb-3 mb-4 pr-8">Detail Kegiatan</h3>
        <div class="space-y-3 text-sm text-gray-800 bg-gray-50 p-4 border border-gray-200 rounded-lg">
            <p><span class="font-bold">Nama Kegiatan:</span> <span id="dtNama">-</span></p>
            <p><span class="font-bold">Jenis Kegiatan:</span> <span id="dtJenisKegiatan" class="capitalize">-</span></p>
            <p><span class="font-bold">Koordinator:</span> <span id="dtKoordinator">-</span></p>
            <p><span class="font-bold">Tanggal Mulai:</span> <span id="dtTanggalMulai">-</span></p>
            <p><span class="font-bold">Tanggal Berakhir:</span> <span id="dtTanggalBerakhir">-</span></p>
            <p><span class="font-bold">Lokasi:</span> <span id="dtLokasi">-</span></p>
            <p><span class="font-bold">Instansi:</span> <span id="dtInstansi">-</span></p>
            <p><span class="font-bold">Jumlah Peserta:</span> <span id="dtPeserta">-</span></p>
        </div>
        <div class="mt-5 flex justify-end">
            <button id="btnBackToDayModal" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 border-2 border-black rounded-lg text-sm font-bold transition-colors">Tutup</button>
        </div>
    </div>
</div>
@endpush

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        
        let rawKegiatan = [];
        
        try {
            const response = await fetch('/kalender-kegiatan');
            const apiData = await response.json();
            rawKegiatan = Array.isArray(apiData) ? apiData : (apiData.data || []);
        } catch (error) {
            console.error("Gagal mengambil data dari API, menggunakan data fallback:", error);
            const fallbackData = @json($kegiatan ?? []);
            rawKegiatan = Array.isArray(fallbackData) ? fallbackData : (fallbackData.data || Object.values(fallbackData || {}));
        }

        const categoryConfig = {
            "SKD CPNS": { color: "bg-[#FFD8B2] text-[#8A3B00] border-2 border-black" },
            "SKB CPNS": { color: "bg-[#FFD8B2] text-[#8A3B00] border-2 border-black" },
            "PPPK": { color: "bg-[#FFD8B2] text-[#8A3B00] border-2 border-black" },
            "SKD Sekolah Kedinasan": { color: "bg-[#FFD8B2] text-[#8A3B00] border-2 border-black" },
            "Seleksi Lanjutan Sekolah Kedinasan": { color: "bg-[#FFD8B2] text-[#8A3B00] border-2 border-black" },
            "Sertifikasi CAT": { color: "bg-[#D0E2FF] text-[#0043CE] border-2 border-black" },
            "Simulasi CAT": { color: "bg-[#D0E2FF] text-[#0043CE] border-2 border-black" },
            "Pengembangan Karier (UDIN/UPKP)": { color: "bg-[#C1F1D2] text-[#00512C] border-2 border-black" },
            "Seleksi Selain ASN (BLUD, perangkat desa, dll)": { color: "bg-[#E8DAFF] text-[#491D8B] border-2 border-black" },
            "Seleksi Lainnya (uji kompetensi, beasiswa, dll)": { color: "bg-[#E8DAFF] text-[#491D8B] border-2 border-black" },
            "KDKMP dan KNMP": { color: "bg-[#F3F4F6] text-[#1F2937] border-2 border-black" }
        };

        const eventsData = rawKegiatan.reduce((acc, item) => {
            const rawMulai = item.start || item['Tanggal Mulai'] || item.tanggal_mulai;
            const rawSelesai = item.end || item['Tanggal Selesai'] || item.tanggal_selesai;
            
            if (!rawMulai) return acc; 

            const safeMulai = String(rawMulai).replace(/ /g, 'T');
            const safeSelesai = rawSelesai ? String(rawSelesai).replace(/ /g, 'T') : safeMulai;

            const tglMulai = new Date(safeMulai);
            const tglSelesai = new Date(safeSelesai);

            if (isNaN(tglMulai.getTime())) return acc;

            const namaJenisMentah = item.extendedProps?.jenis_kegiatan || item.jenis?.nama_jeniskeg || item['Jenis Kegiatan'] || 'Seleksi Lainnya (uji kompetensi, beasiswa, dll)';
            const namaJenis = typeof namaJenisMentah === 'string' ? namaJenisMentah.trim() : namaJenisMentah;
            
            let badgeColor = categoryConfig[namaJenis] ? categoryConfig[namaJenis].color : 'bg-[#D0E2FF] text-[#0043CE] border-2 border-black';

            acc.push({
                id: item.id || item['ID Kegiatan'] || item.id_kegiatan || item.id_keg,
                title: item.title || item['Nama Kegiatan'] || item.nama_keg || '-',
                startDay: tglMulai.getDate(),
                endDay: tglSelesai.getDate(),
                month: tglMulai.getMonth(),
                year: tglMulai.getFullYear(),
                category: namaJenis,
                color: badgeColor,
                
                lokasi: item.extendedProps?.lokasi || item.lokasi?.nm_lokasi || item['Titik Lokasi'] || '-',
                
                instansi: item.extendedProps?.instansi || item.instansi?.nm_instansi || item.instansi?.nama_instansi || item['Instansi'] || '-',
                
                koordinator: item.extendedProps?.koordinator || item.koordinator?.nama_karyawan || item['Nama Karyawan Koordinator'] || '-',
                
                jumlah_peserta: item.extendedProps?.jumlah_peserta || item.jmlh_peserta || item['Jumlah Peserta'] || '-',
                
                status: item.status || 'Terkonfirmasi',
                rawMulai: tglMulai,
                rawSelesai: tglSelesai,
                rawDataAsli: item
            });

            return acc;
        }, []);

        const colStartMap = { 1: 'col-start-1', 2: 'col-start-2', 3: 'col-start-3', 4: 'col-start-4', 5: 'col-start-5', 6: 'col-start-6', 7: 'col-start-7' };
        const colSpanMap = { 1: 'col-span-1', 2: 'col-span-2', 3: 'col-span-3', 4: 'col-span-4', 5: 'col-span-5', 6: 'col-span-6', 7: 'col-span-7' };
        
        const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        const defaultTargetDate = new Date(2026, 9, 6); 
        let currentMonth = defaultTargetDate.getMonth();
        let currentYear = defaultTargetDate.getFullYear();
        const realTodayDate = new Date(); 

        const getFilteredEvents = () => {
            const checkedCategories = Array.from(document.querySelectorAll('.category-filter:checked')).map(cb => cb.value);
            const uniqueChecked = [...new Set(checkedCategories)];
            
            return eventsData.filter(e => {
                if (e.month !== currentMonth || e.year !== currentYear) return false;
                if (uniqueChecked.length > 0 && !uniqueChecked.includes(e.category)) return false;
                
                return true;
            });
        };

        const renderOverlayCalendar = (containerId) => {
            const container = document.getElementById(containerId);
            if (!container) return;
            container.innerHTML = '';

            const header = document.createElement('div');
            header.className = "grid grid-cols-7 gap-px bg-gray-200 border border-gray-200 rounded-t-xl overflow-hidden";
            
            if (containerId === 'calendarGridContainer') {
                header.style.paddingRight = '6px';
            }

            header.innerHTML = `
                <div class="bg-gray-50 py-3 text-center text-xs md:text-sm font-bold text-red-600 uppercase">Min</div>
                <div class="bg-gray-50 py-3 text-center text-xs md:text-sm font-bold text-gray-600 uppercase">Sen</div>
                <div class="bg-gray-50 py-3 text-center text-xs md:text-sm font-bold text-gray-600 uppercase">Sel</div>
                <div class="bg-gray-50 py-3 text-center text-xs md:text-sm font-bold text-gray-600 uppercase">Rab</div>
                <div class="bg-gray-50 py-3 text-center text-xs md:text-sm font-bold text-gray-600 uppercase">Kam</div>
                <div class="bg-gray-50 py-3 text-center text-xs md:text-sm font-bold text-gray-600 uppercase">Jum</div>
                <div class="bg-gray-50 py-3 text-center text-xs md:text-sm font-bold text-red-600 uppercase">Sab</div>
            `;
            container.appendChild(header);

            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const daysInPrevMonth = new Date(currentYear, currentMonth, 0).getDate();
            let firstDayIndex = new Date(currentYear, currentMonth, 1).getDay();
            const startOffset = firstDayIndex === 0 ? 6 : firstDayIndex; 
            
            const totalCells = 42; 
            let days = [];
            
            for (let i = 0; i < startOffset; i++) {
                days.push({ date: daysInPrevMonth - startOffset + 1 + i, isCurrent: false, monthOffset: -1 });
            }
            
            for (let i = 1; i <= daysInMonth; i++) {
                const isRealToday = (i === realTodayDate.getDate() && currentMonth === realTodayDate.getMonth() && currentYear === realTodayDate.getFullYear());
                const isDefaultTarget = (i === 6 && currentMonth === 9 && currentYear === 2026); 

                days.push({ date: i, isCurrent: true, isToday: isRealToday, isTarget: isDefaultTarget, monthOffset: 0 });
            }
            
            const remainingCells = totalCells - days.length;
            for (let i = 1; i <= remainingCells; i++) {
                days.push({ date: i, isCurrent: false, monthOffset: 1 });
            }

            const allWeeks = [];
            for (let w = 0; w < 6; w++) {
                allWeeks.push(days.slice(w * 7, (w + 1) * 7));
            }

            const weeksContainer = document.createElement('div');
            weeksContainer.className = "flex flex-col gap-px bg-gray-200 relative";

            const activeFilteredEvents = getFilteredEvents();

            for (let w = 0; w <= 5; w++) {
                const weekDays = allWeeks[w];
                const weekRow = document.createElement('div');
                weekRow.className = "grid grid-cols-1 grid-rows-1 bg-gray-200 border-b border-gray-300 min-h-[110px] md:min-h-[130px] relative";

                const hasToday = weekDays.some(d => d.isToday);
                const hasTarget = weekDays.some(d => d.isTarget);
                const hasFirstDay = weekDays.some(d => d.isCurrent && d.date === 1);

                if (hasToday || hasTarget) {
                    weekRow.classList.add('scroll-target-row');
                } else if (hasFirstDay) {
                    weekRow.classList.add('scroll-fallback-row');
                }

                const daysLayer = document.createElement('div');
                daysLayer.className = "col-start-1 row-start-1 grid grid-cols-7 gap-px";

                daysLayer.innerHTML = weekDays.map((d) => {
                    const textClass = d.isCurrent ? 'text-gray-900 font-bold' : 'text-gray-400';
                    const todayBadge = d.isToday ? 'bg-[#F97316] text-white w-7 h-7 rounded-full flex items-center justify-center font-bold' : '';
                    const targetBadge = (d.isTarget && !d.isToday) ? 'bg-blue-600 text-white w-7 h-7 rounded-full flex items-center justify-center font-bold' : '';
                    const combinedBadge = todayBadge || targetBadge;
                    const todayBorder = (d.isToday || d.isTarget) ? 'border-2 border-blue-400 z-10' : '';
                    
                    return `
                        <div class="day-cell bg-white p-2.5 relative flex flex-col justify-start hover:bg-gray-50 cursor-pointer transition-colors ${todayBorder} h-full" data-date="${d.date}" data-month-offset="${d.monthOffset}">
                            <div class="text-xs md:text-sm ${textClass} ${combinedBadge}">${d.date}</div>
                        </div>
                    `;
                }).join('');

                weekRow.appendChild(daysLayer);

                const weekEvents = [];
                weekDays.forEach((d) => {
                    if (!d.isCurrent) return;
                    const dayNum = d.date;
                    
                    const evtsInDay = activeFilteredEvents.filter(e => dayNum >= e.startDay && dayNum <= e.endDay);
                    evtsInDay.forEach(evt => {
                        if (!weekEvents.find(e => e.id === evt.id)) {
                            let startCol = weekDays.findIndex(day => day.isCurrent && day.date === evt.startDay);
                            if (startCol === -1) startCol = 0;
                            let endCol = weekDays.findIndex(day => day.isCurrent && day.date === evt.endDay);
                            if (endCol === -1) endCol = 6;

                            weekEvents.push({ ...evt, startCol: startCol + 1, span: (endCol - startCol) + 1 });
                        }
                    });
                });

                if (weekEvents.length > 0) {
                    const overlayGrid = document.createElement('div');
                    overlayGrid.className = "col-start-1 row-start-1 grid grid-cols-7 gap-px pointer-events-none z-20 auto-rows-max space-y-1.5 mt-10 md:mt-12 pb-3";

                    weekEvents.forEach(item => {
                        const badgeEl = document.createElement('div');
                        badgeEl.className = `${colStartMap[item.startCol]} ${colSpanMap[item.span]} px-2`;
                        badgeEl.innerHTML = `
                            <div class="cal-badge ${item.color} rounded-md h-7 md:h-8 px-3 flex items-center shadow-sm text-[11px] md:text-xs font-bold truncate pointer-events-auto cursor-pointer hover:opacity-90" data-id="${item.id}">
                                <span class="truncate hover:underline pointer-events-none">${item.title}</span>
                            </div>
                        `;
                        overlayGrid.appendChild(badgeEl);
                    });
                    weekRow.appendChild(overlayGrid);
                }
                weeksContainer.appendChild(weekRow);
            }

            const scrollWrapper = document.createElement('div');
            if (containerId === 'calendarGridContainer') {
                scrollWrapper.className = "max-h-[350px] overflow-y-auto custom-scrollbar border-x border-b border-gray-200 rounded-b-xl";
            } else {
                scrollWrapper.className = "border-x border-b border-gray-200 rounded-b-xl overflow-hidden";
            }
            
            scrollWrapper.appendChild(weeksContainer);
            container.appendChild(scrollWrapper);

            if (containerId === 'calendarGridContainer') {
                setTimeout(() => {
                    const targetRow = container.querySelector('.scroll-target-row') || container.querySelector('.scroll-fallback-row');
                    if (targetRow) {
                        scrollWrapper.scrollTop = targetRow.offsetTop;
                    }
                }, 50);
            }
        };

        const updateMonthUI = () => {
            const prevMonthDate = new Date(currentYear, currentMonth - 1, 1);
            const nextMonthDate = new Date(currentYear, currentMonth + 1, 1);

            document.getElementById('prevMonthLabel').innerText = `${monthNames[prevMonthDate.getMonth()]} ${prevMonthDate.getFullYear()}`;
            document.getElementById('currMonthLabel').innerText = `${monthNames[currentMonth]} ${currentYear}`;
            document.getElementById('nextMonthLabel').innerText = `${monthNames[nextMonthDate.getMonth()]} ${nextMonthDate.getFullYear()}`;

            renderOverlayCalendar('calendarGridContainer');
            const modalOverlay = document.getElementById('calendarModalOverlay');
            if (modalOverlay && !modalOverlay.classList.contains('hidden')) {
                renderOverlayCalendar('modalCalendarGridContainer');
            }
        };

        const changeMonth = (offset) => {
            currentMonth += offset;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            } else if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            updateMonthUI();
        };

        const btnPrevMonth = document.getElementById('btnPrevMonth');
        if(btnPrevMonth) btnPrevMonth.addEventListener('click', () => changeMonth(-1));
        const prevMonthLabel = document.getElementById('prevMonthLabel');
        if(prevMonthLabel) prevMonthLabel.addEventListener('click', () => changeMonth(-1));
        
        const btnNextMonth = document.getElementById('btnNextMonth');
        if(btnNextMonth) btnNextMonth.addEventListener('click', () => changeMonth(1));
        const nextMonthLabel = document.getElementById('nextMonthLabel');
        if(nextMonthLabel) nextMonthLabel.addEventListener('click', () => changeMonth(1));

        document.querySelectorAll('.category-filter').forEach(chk => {
            chk.addEventListener('change', (e) => {
                const targetValue = e.target.value;
                const isChecked = e.target.checked;
                
                document.querySelectorAll(`.category-filter[value="${targetValue}"]`).forEach(cb => {
                    cb.checked = isChecked;
                });
                
                updateMonthUI();
            });
        });

        document.querySelectorAll('.btn-reset-filter').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.category-filter').forEach(cb => {
                    cb.checked = true;
                });
                updateMonthUI();
            });
        });

        window.openEventDetail = function(eventId) {
            const item = eventsData.find(x => x.id === parseInt(eventId) || x.id === String(eventId));
            if (!item) return;

            const formatTgl = (tgl) => {
                if (!tgl || isNaN(tgl.getTime())) return '-';
                return `${tgl.getDate()} ${monthNames[tgl.getMonth()]} ${tgl.getFullYear()}`;
            };

            document.getElementById('dtNama').innerText = item.title;
            document.getElementById('dtJenisKegiatan').innerText = item.category;
            document.getElementById('dtKoordinator').innerText = item.koordinator;
            document.getElementById('dtTanggalMulai').innerText = formatTgl(item.rawMulai);
            document.getElementById('dtTanggalBerakhir').innerText = formatTgl(item.rawSelesai);
            document.getElementById('dtLokasi').innerText = item.lokasi;
            document.getElementById('dtInstansi').innerText = item.instansi;
            
            document.getElementById('dtPeserta').innerText = item.jumlah_peserta;

            document.getElementById('dayEventsModal').classList.add('hidden');
            document.getElementById('eventDetailModal').classList.remove('hidden');
        };

        const handleGridClick = (e) => {
            const badge = e.target.closest('.cal-badge');
            if (badge) {
                window.openEventDetail(badge.getAttribute('data-id'));
                return;
            }

            const cell = e.target.closest('.day-cell');
            if(!cell) return;
            
            const monthOffset = parseInt(cell.getAttribute('data-month-offset'));
            
            if (monthOffset === -1) { changeMonth(-1); return; }
            if (monthOffset === 1) { changeMonth(1); return; }
            
            const dateVal = parseInt(cell.getAttribute('data-date'));
            const activeEventsForDay = getFilteredEvents().filter(ev => dateVal >= ev.startDay && dateVal <= ev.endDay);
            
            document.getElementById('dayModalTitle').innerText = `Daftar Kegiatan (${dateVal} ${monthNames[currentMonth]} ${currentYear})`;
            const listContainer = document.getElementById('dayModalListContainer');
            listContainer.innerHTML = '';
            
            if(activeEventsForDay.length > 0) {
                activeEventsForDay.forEach(ev => {
                    const badgeColor = ev.color.replace('border-2 border-black', '');
                    listContainer.innerHTML += `
                        <div class="border-2 border-gray-200 bg-white p-3 rounded-lg flex justify-between items-center gap-3 shadow-sm hover:shadow-md transition">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <div class="w-2.5 h-10 rounded-full shrink-0 ${badgeColor}"></div>
                                <div class="truncate">
                                    <h4 class="font-bold text-gray-900 text-sm md:text-base truncate">${ev.title}</h4>
                                    <p class="text-xs text-gray-500 capitalize truncate">${ev.category} • ${ev.lokasi || '-'}</p>
                                </div>
                            </div>
                            <button type="button" onclick="window.openEventDetail('${ev.id}')" class="shrink-0 px-3 py-1.5 bg-white hover:bg-gray-100 border-2 border-black rounded-lg text-xs font-bold transition-colors">
                                Detail
                            </button>
                        </div>`;
                });
            } else {
                listContainer.innerHTML = `<div class="text-sm text-gray-500 italic p-4 text-center border-2 border-dashed border-gray-200 rounded-lg">Tidak ada jadwal tercatat pada hari ini.</div>`;
            }

            document.getElementById('eventDetailModal').classList.add('hidden');
            document.getElementById('dayEventsModal').classList.remove('hidden');
        };

        updateMonthUI();
        
        document.addEventListener('click', (e) => {
            if(e.target.closest('#calendarGridContainer') || e.target.closest('#modalCalendarGridContainer')) {
                handleGridClick(e);
            }
            
            if (e.target.id === 'dayEventsModal') {
                document.getElementById('dayEventsModal').classList.add('hidden');
            }
            if (e.target.id === 'eventDetailModal') {
                document.getElementById('eventDetailModal').classList.add('hidden');
            }
        });

        const btnCloseDayModal = document.getElementById('btnCloseDayModal');
        if(btnCloseDayModal) btnCloseDayModal.addEventListener('click', () => { document.getElementById('dayEventsModal').classList.add('hidden'); });

        const btnCloseDetailModal = document.getElementById('btnCloseDetailModal');
        if(btnCloseDetailModal) btnCloseDetailModal.addEventListener('click', () => { document.getElementById('eventDetailModal').classList.add('hidden'); });

        const btnBackToDayModal = document.getElementById('btnBackToDayModal');
        if(btnBackToDayModal) btnBackToDayModal.addEventListener('click', () => { document.getElementById('eventDetailModal').classList.add('hidden'); });

        const btnOpenModal = document.getElementById('btnOpenModal');
        if(btnOpenModal) btnOpenModal.addEventListener('click', () => {
            document.getElementById('calendarModalOverlay').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; 
            renderOverlayCalendar('modalCalendarGridContainer');
        });

        const btnCloseModal = document.getElementById('btnCloseModal');
        if(btnCloseModal) btnCloseModal.addEventListener('click', () => {
            document.getElementById('calendarModalOverlay').classList.add('hidden');
            document.body.style.overflow = '';
        });
    });
</script>