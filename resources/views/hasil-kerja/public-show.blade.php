<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bukti Kerja - {{ $user->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg p-6 mb-6 flex items-center space-x-4">
            <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover border-4 border-gray-200">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Laporan Bukti Kerja</h1>
                <h2 class="text-xl text-gray-700">{{ $user->name }}</h2>
                <p class="text-gray-500">Periode: {{ \Carbon\Carbon::create()->month((int)$month)->translatedFormat('F') }} {{ $year }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <ul class="space-y-4">
                @forelse ($works as $work)
                    <li class="flex flex-col sm:flex-row justify-between sm:items-center border-b pb-4">
                        <div class="mb-2 sm:mb-0">
                            <p class="text-xs text-gray-500">{{ $work->work_date->translatedFormat('l, j F Y') }}</p>
                            <p class="font-semibold text-lg text-gray-900">{{ $work->title }}</p>
                            <p class="text-sm text-gray-600">{{ $work->description }}</p>
                        </div>
                        <div class="flex items-center space-x-2 shrink-0">
                            <a href="{{ route('hasil-kerja.public.view', ['work' => $work, 'token' => $user->shareable_token]) }}" target="_blank" class="px-3 py-1 text-sm font-medium text-indigo-700 bg-indigo-100 rounded-md hover:bg-indigo-200">Lihat</a>
                            <a href="{{ route('hasil-kerja.public.download', ['work' => $work, 'token' => $user->shareable_token]) }}" class="px-3 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-md hover:bg-green-200">Unduh</a>
                        </div>
                    </li>
                @empty
                    <li class="text-center text-gray-500 py-8">Belum ada bukti kerja yang diunggah untuk periode ini.</li>
                @endforelse
            </ul>
        </div>
    </div>
</body>
</html>
