<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Program') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.programs.update', $program) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="nama_program" :value="__('Nama Program')" />
                            <x-text-input id="nama_program" name="nama_program" type="text" class="mt-1 block w-full" :value="old('nama_program', $program->nama_program)" required />
                            <x-input-error :messages="$errors->get('nama_program')" class="mt-2" />
                        </div>

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
                            <x-input-label for="status" :value="__('Status Program')" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="direncanakan" {{ old('status', $program->status) == 'direncanakan' ? 'selected' : '' }}>Direncanakan</option>
                                <option value="berjalan" {{ old('status', $program->status) == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                                <option value="selesai" {{ old('status', $program->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                                <x-text-input id="tanggal_mulai" name="tanggal_mulai" type="date" class="mt-1 block w-full" :value="old('tanggal_mulai', $program->tanggal_mulai)" />
                                <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')" />
                                <x-text-input id="tanggal_selesai" name="tanggal_selesai" type="date" class="mt-1 block w-full" :value="old('tanggal_selesai', $program->tanggal_selesai)" />
                                <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="deskripsi" :value="__('Deskripsi Program')" />
                            <textarea id="deskripsi" name="deskripsi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.programs.index') }}" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700">
                                {{ __('Perbarui') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
