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

    {{-- KARTU MODAL UTAMA --}}
    <div class="relative bg-white p-6 sm:p-8 max-w-sm w-full text-center border-4 border-black shadow-[8px_8px_0px_rgba(0,0,0,1)]" 
         @click.away="show = false">
        
        {{-- AKSEN KOTAK KUNING LIME DI 4 SUDUT BORDER --}}
        <div class="absolute -top-2 -left-2 w-3.5 h-3.5 bg-[#ccff00] border-2 border-black z-30 pointer-events-none"></div>
        <div class="absolute -top-2 -right-2 w-3.5 h-3.5 bg-[#ccff00] border-2 border-black z-30 pointer-events-none"></div>
        <div class="absolute -bottom-2 -left-2 w-3.5 h-3.5 bg-[#ccff00] border-2 border-black z-30 pointer-events-none"></div>
        <div class="absolute -bottom-2 -right-2 w-3.5 h-3.5 bg-[#ccff00] border-2 border-black z-30 pointer-events-none"></div>

        {{-- BADGE HEADER --}}
        <span class="inline-block bg-[#ccff00] text-[#254bfe] border-2 border-black font-display text-[10px] uppercase px-3 py-1 mb-3 shadow-[2px_2px_0px_rgba(0,0,0,1)] tracking-widest">
            Akses Terbatas 🔒
        </span>

        {{-- JUDUL PROMPT --}}
        <h3 class="font-display text-2xl text-[#254bfe] uppercase leading-tight mb-2">
            Eits, Belum Login!
        </h3>

        {{-- DESKRIPSI --}}
        <p class="font-sans text-xs sm:text-sm font-semibold text-gray-700 leading-relaxed mb-6">
            Join <strong class="text-[#254bfe]">TRASSIC</strong> sekarang untuk menikmati fitur ini dan mulai beraksi bersama komunitas!
        </p>

        {{-- TOMBOL AKSI --}}
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a :href="'/login?redirect=' + encodeURIComponent(redirectUrl)"
               class="flex-1 bg-[#ccff00] text-[#254bfe] font-display text-sm uppercase py-2.5 px-4 border-2 border-black shadow-[3px_3px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all text-center">
                Masuk
            </a>
            
            <a :href="'/register?redirect=' + encodeURIComponent(redirectUrl)"
               class="flex-1 bg-[#ff007a] text-[#ccff00] font-display text-sm uppercase py-2.5 px-4 border-2 border-black shadow-[3px_3px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all text-center">
                Daftar
            </a>
        </div>

        {{-- TOMBOL TUTUP --}}
        <button @click="show = false" 
                class="mt-5 font-display text-xs text-gray-500 hover:text-black uppercase tracking-wider underline underline-offset-4 cursor-pointer transition-colors block mx-auto">
            Nanti Saja
        </button>

    </div>
</div>