<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Logo dan Judul -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block">
                <img src="storage/photos/logo.jpeg" alt="Logo Balai Bahasa" class="w-20 h-20 mx-auto">
            </a>
            <h2 class="mt-4 text-2xl font-bold text-gray-900">Almanak</h2>
            <p class="mt-1 text-sm text-gray-600">
                Kalender Informasi Digital Balai Bahasa Provinsi Jawa Barat
            </p>
        </div>

        <!-- NIP Pegawai -->
        <div class="mt-8">
            <label for="nip" class="block text-sm font-medium text-gray-700">NIP Pegawai</label>
            <div class="mt-1">
                <input id="nip" name="nip" type="text" :value="old('nip')" required autofocus autocomplete="username"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       placeholder="Masukkan NIP">
                <x-input-error :messages="$errors->get('nip')" class="mt-2" />
            </div>
        </div>

        <!-- Kata Sandi dengan Ikon Mata -->
        <div class="mt-4" x-data="{ showPassword: false }">
            <label for="password" class="block text-sm font-medium text-gray-700">Kata sandi</label>
            <div class="mt-1 relative">
                <input id="password" name="password" :type="showPassword ? 'text' : 'password'" autocomplete="current-password" required
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                       placeholder="Masukkan Kata sandi">
                
                <!-- Tombol Ikon Mata -->
                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                    <!-- Ikon Mata Tertutup (default) -->
                    <svg x-show="!showPassword" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                    <!-- Ikon Mata Terbuka -->
                    <svg x-show="showPassword" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.432 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
            <div class="block mt-2">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Ingatkan Saya') }}</span>
                </label>
            </div>

        <div class="mt-4">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Masuk
            </button>
        </div>

    </form>
</x-guest-layout>