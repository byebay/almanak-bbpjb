<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statistik Kehadiran Hari Ini') }}
        </h2>
    </x-slot>

    {{-- Import Swiper.js dari CDN --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                <div class="swiper-button-prev text-blue-600"></div>
                <div class="swiper-button-next text-blue-600"></div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const swiper = new Swiper('.swiper', {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
    @endpush
</x-app-layout>