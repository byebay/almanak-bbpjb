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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Kalender Agenda BBJB</h3>
                    <div id='calendar'></div>
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
                    <h3 class="text-lg leading-6 font-medium text-gray-900 text-center" id="modalTitle"></h3>
                    <div id="modalBody" class="mt-4 border-t border-gray-200 pt-4 space-y-4"></div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeModal()" class="w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    {{-- JavaScript untuk Swiper dan FullCalendar --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    
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
                    const clickedDate = info.dateStr;
                    const allEvents = calendar.getEvents();
                    const eventsOnDate = allEvents.filter(event => toLocalISOString(event.start) === clickedDate);
                    if (eventsOnDate.length > 0) {
                        const dateObj = new Date(info.date);
                        modalTitle.textContent = `Agenda pada tanggal ${dateObj.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })}`;
                        modalBody.innerHTML = '';
                        eventsOnDate.forEach(event => {
                            let fileHtml = '';
                            const props = event.extendedProps;
                            if (props.file_url) {
                                let fileContent = '';
                                // Jika file adalah gambar
                                if (['jpg', 'jpeg', 'png', 'gif'].includes(props.file_extension)) {
                                    fileContent = `<img src="${props.file_url}" alt="File Dukung" class="mt-2 rounded-md border max-w-full h-auto">`;
                                } 
                                // Jika file adalah PDF
                                else if (props.file_extension === 'pdf') {
                                    fileContent = `<iframe src="${props.file_url}" class="mt-2 w-full h-96 rounded-md border"></iframe>`;
                                } 
                                // Untuk tipe file lainnya
                                else {
                                    fileContent = `<a href="${props.file_url}" target="_blank" class="text-sm text-blue-600 hover:underline">${props.file_name}</a>`;
                                }

                                fileHtml = `
                                    <div class="mt-3 pt-3 border-t border-gray-200">
                                        <p class="text-l text-gray-600 font-semibold">Data Dukung:</p>
                                        ${fileContent}
                                    </div>
                                `;
                            }

                            const eventDetail = `
                                <div class="pb-3">
                                    <p class="text-3xl text-center font-bold text-black mb-1 font-montserrat">${event.title}</p>
                                    <p class="text-l text-center text-gray-600">Waktu: ${event.extendedProps.start_time} - ${event.extendedProps.end_time}</p>
                                    <p class="text-l font-semibold text-gray-600 mt-2 whitespace-pre-wrap">Deskripsi Kegiatan:</p>
                                    <p class="text-l text-gray-500 mt-2 whitespace-pre-wrap">${event.extendedProps.description}</p>
                                    ${fileHtml}
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
    @endpush
</x-app-layout>