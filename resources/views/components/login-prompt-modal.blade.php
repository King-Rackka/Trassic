<div x-data="{ show: false, redirectUrl: '' }"
     x-on:show-login-prompt.window="show = true; redirectUrl = $event.detail.redirect ?? window.location.href"
     x-show="show" 
     x-cloak
     class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95">

    <div class="relative bg-white p-6 sm:p-8 max-w-sm w-full text-center border-4 border-[#2F3AFF]" 
         @click.away="show = false">
        
        <div class="absolute -top-2 -left-2 w-3.5 h-3.5 bg-[#D9FC28] border-2 border-[#2F3AFF] z-30 pointer-events-none"></div>
        <div class="absolute -top-2 -right-2 w-3.5 h-3.5 bg-[#D9FC28] border-2 border-[#2F3AFF] z-30 pointer-events-none"></div>
        <div class="absolute -bottom-2 -left-2 w-3.5 h-3.5 bg-[#D9FC28] border-2 border-[#2F3AFF] z-30 pointer-events-none"></div>
        <div class="absolute -bottom-2 -right-2 w-3.5 h-3.5 bg-[#D9FC28] border-2 border-[#2F3AFF] z-30 pointer-events-none"></div>

        <span class="inline-block bg-[#D9FC28] text-[#2F3AFF] border-2 border-[#2F3AFF] font-display text-[10px] uppercase px-3 py-1 mb-3 tracking-widest">
            Akses Terbatas 
        </span>

        <h3 class="font-display text-2xl text-[#2F3AFF] uppercase leading-tight mb-2">
            Eits, Belum Login!
        </h3>

        <p class="font-sans text-xs sm:text-sm font-semibold text-gray-700 leading-relaxed mb-6">
            Join <strong class="text-[#2F3AFF]">TRASSIC</strong> sekarang untuk menikmati fitur ini dan mulai beraksi bersama komunitas!
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a :href="'/login?redirect=' + encodeURIComponent(redirectUrl)"
               class="flex-1 bg-[#D9FC28] text-[#2F3AFF] font-display text-sm uppercase py-2.5 px-4 hover:bg-[#cbf21d] transition-colors text-center">
                Masuk
            </a>
            
            <a :href="'/register?redirect=' + encodeURIComponent(redirectUrl)"
               class="flex-1 bg-[#FC00BB] text-[#D9FC28] font-display text-sm uppercase py-2.5 px-4 hover:bg-[#d900a0] transition-colors text-center">
                Daftar
            </a>
        </div>

        <button @click="show = false" 
                class="mt-5 font-display text-xs text-gray-500 hover:text-[#2F3AFF] uppercase tracking-wider underline underline-offset-4 cursor-pointer transition-colors block mx-auto">
            Nanti Saja
        </button>

    </div>
</div>