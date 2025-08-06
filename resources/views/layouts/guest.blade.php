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
        <div class="min-h-screen flex flex-col sm:flex-row items-center justify-center bg-gray-100">

            <!-- Kolom Kiri: Branding & Logo -->
            <div class="w-full sm:w-1/2 h-full flex flex-col items-center justify-center p-6 sm:p-12 bg-blue-700 text-white">
                <div class="swiper h-full w-full">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide flex flex-col items-center justify-center text-center p-4">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg" alt="Ilustrasi 1" class="items-center w-64 h-64 object-contain">
                            <h2 class="text-2xl font-bold mt-4">Selamat Datang di Almanak</h2>
                            <p class="text-center mt-2 max-w-sm">Kelola agenda harian dan informasi kepegawaian dengan mudah.</p>
                        </div>
                        <div class="swiper-slide flex flex-col items-center justify-center text-center">
                            <img src="URL_GAMBAR_SLIDE_2" alt="Ilustrasi 2" class="w-64 h-64 object-contain">
                            <h2 class="text-2xl font-bold mt-4">Kalender Interaktif</h2>
                            <p class="mt-2 max-w-sm">Lihat semua kegiatan dalam satu tampilan kalender yang mudah diakses.</p>
                        </div>
                        <div class="swiper-slide flex flex-col items-center justify-center text-center">
                            <img src="URL_GAMBAR_SLIDE_3" alt="Ilustrasi 3" class="w-64 h-64 object-contain">
                            <h2 class="text-2xl font-bold mt-4">Laporan Terintegrasi</h2>
                            <p class="mt-2 max-w-sm">Pantau kehadiran dan realisasi kegiatan secara efisien.</p>
                        </div>
                    </div>
                </div>
            
                <!-- <a href="/">
                    <img src="data:image/jpeg;base64,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" alt="Logo Balai Bahasa Provinsi Jawa Barat" class="w-48 mx-auto mb-4">
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-center">Almanak</h1>
                <p class="text-center mt-2 text-blue-200">Kalender Informasi Digital Balai Bahasa Provinsi Jawa Barat</p> -->
            </div>

            <!-- Kolom Kanan: Form Login -->
            <div class="w-full sm:w-1/2 flex items-center justify-center">
                <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    {{ $slot }}
                </div>
            </div>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            // Inisialisasi Swiper.js
            const swiper = new Swiper('.swiper', {
                loop: true,
                autoplay: {
                    delay: 4000, // Geser setiap 4 detik
                    disableOnInteraction: false,
                },
            });
        </script>
    </body>
</html>
