<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Impor Agenda Historis</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <form action="{{ route('agendas.import.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="agenda_file" class="block text-gray-700 text-sm font-bold mb-2">Pilih File Excel:</label>
                            <input type="file" name="agenda_file" id="agenda_file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="year" class="block text-gray-700 text-sm font-bold mb-2">Pilih Tahun:</label>
                                <select name="year" id="year" class="border-gray-300 rounded-md w-full" required>
                                    @for ($y = date('Y'); $y >= 2023; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label for="month" class="block text-gray-700 text-sm font-bold mb-2">Pilih Bulan:</label>
                                <select name="month" id="month" class="border-gray-300 rounded-md w-full" required>
                                    @foreach (range(1, 12) as $m)
                                        <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="mt-6 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Mulai Proses Impor
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
