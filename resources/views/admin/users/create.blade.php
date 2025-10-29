<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pegawai Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Nama Pegawai -->
                        <div>
                            <x-input-label for="name" value="Nama Lengkap Pegawai" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>

                        <!-- NIP -->
                        <div class="mt-4">
                            <x-input-label for="nip" value="NIP (Nomor Induk Pegawai)" />
                            <x-text-input id="nip" class="block mt-1 w-full" type="text" name="nip" :value="old('nip')" required />
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="mt-4">
                            <x-input-label for="tanggal_lahir" value="Tanggal Lahir (Opsional)" />
                            <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir')" />
                        </div>

                        <!-- Email (Opsional) -->
                        <div class="mt-4">
                            <x-input-label for="email" value="Email (Opsional)" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
                            <p class="text-sm text-gray-500 mt-1">Jika dikosongkan, email akan di-generate otomatis dari NIP (contoh: NIP@bbjb.test).</p>
                        </div>

                        <!-- Peran/Role -->
                        <div class="mt-4">
                            <x-input-label for="role" value="Peran (Role)" />
                            <select name="role" id="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="pegawai">Pegawai</option>
                                <option value="kepegawaian">Admin Kepegawaian</option>
                                <option value="super_admin">Super Admin</option>
                            </select>
                        </div>

                        <!-- Unggah Foto (Opsional) -->
                        <div class="mt-4">
                            <x-input-label for="photo" value="Foto Profil (Opsional)" />
                            <input id="photo" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" type="file" name="photo">
                            <p class="text-sm text-gray-500 mt-1">Format yang diizinkan: JPG, PNG. Maksimal 2MB.</p>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Pegawai Baru') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>