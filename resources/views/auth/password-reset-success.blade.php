<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Berhasil Mengubah Kata Sandi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-4 py-6 text-gray-900 text-center sm:px-6">
                    <!-- Icon Sukses -->
                    <div class="mb-6 flex justify-center">
                        <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>

                    <!-- Pesan Sukses -->
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">
                        {{ __('Kata sandi berhasil diubah') }}
                    </h3>
                    <p class="text-gray-600 mb-6">
                        {{ __('Kata sandi Anda telah berhasil diperbarui. Anda sekarang dapat login dengan kata sandi baru Anda.') }}
                    </p>

                    <!-- Tombol Kembali ke Dasbor -->
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest transition ease-in-out duration-150">
                        {{ __('Kembali ke dasbor') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
