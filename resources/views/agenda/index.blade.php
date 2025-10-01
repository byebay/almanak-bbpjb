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
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Daftar Agenda</h3>
                        <button onclick="openModal('add')" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Tambah Agenda Baru</button>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Tabel Agenda -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul Agenda</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ruangan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dibuat Oleh</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($agendas as $agenda)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                {{ $agenda->start_date->translatedFormat('d F Y') }}
                                                @if($agenda->end_date && $agenda->end_date->ne($agenda->start_date))
                                                    <span class="block text-xs text-gray-500">hingga {{ $agenda->end_date->translatedFormat('d F Y') }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $agenda->start_time->format('H:i') }} - {{ $agenda->end_time->format('H:i') }}</td>
                                        <td class="px-6 py-4">{{ $agenda->title }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $agenda->room->name ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $agenda->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-3">
                                                <button onclick="openModal('edit', {{ $agenda->id }})" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                                </button>
                                                <form action="{{ route('agenda-harian.destroy', $agenda->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd" /></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center py-4 text-gray-500">Tidak ada agenda yang ditemukan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="agendaModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form id="agendaForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div id="formMethod"></div>
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle"></h3>
                            <div class="mt-4 space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                                        <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    </div>
                                    <div>
                                        <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Berakhir (Opsional)</label>
                                        <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    </div>
                                </div>
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Agenda</label>
                                    <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="start_time" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                                        <input type="time" name="start_time" id="start_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    </div>
                                    <div>
                                        <label for="end_time" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                                        <input type="time" name="end_time" id="end_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="room_id" class="block text-sm font-medium text-gray-700">Ruangan (Opsional)</label>
                                    <select name="room_id" id="room_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="">Tidak ada</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                                </div>
                                <div>
                                    <label for="file_path" class="block text-sm font-medium text-gray-700">File Dukung (Opsional)</label>
                                    <input type="file" name="file_path" id="file_path" class="mt-1 block w-full text-sm">
                                    <span id="currentFile" class="text-xs text-gray-500 mt-1"></span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto">Simpan</button>
                            <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const modal = document.getElementById('agendaModal');
        const modalTitle = document.getElementById('modalTitle');
        const form = document.getElementById('agendaForm');
        const formMethod = document.getElementById('formMethod');
        const currentFile = document.getElementById('currentFile');

        function openModal(mode, id = null) {
            form.reset();
            currentFile.innerText = '';

            if (mode === 'add') {
                modalTitle.innerText = 'Tambah Agenda Baru';
                form.action = "{{ route('agenda-harian.store') }}";
                formMethod.innerHTML = '';
            } else if (mode === 'edit') {
                modalTitle.innerText = 'Edit Agenda';
                form.action = `/agenda-harian/${id}`;
                formMethod.innerHTML = '@method("PATCH")'; // Gunakan PATCH untuk update

                fetch(`/agenda-harian/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('title').value = data.title;
                        document.getElementById('description').value = data.description;
                        document.getElementById('start_date').value = data.start_date;
                        document.getElementById('end_date').value = data.end_date || '';
                        document.getElementById('start_time').value = data.start_time;
                        document.getElementById('end_time').value = data.end_time;
                        document.getElementById('room_id').value = data.room_id || '';

                        if (data.file_path) {
                            currentFile.innerText = 'File saat ini: ' + data.file_path.split('/').pop();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }
    </script>
    @endpush
</x-app-layout>
