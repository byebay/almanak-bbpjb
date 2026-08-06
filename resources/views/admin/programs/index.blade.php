<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Peta Sebaran Program') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-2">Peta Sebaran Program Jawa Barat</h3>
                    <p class="text-sm text-gray-600 mb-4">Klik wilayah pada peta untuk melihat detail program dan informasi wilayah.</p>
                    @include('components.svg.jabar')
                    <div class="mt-4 w-64">
                        <div class="text-sm text-gray-900 mb-1 font-medium">Jumlah Program:</div>
                        <!-- Batang Gradasi -->
                        <div class="h-3 w-full rounded-sm shadow-inner" style="background: linear-gradient(to right, #f4f5f6ff, #0b43bf);"></div>
                        
                        <!-- Tempat Angka Rentang (Diisi oleh JavaScript) -->
                        <div id="legend-ticks" class="relative w-full h-8 mt-0 text-[15px] text-gray-600 font-mono">
                            <!-- Elemen rentang akan di-generate di sini -->
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div id="daftar-program" class="bg-white overflow-hidden shadow-sm sm:rounded-lg scroll-mt-6">
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
                    <select id="wilayah_id" name="wilayah_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Pilih Wilayah</option>
                        @foreach ($wilayahOptions as $id => $nama)
                            <option value="{{ $id }}" {{ old('wilayah_id') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('wilayah_id')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="tim_kerja" :value="__('Tim Kerja')" />
                    <select id="tim_kerja" name="tim_kerja" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Pilih Tim Kerja (Opsional)</option>
                        <option value="Tim Kerja Pengembangan" {{ old('tim_kerja') == 'Tim Kerja Pengembangan' ? 'selected' : '' }}>Tim Kerja Pengembangan</option>
                        <option value="Tim Kerja Pembinaan" {{ old('tim_kerja') == 'Tim Kerja Pembinaan' ? 'selected' : '' }}>Tim Kerja Pembinaan</option>
                        <option value="Tim Kerja Pelindungan" {{ old('tim_kerja') == 'Tim Kerja Pelindungan' ? 'selected' : '' }}>Tim Kerja Pelindungan</option>
                        <option value="Statistik" {{ old('tim_kerja') == 'Statistik' ? 'selected' : '' }}>Statistik</option>
                    </select>
                    <x-input-error :messages="$errors->get('tim_kerja')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                    <x-text-input id="tanggal_mulai" name="tanggal_mulai" type="date" class="mt-1 block w-full" :value="old('tanggal_mulai')" />
                    <x-input-error :messages="$errors->get('tanggal_mulai')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')" />
                    <x-text-input id="tanggal_selesai" name="tanggal_selesai" type="date" class="mt-1 block w-full" :value="old('tanggal_selesai')" />
                    <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="deskripsi" :value="__('Deskripsi Program')" />
                    <textarea id="deskripsi" name="deskripsi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4">{{ old('deskripsi') }}</textarea>
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
                    <select id="edit_wilayah_id" name="wilayah_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Pilih Wilayah</option>
                        @foreach ($wilayahOptions as $id => $nama)
                            <option value="{{ $id }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="edit_tim_kerja" :value="__('Tim Kerja')" />
                    <select id="edit_tim_kerja" name="tim_kerja" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Pilih Tim Kerja (Opsional)</option>
                        <option value="Tim Kerja Pengembangan">Tim Kerja Pengembangan</option>
                        <option value="Tim Kerja Pembinaan">Tim Kerja Pembinaan</option>
                        <option value="Tim Kerja Pelindungan">Tim Kerja Pelindungan</option>
                        <option value="Statistik">Statistik</option>
                    </select>
                </div>
                    <x-input-label for="edit_tanggal_mulai" :value="__('Tanggal Mulai')" />
                    <x-text-input id="edit_tanggal_mulai" name="tanggal_mulai" type="date" class="mt-1 block w-full" />
                </div>

                <div>
                    <x-input-label for="edit_tanggal_selesai" :value="__('Tanggal Selesai')" />
                    <x-text-input id="edit_tanggal_selesai" name="tanggal_selesai" type="date" class="mt-1 block w-full" />
                </div>

                <div>
                    <x-input-label for="edit_deskripsi" :value="__('Deskripsi Program')" />
                    <textarea id="edit_deskripsi" name="deskripsi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4"></textarea>
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

        function openEditProgramModal(program) {
            document.getElementById('editProgramForm').action = `/admin/programs/${program.id}`;
            document.getElementById('edit_nama_program').value = program.nama_program || '';
            document.getElementById('edit_wilayah_id').value = program.wilayah_id || '';
            document.getElementById('edit_tim_kerja').value = program.tim_kerja || '';
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
    </script>
</x-app-layout>
