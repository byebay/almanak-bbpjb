<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Cuti & Dinas Luar</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Form Input -->
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                <h3 class="font-bold text-lg mb-4">Input Data Baru</h3>
                @if (session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
                @endif
                <form action="{{ route('leaves.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="user_id" class="block font-bold">Nama Pegawai:</label>
                            <select name="user_id" id="user_id" class="border rounded w-full py-2 px-3" required>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="start_date" class="block font-bold">Tanggal Mulai:</label>
                            <input type="date" name="start_date" id="start_date" class="border rounded w-full py-2 px-3" required>
                        </div>
                        <div>
                            <label for="end_date" class="block font-bold">Tanggal Selesai:</label>
                            <input type="date" name="end_date" id="end_date" class="border rounded w-full py-2 px-3" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="status" class="block font-bold">Status:</label>
                            <select name="status" id="status" class="border rounded w-full py-2 px-3" required>
                                <option value="Cuti">Cuti</option>
                                <option value="Dinas Luar">Dinas Luar</option>
                            </select>
                        </div>
                        <div>
                            <label for="notes" class="block font-bold">Keterangan (Opsional):</label>
                            <input type="text" name="notes" id="notes" class="border rounded w-full py-2 px-3">
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Data</button>
                </form>
            </div>
            <!-- Tabel Riwayat -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="font-bold text-lg mb-4">Riwayat Cuti & Dinas Luar</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="text-left py-3 px-4">Nama Pegawai</th>
                                <th class="text-left py-3 px-4">Status</th>
                                <th class="text-left py-3 px-4">Mulai</th>
                                <th class="text-left py-3 px-4">Selesai</th>
                                <th class="text-left py-3 px-4">Keterangan</th>
                                <th class="text-left py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leaveRecords as $record)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4">{{ $record->user->name }}</td>
                                    <td class="py-3 px-4">{{ $record->status }}</td>
                                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($record->start_date)->format('d M Y') }}</td>
                                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($record->end_date)->format('d M Y') }}</td>
                                    <td class="py-3 px-4">{{ $record->notes ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        <form action="{{ route('leaves.destroy', $record) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Belum ada data cuti atau dinas luar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>