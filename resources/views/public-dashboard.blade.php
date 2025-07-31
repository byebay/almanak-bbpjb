<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Almanak - Balai Bahasa Provinsi Jawa Barat</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles & Scripts (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    {{-- Style kustom Anda untuk kalender --}}
    <style>
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
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Header Publik -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRL5cmZSSbEF_Aww6083_87Z96cCKwM6CA0ww&s" alt="Logo Balai Bahasa" class="block h-12 w-auto">
                    <span class="font-semibold text-xl text-gray-800 ml-3">Almanak BBJB</span>
                </div>
                <!-- Tombol Login -->
                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Login Pegawai
                </a>
            </div>
        </header>

        <!-- Konten Utama (Slider & Kalender) -->
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                
                <!-- Slider Statistik Kehadiran -->
                <div class="swiper bg-transparent h-72">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide bg-white rounded-lg p-6 shadow-sm flex flex-col items-center justify-center">
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
                        <div class="swiper-slide bg-white rounded-lg p-6 shadow-sm">
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
                        <div class="swiper-slide bg-white rounded-lg p-6 shadow-sm overflow-y-auto">
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
                        <div class="swiper-slide bg-white rounded-lg p-6 shadow-sm overflow-y-auto">
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

                <!-- Kalender Agenda -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-2xl font-bold mb-4">Kalender Agenda BBJB</h3>
                        <div id='calendar'></div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Modal untuk Detail Agenda -->
    <div id="agendaDetailModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true"><div class="absolute inset-0 bg-gray-500 opacity-75"></div></div>
            <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 text-center" id="modalTitle"></h3>
                    <div id="modalBody" class="mt-4 border-t border-gray-200 pt-4 space-y-4"></div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeModal()" class="w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- JavaScript untuk Swiper dan FullCalendar --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Swiper Slider
            const swiper = new Swiper('.swiper', {
                loop: true,
                autoplay: { delay: 5000, disableOnInteraction: false },
            });

            // Inisialisasi FullCalendar
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

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,dayGridWeek' },
                aspectRatio: 2,
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu'
                },
                eventContent: function(info) {
                    if (info.view.type === 'dayGridMonth') return { html: '' };
                    return true;
                },
                events: '{{ route("public.events") }}', // Perbaikan: Gunakan route publik
                
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
                    const clickedDate = info.dateStr;
                    const allEvents = calendar.getEvents();
                    const eventsOnDate = allEvents.filter(event => toLocalISOString(event.start) === clickedDate);
                    if (eventsOnDate.length > 0) {
                        const dateObj = new Date(info.date);
                        modalTitle.textContent = `Agenda pada tanggal ${dateObj.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })}`;
                        modalBody.innerHTML = '';
                        eventsOnDate.forEach(event => {
                            const eventDetail = `
                                <div class="pb-3">
                                    <p class="font-bold text-gray-800">${event.title}</p>
                                    <p class="text-sm text-gray-600">Waktu: ${event.extendedProps.start_time} - ${event.extendedProps.end_time}</p>
                                    <p class="text-sm text-gray-500 mt-1">${event.extendedProps.description}</p>
                                </div>
                                <hr class="last:hidden">`;
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
</body>
</html>