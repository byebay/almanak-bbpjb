<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Bukti Kerja Pegawai</h2></x-slot>
    <div class="py-12" x-data="{ year: new Date().getFullYear(), month: new Date().getMonth() + 1 }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold mb-4">Pilih Periode Laporan</h3>
                <div class="flex items-center space-x-4">
                    <select x-model="year" class="border-gray-300 rounded-md">
                        @for ($y = date('Y'); $y >= 2023; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                    <select x-model="month" class="border-gray-300 rounded-md">
                        @foreach (range(1, 12) as $m)
                            <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                        @endforeach
                    </select>
                    <a :href="`/hasil-kerja/${year}/${month}`" class="bg-blue-500 text-white px-4 py-2 rounded-md">Tampilkan</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>