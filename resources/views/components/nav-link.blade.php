@props(['active'])

@php
// Logika ini menentukan kelas CSS berdasarkan status link (aktif atau tidak)
$classes = ($active ?? false)
            // Kelas untuk link yang AKTIF
            ? 'w-full flex items-center p-2 rounded-md text-gray-900 font-bold bg-blue-200 transition-colors duration-200'
            // Kelas untuk link yang TIDAK AKTIF
            : 'w-full flex items-center p-2 rounded-md text-gray-700 hover:bg-blue-200 hover:text-gray-900 transition-colors duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
