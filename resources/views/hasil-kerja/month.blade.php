<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Tambahkan (int) untuk mengubah string dari URL menjadi angka --}}
            Hasil Kerja - {{ \Carbon\Carbon::create()->month((int)$month)->translatedFormat('F') }} {{ $year }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
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