<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Realisasi Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Informasi Kegiatan Utama --}}
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $kinerja->judul_kegiatan }}</h3>
                        <p class="mt-2 text-gray-700">
                            <strong class="font-semibold text-gray-900">Target Kinerja:</strong> {{ $kinerja->target_kinerja }}
                        </p>
                    </div>
                    <a href="{{ route('kinerja.index', ['bulan' => \Carbon\Carbon::parse($kinerja->bulan_tahun)->format('Y-m')]) }}" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                        &larr; Kembali
                    </a>
                </div>
            </div>

            {{-- Tombol Aksi untuk Detail --}}
            <div class="flex justify-start">
                <button class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Laporan Progres
                </button>
            </div>

            {{-- Daftar Laporan Progres --}}
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6">
                    <h4 class="text-xl font-bold text-gray-800">Riwayat Progres</h4>
                </div>
                
                @forelse ($kinerja->details as $detail)
                        <div class="px-6 py-5">
                            {{-- Header per Laporan (Tanggal) --}}
                            <div class="border-b border-gray-200 pb-3 mb-4">
                                <p class="text-sm font-medium text-gray-500">{{ $detail->created_at->translatedFormat('l, j F Y \p\u\k\u\l H:i') }}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="font-semibold text-gray-800">Pelaksana</p>
                                    <p class="text-gray-700 mt-1 break-words">{{ $detail->pelaksana }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="font-semibold text-gray-800">Progres Kegiatan</p>
                                    <p class="text-gray-700 mt-1 break-words">{{ $detail->progres_kegiatan }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                                    <p class="font-semibold text-gray-800">Deskripsi Pekerjaan</p>
                                    <p class="text-gray-700 mt-1 whitespace-pre-wrap break-words">{{ $detail->deskripsi_pekerjaan }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                                    <p class="font-semibold text-gray-800">Realisasi Target</p>
                                    <p class="text-gray-700 mt-1 whitespace-pre-wrap break-words">{{ $detail->realisasi_target }}</p>
                                </div>
                                @if($detail->kendala)
                                <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                                    <p class="font-semibold text-gray-800">Kendala</p>
                                    <p class="text-gray-700 mt-1 whitespace-pre-wrap break-words">{{ $detail->kendala }}</p>
                                </div>
                                @endif
                                @if($detail->strategi_penyelesaian)
                                <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                                    <p class="font-semibold text-gray-800">Strategi Penyelesaian</p>
                                    <p class="text-gray-700 mt-1 whitespace-pre-wrap break-words">{{ $detail->strategi_penyelesaian }}</p>
                                </div>
                                @endif

                                {{-- File Bukti (Satu Kolom Penuh) --}}
                                @if($detail->file_bukti)
                                <div class="md:col-span-2 mt-2">
                                    <p class="font-semibold text-gray-900 mb-2">Bukti/Dokumentasi:</p>
                                    @php
                                        $filePath = $detail->file_bukti;
                                        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                    @endphp
                                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ asset('storage/' . $filePath) }}" alt="Bukti Kegiatan" class="rounded-md border max-w-md">
                                    @elseif($extension === 'pdf')
                                        <iframe src="{{ asset('storage/' . $filePath) }}" class="w-full h-96 rounded-md border"></iframe>
                                    @else
                                        <a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="text-blue-600 hover:underline">
                                            Lihat File ({{ basename($filePath) }})
                                        </a>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500 border-t border-gray-200">
                        <p>Belum ada laporan progres untuk kegiatan ini.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>