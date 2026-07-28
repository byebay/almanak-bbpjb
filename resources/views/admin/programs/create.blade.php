<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Program Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.programs.store') }}" class="space-y-6">
                        @csrf

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
                            <x-input-label for="tahun" :value="__('Tahun')" />
                            <x-text-input id="tahun" name="tahun" type="text" class="mt-1 block w-full" :value="old('tahun')" />
                            <x-input-error :messages="$errors->get('tahun')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="deskripsi" :value="__('Deskripsi Program')" />
                            <textarea id="deskripsi" name="deskripsi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4">{{ old('deskripsi') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                            <a href="{{ route('admin.programs.index') }}" class="text-gray-600 hover:underline">{{ __('Batal') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
