<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Manajemen Ruangan') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Form Tambah Ruangan Baru -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h2 class="text-lg font-medium text-gray-900">Tambah Ruangan Baru</h2>
                    <form method="post" action="{{ route('rooms.store') }}" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Nama Ruangan')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="location" :value="__('Lokasi (Contoh: Gedung A, Lantai 2)')" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="capacity" :value="__('Kapasitas (Orang)')" />
                            <x-text-input id="capacity" name="capacity" type="number" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi/Fasilitas')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Daftar Ruangan -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Daftar Ruangan</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kapasitas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($rooms as $room)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $room->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $room->location ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $room->capacity ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-4">
                                            <a href="{{ route('rooms.edit', $room) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('rooms.destroy', $room) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus ruangan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data ruangan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
