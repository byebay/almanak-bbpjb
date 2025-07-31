<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agenda Harian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- PERUBAHAN DI SINI: Mengubah class agar tombol menjadi full-width --}}
                    <button onclick="openModal('add')" class="w-full flex justify-center items-center px-4 py-3 bg-blue-600 border rounded-md font-semibold text-sm text-white uppercase hover:bg-blue-700 mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Agenda Baru
                    </button>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu Mulai</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu Berakhir</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul Agenda</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($agendas as $agenda)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($agenda->date)->translatedFormat('j F Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($agenda->start_time)->format('H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($agenda->end_time)->format('H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $agenda->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                Terpublikasi
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-3">
                                                @can('update', $agenda)
                                                    <button onclick="openModal('edit', {{ $agenda->id }})" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                                    </button>
                                                @endcan
                                                @can('delete', $agenda)
                                                    <form action="{{ route('agenda-harian.destroy', $agenda->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd" /></svg>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data agenda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Form Tambah/Edit Agenda --}}
    <div id="agendaModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true"><div class="absolute inset-0 bg-gray-500 opacity-75"></div></div>
            <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                <form id="agendaForm" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    <div id="form-method"></div>
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle"></h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Judul Agenda</label>
                                <input type="text" name="title" id="title" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label for="agenda_date" class="block text-sm">Tanggal</label>
                                    <input type="date" name="agenda_date" id="agenda_date" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                                <div>
                                    <label for="start_time" class="block text-sm">Waktu Mulai</label>
                                    <input type="time" name="start_time" id="start_time" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                                <div>
                                    <label for="end_time" class="block text-sm">Waktu Berakhir</label>
                                    <input type="time" name="end_time" id="end_time" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                            </div>
                             <div>
                                <label for="description" class="block text-sm">Deskripsi Lengkap</label>
                                <textarea id="description" name="description" rows="4" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required></textarea>
                            </div>
                            <div>
                                <label for="file_path" class="block text-sm">Unggah Data Dukung (Opsional)</label>
                                <input type="file" name="file_path" id="file_path" class="mt-1 block w-full text-sm">
                                <span id="current-file" class="text-sm text-gray-500 mt-1"></span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:w-auto">Simpan</button>
                        <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 bg-white text-base sm:mt-0 sm:w-auto">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const modal = document.getElementById('agendaModal');
        const form = document.getElementById('agendaForm');
        const modalTitle = document.getElementById('modalTitle');
        const formMethod = document.getElementById('form-method');
        const currentFile = document.getElementById('current-file');

        function openModal(mode, id = null) {
        form.reset();
        currentFile.innerText = '';

        if (mode === 'add') {
            modalTitle.innerText = 'Tambah Agenda Baru';
            form.action = "{{ route('agenda-harian.store') }}";
            formMethod.innerHTML = ''; // Hapus method spoofing
        } else if (mode === 'edit') {
            modalTitle.innerText = 'Edit Agenda';
            // Pastikan URL dan method-nya benar
            form.action = `/agenda-harian/${id}`;
            formMethod.innerHTML = '@method("PUT")';

            // Fetch data dari server
            fetch(`/agenda-harian/${id}`)
                .then(response => {
                    if (!response.ok) {
                    // Ini akan memberikan pesan error yang lebih jelas jika server gagal
                    throw new Error('Gagal mengambil data. Server merespons dengan status: ' + response.status);
                }
                return response.json();
                })
                .then(data => {
                    // Isi semua field form dengan data yang diterima
                    document.getElementById('title').value = data.title;
                    document.getElementById('agenda_date').value = data.agenda_date;
                    document.getElementById('start_time').value = data.start_time;
                    document.getElementById('end_time').value = data.end_time;
                    document.getElementById('description').value = data.description;
                    if (data.file_path) {
                        currentFile.innerText = 'File saat ini: ' + data.file_path.split('/').pop();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Tidak dapat memuat data agenda. Periksa konsol browser untuk detail.');
                });
        }
        modal.classList.remove('hidden');
    }

        function closeModal() { modal.classList.add('hidden'); }
    </script>
    @endpush
</x-app-layout>