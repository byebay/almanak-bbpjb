<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Kehadiran Harian</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
                <form method="GET" action="{{ route('reports.attendance.index') }}">
                    <label for="date" class="font-bold">Pilih Tanggal:</label>
                    <input type="date" name="date" id="date" value="{{ $selectedDate }}" class="border rounded-md">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Tampilkan</button>
                </form>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold mb-2">Detail Kehadiran Tanggal {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                           <thead class="bg-gray-200">
                                <tr>
                                    <th class="text-left py-3 px-4">Nama Pegawai</th>
                                    <th class="text-left py-3 px-4">Jam Masuk</th>
                                    <th class="text-left py-3 px-4">Jam Keluar</th>
                                    <th class="text-left py-3 px-4">Status</th>
                                    <th class="text-left py-3 px-4">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reportData as $data)
                                    <tr class="border-b hover:bg-gray-50">
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
                                        <td class="py-3 px-4">{{ $data['notes'] ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center py-4">Tidak ada data pegawai untuk ditampilkan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
