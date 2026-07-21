@auth
@php
    $nip = trim(auth()->user()->nip ?? '');
    $isBirthday = false;
    
    if ($nip && strlen($nip) >= 8) {
        $birthDateStr = substr($nip, 0, 8); // Contoh: 19850312
        if (ctype_digit($birthDateStr)) {
            $birthMonth = substr($birthDateStr, 4, 2); // 03
            $birthDay = substr($birthDateStr, 6, 2); // 12
            
            $currentMonth = date('m');
            $currentDay = date('d');
            
            if ($birthMonth === $currentMonth && $birthDay === $currentDay) {
                $isBirthday = true;
            }
        }
    }
@endphp

@if($isBirthday)
    <div x-data="{ showBirthdayPopup: !sessionStorage.getItem('birthdayPopupClosed') }" 
         x-show="showBirthdayPopup" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-90"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-90"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-sm"
         style="display: none;">
         
        <div @click.away="showBirthdayPopup = false; sessionStorage.setItem('birthdayPopupClosed', 'true')" 
             class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 text-center relative overflow-hidden">
            
            <!-- Confetti background effect (simple css dots) -->
            <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: radial-gradient(#60A5FA 2px, transparent 2px), radial-gradient(#3B82F6 2px, transparent 2px); background-size: 30px 30px; background-position: 0 0, 15px 15px;"></div>

            <button @click="showBirthdayPopup = false; sessionStorage.setItem('birthdayPopupClosed', 'true')" 
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <div class="relative z-10">
                <div class="flex justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-blue-500 animate-bounce" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8"/>
                        <path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1"/>
                        <path d="M2 21h20"/>
                        <path d="M7 8v2"/>
                        <path d="M12 8v2"/>
                        <path d="M17 8v2"/>
                        <circle cx="7" cy="4" r="1" fill="currentColor" stroke="none"/>
                        <circle cx="12" cy="4" r="1" fill="currentColor" stroke="none"/>
                        <circle cx="17" cy="4" r="1" fill="currentColor" stroke="none"/>
                    </svg>
                </div>
                
                <h2 class="text-3xl font-bold text-gray-800 mb-4 font-['Montserrat']">Selamat Ulang Tahun!</h2>
                
                <p class="text-gray-600 mb-8 text-lg leading-relaxed">
                    Selamat ulang tahun, <strong class="text-gray-800">{{ auth()->user()->name }}</strong>!<br>
                    Semoga hari ini dipenuhi dengan kebahagiaan dan kesuksesan selalu menyertai langkahmu.
                </p>
                
                <button @click="showBirthdayPopup = false; sessionStorage.setItem('birthdayPopupClosed', 'true')" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transform transition hover:-translate-y-1 w-full text-lg">
                    Terima Kasih!
                </button>
            </div>
        </div>
    </div>
@endif
@endauth
