<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity md:hidden"></div>

<aside 
    class="fixed inset-y-0 left-0 z-30 w-64 bg-white text-gray-800 border-r border-gray-200 flex flex-col transform transition-transform duration-300 ease-in-out md:translate-x-0"
    :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
>
    <div class="flex items-center justify-center p-4 border-b border-gray-200">
        <a href="{{ route('dashboard') }}">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTRVuB5izhn6_SweD4kY9qdmzSinIWC-_jr2w&s" alt="Logo Balai Bahasa" class="block h-12 w-auto">
        </a>
    </div>

    <nav class="flex-1 px-2 py-4 space-y-2">
        {{-- PERUBAHAN DI SINI: Menambahkan ikon SVG di setiap link --}}
        
        <x-nav-link :href="route('laporan.statistik')" :active="request()->routeIs('laporan.statistik')" class="w-full flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900">
            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H9a2 2 0 01-2-2V5z"/></svg>
            {{ __('Statistik Kehadiran') }}
        </x-nav-link>

        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="w-full flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900">
            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            {{ __('Dasbor') }}
        </x-nav-link>

        <x-nav-link :href="route('agenda-harian.index')" :active="request()->routeIs('agenda-harian.*')" class="w-full flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900">
            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ __('Agenda Harian') }}
        </x-nav-link>

        @if(Auth::check() && Auth::user()->isSuperAdmin())
            <x-nav-link :href="route('users.import.create')" :active="request()->routeIs('users.import.*')" class="w-full flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                {{ __('Impor Pegawai') }}
            </x-nav-link>
        @endif

        <x-nav-link :href="route('reports.attendance.index')" :active="request()->routeIs('reports.attendance.*')" class="w-full flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900">
            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            {{ __('Laporan Kehadiran') }}
        </x-nav-link>

        @if(Auth::check() && Auth::user()->isKepegawaianAdmin())
            <x-nav-link :href="route('attendances.import.create')" :active="request()->routeIs('attendances.import.*')" class="w-full flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                {{ __('Impor Absensi') }}
            </x-nav-link>
        @endif
        
        <x-nav-link :href="route('hasil-kerja.index')" :active="request()->routeIs('hasil-kerja.*')" class="w-full flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900">
            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ __('Hasil Kerja') }}
        </x-nav-link>
    </nav>

    <div class="border-t border-gray-200 p-2">
        <x-dropdown align="top" width="60">
            <x-slot name="trigger">
                <button class="w-full flex items-center p-2 rounded-md text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 focus:outline-none">
                    <div class="flex-shrink-0">
                        <span class="inline-block h-8 w-8 rounded-full bg-gray-200 text-center leading-8 font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="ml-3 text-left">
                        <div>{{ Auth::user()->name }}</div>
                    </div>
                    <div class="ml-auto">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</aside>