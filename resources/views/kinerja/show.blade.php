{{-- File: resources/views/kinerja/show.blade.php (KODE LENGKAP & BENAR) --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Realisasi Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            @forelse ($kinerja->details as $detail)
                {{-- Kartu Utama untuk setiap detail progres --}}
                <div x-data="{ editModalOpen: false }" class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                    
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
                                {{ $detail->pelaksana }}
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

                        @if($detail->file_bukti && is_string($detail->file_bukti))
                        <div class="md:col-span-2">
                            <p class="font-semibold text-gray-500 mb-2">Bukti/Dokumentasi:</p>
                            <div class="mt-2 border rounded-md p-2">
                                @php 
                                    $filePath = $detail->file_bukti;
                                    $extension = strtolower(pathinfo(storage_path('app/public/' . $filePath), PATHINFO_EXTENSION));
                                @endphp
                                @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ asset('storage/' . $filePath) }}" alt="Bukti Kegiatan" class="rounded-md border max-w-full">
                                @elseif($extension === 'pdf')
                                    <iframe src="{{ asset('storage/' . $filePath) }}" class="w-full h-96 rounded-md border"></iframe>
                                @else
                                    <a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="text-blue-600 hover:underline">
                                        Lihat File: {{ basename($filePath) }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    {{-- Footer Kartu dengan tombol aksi --}}
                    <div class="px-6 pb-4 flex justify-start">
                        {{-- Tombol Edit --}}
                        <button @click="editModalOpen = true" class="text-blue-600 hover:text-blue-800" title="Edit Laporan Ini">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </button>
                    </div>

                    <div x-show="editModalOpen" x-cloak class="fixed z-50 inset-0 overflow-y-auto">
                        <div class="flex items-center justify-center min-h-screen">
                            <div x-show="editModalOpen" @click.stop="editModalOpen = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true"><div class="absolute inset-0 bg-gray-500 opacity-75"></div></div>
                            <div x-show="editModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full">
                                <form method="POST" action="{{ route('kinerja.detail.update', $detail) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Laporan Realisasi</h3>
                                        <div class="mt-4 border-t border-gray-200 pt-4 space-y-4">
                                            <div class="p-4 border rounded-md bg-gray-50">
                                                <h4 class="font-semibold text-gray-800 mb-2">Detail Laporan</h4>
                                                <div>
                                                    <label for="pelaksana-{{$detail->id}}" class="block text-sm font-medium">Pelaksana</label>
                                                    <input type="text" name="pelaksana" id="pelaksana-{{$detail->id}}" value="{{ old('pelaksana', $detail->pelaksana) }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                                </div>
                                                <div class="mt-4">
                                                    <label for="deskripsi_pekerjaan-{{$detail->id}}" class="block text-sm font-medium">Deskripsi Pekerjaan</label>
                                                    <textarea name="deskripsi_pekerjaan" id="deskripsi_pekerjaan-{{$detail->id}}" rows="3" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>{{ old('deskripsi_pekerjaan', $detail->deskripsi_pekerjaan) }}</textarea>
                                                </div>
                                                <div class="mt-4">
                                                    <label for="realisasi_target-{{$detail->id}}" class="block text-sm font-medium">Realisasi Target</label>
                                                    <textarea name="realisasi_target" id="realisasi_target-{{$detail->id}}" rows="2" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>{{ old('realisasi_target', $detail->realisasi_target) }}</textarea>
                                                </div>
                                                <div class="mt-4">
                                                    <label for="progres_kegiatan-{{$detail->id}}" class="block text-sm font-medium">Progres Kegiatan</label>
                                                    <textarea name="progres_kegiatan" id="progres_kegiatan-{{$detail->id}}" rows="2" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>{{ old('progres_kegiatan', $detail->progres_kegiatan) }}</textarea>
                                                </div>
                                                <div class="mt-4">
                                                    <label for="kendala-{{$detail->id}}" class="block text-sm font-medium">Kendala</label>
                                                    <textarea name="kendala" id="kendala-{{$detail->id}}" rows="2" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('kendala', $detail->kendala) }}</textarea>
                                                </div>
                                                <div class="mt-4">
                                                    <label for="strategi_penyelesaian-{{$detail->id}}" class="block text-sm font-medium">Strategi Penyelesaian</label>
                                                    <textarea name="strategi_penyelesaian" id="strategi_penyelesaian-{{$detail->id}}" rows="2" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('strategi_penyelesaian', $detail->strategi_penyelesaian) }}</textarea>
                                                </div>
                                                <div class="mt-4">
                                                    <label for="file_bukti-{{$detail->id}}" class="block text-sm font-medium">Upload Dokumentasi Baru (Opsional)</label>
                                                    <input type="file" name="file_bukti" id="file_bukti-{{$detail->id}}" class="mt-1 block w-full text-sm">
                                                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti file yang sudah ada.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:w-auto">Simpan Perubahan</button>
                                        <button type="button" @click="editModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 bg-white text-base sm:mt-0 sm:w-auto">Batal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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