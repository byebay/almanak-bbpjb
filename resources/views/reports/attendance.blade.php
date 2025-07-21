<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Kehadiran Harian</h2>
    </x-slot>

    <div class="py-12" x-data="{ showModal: false, selectedUser: null, selectedDate: '{{ $selectedDate }}' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Form Filter Tanggal & Pesan Sukses -->
            <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
                <form method="GET" action="{{ route('reports.attendance.index') }}">
                    <label for="date" class="font-bold">Pilih Tanggal:</label>
                    <input type="date" name="date" id="date" value="{{ $selectedDate }}" class="border rounded-md">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Tampilkan</button>
                </form>
            </div>
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <!-- Tabel Laporan Terpadu -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold mb-2">Detail Kehadiran Tanggal {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</h3>
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="text-left py-3 px-4">Nama Pegawai</th>
                                <th class="text-left py-3 px-4">Jam Masuk</th>
                                <th class="text-left py-3 px-4">Jam Keluar</th>
                                <th class="text-left py-3 px-4">Status</th>
                                <th class="text-left py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reportData as $data)
                                <tr class="hover:bg-gray-100 border-b">
                                    <td class="py-3 px-4">{{ $data['name'] }}</td>
                                    <td class="py-3 px-4">{{ $data['check_in_time'] ?? '-' }}</td>
                                    <td class="py-3 px-4">{{ $data['check_out_time'] ?? '-' }}</td>
                                    <td class="py-3 px-4 font-semibold">
                                        @if($data['status'] == 'Hadir') <span class="text-green-600">Hadir</span>
                                        @elseif($data['status'] == 'Terlambat') <span class="text-orange-600">Terlambat</span>
                                        @elseif($data['status'] == 'Cuti') <span class="text-blue-600">Cuti</span>
                                        @elseif($data['status'] == 'Dinas Luar') <span class="text-purple-600">Dinas Luar</span>
                                        @else <span class="text-red-600">Tanpa Keterangan</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if(in_array($data['status'], ['Cuti', 'Dinas Luar', 'Tanpa Keterangan']))
                                            <button @click="showModal = true; selectedUser = {{ json_encode($data) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded text-sm">
                                                Update Status
                                            </button>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4">Tidak ada data pegawai untuk ditampilkan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal untuk Update Status -->
        <div x-show="showModal" @click.away="showModal = false" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" x-cloak>
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h4 class="text-lg font-bold mb-2">Update Status untuk <span x-text="selectedUser?.name"></span></h4>
                <p class="text-sm text-gray-600 mb-4">Tanggal: {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</p>
                <form action="{{ route('reports.attendance.updateStatus') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" :value="selectedUser?.user_id">
                    <input type="hidden" name="date" :value="selectedDate">
                    
                    <div class="mb-4">
                        <label for="status" class="block font-bold">Status Baru:</label>
                        <select name="status" id="status" class="border rounded w-full py-2 px-3" required>
                            <option value="Cuti">Cuti</option>
                            <option value="Dinas Luar">Dinas Luar</option>
                            <option value="Tanpa Keterangan">Tanpa Keterangan</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="notes" class="block font-bold">Keterangan (jika Dinas Luar):</label>
                        <textarea name="notes" id="notes" rows="3" class="border rounded w-full py-2 px-3"></textarea>
                    </div>
                    <div class="text-right">
                        <button type="button" @click="showModal = false" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Batal</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
