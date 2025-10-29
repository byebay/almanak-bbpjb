<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity md:hidden"></div>

<aside 
    class="fixed inset-y-0 left-0 z-30 w-64 bg-white text-gray-900 border-r border-blue-200 flex flex-col transform transition-transform duration-300 ease-in-out md:translate-x-0"
    :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
>
    <div class="flex items-center justify-center p-4 border-b border-blue-200">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
            <img src="storage/photos/logo.jpeg" alt="Logo Balai Bahasa" class="block h-10 w-auto">
            <span class="font-bold text-xl text-gray-800">Almanak</span>
        </a>
    </div>

    <nav class="flex-1 px-2 py-4 space-y-2">
        {{-- PERUBAHAN DI SINI: Menambahkan ikon SVG di setiap link --}}
        
        <!-- <x-nav-link :href="route('laporan.statistik')" :active="request()->routeIs('laporan.statistik')" class="w-full flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900">
            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H9a2 2 0 01-2-2V5z"/></svg>
            {{ __('Statistik Kehadiran') }}
        </x-nav-link> -->

        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="w-full flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900">
            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            {{ __('Dasbor') }}
        </x-nav-link>

        <x-nav-link :href="route('agenda-harian.index')" :active="request()->routeIs('agenda-harian.*')" class="w-full flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900">
            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ __('Agenda Harian') }}
        </x-nav-link>

        <x-nav-link :href="route('galeri-tautan.index')" :active="request()->routeIs('galeri-tautan.*')">
                 <!-- Ikon Tautan (Link) -->
                     <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                    </svg>
                {{ __('Galeri Tautan') }}
        </x-nav-link>

        <x-nav-link :href="route('kinerja.index')" :active="request()->routeIs('kinerja.*')" class="w-full flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900">
            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
            {{ __('Realisasi Kegiatan') }}
        </x-nav-link>

        @if(Auth::check() && (Auth::user()->isSuperAdmin() || Auth::user()->isKepegawaianAdmin()))
             @php
                $isPegawaiMenuActive = request()->routeIs(['admin.users.*', 'users.import.*']);
            @endphp
                <div x-data="{ open: {{ $isPegawaiMenuActive ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" class="w-full flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900 {{ $isPegawaiMenuActive ? 'text-gray-900 font-bold' : '' }}">
                        <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span class="flex-1 text-left">{{ __('Manajemen Pegawai') }}</span>
                        <svg class="h-4 w-4 transform transition-transform" :class="{'rotate-90': open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>
                <div x-show="open" x-transition class="space-y-1 pl-4" style="display: none;">
                                
                                {{-- --- PERUBAHAN DI SINI: MENAMBAHKAN IKON --- --}}
                @if(Auth::user()->isSuperAdmin())
                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="w-full flex items-center p-2 rounded-md">
                                        <!-- Ikon Daftar Pengguna -->
                        <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-3.741-5.198M9 15a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm12 0a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z M9 9.75a3 3 0 0 1 3-3h.008v.008h-.008a3 3 0 0 1-3 3Zm.008 0H9.75m5.622-1.622a3 3 0 0 1 3.001 3.001M15 9.75a3 3 0 0 1 3-3h.008v.008h-.008a3 3 0 0 1-3 3Zm.008 0H15.75m-3.75 0a3 3 0 0 1 3-3h.008v.008h-.008a3 3 0 0 1-3 3Zm.008 0H12.75m-3.75 0a3 3 0 0 1 3-3h.008v.008h-.008a3 3 0 0 1-3 3Z" /></svg>
                        {{ __('Daftar & Kelola Pegawai') }}
                        </x-nav-link>
                @endif
                                
                    <x-nav-link :href="route('users.import.create')" :active="request()->routeIs('users.import.*')" class="w-full flex items-center p-2 rounded-md">
                                    <!-- Ikon Impor -->
                        <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5v-2.25A2.25 2.25 0 0 1 9 15h6a2.25 2.25 0 0 1 2.25 2.25v2.25" /></svg>
                                    {{ __('Impor Pegawai (Excel)') }}
                    </x-nav-link>
                                {{-- ------------------------------------------- --}}
                </div>
                </div>
        @endif

        @php
            $isKehadiranMenuActive = request()->routeIs(['reports.attendance.*', 'attendances.import.*', 'leaves.manage']);
        @endphp
        <div x-data="{ open: {{ $isKehadiranMenuActive ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open" class="w-full flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900 {{ $isKehadiranMenuActive ? 'text-gray-900 font-bold' : '' }}">
                <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span class="flex-1 text-left">{{ __('Manajemen Kehadiran') }}</span>
                <svg class="h-4 w-4 transform transition-transform" :class="{'rotate-90': open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </button>
            <div x-show="open" x-transition class="space-y-1 pl-4">
                <x-nav-link :href="route('reports.attendance.index')" :active="request()->routeIs('reports.attendance.*')">
                <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                    {{ __('Laporan Kehadiran') }}
                </x-nav-link>

                @if(Auth::check() && Auth::user()->isKepegawaianAdmin())
                    <x-nav-link :href="route('attendances.import.create')" :active="request()->routeIs('attendances.import.*')">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" /></svg>
                        {{ __('Unggah Presensi Pegawai') }}
                    </x-nav-link>
                    <x-nav-link :href="route('leaves.manage')" :active="request()->routeIs('leaves.manage')">
                    <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" /></svg>
                        {{ __('Kelola Cuti & Dinas Luar') }}
                    </x-nav-link>
                @endif
            </div>
        </div>

        <!-- <x-nav-link :href="route('rooms.status')" :active="request()->routeIs('rooms.status')" class="w-full flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900">
            <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18h16.5M2.25 9h16.5m-16.5 6H21m-1.5-1.5V5.625c0-1.036-.84-1.875-1.875-1.875H5.625c-1.036 0-1.875.84-1.875 1.875v12.75c0 1.036.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V15M12 12h9" />
            </svg>
            {{ __('Status Ruangan') }}
        </x-nav-link> -->

        <!-- @if(Auth::check() && Auth::user()->isSuperAdmin())
            <x-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.index', 'rooms.edit')" class="w-full flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                <svg class="h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.39.44 1.022.12 1.45l-.527.737c-.25.35-.272.806-.108 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.164.398-.142.854.108 1.204l.527.738c.32.427.27 1.06-.12 1.45l-.773.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.93l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527a1.125 1.125 0 01-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.738c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.164-.398.142-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.93l.15-.893z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ __('Manajemen Ruangan') }}
            </x-nav-link>
        @endif -->

        

         {{-- @if(Auth::check() && Auth::user()->isSuperAdmin())
            <x-nav-link :href="route('agendas.import.create')" :active="request()->routeIs('agendas.import.create')">
                {{ __('Impor Agenda Lama') }}
            </x-nav-link>
        @endif --}}

    </nav>

    <div class="mt-auto p-4 border-t border-gray-200">
    {{-- 1. Bungkus semuanya dengan komponen Alpine.js --}}
    <div x-data="{ open: false }" class="relative">
        
        {{-- 2. Tombol Pemicu Dropdown --}}
        <button @click="open = ! open" class="w-full flex items-center justify-between text-left p-2 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <div class="flex items-center">
                {{-- Anda bisa menambahkan foto profil di sini nanti --}}
                {{-- <img src="{{ Auth::user()->photo_url }}" alt="Foto Profil" class="w-8 h-8 rounded-full mr-3 object-cover"> --}}
                <div>
                    <p class="font-semibold text-sm text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->getRoleName() }}</p> {{-- Asumsi ada fungsi getRoleName() di Model User --}}
                </div>
            </div>
            {{-- Ikon Panah Dropdown --}}
            <svg class="w-4 h-4 text-gray-500 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>

        {{-- 3. Konten Dropdown yang Muncul/Hilang --}}
        <div x-show="open"
             @click.away="open = false"
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             class="absolute bottom-full mb-2 w-full bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-10"
             style="display: none;">
            
            <div class="py-1">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profil Saya') }}
                </x-dropdown-link>

                <!-- Tombol Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Keluar') }}
                    </x-dropdown-link>
                </form>
            </div>
        </div>
    </div>
</div>

</aside>