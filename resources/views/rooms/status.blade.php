<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Ketersediaan Ruangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Form Filter Tanggal -->
            <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
                <form method="GET" action="{{ route('rooms.status') }}" class="flex items-center space-x-4">
                    <label for="date" class="font-bold text-gray-700">Tampilkan Status untuk Tanggal:</label>
                    <input type="date" name="date" id="date" value="{{ $selectedDate }}" class="border-gray-300 rounded-md shadow-sm">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Tampilkan</button>
                </form>
            </div>

            <!-- Grid Kartu Ruangan -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($rooms as $room)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all hover:shadow-xl">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">{{ $room->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $room->location }}</p>
                                </div>
                                {{-- Label Status --}}
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $room->status === 'Tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $room->status }}
                                </span>
                            </div>
                            <div class="mt-4 border-t pt-4">
                                @if($room->status === 'Digunakan')
                                    <h4 class="font-semibold text-gray-700 mb-2">Jadwal Penggunaan:</h4>
                                    <ul class="space-y-2">
                                        @foreach($room->agendas as $agenda)
                                            <li class="text-sm text-gray-600">
                                                <span class="font-bold">{{ \Carbon\Carbon::parse($agenda->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($agenda->end_time)->format('H:i') }}:</span>
                                                {{ $agenda->title }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-sm text-gray-500">Tidak ada jadwal penggunaan untuk tanggal ini.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">Tidak ada data ruangan. Silakan tambahkan melalui menu Manajemen Ruangan.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>