<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Realisasi Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Navigasi Bulan --}}
            <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm mb-6">
                <a href="{{ route('kinerja.index', ['bulan' => $currentDate->copy()->subMonth()->format('Y-m')]) }}" class="px-4 py-2 bg-[#1A7EFB] text-white rounded-md hover:bg-blue-700">
                    &lt;
                </a>
                <h3 class="text-xl font-bold">{{ $currentDate->translatedFormat('F Y') }}</h3>
                <a href="{{ route('kinerja.index', ['bulan' => $currentDate->copy()->addMonth()->format('Y-m')]) }}" class="px-4 py-2 bg-[#1A7EFB] text-white rounded-md hover:bg-blue-700">
                    &gt;
                </a>
            </div>
            
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

            {{-- Tombol Aksi --}}
            
            <div class="flex justify-between mb-4">
                <button onclick="openModal()" class="inline-flex items-center px-16 py-2 bg-[#1A7EFB] text-white rounded-md hover:bg-blue-700">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tambah Kegiatan Baru
                </button>
                <!-- <button class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Buat Rekapan</button> -->
            </div>

            {{-- Grid untuk Kartu Kinerja --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse ($kinerjaBulanan as $kinerja)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden flex flex-col">
                        {{-- Header Kartu --}}
                        <div class="p-4 bg-[#BBD8FF]">
                            <h4 class="text-center font-bold text-lg text-gray-800">{{ $kinerja->judul_kegiatan }}</h4>
                        </div>
                        
                        {{-- Konten Kartu --}}
                        <div class="p-6 flex-grow space-y-4">
                            <div>
                                <p class="text-l font-semibold text-gray-500">Target:</p>
                                <div class="mt-1 p-3 bg-[#BBD8FF]/30 rounded-md text-gray-700">
                                    {{ $kinerja->target_kinerja }}
                                </div>
                            </div>
                            
                            @if($latestDetail = $kinerja->details->last())
                                <div>
                                    <p class="text-l font-semibold text-gray-500">Realisasi:</p>
                                    <div class="mt-1 p-3 bg-[#BBD8FF]/30 rounded-md text-gray-700">
                                        {{ $latestDetail->realisasi_target }}
                                    </div>
                                </div>
                            @endif
                        </div>
                            
                            <!-- @if($latestDetail = $kinerja->details->last()) -->
                                <!-- <div>
                                    <p class="text-sm font-semibold text-gray-500">Realisasi:</p>
                                    <div class="mt-1 p-3 bg-[#BBD8FF]/30 rounded-md text-gray-700">
                                        {{ $kinerja->realisasi_target }}
                                    </div>
                                </div> -->
                            <!-- @endif -->
                        <!-- </div> -->

                        {{-- Footer Kartu --}}
                        <div class="px-6 pb-4 border-t border-gray-200 mt-auto pt-4 flex justify-between items-center">
                            {{-- PERUBAHAN DI SINI: Tombol Edit dan Hapus difungsikan --}}
                            <div class="flex space-x-3">
                                <form action="{{ route('kinerja.destroy', $kinerja) }}" method="POST" onsubmit="return confirm('PERINGATAN: Aksi ini akan menghapus kegiatan utama. Lanjutkan?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd" /></svg>
                                    </button>
                                </form>
                            </div>
                            <a href="{{ route('kinerja.show', $kinerja) }}" class="text-[#1A7EFB] hover:underline font-semibold text-sm">Lihat Detail</a>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 bg-white rounded-lg shadow-sm p-6 text-center text-gray-500">
                        <p>Belum ada data realisasi kegiatan untuk bulan ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    
    {{-- Modal Form Tambah Kegiatan --}}
    <div id="formModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true"><div class="absolute inset-0 bg-gray-500 opacity-75"></div></div>
            <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full">
                <form id="dataForm" method="POST" action="{{ route('kinerja.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Tambah Kegiatan Baru</h3>
                        <div class="mt-4 border-t border-gray-200 pt-4 space-y-4">
                            <div class="p-4 border rounded-md bg-gray-50">
                                <h4 class="font-semibold text-gray-800 mb-2">Informasi Kegiatan Utama</h4>
                                <div>
                                    <label for="judul_kegiatan" class="block text-sm font-medium">Judul Kegiatan</label>
                                    <input type="text" name="judul_kegiatan" id="judul_kegiatan" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                                <div class="mt-4">
                                    <label for="target_kinerja" class="block text-sm font-medium">Target Kinerja</label>
                                    <textarea name="target_kinerja" id="target_kinerja" rows="2" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required></textarea>
                                </div>
                                <div class="mt-4">
                                    <label for="bulan_tahun" class="block text-sm font-medium">Bulan & Tahun Laporan</label>
                                    <input type="month" name="bulan_tahun" id="bulan_tahun" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ $currentDate->format('Y-m') }}" required>
                                </div>
                            </div>
                            <div class="p-4 border rounded-md bg-gray-50">
                                <h4 class="font-semibold text-gray-800 mb-2">Laporan Progres Pertama</h4>
                                <div>
                                    <label for="pelaksana" class="block text-sm font-medium">Pelaksana</label>
                                    <input type="text" name="pelaksana" id="pelaksana" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                </div>
                                <div class="mt-4">
                                    <label for="deskripsi_pekerjaan" class="block text-sm font-medium">Deskripsi Pekerjaan</label>
                                    <textarea name="deskripsi_pekerjaan" id="deskripsi_pekerjaan" rows="3" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required></textarea>
                                </div>
                                <div class="mt-4">
                                    <label for="realisasi_target" class="block text-sm font-medium">Realisasi Target</label>
                                    <textarea name="realisasi_target" id="realisasi_target" rows="2" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required></textarea>
                                </div>
                                <div class="mt-4">
                                    <label for="progres_kegiatan" class="block text-sm font-medium">Progres Kegiatan (%)</label>
                                    <textarea name="progres_kegiatan" id="progres_kegiatan" rows="2" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required></textarea>
                                </div>
                                <div class="mt-4">
                                    <label for="kendala" class="block text-sm font-medium">Kendala</label>
                                    <textarea name="kendala" id="kendala" rows="2" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                                <div class="mt-4">
                                    <label for="strategi_penyelesaian" class="block text-sm font-medium">Strategi Penyelesaian</label>
                                    <textarea name="strategi_penyelesaian" id="strategi_penyelesaian" rows="2" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                                <div class="mt-4">
                                    <label for="file_bukti" class="block text-sm font-medium">Upload Dokumentasi</label>
                                    <input type="file" name="file_bukti" id="file_bukti" class="mt-1 block w-full text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:w-auto">Simpan</button>
                        <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 bg-white text-base sm:mt-0 sm:w-auto">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const modal = document.getElementById('formModal');
        function openModal() {
            modal.classList.remove('hidden');
        }
        function closeModal() {
            modal.classList.add('hidden');
        }
    </script>
    @endpush
</x-app-layout>