<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Peta Sebaran Program') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Peta Sebaran Program Jawa Barat -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden" 
     x-data="{ 
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

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif
            <div id="daftar-program" class="bg-white overflow-hidden shadow-sm sm:rounded-lg scroll-mt-6 mt-8 mr-8 ml-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Daftar Program</h3>
                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-program')" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Tambah Program Baru
                        </button>
                    </div>

                    <form action="{{ route('admin.programs.index') }}#daftar-program" method="GET" id="form-search-program" class="mb-6 flex flex-col sm:flex-row gap-3">
                        <div class="flex-1">
                            <label for="search" class="sr-only">Cari program</label>
                            <input
                                type="text"
                                name="search"
                                id="search"
                                value="{{ $search ?? '' }}"
                                placeholder="Cari nama program atau wilayah..."
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                autocomplete="off"
                            >
                        </div>
                        <div class="flex gap-2">
                            <button
                                type="button"
                                id="btn-tampilkan-semua"
                                onclick="document.getElementById('search').value=''; document.getElementById('search').dispatchEvent(new Event('input'));"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm font-medium {{ $search ? '' : 'hidden' }}">
                                Reset
                            </button>
                        </div>
                    </form>

                    <div id="tabel-program-wrapper">
                        @include('admin.programs._table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="create-program" :show="$errors->isNotEmpty() && old('is_edit') != '1'" focusable>
        <form method="POST" action="{{ route('admin.programs.store') }}" class="p-6" enctype="multipart/form-data">
            @csrf

            <h2 class="text-lg font-medium text-gray-900 mb-6">
                {{ __('Tambah Program Baru') }}
            </h2>

            <div class="space-y-6">
                <div>
                    <x-input-label for="nama_program" :value="__('Nama Program')" />
                    <x-text-input id="nama_program" name="nama_program" type="text" class="mt-1 block w-full" :value="old('nama_program')" required />
                    <x-input-error :messages="$errors->get('nama_program')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="wilayah_id" :value="__('Wilayah')" />
                    <select id="wilayah_id" name="wilayah_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="" disabled {{ old('wilayah_id') == '' ? 'selected' : '' }}>Pilih Wilayah</option>
                        @foreach ($wilayahOptions as $id => $nama)
                            <option value="{{ $id }}" {{ old('wilayah_id') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('wilayah_id')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="tim_kerja" :value="__('Tim Kerja')" />
                    <select id="tim_kerja" name="tim_kerja" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="" disabled {{ old('tim_kerja') == '' ? 'selected' : '' }}>Pilih Tim Kerja</option>
                        <option value="Tim Kerja Pengembangan" {{ old('tim_kerja') == 'Tim Kerja Pengembangan' ? 'selected' : '' }}>Tim Kerja Pengembangan</option>
                        <option value="Tim Kerja Pembinaan" {{ old('tim_kerja') == 'Tim Kerja Pembinaan' ? 'selected' : '' }}>Tim Kerja Pembinaan</option>
                        <option value="Tim Kerja Pelindungan" {{ old('tim_kerja') == 'Tim Kerja Pelindungan' ? 'selected' : '' }}>Tim Kerja Pelindungan</option>
                    </select>
                    <x-input-error :messages="$errors->get('tim_kerja')" class="mt-2" />
                </div>

                <div id="sub_tim_kerja_container">
                    <x-input-label for="sub_tim_kerja" :value="__('Sub Tim Kerja')" />
                    <select id="sub_tim_kerja" name="sub_tim_kerja" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" disabled required>
                        <option value="" disabled selected>Pilih Sub Tim Kerja</option>
                    </select>
                    <x-input-error :messages="$errors->get('sub_tim_kerja')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                    <x-text-input id="tanggal_mulai" name="tanggal_mulai" type="date" class="mt-1 block w-full" :value="old('tanggal_mulai')" required />
                    <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')" />
                    <x-text-input id="tanggal_selesai" name="tanggal_selesai" type="date" class="mt-1 block w-full" :value="old('tanggal_selesai')" required />
                    <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="deskripsi" :value="__('Deskripsi Program')" />
                    <textarea id="deskripsi" name="deskripsi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required>{{ old('deskripsi') }}</textarea>
                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="file_path" :value="__('File Dukung (Opsional)')" />
                    <input type="file" name="file_path" id="file_path" class="mt-1 block w-full text-sm" accept=".pdf,.docx,.jpg,.jpeg,.png,.webp">
                    <span class="text-xs text-gray-500 mt-1 block">Format didukung: PDF, DOCX, JPG, JPEG, PNG, WEBP. Maks 5MB.</span>
                    <x-input-error :messages="$errors->get('file_path')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50">
                    {{ __('Batal') }}
                </button>
                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700">
                    {{ __('Simpan') }}
                </button>
            </div>
        </form>
    </x-modal>

    <x-modal name="edit-program" focusable>
        <form method="POST" id="editProgramForm" class="p-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-medium text-gray-900 mb-6">
                {{ __('Edit Program') }}
            </h2>

            <div class="space-y-6">
                <div>
                    <x-input-label for="edit_nama_program" :value="__('Nama Program')" />
                    <x-text-input id="edit_nama_program" name="nama_program" type="text" class="mt-1 block w-full" required />
                </div>

                <div>
                    <x-input-label for="edit_wilayah_id" :value="__('Wilayah')" />
                    <select id="edit_wilayah_id" name="wilayah_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="" disabled selected>Pilih Wilayah</option>
                        @foreach ($wilayahOptions as $id => $nama)
                            <option value="{{ $id }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="edit_tim_kerja" :value="__('Tim Kerja')" />
                    <select id="edit_tim_kerja" name="tim_kerja" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="" disabled selected>Pilih Tim Kerja</option>
                        <option value="Tim Kerja Pengembangan">Tim Kerja Pengembangan</option>
                        <option value="Tim Kerja Pembinaan">Tim Kerja Pembinaan</option>
                        <option value="Tim Kerja Pelindungan">Tim Kerja Pelindungan</option>
                    </select>
                </div>

                <div id="edit_sub_tim_kerja_container">
                    <x-input-label for="edit_sub_tim_kerja" :value="__('Sub Tim Kerja')" />
                    <select id="edit_sub_tim_kerja" name="sub_tim_kerja" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" disabled required>
                        <option value="" disabled selected>Pilih Sub Tim Kerja</option>
                    </select>
                </div>
                    <x-input-label for="edit_tanggal_mulai" :value="__('Tanggal Mulai')" />
                    <x-text-input id="edit_tanggal_mulai" name="tanggal_mulai" type="date" class="mt-1 block w-full" required />
                </div>

                <div>
                    <x-input-label for="edit_tanggal_selesai" :value="__('Tanggal Selesai')" />
                    <x-text-input id="edit_tanggal_selesai" name="tanggal_selesai" type="date" class="mt-1 block w-full" required />
                </div>

                <div>
                    <x-input-label for="edit_deskripsi" :value="__('Deskripsi Program')" />
                    <textarea id="edit_deskripsi" name="deskripsi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required></textarea>
                </div>

                <div>
                    <x-input-label for="edit_file_path" :value="__('File Dukung (Opsional)')" />
                    <input type="file" name="file_path" id="edit_file_path" class="mt-1 block w-full text-sm" accept=".pdf,.docx,.jpg,.jpeg,.png,.webp">
                    <span class="text-xs text-gray-500 mt-1 block">Format didukung: PDF, DOCX, JPG, JPEG, PNG, WEBP. Maks 5MB. Memilih file baru akan menimpa file lama.</span>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50">
                    {{ __('Batal') }}
                </button>
                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700">
                    {{ __('Simpan Perubahan') }}
                </button>
            </div>
        </form>
    </x-modal>

    <script>
        (function () {
            const searchInput = document.getElementById('search');
            const searchForm = document.getElementById('form-search-program');
            let debounceTimer;

            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                const query = this.value;

                const tampilkanSemuaBtn = document.getElementById('btn-tampilkan-semua');
                if (query) {
                    tampilkanSemuaBtn.classList.remove('hidden');
                } else {
                    tampilkanSemuaBtn.classList.add('hidden');
                }

                debounceTimer = setTimeout(() => doSearch(query), 200);
            });
        })();

        const subTimMap = {
            'Tim Kerja Pengembangan': [
                'Kamus dan Istilah',
                'BIPA'
            ],
            'Tim Kerja Pembinaan': [
                'Pembahu',
                'Literasi',
                'UKBI',
                'Penerjemahan'
            ],
            'Tim Kerja Pelindungan': [
                'Molinbastra'
            ]
        };

        function updateSubTimOptions(timSelect, subContainer, subSelect, selectedSubVal = '') {
            const selectedTim = timSelect.value;
            subSelect.innerHTML = '<option value="" disabled selected>Pilih Sub Tim Kerja</option>';

            if (selectedTim && subTimMap[selectedTim]) {
                subSelect.disabled = false;
                subTimMap[selectedTim].forEach(function (sub) {
                    const option = document.createElement('option');
                    option.value = sub;
                    option.textContent = sub;
                    if (sub === selectedSubVal) {
                        option.selected = true;
                    }
                    subSelect.appendChild(option);
                });
            } else {
                subSelect.disabled = true;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Setup for Create Modal
            const timKerjaCreate = document.getElementById('tim_kerja');
            const subTimContainerCreate = document.getElementById('sub_tim_kerja_container');
            const subTimSelectCreate = document.getElementById('sub_tim_kerja');
            const oldSubTimKerja = "{{ old('sub_tim_kerja') }}";

            timKerjaCreate.addEventListener('change', function () {
                updateSubTimOptions(timKerjaCreate, subTimContainerCreate, subTimSelectCreate);
            });

            if (timKerjaCreate.value) {
                updateSubTimOptions(timKerjaCreate, subTimContainerCreate, subTimSelectCreate, oldSubTimKerja);
            }

            // Setup for Edit Modal
            const timKerjaEdit = document.getElementById('edit_tim_kerja');
            const subTimContainerEdit = document.getElementById('edit_sub_tim_kerja_container');
            const subTimSelectEdit = document.getElementById('edit_sub_tim_kerja');

            timKerjaEdit.addEventListener('change', function () {
                updateSubTimOptions(timKerjaEdit, subTimContainerEdit, subTimSelectEdit);
            });
        });

        function openEditProgramModal(program) {
            document.getElementById('editProgramForm').action = `/admin/programs/${program.id}`;
            document.getElementById('edit_nama_program').value = program.nama_program || '';
            document.getElementById('edit_wilayah_id').value = program.wilayah_id || '';
            document.getElementById('edit_tim_kerja').value = program.tim_kerja || '';
            
            // Trigger sub-team options update and pre-select the program's sub_tim_kerja
            const timKerjaEdit = document.getElementById('edit_tim_kerja');
            const subTimContainerEdit = document.getElementById('edit_sub_tim_kerja_container');
            const subTimSelectEdit = document.getElementById('edit_sub_tim_kerja');
            updateSubTimOptions(timKerjaEdit, subTimContainerEdit, subTimSelectEdit, program.sub_tim_kerja || '');

            // Format dates from YYYY-MM-DD HH:MM:SS to YYYY-MM-DD if needed
            let start = program.tanggal_mulai ? program.tanggal_mulai.split(' ')[0] : '';
            let end = program.tanggal_selesai ? program.tanggal_selesai.split(' ')[0] : '';
            
            document.getElementById('edit_tanggal_mulai').value = start;
            document.getElementById('edit_tanggal_selesai').value = end;
            document.getElementById('edit_deskripsi').value = program.deskripsi || '';
            
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'edit-program' }));
        }

        (function () {
            const searchInput = document.getElementById('search');
            const tableWrapper = document.getElementById('tabel-program-wrapper');
            const baseUrl = "{{ route('admin.programs.index') }}";
            let debounceTimer;
            let currentController = null;

            function doSearch(query) {
                // Batalkan request sebelumnya kalau masih jalan, cegah race condition
                if (currentController) currentController.abort();
                currentController = new AbortController();

                const url = query
                    ? `${baseUrl}?search=${encodeURIComponent(query)}`
                    : baseUrl;

                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    signal: currentController.signal,
                })
                    .then(res => res.text())
                    .then(html => {
                        tableWrapper.innerHTML = html;
                        // Update URL browser tanpa reload, biar bisa di-bookmark/refresh
                        const newUrl = query
                            ? `${baseUrl}?search=${encodeURIComponent(query)}#daftar-program`
                            : `${baseUrl}#daftar-program`;
                        window.history.replaceState({}, '', newUrl);
                    })
                    .catch(err => {
                        if (err.name !== 'AbortError') console.error('Gagal memuat data:', err);
                    });

                const tampilkanSemuaBtn = document.getElementById('btn-tampilkan-semua');
                    if (query) {
                        tampilkanSemuaBtn.classList.remove('hidden');
                    } else {
                        tampilkanSemuaBtn.classList.add('hidden');
                    }
            }

            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                const query = this.value;
                debounceTimer = setTimeout(() => doSearch(query), 150);
            });

            // Cegah submit form biasa (klik tombol Cari / tekan Enter) supaya tetap konsisten pakai fetch juga
            document.getElementById('form-search-program').addEventListener('submit', function (e) {
                e.preventDefault();
                doSearch(searchInput.value);
            });
        })();

        // --- MAP PINS LOGIC ---
        window.allProgramsData = @json($allProgramsData);

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

            window.currentTimKerjaTarget = timKerjaTarget;
            window.currentActiveSubTims = activeSubTims;

            let filteredPrograms = window.allProgramsData.filter(p => p.tim_kerja === timKerjaTarget);
            
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

                // Ukuran visual pin (setelah scale 1.5x): lebar ±11, tinggi 33 ke atas dari tip
                const PIN_HALF_WIDTH = 5;
                const PIN_HEIGHT = 10;

                // Cek apakah seluruh area visual pin (bukan cuma titik tip) berada di dalam wilayah
                function isPinFullyInside(pathEl, svgPt, tipX, tipY, scaleFactor = 1) {
                    const halfW = PIN_HALF_WIDTH * scaleFactor;
                    const h = PIN_HEIGHT * scaleFactor;
                    const stepsX = 5; // jumlah titik sampel horizontal
                    const stepsY = 6; // jumlah titik sampel vertikal

                    for (let iy = 0; iy <= stepsY; iy++) {
                        const dy = -(h * iy / stepsY); // dari tip (0) ke atas (-h)
                        for (let ix = 0; ix <= stepsX; ix++) {
                            const dx = -halfW + (2 * halfW * ix / stepsX);
                            svgPt.x = tipX + dx;
                            svgPt.y = tipY + dy;
                            if (!pathEl.isPointInFill(svgPt)) {
                                return false;
                            }
                        }
                    }
                    return true;
                }

                // Phase 1: Try to find a spot inside the region without overlap
                while (!validPoint && attempts < 250) { // naikkan dari 150 -> 250, pengecekan lebih ketat butuh lebih banyak percobaan
                    rx = bbox.x + Math.random() * bbox.width;
                    ry = bbox.y + Math.random() * bbox.height;
                    
                    svgPt.x = rx;
                    svgPt.y = ry;
                    
                    if (pathEl.isPointInFill(svgPt) && isPinFullyInside(pathEl, svgPt, rx, ry, 1)) {
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

                // Phase 2: spiral outward, dengan ukuran pin yang menyusut kalau gagal
                if (!validPoint) {
                    const cx = bbox.x + bbox.width / 2;
                    const cy = bbox.y + bbox.height / 2;

                    // Coba beberapa level ukuran pin: penuh -> setengah -> tanpa cek sama sekali (last resort)
                    const scaleLevels = [1, 0.5, 0];

                    for (const scaleFactor of scaleLevels) {
                        if (validPoint) break;
                        let radius = 0;
                        let angle = 0;

                        for (let i = 0; i < 300; i++) {
                            rx = cx + Math.cos(angle) * radius;
                            ry = cy + Math.sin(angle) * radius;

                            svgPt.x = rx;
                            svgPt.y = ry;

                            const inside = scaleFactor > 0
                                ? (pathEl.isPointInFill(svgPt) && isPinFullyInside(pathEl, svgPt, rx, ry, scaleFactor))
                                : pathEl.isPointInFill(svgPt);

                            let collision = false;
                            for (const p of placedPins) {
                                const dx = p.x - rx;
                                const dy = p.y - ry;
                                if (Math.sqrt(dx*dx + dy*dy) < MIN_DIST) { collision = true; break; }
                            }

                            if (inside && !collision) {
                                validPoint = true;
                                break;
                            }
                            radius += 0.5;
                            angle += 0.5;
                        }
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
                    path.setAttribute('stroke', '#000000');
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
</x-app-layout>
