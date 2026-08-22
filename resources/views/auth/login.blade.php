<x-app-layout :fullscreen="true">
    <x-slot:title>Login - Trassic</x-slot:title>

<div class="w-full flex flex-col lg:flex-row h-full min-h-0 overflow-hidden" x-data="loginForm()">

        {{-- LEFT: Visual Hero Section --}}
        <div class="hidden lg:flex lg:w-1/2 bg-white relative items-center justify-center overflow-hidden border-r-2 border-[#254bfe] bg-grid-pattern h-full">

            {{-- Vector Petir Kiri Atas --}}
            <img src="{{ asset('images/vector/Vector_Login_1.png') }}" 
                 alt="Vector Top Left" 
                 class="absolute -top-[2%] -left-[2%] w-[100%] max-w-[400px] min-w-[240px] h-auto object-contain pointer-events-none z-0">

            {{-- Vector Petir Kanan Bawah --}}
            <img src="{{ asset('images/vector/Vector_Login_2.png') }}" 
                 alt="Vector Bottom Right" 
                 class="absolute bottom-0 -right-[30%] w-[100%] max-w-[400px] min-w-[240px] h-auto object-contain pointer-events-none z-10">

            {{-- Lingkaran Merah-Muda & Kuning (Pojok Kanan Atas) --}}
            <div class="absolute top-6 -right-28 w-52 h-52 xl:w-60 xl:h-60 rounded-full bg-[#ccff00] border-[20px] border-[#ff007a] pointer-events-none z-0"></div>

            {{-- Lingkaran Merah-Muda & Kuning (Pojok Kiri Bawah) --}}
            <div class="absolute -bottom-16 -left-16 w-60 h-60 xl:w-68 xl:h-68 rounded-full bg-[#ccff00] border-[20px] border-[#ff007a] pointer-events-none z-0"></div>

            {{-- Visual utama: Kaleng & Panah Recycle --}}
            <div class="relative z-20 w-[240px] md:w-[320px] xl:w-[420px] h-auto flex items-center justify-center">
                <img src="{{ asset('images/recycle-can.png') }}" 
                     alt="Recycle Can" 
                     class="w-full h-full object-contain drop-shadow-2xl animate-float"
                     onerror="this.style.display='none'; document.getElementById('canFallback').style.display='flex';">

                {{-- Fallback --}}
                <div id="canFallback" class="hidden flex-col items-center justify-center gap-4">
                    <svg class="w-32 h-32 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 4V2h10v2h3v2h-1l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6H4V4h3zm2 0h6V2H9v2z"/>
                    </svg>
                    <p class="text-gray-400 text-sm font-medium text-center">Simpan gambar kaleng di<br><code class="text-xs bg-gray-100 p-1 rounded">public/images/recycle-can.png</code></p>
                </div>
            </div>
        </div>

        {{-- RIGHT: Form Login --}}
        <div class="w-full lg:w-1/2 bg-[#2f3cff] px-6 sm:px-12 lg:px-16 py-6 flex flex-col justify-center h-full overflow-y-auto">

            <div class="max-w-md w-full mx-auto space-y-4 xl:space-y-5">

                <h1 class="text-3xl sm:text-4xl font-display text-[#ccff00] uppercase tracking-normal text-center mb-4">
                    Masuk
                </h1>

                @if (session('status'))
                    <div class="bg-lime-300 text-indigo-900 text-xs font-semibold px-4 py-2.5 rounded-xl">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Google Login --}}
                <a href="{{ route('auth.google') }}"
                   class="w-full flex items-center justify-center gap-3 bg-[#f7f7f7] hover:bg-gray-100 transition text-[#254bfe] font-bold text-xs sm:text-sm py-3 rounded-xl">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Lanjutkan dengan akun google
                </a>

                {{-- Divider --}}
                <div class="flex items-center gap-4 py-1">
                    <div class="flex-1 h-px bg-[#ccff00]"></div>
                    <span class="text-[#ccff00] text-xs font-bold">OR</span>
                    <div class="flex-1 h-px bg-[#ccff00]"></div>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-3.5 xl:space-y-4">
                    @csrf

                    <div class="space-y-1">
                        <label class="text-white text-[10px] font-bold uppercase tracking-wider block">
                            Email
                        </label>
                        <input type="email" name="email"
                               placeholder="Masukkan Email"
                               class="w-full rounded-xl border-0 px-4 py-2.5 sm:py-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-[#ccff00] bg-[#f7f7f7] text-xs sm:text-sm font-medium outline-none"
                               required autofocus>
                        @error('email') <p class="text-pink-300 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-white text-[10px] font-bold uppercase tracking-wider block">
                            Password
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

                    <div class="text-right pt-0.5">
                        <a href="{{ route('password.request') }}" class="text-white text-xs hover:underline font-normal">
                            Lupa password?
                        </a>
                    </div>

                    <button type="submit"
                            class="w-full bg-[#ccff00] text-[#2f3cff] font-display text-xl sm:text-2xl py-2.5 sm:py-3 rounded-2xl hover:bg-lime-300 transition uppercase tracking-wide mt-2 shadow-sm">
                        Masuk
                    </button>

                    <p class="text-center text-white pt-1 font-normal text-xs sm:text-sm">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-bold underline text-[#ccff00]">Daftar</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function loginForm() {
    return {
        showPassword: false
    }
}
</script>

</x-app-layout>