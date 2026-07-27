<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sebaran Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Peta Sebaran Program Jawa Barat -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Peta Sebaran Program Jawa Barat</h3>
                    <p class="text-sm text-gray-600 mb-4">Klik wilayah pada peta untuk melihat detail program dan informasi wilayah.</p>
                    @include('components.svg.jabar')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
