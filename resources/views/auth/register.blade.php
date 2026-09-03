<x-app-layout :fullscreen="true">
    <x-slot:title>Register - Trassic</x-slot:title>

    @push('scripts')
        @viteReactRefresh
        @vite(['resources/js/lanyard-entry.jsx'])
    @endpush

    <div class="w-full flex flex-col lg:flex-row h-full min-h-0 overflow-hidden relative bg-[#2F3AFF]" 
         x-data="{
            name: '',
            email: '',
            password: '',
            passwordConfirmation: '',
            acceptedTerms: false,
            showPassword: false,
            showConfirmPassword: false,
            showLanyardModal: false,

            // Cek apakah seluruh field form registrasi sudah diisi
            get isFormFilled() {
                return this.name.trim() !== '' && 
                       this.email.trim() !== '' && 
                       this.password.trim() !== '' && 
                       this.passwordConfirmation.trim() !== '';
            },

            init() {
                window.addEventListener('terms-toggled', (e) => {
                    this.acceptedTerms = e.detail.acceptedTerms;
                });
            },
            updateLanyard() {
                window.dispatchEvent(new CustomEvent('lanyard-update', {
                    detail: { name: this.name, acceptedTerms: this.acceptedTerms }
                }));
            },
            openModal() {
                this.showLanyardModal = true;
                this.$nextTick(() => {
                    const lanyardEl = document.getElementById('lanyard-react-root');
                    const targetMobile = document.getElementById('lanyard-modal-container');
                    if (lanyardEl && targetMobile) {
                        targetMobile.appendChild(lanyardEl);
                        setTimeout(() => window.dispatchEvent(new Event('resize')), 100);
                    }
                });
            },
            closeModal() {
                this.showLanyardModal = false;
                this.$nextTick(() => {
                    const lanyardEl = document.getElementById('lanyard-react-root');
                    const targetDesktop = document.getElementById('lanyard-desktop-container');
                    if (lanyardEl && targetDesktop) {
                        targetDesktop.appendChild(lanyardEl);
                        setTimeout(() => window.dispatchEvent(new Event('resize')), 100);
                    }
                });
            }
         }">

        {{-- MODAL PREVIEW LANYARD (MOBILE) --}}
        <div x-show="showLanyardModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 lg:hidden"
             x-cloak>
            
            <div class="bg-white w-full max-w-sm h-[75vh] rounded-2xl border-4 border-[#2F3AFF] relative overflow-hidden flex flex-col">
                {{-- Tombol Close --}}
                <button type="button" 
                        @click="closeModal()"
                        class="absolute top-3 right-3 z-50 bg-[#FC00BB] text-white w-8 h-8 rounded-lg font-black text-sm border-2 border-[#2F3AFF] flex items-center justify-center active:scale-95 transition">
                    ✕
                </button>

                {{-- Slot Penampung Lanyard 3D di Modal Mobile --}}
                <div id="lanyard-modal-container" class="w-full h-full bg-grid-pattern relative"></div>

                {{-- NOTIFIKASI MOBILE: TEKS CLEAN DI BAWAH PREVIEW --}}
                <p x-show="isFormFilled && !acceptedTerms"
                   x-transition
                   class="absolute bottom-4 left-0 right-0 text-center font-display text-[11px] text-[#2F3AFF] uppercase tracking-wider z-40 pointer-events-none px-4">
                    Klik ID Card 3D untuk menyetujui syarat!
                </p>
            </div>
        </div>

        {{-- MAIN CONTENT AREA --}}
        <div class="flex-1 flex flex-col lg:flex-row min-h-0 overflow-hidden">

            {{-- LEFT CONTAINER: REACT THREE.JS LANYARD VISUAL (DESKTOP) --}}
            <div class="hidden lg:flex lg:w-1/2 bg-white relative flex-col items-center justify-center overflow-hidden border-r-2 border-[#2F3AFF] bg-grid-pattern h-full"
                 id="lanyard-desktop-container">
                
                {{-- SINGLE ROOT ELEMENT FOR REACT THREE.JS --}}
                <div id="lanyard-react-root" class="w-full h-full cursor-pointer"></div>

                {{-- NOTIFIKASI DESKTOP: TEKS CLEAN MELAYANG RATA TENGAH TANPA GARIS --}}
                <p x-show="isFormFilled && !acceptedTerms"
                   x-transition
                   class="absolute bottom-6 left-0 right-0 text-center font-display text-xs sm:text-sm text-[#2F3AFF] uppercase tracking-wider z-30 pointer-events-none px-4">
                    Klik ID Card 3D untuk menyetujui syarat!
                </p>
            </div>

            {{-- RIGHT CONTAINER: FORM REGISTRASI --}}
            <div class="w-full lg:w-1/2 bg-[#2F3AFF] px-6 sm:px-12 lg:px-16 py-6 flex flex-col justify-center items-center h-full overflow-y-auto relative">

                {{-- TOMBOL KOTAK PREVIEW LANYARD (KHUSUS MOBILE) --}}
                <div class="lg:hidden w-full max-w-md flex justify-between items-center mb-2">
                    <template x-if="isFormFilled && !acceptedTerms">
                        <span class="text-[10px] font-display text-[#FC00BB] bg-[#D9FC28] px-2 py-1 uppercase">
                            Setujui Syarat ID Card!
                        </span>
                    </template>
                    <span x-show="!isFormFilled || acceptedTerms"></span>

                    <button type="button" 
                            @click="openModal()"
                            class="bg-[#D9FC28] hover:bg-[#cbf21d] text-[#2F3AFF] font-display text-xs px-3 py-2 rounded-lg border-2 border-[#2F3AFF] flex items-center gap-1.5 active:scale-95 transition">
                        <svg class="w-4 h-4 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <span>Review</span>
                    </button>
                </div>

                <div class="max-w-md w-full mx-auto space-y-4 sm:space-y-5 my-auto">
                    
                    {{-- JUDUL UTAMA --}}
                    <h1 class="text-2xl sm:text-3xl xl:text-4xl font-display text-[#D9FC28] uppercase tracking-normal text-center mb-2 sm:mb-4">
                        Bergabung dengan kami
                    </h1>

                    <form method="POST" action="{{ route('register') }}" class="space-y-4 sm:space-y-4.5">
                        @csrf
                        <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                        <input type="checkbox" name="terms" :checked="acceptedTerms" class="hidden" required>

                        {{-- NAMA PENGGUNA --}}
                        <div class="space-y-1.5">
                            <label class="text-white text-xs font-extrabold uppercase tracking-wide block">
                                NAMA PENGGUNA
                            </label>
                            <input type="text" name="name" x-model="name" @input="updateLanyard()" maxlength="14"
                                   placeholder="Contoh: Raditya Meyka"
                                   class="w-full rounded-tl-2xl rounded-br-2xl border-2 border-[#FC00BB] px-4 py-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-[#D9FC28] bg-[#f7f7f7] text-xs sm:text-sm font-medium outline-none transition-all"
                                   required autofocus>
                            @error('name') <p class="text-[#D9FC28] text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        {{-- EMAIL --}}
                        <div class="space-y-1.5">
                            <label class="text-white text-xs font-extrabold uppercase tracking-wide block">
                                EMAIL
                            </label>
                            <input type="email" name="email" x-model="email"
                                   placeholder="Contoh: radityameyka5@gmail.com"
                                   class="w-full rounded-tl-2xl rounded-br-2xl border-2 border-[#FC00BB] px-4 py-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-[#D9FC28] bg-[#f7f7f7] text-xs sm:text-sm font-medium outline-none transition-all"
                                   required>
                            @error('email') <p class="text-[#D9FC28] text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div class="space-y-1.5">
                            <label class="text-white text-xs font-extrabold uppercase tracking-wide block">
                                PASSWORD
                            </label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" name="password" x-model="password"
                                       placeholder="Masukkan Password"
                                       class="w-full rounded-tl-2xl rounded-br-2xl border-2 border-[#FC00BB] px-4 py-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-[#D9FC28] bg-[#f7f7f7] text-xs sm:text-sm font-medium pr-11 outline-none transition-all"
                                       required>
                                <button type="button" x-on:click="showPassword = !showPassword"
                                        class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition focus:outline-none">
                                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.962 8.962 0 012.122-.163c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-2.122 2.122A3 3 0 0112 15a3 3 0 01-3-3"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/>
                                    </svg>
                                    <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" x-cloak>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password') <p class="text-[#D9FC28] text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
                        </div>

                        {{-- KONFIRMASI PASSWORD --}}
                        <div class="space-y-1.5">
                            <label class="text-white text-xs font-extrabold uppercase tracking-wide block">
                                KONFIRMASI PASSWORD
                            </label>
                            <div class="relative">
                                <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" x-model="passwordConfirmation"
                                       placeholder="Masukkan Password"
                                       class="w-full rounded-tl-2xl rounded-br-2xl border-2 border-[#FC00BB] px-4 py-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-[#D9FC28] bg-[#f7f7f7] text-xs sm:text-sm font-medium pr-11 outline-none transition-all"
                                       required>
                                <button type="button" x-on:click="showConfirmPassword = !showConfirmPassword"
                                        class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition focus:outline-none">
                                    <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.962 8.962 0 012.122-.163c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-2.122 2.122A3 3 0 0112 15a3 3 0 01-3-3"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/>
                                    </svg>
                                    <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" x-cloak>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full bg-[#D9FC28] text-[#2F3AFF] font-display text-base sm:text-lg py-3 hover:bg-[#cbf21d] transition uppercase tracking-wider mt-6 sm:mt-8 ">
                            Daftar
                        </button>

                        {{-- LINK MASUK --}}
                        <p class="text-center text-white text-xs sm:text-sm pt-2 font-medium">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-bold underline text-[#D9FC28]">Masuk</a>
                        </p>
                    </form>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>