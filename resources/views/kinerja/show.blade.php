<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Realisasi Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @forelse ($kinerja->details as $detail)
                {{-- Kartu Utama untuk setiap detail progres --}}
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    
                    {{-- Header Kartu Detail --}}
                    <div class="p-4 bg-[#BBD8FF] flex justify-between items-center">
                        <div>
                            <h4 class="font-bold text-lg text-gray-800">{{ $kinerja->judul_kegiatan }}</h4>
                            <p class="text-sm text-gray-600">{{ $detail->created_at->translatedFormat('l, j F Y \p\u\k\u\l H:i') }}</p>
                        </div>
                        <a href="{{ route('kinerja.index', ['bulan' => \Carbon\Carbon::parse($kinerja->bulan_tahun)->format('Y-m')]) }}" class="ml-4 px-4 py-2 bg-[#1A7EFB] text-white rounded-md text-sm font-semibold hover:bg-blue-700">
                            &larr; Kembali
                        </a>
                    </div>

                    {{-- Konten Kartu Detail --}}
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        
                        <div>
                            <p class="font-semibold text-gray-500">Pelaksana:</p>
                            <div class="mt-1 p-3 bg-[#BBD8FF]/30 rounded-md text-gray-700 break-words">
                                {{ $kinerja->pelaksana }}
                            </div>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-500">Progres Kegiatan:</p>
                            <div class="mt-1 p-3 bg-[#BBD8FF]/30 rounded-md text-gray-700 break-words">
                                {{ $detail->progres_kegiatan }}
                            </div>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-500">Target Kinerja:</p>
                            <div class="mt-1 p-3 bg-[#BBD8FF]/30 rounded-md text-gray-700 break-words">
                                {{ $kinerja->target_kinerja }}
                            </div>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-500">Realisasi:</p>
                            <div class="mt-1 p-3 bg-[#BBD8FF]/30 rounded-md text-gray-700 break-words">
                                {{ $detail->realisasi_target }}
                            </div>
                        </div>
                        
                        <div class="md:col-span-2">
                            <p class="font-semibold text-gray-500">Deskripsi Pekerjaan:</p>
                            <div class="mt-1 p-3 bg-[#BBD8FF]/30 rounded-md text-gray-700">
                                {{ $detail->deskripsi_pekerjaan }}
                            </div>
                        </div>
                        
                        @if($detail->kendala)
                        <div class="md:col-span-2">
                            <p class="font-semibold text-gray-500">Kendala:</p>
                            <div class="mt-1 p-3 bg-[#BBD8FF]/30 rounded-md text-gray-700 break-words">
                                {{ $detail->kendala }}
                            </div>
                        </div>
                        @endif

                        @if($detail->strategi_penyelesaian)
                        <div class="md:col-span-2">
                            <p class="font-semibold text-gray-500">Strategi Penyelesaian:</p>
                            <div class="mt-1 p-3 bg-[#BBD8FF]/30 rounded-md text-gray-700 break-words">
                                {{ $detail->strategi_penyelesaian }}
                            </div>
                        </div>
                        @endif

                        @if($detail->file_bukti && is_array($detail->file_bukti) && count($detail->file_bukti) > 0)
                        <div class="md:col-span-2">
                            <p class="font-semibold text-gray-500 mb-2">Bukti/Dokumentasi:</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                                @foreach($detail->file_bukti as $filePath)
                                    <div>
                                    @php $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION)); @endphp
                                    @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                        <img src="{{ asset('storage/' . $filePath) }}" alt="Bukti Kegiatan" class="rounded-md border max-w-md">
                                    @elseif($extension === 'pdf')
                                        <iframe src="{{ asset('storage/' . $filePath) }}" class="w-full h-96 rounded-md border"></iframe>
                                    @else
                                        <a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="text-blue-600 hover:underline">
                                            Lihat File: {{ basename($filePath) }}
                                        </a>
                                    @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    {{-- Footer Kartu dengan tombol aksi --}}
                    <div class="px-6 pb-4 flex justify-start">
                        <button @click="editModalOpen = true" class="text-blue-600 hover:text-blue-800" title="Edit Laporan Ini">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-sm p-6 text-center text-gray-500">
                    <p>Belum ada detail laporan untuk kegiatan ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>