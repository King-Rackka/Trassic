<x-app-layout :fullscreen="true">
    <x-slot:title>Register - Trassic</x-slot:title>

<div class="w-full flex flex-col lg:flex-row h-full min-h-0 overflow-hidden" x-data="registerForm()">

    {{-- MAIN CONTENT AREA --}}
    <div class="flex-1 flex flex-col lg:flex-row min-h-0 overflow-hidden">

        {{-- LEFT CONTAINER: LANYARD VISUAL --}}
        <div class="hidden lg:flex lg:w-1/2 bg-white relative flex-col items-center justify-start overflow-hidden border-r-2 border-[#254bfe] bg-grid-pattern h-full"
             id="lanyard-container">

            {{-- SVG Strap --}}
            <svg class="absolute inset-0 w-full h-full pointer-events-none z-10">
                <defs>
                    <pattern id="strapPattern" width="14" height="14" patternUnits="userSpaceOnUse" patternTransform="rotate(45)">
                        <rect width="7" height="14" fill="#254bfe"/>
                        <rect x="7" width="7" height="14" fill="#ccff00"/>
                    </pattern>
                </defs>
                <path id="ropePathOuter" fill="none" stroke="#000000" stroke-width="20" stroke-linecap="round"/>
                <path id="ropePathInner" fill="none" stroke="url(#strapPattern)" stroke-width="14" stroke-linecap="round"/>
            </svg>

            {{-- ID Card Element --}}
            <div id="lanyardCard" class="absolute z-20 cursor-grab active:cursor-grabbing select-none" style="top: 0; left: 0; transform-origin: top center;">
                <div class="w-[300px] xl:w-[330px] relative drop-shadow-[10px_15px_20px_rgba(0,0,0,0.35)]">
                    
                    {{-- Klip Gantung Atas Kuning --}}
                    <div class="w-10 h-7 bg-[#ccff00] mx-auto rounded-t-md border-2 border-black flex items-center justify-center relative z-30 -mb-1 shadow-sm">
                        <div class="w-5 h-1.5 bg-black rounded-full"></div>
                    </div>

                    {{-- Outer Frame Lanyard Gradasi --}}
                    <div class="w-full card-outer-gradient rounded-[28px] p-2.5 border-2 border-black relative overflow-hidden clip-outer-card">

                        {{-- Lubang Tali Card --}}
                        <div class="w-12 h-3 bg-black rounded-full mx-auto mb-1.5 flex items-center justify-center">
                            <div class="w-6 h-1 bg-white/20 rounded-full"></div>
                        </div>

                        {{-- Aksen Samping Kiri Atas --}}
                        <div class="absolute left-2 top-12 bg-[#7c3aed] p-1 rounded-2xl border-2 border-black z-10 flex gap-0.5">
                            <div class="w-2 h-36 bg-[#ccff00] rounded-full border border-black"></div>
                            <div class="w-2 h-36 bg-[#ccff00] rounded-full border border-black"></div>
                            <div class="w-2 h-36 bg-[#ccff00] rounded-full border border-black"></div>
                        </div>

                        {{-- Inner Card Putih --}}
                        <div class="bg-[#f8f9fa] rounded-[18px] ml-9 p-3 flex flex-col justify-between min-h-[380px] relative border border-gray-200 clip-inner-card">

                            <div>
                                {{-- Header / Logo --}}
                                <div class="flex items-center justify-between mb-2">
                                    <img src="{{ asset('images/logo.png') }}" alt="Trassic" class="h-5 object-contain" onerror="this.src='https://via.placeholder.com/80x24/254bfe/ffffff?text=Trassic'">
                                    <div class="h-0.5 w-16 bg-gradient-to-r from-[#ff007a] via-[#7c3aed] to-[#ccff00]"></div>
                                </div>

                                {{-- Avatar Outer Circle --}}
                                <div class="w-full flex justify-center my-2">
                                    <div class="w-28 h-28 rounded-full border-[3px] border-[#254bfe] flex items-center justify-center relative bg-white">
                                        <div class="w-7 h-7 bg-[#ccff00] rounded-full absolute top-0 left-0 border-2 border-[#254bfe]"></div>
                                        <div class="w-6 h-6 bg-[#ff007a] rounded-full absolute bottom-1 right-1 border-2 border-[#254bfe]"></div>
                                        
                                        <div class="w-22 h-22 rounded-full border-2 border-[#254bfe] flex items-center justify-center bg-white">
                                            <svg class="w-14 h-14 text-[#254bfe]" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 100-8 4 4 0 000 8z"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Identity Text Section --}}
                                <div class="space-y-2 mt-3 pl-1">
                                    <div class="flex items-center gap-2">
                                        <span class="bg-[#ccff00] text-black text-[9px] font-extrabold uppercase px-2.5 py-0.5 rounded-full border border-black shrink-0 tracking-tight">Known as</span>
                                        <span class="text-xl font-display text-[#254bfe] leading-none uppercase tracking-wide truncate" x-text="knownAs || 'MAPLESTAR'"></span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="bg-[#ccff00] text-black text-[9px] font-extrabold uppercase px-2.5 py-0.5 rounded-full border border-black shrink-0 tracking-tight">Join at</span>
                                        <span class="text-xl font-display text-[#254bfe] leading-none tracking-wide" x-text="joinDate"></span>
                                    </div>
                                </div>
                            </div>

                            {{-- Terms Checkbox Box --}}
                            <div class="mt-2 bg-[#254bfe] text-white p-2 rounded-lg flex items-center gap-2 text-[8px] font-medium leading-tight border border-black shadow-sm">
                                <input type="checkbox" x-model="acceptedTerms" class="rounded border-white text-indigo-900 focus:ring-0 w-3.5 h-3.5 shrink-0 cursor-pointer accent-[#ccff00]">
                                <span>I confirm that I have read and accepted the Terms and Conditions and Privacy Policy.</span>
                            </div>

                        </div>

                        {{-- Aksen Samping Kiri Bawah --}}
                        <div class="absolute left-2 bottom-2 bg-[#ff007a] p-0.5 rounded-lg border-2 border-black z-10 flex gap-0.5">
                            <div class="w-1.5 h-5 bg-[#ccff00] rounded-full border border-black"></div>
                            <div class="w-1.5 h-5 bg-[#ccff00] rounded-full border border-black"></div>
                            <div class="w-1.5 h-5 bg-[#ccff00] rounded-full border border-black"></div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT CONTAINER: FORM REGISTRASI --}}
        <div class="w-full lg:w-1/2 bg-[#2f3cff] px-6 sm:px-12 lg:px-16 py-4 sm:py-6 flex flex-col justify-center h-full overflow-y-auto">

            <div class="max-w-md w-full mx-auto space-y-3 sm:space-y-4">
                
                {{-- JUDUL UTAMA --}}
                <h1 class="text-3xl sm:text-4xl font-display text-[#ccff00] uppercase tracking-normal text-center mb-2 sm:mb-4">
                    Bergabung dengan kami
                </h1>

                <form method="POST" action="{{ route('register') }}" class="space-y-3">
                    @csrf

                    {{-- NAMA PENGGUNA --}}
                    <div class="space-y-1">
                        <label class="text-white text-[10px] font-bold uppercase tracking-wider block">
                            NAMA PENGGUNA
                        </label>
                        <input type="text" name="name" x-model="knownAsFull" maxlength="50"
                               placeholder="Contoh: Raditya Meyka"
                               class="w-full rounded-xl border-0 px-4 py-2.5 sm:py-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-[#ccff00] bg-[#f7f7f7] text-xs sm:text-sm font-medium outline-none"
                               required autofocus>
                        @error('name') <p class="text-pink-300 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="space-y-1">
                        <label class="text-white text-[10px] font-bold uppercase tracking-wider block">
                            EMAIL
                        </label>
                        <input type="email" name="email"
                               placeholder="Contoh: radityameyka5@gmail.com"
                               class="w-full rounded-xl border-0 px-4 py-2.5 sm:py-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-[#ccff00] bg-[#f7f7f7] text-xs sm:text-sm font-medium outline-none"
                               required>
                        @error('email') <p class="text-pink-300 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="space-y-1">
                        <label class="text-white text-[10px] font-bold uppercase tracking-wider block">
                            PASSWORD
                        </label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" name="password"
                                   placeholder="Masukkan Password"
                                   class="w-full rounded-xl border-0 px-4 py-2.5 sm:py-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-[#ccff00] bg-[#f7f7f7] text-xs sm:text-sm font-medium pr-10 outline-none"
                                   required>
                            <button type="button" x-on:click="showPassword = !showPassword"
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                                <svg x-show="!showPassword" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" x-cloak>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.962 8.962 0 012.122-.163c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-2.122 2.122A3 3 0 0112 15a3 3 0 01-3-3"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                        @error('password') <p class="text-pink-300 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- KONFIRMASI PASSWORD --}}
                    <div class="space-y-1">
                        <label class="text-white text-[10px] font-bold uppercase tracking-wider block">
                            KONFIRMASI PASSWORD
                        </label>
                        <div class="relative">
                            <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation"
                                   placeholder="Masukkan Password"
                                   class="w-full rounded-xl border-0 px-4 py-2.5 sm:py-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-[#ccff00] bg-[#f7f7f7] text-xs sm:text-sm font-medium pr-10 outline-none"
                                   required>
                            <button type="button" x-on:click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                                <svg x-show="!showConfirmPassword" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showConfirmPassword" class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" x-cloak>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.962 8.962 0 012.122-.163c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-2.122 2.122A3 3 0 0112 15a3 3 0 01-3-3"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- LUPA PASSWORD --}}
                    <div class="text-right pt-0.5">
                        <a href="{{ route('password.request') }}" class="text-white text-xs hover:underline font-normal">
                            Lupa password?
                        </a>
                    </div>

                    {{-- TOMBOL DAFTAR --}}
                    <button type="submit"
                            class="w-full bg-[#ccff00] text-[#2f3cff] font-display text-xl sm:text-2xl py-2.5 sm:py-3 rounded-2xl hover:bg-lime-300 transition uppercase tracking-wide mt-2 shadow-sm">
                        Daftar
                    </button>

                    {{-- LINK MASUK --}}
                    <p class="text-center text-white text-xs sm:text-sm pt-1 font-normal">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-bold underline text-[#ccff00]">Masuk</a>
                    </p>
                </form>

            </div>

        </div>
    </div>
</div>

<script>
function registerForm() {
    return {
        knownAsFull: '',
        showPassword: false,
        showConfirmPassword: false,
        acceptedTerms: false,
        joinDate: '17/08/2026',

        init() {
            this.setJoinDate();
            this.$nextTick(() => {
                initShortLanyardPhysics();
            });
        },

        setJoinDate() {
            const now = new Date();
            const dd = String(now.getDate()).padStart(2, '0');
            const mm = String(now.getMonth() + 1).padStart(2, '0');
            const yyyy = now.getFullYear();
            this.joinDate = `${dd}/${mm}/${yyyy}`;
        },

        get knownAs() {
            return this.knownAsFull.slice(0, 12).toUpperCase();
        }
    }
}

function initShortLanyardPhysics() {
    const container = document.getElementById('lanyard-container');
    const cardEl = document.getElementById('lanyardCard');
    const pathOuter = document.getElementById('ropePathOuter');
    const pathInner = document.getElementById('ropePathInner');

    if (!container || !cardEl || !pathOuter) return;

    let isDragging = false;
    let cardX = container.clientWidth / 2;
    let cardY = -350;
    let velX = 0;
    let velY = 0;
    let startMouseX = 0;
    let startMouseY = 0;
    let startCardX = 0;
    let startCardY = 0;

    function renderLoop() {
        const anchorX = container.clientWidth / 2;
        const anchorY = -25;

        if (!isDragging) {
            const targetX = anchorX;
            const targetY = 35; 

            const forceX = (targetX - cardX) * 0.08;
            const forceY = (targetY - cardY) * 0.08;

            velX = (velX + forceX) * 0.82;
            velY = (velY + forceY) * 0.82;

            cardX += velX;
            cardY += velY;
        }

        const offsetX = cardX - anchorX;
        const maxRotationRad = 0.22;
        let rotationRad = (offsetX / 220) * maxRotationRad;
        rotationRad = Math.max(-maxRotationRad, Math.min(maxRotationRad, rotationRad));

        const cardCenterTopX = cardX;
        const cardCenterTopY = cardY;
        
        const controlX = (anchorX + cardCenterTopX) / 2;
        const controlY = (anchorY + cardCenterTopY) / 2 + Math.abs(offsetX) * 0.1;

        const pathD = `M ${anchorX} ${anchorY} Q ${controlX} ${controlY}, ${cardCenterTopX} ${cardCenterTopY}`;
        pathOuter.setAttribute('d', pathD);
        pathInner.setAttribute('d', pathD);

        cardEl.style.transform = `translate3d(${cardX - 165}px, ${cardY}px, 0) rotate(${rotationRad}rad)`;

        requestAnimationFrame(renderLoop);
    }

    function onPointerDown(e) {
        isDragging = true;
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;

        startMouseX = clientX;
        startMouseY = clientY;
        startCardX = cardX;
        startCardY = cardY;

        velX = 0;
        velY = 0;
    }

    function onPointerMove(e) {
        if (!isDragging) return;
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;

        const deltaX = clientX - startMouseX;
        const deltaY = clientY - startMouseY;

        const anchorX = container.clientWidth / 2;
        cardX = Math.max(anchorX - 140, Math.min(anchorX + 140, startCardX + deltaX));
        cardY = Math.max(10, Math.min(140, startCardY + deltaY));
    }

    function onPointerUp() {
        isDragging = false;
    }

    cardEl.addEventListener('mousedown', onPointerDown);
    window.addEventListener('mousemove', onPointerMove);
    window.addEventListener('mouseup', onPointerUp);

    cardEl.addEventListener('touchstart', onPointerDown);
    window.addEventListener('touchmove', onPointerMove);
    window.addEventListener('touchend', onPointerUp);

    renderLoop();
}
</script>

</x-app-layout>