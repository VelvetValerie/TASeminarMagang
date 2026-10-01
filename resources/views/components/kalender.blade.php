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
        
        <div class="relative filter-dropdown-container z-40">
            <button class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 transition-colors flex items-center gap-2 font-medium text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter Kategori
            </button>
            <div class="filter-dropdown absolute right-0 top-full mt-2 w-56 bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 invisible transition-all duration-200 p-4">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Tampilkan:</h4>
                <label class="flex items-center gap-3 mb-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                    <input type="checkbox" id="chkPendaftaran" checked class="category-filter w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                    <span class="text-sm font-medium">Pendaftaran</span>
                </label>
                <label class="flex items-center gap-3 mb-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                    <input type="checkbox" id="chkUjian" checked class="category-filter w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                    <span class="text-sm font-medium">Ujian / Tes</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-1 -ml-1 rounded">
                    <input type="checkbox" id="chkPengumuman" checked class="category-filter w-4 h-4 text-black border-gray-400 rounded focus:ring-black">
                    <span class="text-sm font-medium">Pengumuman</span>
                </label>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between mb-6 bg-gray-50 border border-gray-200 rounded-xl p-3">
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

    <div id="calendarGridContainer" class="w-full relative"></div>

    <div class="mt-6 flex justify-end">
        <button id="btnOpenModal" class="p-2.5 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 hover:-translate-y-1 transition-all flex items-center justify-center group" title="Lihat selengkapnya">
            <span class="mr-2 text-sm font-bold">Lihat Semua Jadwal</span>
            <svg class="w-5 h-5 text-gray-700 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15"></path>
            </svg>
        </button>
    </div>
</div>

@push('modals')
<div id="calendarModalOverlay" class="hidden fixed inset-0 z-[100] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6 transition-opacity duration-300">
    <div class="bg-white w-full max-w-[95vw] md:max-w-7xl max-h-[95vh] rounded-2xl shadow-2xl flex flex-col relative overflow-hidden transform scale-100 transition-transform">
        <div class="flex-shrink-0 p-6 border-b border-gray-200 flex justify-between items-center bg-white z-20">
            <div><h2 class="text-2xl md:text-3xl font-bold text-gray-900">Agenda Jadwal Lengkap</h2></div>
            <button id="btnCloseModal" class="p-2 bg-gray-100 border-2 border-transparent hover:border-black text-gray-700 rounded-lg transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="flex-grow overflow-y-auto bg-gray-50 p-4 md:p-8 custom-scrollbar relative">
            <div class="max-w-6xl mx-auto"><div id="modalCalendarGridContainer" class="w-full"></div></div>
        </div>
    </div>
</div>
@endpush

<div id="dayEventsModal" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity">
    <div class="relative w-full max-w-lg bg-white rounded-xl p-5">
        <button id="btnCloseDayModal" class="absolute top-4 right-4 p-1 text-gray-400 hover:text-black transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <h3 id="dayModalTitle" class="text-lg font-bold text-gray-900 border-b-2 border-gray-100 pb-3 mb-4 pr-8">Daftar Kegiatan</h3>
        <div id="dayModalListContainer" class="max-h-[350px] overflow-y-auto space-y-3 custom-scrollbar pr-2"></div>
    </div>
</div>

<div id="eventDetailModal" class="hidden fixed inset-0 z-[200] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-opacity">
    <div class="relative w-full max-w-md bg-white rounded-xl p-5">
        <button id="btnCloseDetailModal" class="absolute top-4 right-4 p-1 text-gray-400 hover:text-black transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <h3 class="text-lg font-bold text-gray-900 border-b-2 border-gray-100 pb-3 mb-4 pr-8">Detail Kegiatan</h3>
        <div class="space-y-3 text-sm text-gray-800 bg-gray-50 p-4 border border-gray-200 rounded-lg">
            <p><span class="font-bold">Nama Kegiatan:</span> <span id="dtNama">-</span></p>
            <p><span class="font-bold">Kategori:</span> <span id="dtKategori" class="capitalize">-</span></p>
            <p><span class="font-bold">Tanggal:</span> <span id="dtTanggal">-</span></p>
            <p><span class="font-bold">Lokasi:</span> <span id="dtLokasi">-</span></p>
            <p><span class="font-bold">Status:</span> <span id="dtStatus">-</span></p>
        </div>
        <div class="mt-5 flex justify-end">
            <button id="btnBackToDayModal" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 border-2 border-black rounded-lg text-sm font-bold transition-colors">Tutup</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Ambil data kegiatan dari $kegiatan (dikirim via controller ke view landing)
        const rawKegiatan = @json($kegiatan ?? []);

        // Mapping data dari Database ke format objek Kalender
        const eventsData = rawKegiatan.map(item => {
            const tglMulai = new Date(item.tanggal_mulai);
            const tglSelesai = item.tanggal_selesai ? new Date(item.tanggal_selesai) : tglMulai;

            const namaJenis = item.jenis ? item.jenis.nama_jeniskeg.toLowerCase() : 'umum';
            let category = 'pendaftaran';
            let badgeColor = 'bg-[#D0E2FF] text-[#0043CE] border-2 border-black';

            if (namaJenis.includes('ujian') || namaJenis.includes('tes') || namaJenis.includes('cat') || namaJenis.includes('casn')) {
                category = 'ujian';
                badgeColor = 'bg-[#FFD8B2] text-[#8A3B00] border-2 border-black';
            } else if (namaJenis.includes('pengumuman') || namaJenis.includes('hasil') || namaJenis.includes('karir')) {
                category = 'pengumuman';
                badgeColor = 'bg-[#C1F1D2] text-[#00512C] border-2 border-black';
            } else if (namaJenis.includes('daftar') || namaJenis.includes('pendaftaran') || namaJenis.includes('bimtek')) {
                category = 'pendaftaran';
                badgeColor = 'bg-[#D0E2FF] text-[#0043CE] border-2 border-black';
            }

            return {
                id: item.id_keg,
                title: item.nama_keg,
                startDay: tglMulai.getDate(),
                endDay: tglSelesai.getDate(),
                month: tglMulai.getMonth(),
                year: tglMulai.getFullYear(),
                category: category,
                color: badgeColor,
                lokasi: item.lokasi ? item.lokasi.nm_lokasi : '-',
                status: item.status || 'Belum Konfirmasi'
            };
        });

        const colStartMap = { 1: 'col-start-1', 2: 'col-start-2', 3: 'col-start-3', 4: 'col-start-4', 5: 'col-start-5', 6: 'col-start-6', 7: 'col-start-7' };
        const colSpanMap = { 1: 'col-span-1', 2: 'col-span-2', 3: 'col-span-3', 4: 'col-span-4', 5: 'col-span-5', 6: 'col-span-6', 7: 'col-span-7' };
        
        const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        const todayDate = new Date();
        let currentMonth = todayDate.getMonth();
        let currentYear = todayDate.getFullYear();

        const getFilteredEvents = () => {
            const showPendaftaran = document.getElementById('chkPendaftaran').checked;
            const showUjian = document.getElementById('chkUjian').checked;
            const showPengumuman = document.getElementById('chkPengumuman').checked;
            
            return eventsData.filter(e => {
                if (e.month !== currentMonth || e.year !== currentYear) return false;
                if (e.category === 'pendaftaran' && !showPendaftaran) return false;
                if (e.category === 'ujian' && !showUjian) return false;
                if (e.category === 'pengumuman' && !showPengumuman) return false;
                return true;
            });
        };

        const renderOverlayCalendar = (containerId) => {
            const container = document.getElementById(containerId);
            if (!container) return;
            container.innerHTML = '';

            const header = document.createElement('div');
            header.className = "grid grid-cols-7 gap-px bg-gray-200 border border-gray-200 rounded-t-xl overflow-hidden";
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
                const isRealToday = (i === todayDate.getDate() && currentMonth === todayDate.getMonth() && currentYear === todayDate.getFullYear());
                days.push({ date: i, isCurrent: true, isToday: isRealToday, monthOffset: 0 });
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
                const hasFirstDay = weekDays.some(d => d.isCurrent && d.date === 1);

                if (hasToday) {
                    weekRow.classList.add('scroll-target-row');
                } else if (hasFirstDay) {
                    weekRow.classList.add('scroll-fallback-row');
                }

                const daysLayer = document.createElement('div');
                daysLayer.className = "col-start-1 row-start-1 grid grid-cols-7 gap-px";

                daysLayer.innerHTML = weekDays.map((d) => {
                    const textClass = d.isCurrent ? 'text-gray-900 font-bold' : 'text-gray-400';
                    const todayBadge = d.isToday ? 'bg-[#F97316] text-white w-7 h-7 rounded-full flex items-center justify-center font-bold' : '';
                    const todayBorder = d.isToday ? 'border-2 border-[#F97316] z-10' : '';
                    
                    return `
                        <div class="day-cell bg-white p-2.5 relative flex flex-col justify-start hover:bg-gray-50 cursor-pointer transition-colors ${todayBorder} h-full" data-date="${d.date}" data-month-offset="${d.monthOffset}">
                            <div class="text-xs md:text-sm ${textClass} ${todayBadge}">${d.date}</div>
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
            if (!document.getElementById('calendarModalOverlay').classList.contains('hidden')) {
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

        document.getElementById('btnPrevMonth').addEventListener('click', () => changeMonth(-1));
        document.getElementById('prevMonthLabel').addEventListener('click', () => changeMonth(-1));
        document.getElementById('btnNextMonth').addEventListener('click', () => changeMonth(1));
        document.getElementById('nextMonthLabel').addEventListener('click', () => changeMonth(1));

        document.querySelectorAll('.category-filter').forEach(chk => {
            chk.addEventListener('change', updateMonthUI);
        });

        window.openEventDetail = function(eventId) {
            const item = eventsData.find(x => x.id === parseInt(eventId));
            if (!item) return;

            document.getElementById('dtNama').innerText = item.title;
            document.getElementById('dtKategori').innerText = item.category.replace('-', ' ');
            document.getElementById('dtTanggal').innerText = 
                (item.startDay === item.endDay) 
                ? `${item.startDay} ${monthNames[item.month]} ${item.year}` 
                : `${item.startDay} - ${item.endDay} ${monthNames[item.month]} ${item.year}`;
            document.getElementById('dtLokasi').innerText = item.lokasi || '-';
            document.getElementById('dtStatus').innerText = item.status || '-';

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
                            <button type="button" onclick="window.openEventDetail(${ev.id})" class="shrink-0 px-3 py-1.5 bg-white hover:bg-gray-100 border-2 border-black rounded-lg text-xs font-bold transition-colors">
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

        document.getElementById('btnCloseDayModal').addEventListener('click', () => {
            document.getElementById('dayEventsModal').classList.add('hidden');
        });

        document.getElementById('btnCloseDetailModal').addEventListener('click', () => {
            document.getElementById('eventDetailModal').classList.add('hidden');
        });

        document.getElementById('btnBackToDayModal').addEventListener('click', () => {
            document.getElementById('eventDetailModal').classList.add('hidden');
        });

        document.getElementById('btnOpenModal').addEventListener('click', () => {
            document.getElementById('calendarModalOverlay').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; 
            renderOverlayCalendar('modalCalendarGridContainer');
        });

        document.getElementById('btnCloseModal').addEventListener('click', () => {
            document.getElementById('calendarModalOverlay').classList.add('hidden');
            document.body.style.overflow = '';
        });
    });
</script>