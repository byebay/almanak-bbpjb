<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Wilayah Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.wilayah.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="kode" :value="__('Kode Wilayah (slug)')" />
                            <x-text-input id="kode" name="kode" type="text" class="mt-1 block w-full" :value="old('kode')" required />
                            <x-input-error :messages="$errors->get('kode')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="nama_wilayah" :value="__('Nama Wilayah')" />
                            <x-text-input id="nama_wilayah" name="nama_wilayah" type="text" class="mt-1 block w-full" :value="old('nama_wilayah')" required />
                            <x-input-error :messages="$errors->get('nama_wilayah')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="informasi" :value="__('Informasi Wilayah')" />
                            <textarea id="informasi" name="informasi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4">{{ old('informasi') }}</textarea>
                            <x-input-error :messages="$errors->get('informasi')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                            <a href="{{ route('admin.wilayah.index') }}" class="text-gray-600 hover:underline">{{ __('Batal') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
