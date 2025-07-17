<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Impor Master Data Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Kotak Instruksi -->
                    <div class="mb-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800">
                        <p class="font-bold">Petunjuk Penting!</p>
                        <ul class="list-disc list-inside mt-2">
                            <li>Fitur ini akan membuat atau memperbarui data pegawai berdasarkan kolom **NIP**.</li>
                            <li>Pastikan file Excel Anda memiliki header (judul kolom) persis seperti ini: `NIP`, `Nama`, `Tanggal Lahir`.</li>
                            <li>Password default untuk semua akun baru adalah: `password123`.</li>
                        </ul>
                    </div>

                    <!-- Menampilkan Error Validasi -->
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Oops!</strong>
                            <span class="block sm:inline">Terjadi kesalahan.</span>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Upload -->
                    <form action="{{ route('users.import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="users_file" class="block text-gray-700 text-sm font-bold mb-2">Pilih File Excel Master Pegawai:</label>
                            <input type="file" name="users_file" id="users_file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" required>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Mulai Proses Impor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>