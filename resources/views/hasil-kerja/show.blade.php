    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Bukti Kerja: {{ $user->name }}</h2>
        </x-slot>

        {{-- Kita definisikan state Alpine.js di sini --}}
        <div class="py-12" x-data="{
            showModal: false,
            modalTitle: '',
            modalDescription: '',
            modalViewUrl: '',
            modalDownloadUrl: '',
            modalFileType: ''
        }">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- === TOMBOL KEMBALI BARU === -->
                <div class="mb-6">
                    <a href="{{ route('hasil-kerja.month', ['year' => $year, 'month' => $month]) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Daftar Pegawai
                    </a>
                </div>
                <!-- ============================ -->
                <!-- Form Upload (hanya untuk pemilik) -->
                @if(Auth::id() === $user->id)
                <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                    <h3 class="font-bold text-lg mb-4">Unggah Hasil Kerja Baru ({{ \Carbon\Carbon::create()->month((int)$month)->translatedFormat('F') }} {{ $year }})</h3>
                    @if (session('success')) <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div> @endif
                    <form action="{{ route('hasil-kerja.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="year" value="{{ $year }}">
                        <input type="hidden" name="month" value="{{ $month }}">
                        <div class="mb-4">
                            <label for="work_date" class="block font-bold">Tanggal Bukti Kerja:</label>
                            <input type="date" name="work_date" id="work_date" class="border rounded w-full py-2 px-3" required>
                        </div>
                        <div class="mb-4">
                            <label for="title" class="block font-bold">Nama Bukti Kerja:</label>
                            <input type="text" name="title" id="title" class="border rounded w-full py-2 px-3" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block font-bold">Deskripsi (Opsional):</label>
                            <textarea name="description" id="description" rows="2" class="border rounded w-full py-2 px-3"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="work_file" class="block font-bold">Pilih Fail:</label>
                            <input type="file" name="work_file" id="work_file" class="border rounded w-full py-2 px-3" required>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Unggah</button>
                    </form>
                </div>
                @endif

                <!-- Daftar Hasil Kerja (Grid Ikon) -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="font-bold text-lg mb-4">Daftar Bukti Kerja</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                        @forelse ($works as $work)
                            <div class="relative group">
                                {{-- Ikon File yang bisa diklik --}}
                                <div @click="
                                    showModal = true;
                                    modalTitle = '{{ addslashes($work->title) }}';
                                    modalDescription = '{{ addslashes($work->description) }}';
                                    modalViewUrl = '{{ route('hasil-kerja.view', $work) }}';
                                    modalDownloadUrl = '{{ route('hasil-kerja.download', $work) }}';
                                    modalFileType = '{{ $work->file_type }}';
                                " class="cursor-pointer flex flex-col items-center justify-center p-4 border rounded-lg hover:bg-gray-100 hover:shadow-md transition aspect-square">
                                    {{-- Logika untuk menampilkan ikon berdasarkan tipe file --}}
                                    @if(in_array($work->file_type, ['jpg', 'jpeg', 'png', 'gif']))
                                        <svg class="w-12 h-12 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                                    @elseif($work->file_type == 'pdf')
                                        <svg class="w-12 h-12 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                    @else
                                        <svg class="w-12 h-12 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                    @endif
                                    <p class="text-xs text-center mt-2 break-all" x-text="'{{ Str::limit($work->title, 20) }}'"></p>
                                    <p class="text-xs text-center text-gray-500">{{ $work->work_date->translatedFormat('j M Y') }}</p>
                                </div>
                                {{-- Tombol Hapus --}}
                                @php $authUser = Auth::user(); @endphp
                                @if($authUser->id === $work->user_id || $authUser->isSuperAdmin() || $authUser->isKepegawaianAdmin())
                                <form action="{{ route('hasil-kerja.destroy', $work) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus fail ini?');" class="absolute top-0 right-0 m-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 bg-red-500 text-white rounded-full hover:bg-red-600">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-500 col-span-full">Belum ada bukti kerja yang diunggah untuk periode ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Modal untuk Pratinjau File -->
            <div x-show="showModal" @keydown.escape.window="showModal = false" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50" x-cloak>
                <div class="bg-white rounded-lg w-full max-w-4xl h-[90vh] flex flex-col">
                    {{-- Header Modal --}}
                    <div class="flex justify-between items-center p-4 border-b">
                        <div>
                        <h3 class="font-bold text-lg" x-text="modalTitle"></h3>
                        <p class="text-sm text-gray-600 mt-1" x-text="modalDescription"></p>
                        </div>
                        <button @click="showModal = false" class="p-2">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    {{-- Konten Pratinjau --}}
                    <div class="flex-grow p-4 overflow-auto">
                        {{-- Tampilkan gambar jika tipe file adalah gambar --}}
                        <template x-if="['jpg', 'jpeg', 'png', 'gif'].includes(modalFileType)">
                            <img :src="modalViewUrl" class="max-w-full max-h-full mx-auto">
                        </template>
                        {{-- Tampilkan iframe untuk PDF dan tipe lain yang didukung browser --}}
                        <template x-if="!['jpg', 'jpeg', 'png', 'gif'].includes(modalFileType)">
                            <iframe :src="modalViewUrl" class="w-full h-full border-0"></iframe>
                        </template>
                    </div>
                    {{-- Footer Modal dengan Tombol Unduh --}}
                    <div class="p-4 border-t text-right">
                        <a :href="modalDownloadUrl" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Unduh Fail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
