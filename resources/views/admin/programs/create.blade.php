<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Program Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form id="form-program" method="POST" action="{{ route('admin.programs.store') }}" class="space-y-6">
                        @csrf

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
                            <x-input-label for="deskripsi" :value="__('Deskripsi Program')" />
                            <textarea id="deskripsi" name="deskripsi" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required>{{ old('deskripsi') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>



                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
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
                        </div>

                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.programs.index') }}" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50">
                                {{ __('Batal') }}
                            </a>
                            <button type="submit" id="btn-submit-program" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                                {{ __('Simpan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const timKerjaSelect = document.getElementById('tim_kerja');
            const subTimKerjaContainer = document.getElementById('sub_tim_kerja_container');
            const subTimKerjaSelect = document.getElementById('sub_tim_kerja');

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

            const oldSubTimKerja = "{{ old('sub_tim_kerja') }}";

            function updateSubTimKerja() {
                const selectedTim = timKerjaSelect.value;
                
                // Clear existing options except the first one
                subTimKerjaSelect.innerHTML = '<option value="" disabled selected>Pilih Sub Tim Kerja</option>';

                if (selectedTim && subTimMap[selectedTim]) {
                    subTimKerjaSelect.disabled = false;
                    subTimMap[selectedTim].forEach(function (sub) {
                        const option = document.createElement('option');
                        option.value = sub;
                        option.textContent = sub;
                        if (sub === oldSubTimKerja) {
                            option.selected = true;
                        }
                        subTimKerjaSelect.appendChild(option);
                    });
                } else {
                    subTimKerjaSelect.disabled = true;
                }
            }

            timKerjaSelect.addEventListener('change', updateSubTimKerja);
            
            // Trigger initially to handle validation errors or old input
            if (timKerjaSelect.value) {
                updateSubTimKerja();
            }
        });

        document.getElementById('form-program').addEventListener('submit', function (e) {
            const btn = document.getElementById('btn-submit-program');
            if (btn.disabled) {
                e.preventDefault();
                return;
            }
            btn.disabled = true;
            btn.innerHTML = 'Menyimpan...';
        });
    </script>
    @endpush
</x-app-layout>