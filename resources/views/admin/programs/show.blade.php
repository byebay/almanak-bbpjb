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
                            <p class="text-sm font-medium text-gray-500">Tim Kerja</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $program->tim_kerja ?: '-' }}</p>
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
                        <button type="button" x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-program')" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                            </svg>
                            Edit
                        </button>
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

    <x-modal name="edit-program" focusable>
        <form method="POST" action="{{ route('admin.programs.update', $program) }}" class="p-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900 mb-6">
                {{ __('Edit Program') }}
            </h2>

            <div class="space-y-6">
                <div>
                    <x-input-label for="nama_program" :value="__('Nama Program')" />
                    <x-text-input id="nama_program" name="nama_program" type="text" class="mt-1 block w-full" :value="old('nama_program', $program->nama_program)" required />
                    <x-input-error :messages="$errors->get('nama_program')" class="mt-2" />
                </div>

                @php
                    $wilayahOptions = \App\Models\Wilayah::orderBy('nama_wilayah')->pluck('nama_wilayah', 'id');
                @endphp
                <div>
                    <x-input-label for="wilayah_id" :value="__('Wilayah')" />
                    <select id="wilayah_id" name="wilayah_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Pilih Wilayah</option>
                        @foreach ($wilayahOptions as $id => $nama)
                            <option value="{{ $id }}" {{ old('wilayah_id', $program->wilayah_id) == $id ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('wilayah_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tim_kerja" :value="__('Tim Kerja')" />
                    <select id="tim_kerja" name="tim_kerja" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Pilih Tim Kerja (Opsional)</option>
                        <option value="Tim Kerja Pengembangan" {{ old('tim_kerja', $program->tim_kerja) == 'Tim Kerja Pengembangan' ? 'selected' : '' }}>Tim Kerja Pengembangan</option>
                        <option value="Tim Kerja Pembinaan" {{ old('tim_kerja', $program->tim_kerja) == 'Tim Kerja Pembinaan' ? 'selected' : '' }}>Tim Kerja Pembinaan</option>
                        <option value="Tim Kerja Pelindungan" {{ old('tim_kerja', $program->tim_kerja) == 'Tim Kerja Pelindungan' ? 'selected' : '' }}>Tim Kerja Pelindungan</option>
                        <option value="Statistik" {{ old('tim_kerja', $program->tim_kerja) == 'Statistik' ? 'selected' : '' }}>Statistik</option>
                    </select>
                    <x-input-error :messages="$errors->get('tim_kerja')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                    <x-text-input id="tanggal_mulai" name="tanggal_mulai" type="date" class="mt-1 block w-full" :value="old('tanggal_mulai', $program->tanggal_mulai ? explode(' ', $program->tanggal_mulai)[0] : '')" />
                    <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')" />
                    <x-text-input id="tanggal_selesai" name="tanggal_selesai" type="date" class="mt-1 block w-full" :value="old('tanggal_selesai', $program->tanggal_selesai ? explode(' ', $program->tanggal_selesai)[0] : '')" />
                    <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="deskripsi" :value="__('Deskripsi Program')" />
                    <textarea id="deskripsi" name="deskripsi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="file_path" :value="__('File Dukung (Opsional)')" />
                    <input type="file" name="file_path" id="file_path" class="mt-1 block w-full text-sm" accept=".pdf,.docx,.jpg,.jpeg,.png,.webp">
                    <span class="text-xs text-gray-500 mt-1 block">Format didukung: PDF, DOCX, JPG, JPEG, PNG, WEBP. Maks 5MB. Memilih file baru akan menimpa file lama.</span>
                    <x-input-error :messages="$errors->get('file_path')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50">
                    {{ __('Batal') }}
                </button>
                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700">
                    {{ __('Simpan Perubahan') }}
                </button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
