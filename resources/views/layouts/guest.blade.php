<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        {{-- Kontainer utama untuk menengahkan kartu --}}
        <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-4">
            
            {{-- Kartu Login Utama --}}
            <div class="w-full max-w-4xl flex flex-col sm:flex-row bg-white rounded-2xl shadow-2xl overflow-hidden">
                
                <!-- Kolom Kiri: Biru Solid -->
                <div class="relative w-full sm:w-1/2 hidden sm:block bg-blue-600">
                    <!-- Anda bisa menambahkan elemen dekoratif di sini jika mau -->
                </div>

                <!-- Kolom Kanan: Form Login -->
                <div class="w-full sm:w-1/2 flex items-center justify-center p-8 sm:p-12">
                    <div class="w-full max-w-sm">
                        {{-- Slot untuk menempatkan form --}}
                        {{ $slot }}
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>