<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bukti Kerja - {{ $user->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header Section dengan Profil -->
        <div class="bg-white shadow-lg rounded-xl p-6 mb-8 border-l-4 border-blue-500">
            <div class="flex items-center space-x-6">
                <div class="relative">
                    <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" 
                         class="w-28 h-28 rounded-full object-cover border-4 border-blue-200 shadow-md">
                    <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-blue-900 mb-2">Laporan Bukti Kerja</h1>
                    <h2 class="text-xl font-semibold text-blue-700 mb-1">{{ $user->name }}</h2>
                    <div class="flex items-center text-blue-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a2 2 0 012 2v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2h3z"></path>
                        </svg>
                        <span class="font-medium">Periode: {{ \Carbon\Carbon::create()->month((int)$month)->translatedFormat('F') }} {{ $year }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Bukti Kerja -->
        <div class="bg-white rounded-xl shadow-lg border border-blue-100 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Daftar Bukti Kerja
                </h3>
            </div>
            
            <div class="p-6">
                <ul class="space-y-6">
                    @forelse ($works as $work)
                        <li class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-lg p-5 hover:shadow-md transition-shadow duration-200">
                            <div class="flex flex-col sm:flex-row justify-between sm:items-start">
                                <div class="flex-1 mb-4 sm:mb-0">
                                    <div class="flex items-center mb-2">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                                        <p class="text-sm font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full">
                                            {{ $work->work_date->translatedFormat('l, j F Y') }}
                                        </p>
                                    </div>
                                    <h4 class="font-bold text-xl text-blue-900 mb-2">{{ $work->title }}</h4>
                                    <p class="text-gray-700 leading-relaxed">{{ $work->description }}</p>
                                </div>
                                <div class="flex items-center space-x-3 sm:ml-6">
                                    <a href="{{ route('hasil-kerja.public.view', ['work' => $work, 'token' => $user->shareable_token]) }}" 
                                       target="_blank" 
                                       class="inline-flex items-center px-4 py-2 text-sm font-semibold text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-200 shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Lihat
                                    </a>
                                    <a href="{{ route('hasil-kerja.public.download', ['work' => $work, 'token' => $user->shareable_token]) }}" 
                                       class="inline-flex items-center px-4 py-2 text-sm font-semibold text-green-700 bg-green-100 rounded-lg hover:bg-green-200 transition-colors duration-200 shadow-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Unduh
                                    </a>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="text-center py-16">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-blue-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="text-lg font-semibold text-blue-800 mb-2">Belum Ada Bukti Kerja</h3>
                                <p class="text-blue-600">Belum ada bukti kerja yang diunggah untuk periode ini.</p>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-blue-600 text-sm">
                Laporan ini dibuat secara otomatis dan dapat diakses melalui tautan publik
            </p>
        </div>
    </div>
</body>
</html>