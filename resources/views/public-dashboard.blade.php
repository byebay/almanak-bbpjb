<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Almanak - Balai Bahasa Provinsi Jawa Barat</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles & Scripts (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    {{-- Style kustom Anda untuk kalender --}}
    <style>
        :root {
            --fc-button-bg-color: #3B82F6;
            --fc-button-border-color: #3B82F6;
            --fc-button-hover-bg-color: #2563EB;
            --fc-button-hover-border-color: #2563EB;
            --fc-button-active-bg-color: #1D4ED8;
            --fc-button-active-border-color: #1D4ED8;
            --fc-today-bg-color: rgba(219, 234, 254, 0.7);
        }
        .fc .fc-col-header-cell {
            background-color: #DBEAFE;
        }
        .fc-day-sun .fc-daygrid-day-number,
        .fc-day-sat .fc-daygrid-day-number {
            color: #EF4444;
            font-weight: bold;
        }

        .fc .fc-toolbar.fc-header-toolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            row-gap: 0.75rem;
            margin-bottom: 1.25rem;
        }

        .fc .fc-toolbar-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .fc .fc-toolbar-chunk {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* === Responsive mobile === */
        @media (max-width: 640px) {
            .fc .fc-toolbar.fc-header-toolbar {
                flex-direction: column;
                align-items: center;
            }
            /* chunk pertama = tombol2 (right), chunk kedua = judul (left) */
            .fc .fc-toolbar-chunk:first-child {
                order: 1; /* tombol2 di atas */
                flex-wrap: wrap;
                justify-content: center;
            }
            .fc .fc-toolbar-chunk:last-child {
                order: 2; /* judul (Juli 2026) di bawah tombol, di atas kalender */
            }
            .fc .fc-toolbar-title {
                font-size: 1.5rem;
            }
            .fc .fc-button {
                font-size: 0.8rem;
                padding: 0.4rem 0.6rem;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Header Publik -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex flex-wrap justify-between items-center gap-y-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <img src="{{ asset('image/logo.jpg') }}" alt="Logo Balai Bahasa" class="block h-12 w-auto">
                    <span class="font-semibold text-xl text-gray-800 ml-3">Almanak</span>
                </div>

                <!-- Tombol Login -->
                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Login Pegawai
                </a>
            </div>

        </header>

        <!-- Konten Utama (Slider & Kalender) -->
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                
                <!-- Slider Statistik Kehadiran -->
                <div class="swiper bg-transparent h-72">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide bg-white rounded-lg p-6 shadow-sm flex flex-col items-center justify-center">
                            <h3 class="text-xl font-bold text-gray-800 text-center">Datang Paling Awal</h3>
                            @if($pegawaiPalingAwal)
                                <div class="text-center mt-4">
                                    <img src="{{ $pegawaiPalingAwal->photo_url }}" alt="{{ $pegawaiPalingAwal->name }}" class="w-24 h-24 rounded-full mx-auto object-cover">
                                    <p class="text-xl font-semibold mt-3">{{ $pegawaiPalingAwal->name }}</p>
                                    <p class="text-gray-500 text-sm">NIP: {{ $pegawaiPalingAwal->nip }}</p>
                                </div>
                            @else
                                <p class="text-center text-gray-500 mt-4">Tidak ada data kehadiran.</p>
                            @endif
                        </div>
                        <div class="swiper-slide bg-white rounded-lg p-6 shadow-sm">
                            <div class="grid grid-cols-2 divide-x divide-gray-200 h-full">
                                <div class="flex flex-col items-center justify-center text-center pr-4">
                                    <h3 class="text-xl font-bold text-gray-800">Jumlah Hadir</h3>
                                    <p class="text-7xl font-extrabold text-blue-500 mt-2">{{ $jumlahHadir }}</p>
                                    <p class="text-lg text-gray-600">Pegawai</p>
                                </div>
                                <div class="flex flex-col items-center justify-center text-center pl-4">
                                    <h3 class="text-xl font-bold text-gray-800">Jumlah Terlambat</h3>
                                    <p class="text-7xl font-extrabold text-yellow-500 mt-2">{{ $jumlahTerlambat }}</p>
                                    <p class="text-lg text-gray-600">Pegawai</p>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide bg-white rounded-lg p-6 shadow-sm overflow-y-auto">
                            <h3 class="text-xl font-bold text-gray-800 text-center mb-4">Pegawai Cuti</h3>
                            <div class="flex flex-wrap justify-center gap-4">
                                @forelse($pegawaiCuti as $pegawai)
                                    <div class="text-center w-24">
                                        <img src="{{ $pegawai->photo_url }}" alt="{{ $pegawai->name }}" class="w-20 h-20 rounded-full mx-auto object-cover">
                                        <p class="mt-2 text-sm font-medium break-words">{{ $pegawai->name }}</p>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-500">Tidak ada pegawai yang cuti hari ini.</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="swiper-slide bg-white rounded-lg p-6 shadow-sm overflow-y-auto">
                            <h3 class="text-xl font-bold text-gray-800 text-center mb-4">Pegawai Dinas Luar</h3>
                            <div class="flex flex-wrap justify-center gap-4">
                                @forelse($pegawaiDinasLuar as $pegawai)
                                    <div class="text-center w-24">
                                        <img src="{{ $pegawai->photo_url }}" alt="{{ $pegawai->name }}" class="w-20 h-20 rounded-full mx-auto object-cover">
                                        <p class="mt-2 text-sm font-medium break-words">{{ $pegawai->name }}</p>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-500">Tidak ada pegawai dinas luar hari ini.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Peta Sebaran Program Jawa Barat -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div x-data="{ 
        activeTab: 'kabupaten', 
        activeSubTims: [],
        toggleSubTim(tabTarget, subTim) {
            if (this.activeTab !== tabTarget) {
                // Pindah tab otomatis
                this.activeTab = tabTarget;
                this.activeSubTims = [subTim];
            } else {
                if (this.activeSubTims.includes(subTim)) {
                    this.activeSubTims = this.activeSubTims.filter(s => s !== subTim);
                } else {
                    this.activeSubTims.push(subTim);
                }
            }
            setTimeout(() => { if(typeof drawPins === 'function') drawPins(this.activeTab, this.activeSubTims); }, 50);
        },
        init() { 
            setTimeout(() => { if(typeof drawPins === 'function') drawPins(this.activeTab, this.activeSubTims); }, 100); 
        },
        switchTab(tab) {
            this.activeTab = tab;
            this.activeSubTims = [];
            setTimeout(() => { if(typeof drawPins === 'function') drawPins(this.activeTab, this.activeSubTims); }, 100);
        }
    }">

                        <!-- Navbar -->
                        <nav class="bg-[#0b43bf]">
                            <div class="max-w-7xl mx-auto px-4">
                                <ul class="flex items-center justify-center flex-wrap gap-x-8 gap-y-2 py-3 text-base font-extrabold relative">
                                    <li>
                                        <button type="button"
                                            @click="switchTab('kabupaten')"
                                            :class="activeTab === 'kabupaten' ? 'text-white underline underline-offset-4' : 'text-cyan-100 hover:text-white'"
                                            class="transition py-2">
                                            Per Kabupaten
                                        </button>
                                    </li>
                                    <!-- Dropdown Pengembangan -->
                                    <li class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                        <button type="button"
                                            @click="switchTab('pengembangan')"
                                            :class="activeTab === 'pengembangan' ? 'text-white underline underline-offset-4' : 'text-cyan-100 hover:text-white'"
                                            class="transition py-2">
                                            Tim Kerja Pengembangan
                                        </button>
                                        <div x-show="open" x-transition.opacity style="display: none;"
                                             class="absolute left-0 mt-0 w-56 bg-white rounded-md shadow-xl border border-gray-100 z-50 overflow-hidden font-normal text-sm">
                                            <div class="p-2 space-y-1">
                                                <label class="flex items-center px-3 py-2 rounded hover:bg-gray-100 cursor-pointer transition">
                                                    <input type="checkbox" class="rounded text-blue-600 form-checkbox border-gray-300" 
                                                           :checked="activeTab === 'pengembangan' && activeSubTims.includes('Kamus dan Istilah')"
                                                           @change="toggleSubTim('pengembangan', 'Kamus dan Istilah')">
                                                    <span class="w-3 h-3 rounded-full ml-3 mr-2 border border-gray-500" style="background-color: #FF1493;"></span>
                                                    <span class="text-gray-700">Kamus dan Istilah</span>
                                                </label>
                                                <label class="flex items-center px-3 py-2 rounded hover:bg-gray-100 cursor-pointer transition">
                                                    <input type="checkbox" class="rounded text-blue-600 form-checkbox border-gray-300" 
                                                           :checked="activeTab === 'pengembangan' && activeSubTims.includes('BIPA')"
                                                           @change="toggleSubTim('pengembangan', 'BIPA')">
                                                    <span class="w-3 h-3 rounded-full ml-3 mr-2 border border-gray-500" style="background-color: #00E5FF;"></span>
                                                    <span class="text-gray-700">BIPA</span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Dropdown Pembinaan -->
                                    <li class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                        <button type="button"
                                            @click="switchTab('pembinaan')"
                                            :class="activeTab === 'pembinaan' ? 'text-white underline underline-offset-4' : 'text-cyan-100 hover:text-white'"
                                            class="transition py-2">
                                            Tim Kerja Pembinaan
                                        </button>
                                        <div x-show="open" x-transition.opacity style="display: none;"
                                             class="absolute left-0 mt-0 w-56 bg-white rounded-md shadow-xl border border-gray-100 z-50 overflow-hidden font-normal text-sm">
                                            <div class="p-2 space-y-1">
                                                <label class="flex items-center px-3 py-2 rounded hover:bg-gray-100 cursor-pointer transition">
                                                    <input type="checkbox" class="rounded text-blue-600 form-checkbox border-gray-300" 
                                                           :checked="activeTab === 'pembinaan' && activeSubTims.includes('Pembahu')"
                                                           @change="toggleSubTim('pembinaan', 'Pembahu')">
                                                    <span class="w-3 h-3 rounded-full ml-3 mr-2 border border-gray-500" style="background-color: #00E676;"></span>
                                                    <span class="text-gray-700">Pembahu</span>
                                                </label>
                                                <label class="flex items-center px-3 py-2 rounded hover:bg-gray-100 cursor-pointer transition">
                                                    <input type="checkbox" class="rounded text-blue-600 form-checkbox border-gray-300" 
                                                           :checked="activeTab === 'pembinaan' && activeSubTims.includes('Literasi')"
                                                           @change="toggleSubTim('pembinaan', 'Literasi')">
                                                    <span class="w-3 h-3 rounded-full ml-3 mr-2 border border-gray-500" style="background-color: #2979FF;"></span>
                                                    <span class="text-gray-700">Literasi</span>
                                                </label>
                                                <label class="flex items-center px-3 py-2 rounded hover:bg-gray-100 cursor-pointer transition">
                                                    <input type="checkbox" class="rounded text-blue-600 form-checkbox border-gray-300" 
                                                           :checked="activeTab === 'pembinaan' && activeSubTims.includes('UKBI')"
                                                           @change="toggleSubTim('pembinaan', 'UKBI')">
                                                    <span class="w-3 h-3 rounded-full ml-3 mr-2 border border-gray-500" style="background-color: #D500F9;"></span>
                                                    <span class="text-gray-700">UKBI</span>
                                                </label>
                                                <label class="flex items-center px-3 py-2 rounded hover:bg-gray-100 cursor-pointer transition">
                                                    <input type="checkbox" class="rounded text-blue-600 form-checkbox border-gray-300" 
                                                           :checked="activeTab === 'pembinaan' && activeSubTims.includes('Penerjemahan')"
                                                           @change="toggleSubTim('pembinaan', 'Penerjemahan')">
                                                    <span class="w-3 h-3 rounded-full ml-3 mr-2 border border-gray-500" style="background-color: #FF3D00;"></span>
                                                    <span class="text-gray-700">Penerjemahan</span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Dropdown Perlindungan -->
                                    <li class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                        <button type="button"
                                            @click="switchTab('perlindungan')"
                                            :class="activeTab === 'perlindungan' ? 'text-white underline underline-offset-4' : 'text-cyan-100 hover:text-white'"
                                            class="transition py-2">
                                            Tim Kerja Perlindungan
                                        </button>
                                        <div x-show="open" x-transition.opacity style="display: none;"
                                             class="absolute left-0 mt-0 w-56 bg-white rounded-md shadow-xl border border-gray-100 z-50 overflow-hidden font-normal text-sm">
                                            <div class="p-2 space-y-1">
                                                <label class="flex items-center px-3 py-2 rounded hover:bg-gray-100 cursor-pointer transition">
                                                    <input type="checkbox" class="rounded text-blue-600 form-checkbox border-gray-300" 
                                                           :checked="activeTab === 'perlindungan' && activeSubTims.includes('Molinbastra')"
                                                           @change="toggleSubTim('perlindungan', 'Molinbastra')">
                                                    <span class="w-3 h-3 rounded-full ml-3 mr-2 border border-gray-500" style="background-color: #FFEA00;"></span>
                                                    <span class="text-gray-700">Molinbastra</span>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <button type="button"
                                            @click="switchTab('statistik')"
                                            :class="activeTab === 'statistik' ? 'text-white underline underline-offset-4' : 'text-cyan-100 hover:text-white'"
                                            class="transition py-2">
                                            Statistik
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </nav>

                        <!-- ============================= -->
                        <!-- TAB: PER KABUPATEN             -->
                        <!-- ============================= -->
                        <div x-show="activeTab === 'kabupaten'" x-cloak>
                            <div class="p-6 text-gray-900">

                                <h3 class="text-2xl font-bold mb-4">
                                    Peta Sebaran Program Jawa Barat
                                </h3>

                                <p class="text-sm text-gray-600 mb-4">
                                    Klik wilayah pada peta untuk melihat detail program dan informasi wilayah.
                                </p>
                                <!-- Legend -->
                                <div class="mt-4 w-64">
                                    <div class="text-sm text-gray-900 mb-1 font-medium">
                                        Jumlah Program:
                                    </div>

                                    <div
                                        class="h-3 w-full rounded-sm shadow-inner"
                                        style="background: linear-gradient(to right, #f4f5f6ff, #0b43bf);">
                                    </div>

                                    <div
                                        id="legend-ticks"
                                        class="relative w-full h-8 mt-0 text-[15px] text-gray-600 font-mono">
                                </div>
                            </div>
                                @include('components.svg.jabar')

                            </div>
                        </div>

                        <!-- ============================= -->
                        <!-- TAB: TIM KERJA PENGEMBANGAN   -->
                        <!-- ============================= -->
                        <div x-show="activeTab === 'pengembangan'" x-cloak>
                            <div class="p-6 text-gray-900">

                                <h3 class="text-2xl font-bold mb-4">Tim Kerja Pengembangan</h3>
                                <p class="text-sm text-gray-600 mb-4">Peta sebaran program Tim Kerja Pengembangan.</p>


                                @include('components.svg.jabar-tim-kerja')

                            </div>
                        </div>

                        <!-- ============================= -->
                        <!-- TAB: TIM KERJA PEMBINAAN      -->
                        <!-- ============================= -->
                        <div x-show="activeTab === 'pembinaan'" x-cloak>
                            <div class="p-6 text-gray-900">

                                <h3 class="text-2xl font-bold mb-4">Tim Kerja Pembinaan</h3>
                                <p class="text-sm text-gray-600 mb-4">Peta sebaran program Tim Kerja Pembinaan.</p>


                                @include('components.svg.jabar-tim-kerja')

                            </div>
                        </div>

                        <!-- ============================= -->
                        <!-- TAB: TIM KERJA PERLINDUNGAN   -->
                        <!-- ============================= -->
                        <div x-show="activeTab === 'perlindungan'" x-cloak>
                            <div class="p-6 text-gray-900">

                                <h3 class="text-2xl font-bold mb-4">Tim Kerja Perlindungan</h3>
                                <p class="text-sm text-gray-600 mb-4">Peta sebaran program Tim Kerja Perlindungan.</p>


                                @include('components.svg.jabar-tim-kerja')

                            </div>
                        </div>

                        <!-- ============================= -->
                        <!-- TAB: STATISTIK                 -->
                        <!-- ============================= -->
                        <div x-show="activeTab === 'statistik'" x-cloak>
                            <div class="p-6 text-gray-900">

                                <h3 class="text-2xl font-bold mb-4">
                                    Statistik
                                </h3>

                                <p class="text-sm text-gray-600">
                                    Statistik program akan ditampilkan di sini.
                                </p>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kalender Agenda -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-2xl font-bold mb-4">Kalender Agenda BBPJB</h3>
                        <div id='calendar'></div>
                    </div>
                </div>

                <!-- Statistik Pengunjung dengan Grafik (Publik) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                            <div>
                                <h3 class="text-2xl font-bold">Statistik Pengunjung</h3>
                                <p id="chartSubtitleText" class="text-sm text-gray-500 mt-1"></p>
                            </div>
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">
                                <select id="chartPeriodFilter" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm w-full sm:w-auto">
                                    <option value="daily">Harian (Bulan Ini)</option>
                                    <option value="monthly">Bulanan (Tahun Ini)</option>
                                    <option value="yearly">Tahunan (5 Tahun Terakhir)</option>
                                </select>
                            </div>
                        </div>
                        <div class="relative w-full overflow-x-auto">
                            <div class="relative h-72" style="min-width: 800px;">
                                <canvas id="visitorChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <footer class="bg-blue-700 text-white mt-auto">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                <!-- Kolom Logo -->
                <div class="lg:col-span-2">
                    <div class="flex items-center">
                        <img src="https://i.pinimg.com/1200x/bc/3e/e8/bc3ee8618c9672304e9940969265728c.jpg" alt="Logo Balai Bahasa" class="h-16 w-auto">
                        <div class="ml-4">
                            <h3 class="font-bold text-lg">BALAI BAHASA</h3>
                            <p class="text-sm">PROVINSI JAWA BARAT</p>
                            <p class="text-xs text-blue-200 mt-1">BADAN PENGEMBANGAN DAN PEMBINAAN BAHASA<br>Kementerian Pendidikan Dasar dan Menengah</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-bold uppercase tracking-wider text-sm mb-4">Alamat</h3>
                    <p class="text-sm text-blue-200">Jl. Sumbawa No.11, Kelurahan Merdeka, Kec. Sumur Bandung, Kota Bandung, Jawa Barat 40113</p>
                    <p class="text-sm text-blue-200 mt-2"><strong>Telepon :</strong> (022) 4205468</p>
                    <p class="text-sm text-blue-200 mt-1"><strong>Posel :</strong> balaibahasa.jabar@kemdikbud.go.id</p>
                </div>
            </div>
        </div>
        
        <div class="bg-blue-800 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-blue-200">&copy; Copyright 2025. IT Support Balai Bahasa Provinsi Jawa Barat. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <a href="https://wa.me/6282130165377" 
       target="_blank" 
       class="fixed bottom-5 right-5 bg-green-500 text-white font-bold py-3 px-5 rounded-full shadow-lg hover:bg-green-600 transition-transform hover:scale-105 flex items-center z-50">
        <!-- Ikon WhatsApp SVG -->
        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.31 20.62C8.75 21.41 10.37 21.82 12.04 21.82C17.5 21.82 21.95 17.37 21.95 11.91C21.95 6.45 17.5 2 12.04 2M12.04 3.67C16.56 3.67 20.28 7.39 20.28 11.91C20.28 16.43 16.56 20.15 12.04 20.15C10.46 20.15 8.96 19.68 7.72 18.83L7.29 18.57L4.35 19.41L5.21 16.54L4.93 16.11C4.03 14.78 3.56 13.25 3.56 11.91C3.56 7.39 7.28 3.67 12.04 3.67M9.13 7.5C8.89 7.5 8.67 7.55 8.46 7.91C8.25 8.27 7.5 8.99 7.5 10.13C7.5 11.27 8.48 12.35 8.63 12.52C8.78 12.69 9.94 14.48 11.72 15.2C13.5 15.92 14.04 15.72 14.43 15.68C14.82 15.64 15.78 15.08 15.97 14.52C16.16 13.96 16.16 13.48 16.1 13.38C16.04 13.28 15.86 13.23 15.61 13.11C15.36 12.99 14.21 12.43 13.98 12.33C13.75 12.23 13.59 12.18 13.43 12.43C13.27 12.68 12.82 13.23 12.67 13.4C12.52 13.57 12.38 13.61 12.13 13.49C11.88 13.37 11.08 13.11 10.12 12.25C9.37 11.59 8.87 10.78 8.75 10.53C8.63 10.28 8.77 10.14 8.89 10.02C9 9.92 9.14 9.74 9.27 9.6C9.4 9.46 9.45 9.35 9.53 9.17C9.61 8.99 9.56 8.84 9.5 8.73C9.44 8.62 9.22 8.06 9.13 7.82V7.5Z" />
        </svg>
        <span>Apa yang bisa kami bantu?</span>
    </a>
                

    <!-- Modal untuk Detail Agenda -->
    <div id="agendaDetailModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true"><div class="absolute inset-0 bg-gray-500 opacity-75"></div></div>
            <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 text-center" id="modalTitle"></h3>
                    <div id="modalBody" class="mt-4 border-t border-gray-200 pt-4 space-y-4"></div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeModal()" class="w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- JavaScript untuk Swiper, FullCalendar, dan Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Swiper Slider
            const swiper = new Swiper('.swiper', {
                loop: true,
                autoplay: { delay: 5000, disableOnInteraction: false },
            });

            // Inisialisasi FullCalendar
            const calendarEl = document.getElementById('calendar');
            const modal = document.getElementById('agendaDetailModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalBody = document.getElementById('modalBody');
            
            const toLocalISOString = (date) => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            const getAspectRatio = () => window.innerWidth < 640 ? 0.7 : 2;

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                    headerToolbar: {
                        left: 'title',
                        center: '',
                        right: 'prev,next today dayGridMonth,dayGridWeek'
                    },
                aspectRatio: getAspectRatio(),
                expandRows: true,
                windowResize: function(arg) {
                    calendar.setOption('aspectRatio', getAspectRatio());
                },
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu'
                },
                eventContent: function(info) {
                    if (info.view.type === 'dayGridMonth') return { html: '' };
                    return true;
                },
                events: '{{ route("public.events") }}', // Perbaikan: Gunakan route publik
                
                datesSet: function(dateInfo) {
                    document.querySelectorAll('.fc-daygrid-day .custom-star').forEach(el => el.remove());
                    const currentEvents = calendar.getEvents();
                    currentEvents.forEach(event => {
                        const dateStr = toLocalISOString(event.start);
                        const dayCell = document.querySelector(`.fc-day[data-date="${dateStr}"]`);
                        if (dayCell) {
                            const dayNumberEl = dayCell.querySelector('.fc-daygrid-day-number');
                            if (dayNumberEl && !dayNumberEl.querySelector('.custom-star')) {
                                const starEl = document.createElement('span');
                                starEl.innerHTML = '★&nbsp;';
                                starEl.className = 'text-blue-600 custom-star';
                                dayNumberEl.prepend(starEl);
                            }
                        }
                    });
                },

                dateClick: function(info) {
                        const clickedDateStr = toLocalISOString(info.date);
                        const allEvents = calendar.getEvents();
                        const eventsOnDate = allEvents.filter(event => toLocalISOString(event.start) === clickedDateStr);

                        if (eventsOnDate.length > 0) {
                            const dateObj = new Date(info.date);
                            modalTitle.textContent = `Agenda pada tanggal ${dateObj.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })}`;
                            modalBody.innerHTML = '';
                            
                            eventsOnDate.forEach(event => {
                                const props = event.extendedProps;
                                let fileHtml = '';
                                if (props.file_url) {
                                    let fileContent = '';
                                    if (['jpg', 'jpeg', 'png', 'gif'].includes(props.file_extension)) {
                                        fileContent = `<img src="${props.file_url}" alt="File Dukung" class="mt-2 rounded-md border max-w-full h-auto">`;
                                    } else if (props.file_extension === 'pdf') {
                                        fileContent = `<iframe src="${props.file_url}" class="mt-2 w-full h-96 rounded-md border"></iframe>`;
                                    } else {
                                        fileContent = `<a href="${props.file_url}" target="_blank" class="text-sm text-blue-600 hover:underline">${props.file_name}</a>`;
                                    }
                                    fileHtml = `<div class="mt-3 pt-3 border-t border-gray-200"><p class="text-l text-gray-600 font-semibold">Data Dukung:</p>${fileContent}</div>`;
                                }

                                let roomHtml = '';
                                if (props.room_name) {
                                    roomHtml = `<div class="mt-2 flex items-center justify-center text-sm text-gray-500 bg-blue-50 rounded-full px-3 py-1"><span>${props.room_name}</span></div>`;
                                }

                                const eventDetail = `<div class="pb-3"><p class="text-3xl text-center font-bold text-black mb-1">${event.title}</p><p class="text-l text-center text-gray-600">Waktu: ${props.start_time} - ${props.end_time}</p>${roomHtml}<p class="text-l font-semibold text-gray-600 mt-2 whitespace-pre-wrap">Deskripsi Kegiatan:</p><p class="text-l text-gray-500 mt-2 whitespace-pre-wrap">${props.description}</p>${fileHtml}</div><hr class="last:hidden">`;
                                modalBody.innerHTML += eventDetail;
                            });
                            modal.classList.remove('hidden');
                        }
                    }
            });
            calendar.render();
            window.closeModal = function() { modal.classList.add('hidden'); }

            // === Inisialisasi Chart.js Statistik Pengunjung ===
            const ctx = document.getElementById('visitorChart').getContext('2d');
            const chartDataGrouped = @json($chartDataGrouped);
            
            // Buat grafik awal (Daily)
            let visitorChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartDataGrouped.daily.labels,
                    datasets: [{
                        label: 'Jumlah Pengunjung',
                        data: chartDataGrouped.daily.data,
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgb(37, 99, 235)',
                        borderWidth: 1,
                        borderRadius: 4,
                        barPercentage: 0.7 
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { grid: { display: false } },
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 },
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Pengunjung';
                                }
                            }
                        }
                    }
                }
            });

            // Set subtitle awal
            document.getElementById('chartSubtitleText').textContent = chartDataGrouped.daily.subtitle;

            // Logika ganti data saat Dropdown dipilih
            document.getElementById('chartPeriodFilter').addEventListener('change', function(e) {
                const period = e.target.value; 
                const newData = chartDataGrouped[period];
                
                // Animasi pertukaran data yang mulus
                visitorChart.data.labels = newData.labels;
                visitorChart.data.datasets[0].data = newData.data;
                visitorChart.update();

                // Update subtitle
                document.getElementById('chartSubtitleText').textContent = newData.subtitle;
            });
        });

        // --- MAP PINS LOGIC ---
        const allProgramsData = @json($allProgramsData);

        const subTimColors = {
            'Kamus dan Istilah': '#FF1493', // Deep Pink
            'BIPA': '#00E5FF', // Cyan
            'Pembahu': '#00E676', // Green
            'Literasi': '#2979FF', // Blue
            'UKBI': '#D500F9', // Purple
            'Penerjemahan': '#FF3D00', // Orange-Red
            'Molinbastra': '#FFEA00' // Yellow
        };

        function drawPins(activeTab, activeSubTims = []) {
            // First clear all pins in all SVGs
            document.querySelectorAll('.pins-container').forEach(container => {
                container.innerHTML = '';
            });

            if (activeTab === 'kabupaten' || activeTab === 'statistik') return;

            let timKerjaTarget = '';
            if (activeTab === 'pengembangan') timKerjaTarget = 'Tim Kerja Pengembangan';
            if (activeTab === 'pembinaan') timKerjaTarget = 'Tim Kerja Pembinaan';
            if (activeTab === 'perlindungan') timKerjaTarget = 'Tim Kerja Pelindungan';

            let filteredPrograms = allProgramsData.filter(p => p.tim_kerja === timKerjaTarget);
            
            // Terapkan filter Sub Tim Kerja jika ada
            if (activeSubTims && activeSubTims.length > 0) {
                filteredPrograms = filteredPrograms.filter(p => activeSubTims.includes(p.sub_tim_kerja));
            }
            
            // Find the active tab's SVG container
            const activeDiv = document.querySelector(`[x-show="activeTab === '${activeTab}'"]`);
            if (!activeDiv) return;
            const pinsContainer = activeDiv.querySelector('.pins-container');
            const svgElement = activeDiv.querySelector('svg');
            if (!pinsContainer || !svgElement) return;

            let delay = 0;
            const placedPins = [];
            const MIN_DIST = 12; // Minimum pixel distance between pins

            filteredPrograms.forEach((program) => {
                if (!program.wilayah || !program.wilayah.kode) return;
                
                const pathEl = svgElement.querySelector(`a[data-kode="${program.wilayah.kode}"] path`);
                if (!pathEl) return;

                const bbox = pathEl.getBBox();
                if (bbox.width === 0 && bbox.height === 0) return; // Hidden SVG

                const svgPt = svgElement.createSVGPoint();
                let validPoint = false;
                let rx = 0, ry = 0;
                let attempts = 0;

                // Phase 1: Try to find a spot inside the region without overlap
                while (!validPoint && attempts < 150) {
                    rx = bbox.x + Math.random() * bbox.width;
                    ry = bbox.y + Math.random() * bbox.height;
                    svgPt.x = rx;
                    svgPt.y = ry;
                    
                    if (pathEl.isPointInFill(svgPt)) {
                        let collision = false;
                        for (const p of placedPins) {
                            const dx = p.x - rx;
                            const dy = p.y - ry;
                            if (Math.sqrt(dx*dx + dy*dy) < MIN_DIST) {
                                collision = true;
                                break;
                            }
                        }
                        if (!collision) validPoint = true;
                    }
                    attempts++;
                }

                // Phase 2: If area is too small (e.g. Cimahi), spiral outward from center
                if (!validPoint) {
                    const cx = bbox.x + bbox.width / 2;
                    const cy = bbox.y + bbox.height / 2;
                    let radius = 0;
                    let angle = 0;
                    
                    for (let i = 0; i < 300; i++) {
                        rx = cx + Math.cos(angle) * radius;
                        ry = cy + Math.sin(angle) * radius;
                        
                        let collision = false;
                        for (const p of placedPins) {
                            const dx = p.x - rx;
                            const dy = p.y - ry;
                            if (Math.sqrt(dx*dx + dy*dy) < MIN_DIST) {
                                collision = true;
                                break;
                            }
                        }
                        if (!collision) {
                            validPoint = true;
                            break;
                        }
                        radius += 0.5; // expand spiral slowly
                        angle += 0.5; // rotate
                    }
                }

                placedPins.push({x: rx, y: ry});

                if (validPoint) {
                    const color = subTimColors[program.sub_tim_kerja] || '#111827';
                    const pinGroup = document.createElementNS("http://www.w3.org/2000/svg", "g");
                    
                    // Initial state: scaled to 0
                    pinGroup.setAttribute('transform', `translate(${rx}, ${ry}) scale(0)`);
                    pinGroup.style.transition = 'transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                    pinGroup.style.cursor = 'pointer';
                    
                    const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
                    path.setAttribute('d', "M12 2C8.13 2 5 5.13 5 9c0 5.25 7 15 7 15s7-9.75 7-15c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z");
                    path.setAttribute('fill', color);
                    path.style.stroke = '#000000';
                    path.setAttribute('stroke-width', '1');
                    // Translate path so its tip (12, 24) is exactly at the group's (0,0)
                    path.setAttribute('transform', 'translate(-12, -24)');
                    
                    const title = document.createElementNS("http://www.w3.org/2000/svg", "title");
                    title.textContent = `${program.nama_program} (${program.sub_tim_kerja})`;
                    
                    pinGroup.appendChild(path);
                    pinGroup.appendChild(title);
                    pinsContainer.appendChild(pinGroup);

                    setTimeout(() => {
                        // Final state: scaled to 1
                        pinGroup.setAttribute('transform', `translate(${rx}, ${ry}) scale(1.5)`);
                    }, delay);
                    delay += 75; 
                }
            });
        }
    </script>
</body>
</html>