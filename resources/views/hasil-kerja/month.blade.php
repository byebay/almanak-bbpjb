<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Tambahkan (int) untuk mengubah string dari URL menjadi angka --}}
            Bukti Kerja - {{ \Carbon\Carbon::create()->month((int)$month)->translatedFormat('F') }} {{ $year }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">

                <!-- === TOMBOL KEMBALI BARU === -->
                <div class="mb-6">
                    <a href="{{ route('hasil-kerja.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Pilihan Periode
                    </a>
                </div>
                <!-- ============================ -->
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach ($employees as $employee)
                        <a href="{{ route('hasil-kerja.employee', ['year' => $year, 'month' => $month, 'user' => $employee->id]) }}" class="text-center p-4 border rounded-lg hover:bg-gray-50 hover:shadow-md transition">
                            <p class="font-semibold">{{ $employee->name }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>