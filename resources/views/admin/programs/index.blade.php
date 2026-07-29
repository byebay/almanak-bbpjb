<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Peta Sebaran Program') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-2">Peta Sebaran Program Jawa Barat</h3>
                    <p class="text-sm text-gray-600 mb-4">Klik wilayah pada peta untuk melihat detail program dan informasi wilayah.</p>
                    @include('components.svg.jabar')
                </div>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Daftar Program</h3>
                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-program')" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Tambah Program Baru
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="w-64 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Program</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Wilayah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Mulai</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Selesai</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">File</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pembuat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 [&>tr>td]:align-top">
                                @forelse ($programs as $program)
                                    <tr>
                                        <td class="w-64 px-6 py-4 align-top text-sm text-gray-900 whitespace-normal break-words">{{ $program->nama_program }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $program->wilayah?->nama_wilayah ?? 'Tidak ditentukan' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($program->deskripsi, 120) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
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
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $program->tanggal_mulai ? \Carbon\Carbon::parse($program->tanggal_mulai)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $program->tanggal_selesai ? \Carbon\Carbon::parse($program->tanggal_selesai)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($program->file_path)
                                                <a href="{{ Storage::url($program->file_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $program->creator->name ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-3">
                                                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-program-{{ $program->id }}')" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                                </button>
                                                <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus program ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd" /></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">Belum ada data program.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($programs->hasPages())
                        <div class="mt-6">
                            {{ $programs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-modal name="create-program" :show="$errors->isNotEmpty() && old('is_edit') != '1'" focusable>
        <form method="POST" action="{{ route('admin.programs.store') }}" class="p-6" enctype="multipart/form-data">
            @csrf

            <h2 class="text-lg font-medium text-gray-900 mb-6">
                {{ __('Tambah Program Baru') }}
            </h2>

            <div class="space-y-6">
                <div>
                    <x-input-label for="nama_program" :value="__('Nama Program')" />
                    <x-text-input id="nama_program" name="nama_program" type="text" class="mt-1 block w-full" :value="old('nama_program')" required />
                    <x-input-error :messages="$errors->get('nama_program')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="wilayah_id" :value="__('Wilayah')" />
                    <select id="wilayah_id" name="wilayah_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Pilih Wilayah</option>
                        @foreach ($wilayahOptions as $id => $nama)
                            <option value="{{ $id }}" {{ old('wilayah_id') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('wilayah_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="status" :value="__('Status Program')" />
                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="direncanakan" {{ old('status') == 'direncanakan' ? 'selected' : '' }}>Direncanakan</option>
                        <option value="berjalan" {{ old('status') == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                    <x-text-input id="tanggal_mulai" name="tanggal_mulai" type="date" class="mt-1 block w-full" :value="old('tanggal_mulai')" />
                    <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')" />
                    <x-text-input id="tanggal_selesai" name="tanggal_selesai" type="date" class="mt-1 block w-full" :value="old('tanggal_selesai')" />
                    <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="deskripsi" :value="__('Deskripsi Program')" />
                    <textarea id="deskripsi" name="deskripsi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4">{{ old('deskripsi') }}</textarea>
                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="file_path" :value="__('File Dukung (Opsional)')" />
                    <input type="file" name="file_path" id="file_path" class="mt-1 block w-full text-sm" accept=".pdf,.docx,.jpg,.jpeg,.png,.webp">
                    <span class="text-xs text-gray-500 mt-1 block">Format didukung: PDF, DOCX, JPG, JPEG, PNG, WEBP. Maks 5MB.</span>
                    <x-input-error :messages="$errors->get('file_path')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50">
                    {{ __('Batal') }}
                </button>
                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700">
                    {{ __('Simpan') }}
                </button>
            </div>
        </form>
    </x-modal>

    @foreach ($programs as $program)
        <x-modal name="edit-program-{{ $program->id }}" :show="$errors->isNotEmpty() && old('is_edit') == $program->id" focusable>
            <form method="POST" action="{{ route('admin.programs.update', $program) }}" class="p-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="is_edit" value="{{ $program->id }}">

                <h2 class="text-lg font-medium text-gray-900 mb-6">
                    {{ __('Edit Program') }}
                </h2>

                <div class="space-y-6">
                    <div>
                        <x-input-label for="nama_program_{{ $program->id }}" :value="__('Nama Program')" />
                        <x-text-input id="nama_program_{{ $program->id }}" name="nama_program" type="text" class="mt-1 block w-full" :value="old('nama_program', $program->nama_program)" required />
                        <x-input-error :messages="$errors->get('nama_program')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="wilayah_id_{{ $program->id }}" :value="__('Wilayah')" />
                        <select id="wilayah_id_{{ $program->id }}" name="wilayah_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Pilih Wilayah</option>
                            @foreach ($wilayahOptions as $id => $nama)
                                <option value="{{ $id }}" {{ old('wilayah_id', $program->wilayah_id) == $id ? 'selected' : '' }}>{{ $nama }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('wilayah_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="status_{{ $program->id }}" :value="__('Status Program')" />
                        <select id="status_{{ $program->id }}" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="direncanakan" {{ old('status', $program->status) == 'direncanakan' ? 'selected' : '' }}>Direncanakan</option>
                            <option value="berjalan" {{ old('status', $program->status) == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                            <option value="selesai" {{ old('status', $program->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="tanggal_mulai_{{ $program->id }}" :value="__('Tanggal Mulai')" />
                        <x-text-input id="tanggal_mulai_{{ $program->id }}" name="tanggal_mulai" type="date" class="mt-1 block w-full" :value="old('tanggal_mulai', $program->tanggal_mulai)" />
                        <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="tanggal_selesai_{{ $program->id }}" :value="__('Tanggal Selesai')" />
                        <x-text-input id="tanggal_selesai_{{ $program->id }}" name="tanggal_selesai" type="date" class="mt-1 block w-full" :value="old('tanggal_selesai', $program->tanggal_selesai)" />
                        <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="deskripsi_{{ $program->id }}" :value="__('Deskripsi Program')" />
                        <textarea id="deskripsi_{{ $program->id }}" name="deskripsi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="file_path_{{ $program->id }}" :value="__('File Dukung (Opsional)')" />
                        <input type="file" name="file_path" id="file_path_{{ $program->id }}" class="mt-1 block w-full text-sm" accept=".pdf,.docx,.jpg,.jpeg,.png,.webp">
                        <span class="text-xs text-gray-500 mt-1 block">Format didukung: PDF, DOCX, JPG, JPEG, PNG, WEBP. Maks 5MB.</span>
                        @if($program->file_path)
                            <span class="text-xs text-blue-600 mt-1 block">File saat ini: <a href="{{ Storage::url($program->file_path) }}" target="_blank" class="hover:underline">Lihat File</a></span>
                        @endif
                        <x-input-error :messages="$errors->get('file_path')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50">
                        {{ __('Batal') }}
                    </button>
                    <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700">
                        {{ __('Perbarui') }}
                    </button>
                </div>
            </form>
        </x-modal>
    @endforeach
</x-app-layout>
