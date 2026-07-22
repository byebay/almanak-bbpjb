<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ganti Kata Sandi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-xl mx-auto bg-white p-6 sm:p-8 rounded-lg shadow-sm border border-gray-100">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ __('Kirim Tautan Ganti Kata Sandi') }}
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Masukkan alamat posel tujuan ke mana tautan ganti kata sandi akun Anda akan dikirimkan. Setelah menerima posel tersebut, klik tautan di dalamnya untuk mengatur kata sandi baru.') }}
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-r-md text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 text-red-700 rounded-r-md text-sm">
                        <strong class="font-medium">{{ __('Terjadi kesalahan:') }}</strong>
                        <ul class="mt-1 list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.change-password.send') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Alamat Posel Penerima')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="nama@posel.com" />
                        <p class="mt-2 text-xs text-gray-500">
                            {{ __('Tautan ganti kata sandi akan dikirim ke posel ini. Kata sandi akun yang sedang aktif saat ini akan diperbarui.') }}
                        </p>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#1A7EFB] hover:bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Kirim Tautan Ganti Kata Sandi') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
