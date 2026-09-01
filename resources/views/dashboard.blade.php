<style>
    /* CSS kustom Anda untuk mengubah warna kalender tetap dipertahankan */
    :root {
        --fc-button-bg-color: #3B82F6;
        --fc-button-border-color: #3B82F6;
        --fc-button-hover-bg-color: #2563EB;
        --fc-button-hover-border-color: #2563EB;
        --fc-button-active-bg-color: #1D4ED8;
        --fc-button-active-border-color: #1D4ED8;
        --fc-today-bg-color: rgba(219, 234, 254, 0.7);
    }
    .fc .fc-col-header-cell {
        background-color: #DBEAFE;
    }
    .fc-day-sun .fc-daygrid-day-number,
    .fc-day-sat .fc-daygrid-day-number {
        color: #EF4444;
        font-weight: bold;
    }
    #modalBody .font-montserrat {
        font-family: 'Montserrat', sans-serif;
    }

    .fc .fc-toolbar.fc-header-toolbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        row-gap: 0.75rem;
        margin-bottom: 1.25rem;
    }

    .fc .fc-toolbar-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .fc .fc-toolbar-chunk {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* === Responsive mobile === */
    @media (max-width: 640px) {
        .fc .fc-toolbar.fc-header-toolbar {
            flex-direction: column;
            align-items: center;
        }
        /* chunk pertama = tombol2 (right), chunk kedua = judul (left) */
        .fc .fc-toolbar-chunk:first-child {
            order: 1; /* tombol2 di atas */
            flex-wrap: wrap;
            justify-content: center;
        }
        .fc .fc-toolbar-chunk:last-child {
            order: 2; /* judul (Juli 2026) di bawah tombol, di atas kalender */
        }
        .fc .fc-toolbar-title {
            font-size: 1.1rem;
        }
        .fc .fc-button {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
        }
    }
</style>

<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dasbor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- HTML untuk Swiper Slider (sesuai struktur Anda) --}}
            <div class="swiper bg-transparent h-72">
                <div class="swiper-wrapper">
                    <!-- Slide 1: Datang Paling Awal -->
                    <div class="swiper-slide">
                        <div class="bg-white rounded-lg p-6 shadow-sm flex flex-col items-center justify-center h-full">
                            <h3 class="text-xl font-bold text-gray-800 text-center">Datang Paling Awal</h3>
                            @if($pegawaiPalingAwal)
                                <div class="text-center mt-4">
                                    <img src="{{ $pegawaiPalingAwal->photo_url }}" alt="{{ $pegawaiPalingAwal->name }}" class="w-24 h-24 rounded-full mx-auto object-cover">
                                    <p class="text-xl font-semibold mt-3">{{ $pegawaiPalingAwal->name }}</p>
                                    <p class="text-gray-500 text-sm">NIP: {{ $pegawaiPalingAwal->nip }}</p>
                                </div>
                            @else
                                <p class="text-center text-gray-500 mt-4">Tidak ada data kehadiran.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Slide 2: Jumlah Hadir & Terlambat -->
                    <div class="swiper-slide">
                        <div class="bg-white rounded-lg p-6 shadow-sm h-full">
                            <div class="grid grid-cols-2 divide-x divide-gray-200 h-full">
                                <div class="flex flex-col items-center justify-center text-center pr-4">
                                    <h3 class="text-xl font-bold text-gray-800">Jumlah Hadir</h3>
                                    <p class="text-7xl font-extrabold text-blue-500 mt-2">{{ $jumlahHadir }}</p>
                                    <p class="text-lg text-gray-600">Pegawai</p>
                                </div>
                                <div class="flex flex-col items-center justify-center text-center pl-4">
                                    <h3 class="text-xl font-bold text-gray-800">Jumlah Terlambat</h3>
                                    <p class="text-7xl font-extrabold text-yellow-500 mt-2">{{ $jumlahTerlambat }}</p>
                                    <p class="text-lg text-gray-600">Pegawai</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3: Pegawai Cuti -->
                    <div class="swiper-slide">
                        <div class="bg-white rounded-lg p-6 shadow-sm overflow-y-auto h-full">
                            <h3 class="text-xl font-bold text-gray-800 text-center mb-4">Pegawai Cuti</h3>
                            <div class="flex flex-wrap justify-center gap-4">
                                @forelse($pegawaiCuti as $pegawai)
                                    <div class="text-center w-24">
                                        <img src="{{ $pegawai->photo_url }}" alt="{{ $pegawai->name }}" class="w-20 h-20 rounded-full mx-auto object-cover">
                                        <p class="mt-2 text-sm font-medium break-words">{{ $pegawai->name }}</p>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-500">Tidak ada pegawai yang cuti hari ini.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Slide 4: Pegawai Dinas Luar -->
                    <div class="swiper-slide">
                        <div class="bg-white rounded-lg p-6 shadow-sm overflow-y-auto h-full">
                            <h3 class="text-xl font-bold text-gray-800 text-center mb-4">Pegawai Dinas Luar</h3>
                            <div class="flex flex-wrap justify-center gap-4">
                                @forelse($pegawaiDinasLuar as $pegawai)
                                    <div class="text-center w-24">
                                        <img src="{{ $pegawai->photo_url }}" alt="{{ $pegawai->name }}" class="w-20 h-20 rounded-full mx-auto object-cover">
                                        <p class="mt-2 text-sm font-medium break-words">{{ $pegawai->name }}</p>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-500">Tidak ada pegawai dinas luar hari ini.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tambahkan Pagination -->
                <div class="swiper-pagination"></div>
            </div>

            <!-- Kalender Agenda (sesuai struktur Anda) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Kalender Agenda BBPJB</h3>
                    <div id='calendar'></div>
                </div>
            </div>

            <!-- Statistik Pengunjung dengan Grafik -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div>
                            <h3 class="text-2xl font-bold">Statistik Pengunjung</h3>
                            <p id="chartSubtitleText" class="text-sm text-gray-500 mt-1"></p>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">
                            <select id="chartPeriodFilter" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm w-full sm:w-auto">
                                <option value="daily">Harian</option>
                                <option value="monthly">Bulanan</option>
                                <option value="yearly">Tahunan</option>
                            </select>
                            <div id="chartMonthNavContainer" class="inline-flex items-center gap-1 bg-white border border-gray-300 rounded-md shadow-sm px-2 py-1 text-sm">
                                <button type="button" id="prevMonthBtn" class="p-1 hover:bg-gray-100 rounded text-gray-600 focus:outline-none" title="Bulan Sebelumnya">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                </button>
                                <span id="currentMonthText" class="font-medium text-gray-700 min-w-[110px] text-center px-1"></span>
                                <button type="button" id="nextMonthBtn" class="p-1 hover:bg-gray-100 rounded text-gray-600 focus:outline-none disabled:opacity-30 disabled:cursor-not-allowed" title="Bulan Selanjutnya">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </div>
                            <input type="hidden" id="chartMonthFilter" value="{{ $chartDataGrouped['daily']['selectedMonth'] ?? date('Y-m') }}">
                            <select id="chartYearFilter" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm w-full sm:w-auto hidden">
                                @php
                                    $currentY = (int)date('Y');
                                    $selectedY = (int)($chartDataGrouped['monthly']['selectedYear'] ?? date('Y'));
                                @endphp
                                @for ($y = $currentY; $y >= 2025; $y--)
                                    <option value="{{ $y }}" {{ $y === $selectedY ? 'selected' : '' }}>Tahun {{ $y }}</option>
                                @endfor
                            </select>
                            <select id="chartYearRangeFilter" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm w-full sm:w-auto hidden">
                                @php
                                    $currentY = (int)date('Y');
                                    $currBlock = (int)(floor($currentY / 5) * 5);
                                    if ($currBlock < 2025) { $currBlock = 2025; }
                                    $selectedBlock = (int)($chartDataGrouped['yearly']['selectedYearRange'] ?? $currBlock);
                                    $maxBlock = $currBlock;
                                @endphp
                                @for ($startBlock = $maxBlock; $startBlock >= 2025; $startBlock -= 5)
                                    <option value="{{ $startBlock }}" {{ $startBlock === $selectedBlock ? 'selected' : '' }}>
                                        {{ $startBlock }} - {{ $startBlock + 4 }}
                                    </option>
                                @endfor
                            </select>
                            <a id="exportExcelBtn" href="{{ route('dashboard.visitor.export', ['period' => 'daily', 'month' => $chartDataGrouped['daily']['selectedMonth'] ?? date('Y-m'), 'year' => $chartDataGrouped['monthly']['selectedYear'] ?? date('Y'), 'year_range' => $chartDataGrouped['yearly']['selectedYearRange'] ?? $currBlock]) }}" class="w-full sm:w-auto justify-center inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition duration-150">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Unduh Excel
                            </a>
                        </div>
                    </div>
                    <div class="relative w-full overflow-x-auto">
                        <div class="relative h-72" style="min-width: 800px;">
                            <canvas id="visitorChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Detail Agenda (sesuai struktur Anda) -->
    <div id="agendaDetailModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true"><div class="absolute inset-0 bg-gray-500 opacity-75"></div></div>
            <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-l leading-6 font-medium text-gray-900 text-center" id="modalTitle"></h3>
                    <div id="modalBody" class="mt-4 border-t border-gray-200 pt-4 space-y-4"></div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeModal()" class="w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    {{-- JavaScript untuk Swiper, FullCalendar, dan Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Swiper Slider
            const swiper = new Swiper('.swiper', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });

            // Inisialisasi Chart.js dengan filter dinamis
            const ctx = document.getElementById('visitorChart').getContext('2d');
            const chartDataGrouped = @json($chartDataGrouped);
            
            // Buat grafik awal (Daily)
            let visitorChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartDataGrouped.daily.labels,
                    datasets: [{
                        label: 'Jumlah Pengunjung',
                        data: chartDataGrouped.daily.data,
                        backgroundColor: 'rgba(59, 130, 246, 0.8)', // Warna biru
                        borderColor: 'rgb(37, 99, 235)',
                        borderWidth: 1,
                        borderRadius: 4,
                        barPercentage: 0.7 // Membuat batang agak langsing biar tidak terlalu sesak saat 30 hari
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                display: false // Hilangkan garis vertikal
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 },
                            grid: {
                                display: false // Hilangkan garis horizontal
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Pengunjung';
                                }
                            }
                        }
                    }
                }
            });

            // Set subtitle awal
            document.getElementById('chartSubtitleText').textContent = chartDataGrouped.daily.subtitle;

            const periodFilterEl = document.getElementById('chartPeriodFilter');
            const monthNavContainer = document.getElementById('chartMonthNavContainer');
            const monthFilterEl = document.getElementById('chartMonthFilter');
            const currentMonthText = document.getElementById('currentMonthText');
            const prevMonthBtn = document.getElementById('prevMonthBtn');
            const nextMonthBtn = document.getElementById('nextMonthBtn');
            const yearFilterEl = document.getElementById('chartYearFilter');
            const yearRangeFilterEl = document.getElementById('chartYearRangeFilter');
            const exportExcelBtn = document.getElementById('exportExcelBtn');

            const monthNamesIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            function updateMonthNavDisplay() {
                const [y, m] = monthFilterEl.value.split('-').map(Number);
                currentMonthText.textContent = `${monthNamesIndo[m - 1]} ${y}`;

                // Disable prev if reaches 2025-01
                if (y <= 2025 && m <= 1) {
                    prevMonthBtn.disabled = true;
                    prevMonthBtn.classList.add('opacity-30', 'cursor-not-allowed');
                } else {
                    prevMonthBtn.disabled = false;
                    prevMonthBtn.classList.remove('opacity-30', 'cursor-not-allowed');
                }

                // Disable next if reaches current month
                const now = new Date();
                const curY = now.getFullYear();
                const curM = now.getMonth() + 1;
                if (y > curY || (y === curY && m >= curM)) {
                    nextMonthBtn.disabled = true;
                    nextMonthBtn.classList.add('opacity-30', 'cursor-not-allowed');
                } else {
                    nextMonthBtn.disabled = false;
                    nextMonthBtn.classList.remove('opacity-30', 'cursor-not-allowed');
                }
            }

            prevMonthBtn.addEventListener('click', function() {
                let [y, m] = monthFilterEl.value.split('-').map(Number);
                m--;
                if (m < 1) { m = 12; y--; }
                if (y < 2025) return;
                monthFilterEl.value = `${y}-${String(m).padStart(2, '0')}`;
                updateMonthNavDisplay();
                reloadChartData();
            });

            nextMonthBtn.addEventListener('click', function() {
                let [y, m] = monthFilterEl.value.split('-').map(Number);
                const now = new Date();
                const curY = now.getFullYear();
                const curM = now.getMonth() + 1;
                if (y > curY || (y === curY && m >= curM)) return;

                m++;
                if (m > 12) { m = 1; y++; }
                monthFilterEl.value = `${y}-${String(m).padStart(2, '0')}`;
                updateMonthNavDisplay();
                reloadChartData();
            });

            function toggleFilterInputs(period) {
                if (period === 'daily') {
                    monthNavContainer.classList.remove('hidden');
                    monthNavContainer.classList.add('inline-flex');
                    yearFilterEl.classList.add('hidden');
                    yearRangeFilterEl.classList.add('hidden');
                } else if (period === 'monthly') {
                    monthNavContainer.classList.add('hidden');
                    monthNavContainer.classList.remove('inline-flex');
                    yearFilterEl.classList.remove('hidden');
                    yearRangeFilterEl.classList.add('hidden');
                } else {
                    monthNavContainer.classList.add('hidden');
                    monthNavContainer.classList.remove('inline-flex');
                    yearFilterEl.classList.add('hidden');
                    yearRangeFilterEl.classList.remove('hidden');
                }
            }

            function updateExportLink() {
                const period = periodFilterEl.value;
                const month = monthFilterEl.value;
                const year = yearFilterEl.value;
                const yearRange = yearRangeFilterEl.value;
                exportExcelBtn.href = "{{ route('dashboard.visitor.export') }}?period=" + period + "&month=" + month + "&year=" + year + "&year_range=" + yearRange;
            }

            function reloadChartData() {
                const period = periodFilterEl.value;
                const month = monthFilterEl.value;
                const year = yearFilterEl.value;
                const yearRange = yearRangeFilterEl.value;

                updateExportLink();

                const params = new URLSearchParams(window.location.search);
                params.set('month', month);
                params.set('year', year);
                params.set('year_range', yearRange);

                fetch(`${window.location.pathname}?${params.toString()}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const scriptTag = Array.from(doc.querySelectorAll('script')).find(s => s.textContent.includes('chartDataGrouped'));
                    if (scriptTag) {
                        const match = scriptTag.textContent.match(/const chartDataGrouped = (\{.*?\});/s);
                        if (match && match[1]) {
                            const newGroupedData = JSON.parse(match[1]);
                            const newData = newGroupedData[period];
                            visitorChart.data.labels = newData.labels;
                            visitorChart.data.datasets[0].data = newData.data;
                            visitorChart.update();
                            document.getElementById('chartSubtitleText').textContent = newData.subtitle;
                            history.replaceState(null, '', `${window.location.pathname}?${params.toString()}`);
                            return;
                        }
                    }
                    window.location.search = params.toString();
                })
                .catch(() => {
                    window.location.search = params.toString();
                });
            }

            periodFilterEl.addEventListener('change', function(e) {
                const period = e.target.value;
                toggleFilterInputs(period);
                const newData = chartDataGrouped[period];
                visitorChart.data.labels = newData.labels;
                visitorChart.data.datasets[0].data = newData.data;
                visitorChart.update();
                document.getElementById('chartSubtitleText').textContent = newData.subtitle;
                updateExportLink();
            });

            yearFilterEl.addEventListener('change', reloadChartData);
            yearRangeFilterEl.addEventListener('change', reloadChartData);
            updateMonthNavDisplay();
            toggleFilterInputs(periodFilterEl.value);

            // Inisialisasi FullCalendar (menggunakan kode kustom Anda)
            const calendarEl = document.getElementById('calendar');
            const modal = document.getElementById('agendaDetailModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalBody = document.getElementById('modalBody');
            
            const toLocalISOString = (date) => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            const getAspectRatio = () => window.innerWidth < 640 ? 0.7 : 2;

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                    headerToolbar: {
                    left: 'title',
                    center: '',
                    right: 'prev,next today dayGridMonth,dayGridWeek'
                },
                aspectRatio: getAspectRatio(),
                expandRows: true,
                windowResize: function(arg) {
                    calendar.setOption('aspectRatio', getAspectRatio());
                },
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu'
                },
                eventContent: function(info) {
                    if (info.view.type === 'dayGridMonth') return { html: '' };
                    return true;
                },
                events: '{{ route("dashboard.events") }}',
                
                datesSet: function(dateInfo) {
                    document.querySelectorAll('.fc-daygrid-day .custom-star').forEach(el => el.remove());
                    const currentEvents = calendar.getEvents();
                    currentEvents.forEach(event => {
                        const dateStr = toLocalISOString(event.start);
                        const dayCell = document.querySelector(`.fc-day[data-date="${dateStr}"]`);
                        if (dayCell) {
                            const dayNumberEl = dayCell.querySelector('.fc-daygrid-day-number');
                            if (dayNumberEl && !dayNumberEl.querySelector('.custom-star')) {
                                const starEl = document.createElement('span');
                                starEl.innerHTML = '★&nbsp;';
                                starEl.className = 'text-blue-600 custom-star';
                                dayNumberEl.prepend(starEl);
                            }
                        }
                    });
                },

                dateClick: function(info) {
                        const clickedDateStr = toLocalISOString(info.date);
                        const allEvents = calendar.getEvents();
                        const eventsOnDate = allEvents.filter(event => toLocalISOString(event.start) === clickedDateStr);

                        if (eventsOnDate.length > 0) {
                            const dateObj = new Date(info.date);
                            modalTitle.textContent = `Agenda pada tanggal ${dateObj.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })}`;
                            modalBody.innerHTML = '';
                            
                            eventsOnDate.forEach(event => {
                                const props = event.extendedProps;
                                let fileHtml = '';
                                if (props.file_url) {
                                    let fileContent = '';
                                    if (['jpg', 'jpeg', 'png', 'gif'].includes(props.file_extension)) {
                                        fileContent = `<img src="${props.file_url}" alt="File Dukung" class="mt-2 rounded-md border max-w-full h-auto">`;
                                    } else if (props.file_extension === 'pdf') {
                                        fileContent = `<iframe src="${props.file_url}" class="mt-2 w-full h-96 rounded-md border"></iframe>`;
                                    } else {
                                        fileContent = `<a href="${props.file_url}" target="_blank" class="text-sm text-blue-600 hover:underline">${props.file_name}</a>`;
                                    }
                                    fileHtml = `<div class="mt-3 pt-3 border-t border-gray-200"><p class="text-l text-gray-600 font-semibold">Data Dukung:</p>${fileContent}</div>`;
                                }

                                let roomHtml = '';
                                if (props.room_name) {
                                    roomHtml = `<div class="mt-2 flex items-center justify-center text-sm text-gray-500 bg-blue-50 rounded-full px-3 py-1"><span>${props.room_name}</span></div>`;
                                }

                                const eventDetail = `<div class="pb-3"><p class="text-3xl text-center font-bold text-black mb-1">${event.title}</p><p class="text-l text-center text-gray-600">Waktu: ${props.start_time} - ${props.end_time}</p>${roomHtml}<p class="text-l font-semibold text-gray-600 mt-2 whitespace-pre-wrap">Deskripsi Kegiatan:</p><p class="text-l text-gray-500 mt-2 whitespace-pre-wrap">${props.description}</p>${fileHtml}</div><hr class="last:hidden">`;
                                modalBody.innerHTML += eventDetail;
                            });
                            modal.classList.remove('hidden');
                        }
                    }
            });
            calendar.render();
            window.closeModal = function() { modal.classList.add('hidden'); }
        });
    </script>
    @endpush
</x-app-layout>