{{-- Blok CSS untuk mengubah warna kalender --}}
<style>
    /* Mengubah warna semua tombol (prev, next, today, bulan, minggu) menjadi biru */
    :root {
        --fc-button-bg-color: #3B82F6; /* blue-500 */
        --fc-button-border-color: #3B82F6;
        --fc-button-hover-bg-color: #2563EB; /* blue-600 */
        --fc-button-hover-border-color: #2563EB;
        --fc-button-active-bg-color: #1D4ED8; /* blue-700 */
        --fc-button-active-border-color: #1D4ED8;
        --fc-today-bg-color: rgba(219, 234, 254, 0.7); /* Latar belakang tanggal hari ini */
    }

    /* PERUBAHAN #1: Warna header hari dibuat sedikit lebih gelap */
    .fc .fc-col-header-cell {
        background-color: #DBEAFE; /* Warna biru muda (blue-200) */
    }

    /* Mengubah warna angka tanggal di hari Minggu dan Sabtu menjadi merah */
    .fc-day-sun .fc-daygrid-day-number,
    .fc-day-sat .fc-daygrid-day-number {
        color: #EF4444; /* red-500 */
        font-weight: bold;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Kalender Agenda BBJB</h3>
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal untuk Detail Agenda --}}
    <div id="agendaDetailModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 text-center" id="modalTitle"></h3>
                    <div id="modalBody" class="mt-4 border-t border-gray-200 pt-4 space-y-4"></div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeModal()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const modal = document.getElementById('agendaDetailModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalBody = document.getElementById('modalBody');
            
            // --- FUNGSI BANTU UNTUK FORMAT TANGGAL TANPA TIMEZONE ---
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
                
                // --- PERUBAHAN DI SINI ---
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
                        // PERBAIKAN TIMEZONE #1
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
                    
                    // PERBAIKAN TIMEZONE #2
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
    @endpush
</x-app-layout>