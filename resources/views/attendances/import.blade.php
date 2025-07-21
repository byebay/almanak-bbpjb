<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Impor Data Kehadiran</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <form action="{{ route('attendances.import.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="report_date" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Laporan:</label>
                        <input type="date" name="report_date" id="report_date" class="border rounded w-full py-2 px-3" required>
                    </div>
                    <div>
                        <label for="attendance_file" class="block text-gray-700 text-sm font-bold mb-2">Pilih File Excel Absensi:</label>
                        <input type="file" name="attendance_file" id="attendance_file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" required>
                    </div>
                    <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Impor Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
