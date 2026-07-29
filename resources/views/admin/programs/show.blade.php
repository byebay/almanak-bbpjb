<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Program') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $program->nama_program }}</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Wilayah</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $program->wilayah?->nama_wilayah ?? 'Tidak ditentukan' }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p class="mt-1">
                                @php
                                    $statusStyles = [
                                        'direncanakan' => 'bg-yellow-100 text-yellow-800',
                                        'berjalan' => 'bg-blue-100 text-blue-800',
                                        'selesai' => 'bg-green-100 text-green-800',
                                    ];
                                @endphp
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $statusStyles[$program->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($program->status) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Tanggal Mulai</p>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $program->tanggal_mulai ? \Carbon\Carbon::parse($program->tanggal_mulai)->format('d/m/Y') : '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Tanggal Selesai</p>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $program->tanggal_selesai ? \Carbon\Carbon::parse($program->tanggal_selesai)->format('d/m/Y') : '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-500">Pembuat</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $program->creator->name ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <p class="text-sm font-medium text-gray-500">Deskripsi</p>
                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $program->deskripsi ?: '-' }}</p>
                    </div>

                    @if ($program->file_path)
                        <div class="mt-6">
                            <p class="text-sm font-medium text-gray-500 mb-2">File Dukung</p>
                            @php
                                $imageExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                                $extension = strtolower(pathinfo($program->file_path, PATHINFO_EXTENSION));
                                $isImage = in_array($extension, $imageExtensions);
                            @endphp

                            @if ($isImage)
                                <img src="{{ Storage::url($program->file_path) }}" alt="File dukung program" class="max-w-full md:max-w-lg rounded-md border border-gray-200">
                            @else
                                <a href="{{ Storage::url($program->file_path) }}" target="_blank" download class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 text-sm font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Unduh File ({{ strtoupper($extension) }})
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm font-medium">
                            Kembali
                        </a>
                        <a href="{{ route('admin.programs.edit', $program) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus program ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd" />
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
