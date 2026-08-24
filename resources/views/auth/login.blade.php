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
<div class="w-full lg:w-1/2 bg-[#3143ff] px-6 sm:px-12 lg:px-16 py-8 flex flex-col justify-center items-center min-h-full overflow-y-auto">

    <div class="max-w-md w-full mx-auto space-y-4 xl:space-y-5 my-auto">

        <h1 class="text-4xl sm:text-5xl font-black text-[#ccff00] uppercase tracking-wider text-center mb-6">
            Masuk
        </h1>

        @if (session('status'))
            <div class="bg-[#ccff00] text-[#3143ff] text-xs font-bold px-4 py-2.5 rounded-xl text-center">
                {{ session('status') }}
            </div>
        @endif

        {{-- Google Login Button (Ikon & Teks Warna Biru) --}}
        <a href="{{ route('auth.google') }}"
           class="w-full flex items-center justify-center gap-3 bg-[#f7f7f7] hover:bg-white transition text-[#3143ff] font-bold text-xs sm:text-sm py-3 px-4 rounded-xl shadow-sm border border-transparent">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0 fill-[#3143ff]" viewBox="0 0 24 24">
                <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"/>
            </svg>
            <span>Lanjutkan dengan akun google</span>
        </a>

        {{-- Guest Login Button --}}
        <a href="{{ url('/') }}"
           class="w-full flex items-center justify-center gap-3 bg-[#f7f7f7] hover:bg-white transition text-[#3143ff] font-bold text-xs sm:text-sm py-3 px-4 rounded-xl shadow-sm border border-transparent">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0 fill-[#3143ff]" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
            <span>Lanjutkan sebagai guest</span>
        </a>

        {{-- Divider --}}
        <div class="flex items-center gap-4 py-2">
            <div class="flex-1 h-[2px] bg-[#ccff00]"></div>
            <span class="text-[#ccff00] text-xs font-black tracking-widest">OR</span>
            <div class="flex-1 h-[2px] bg-[#ccff00]"></div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div class="space-y-1.5">
                <label class="text-white text-xs sm:text-sm font-extrabold uppercase tracking-wide block">
                    Email
                </label>
                <input type="email" name="email"
                       placeholder="Masukkan Email"
                       class="w-full rounded-tl-2xl rounded-br-2xl border-2 border-[#ff007a] px-4 py-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-[#ccff00] bg-[#f7f7f7] text-xs sm:text-sm font-medium outline-none transition-all"
                       required autofocus>
                @error('email') <p class="text-pink-300 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            {{-- Input Password --}}
            <div class="space-y-1.5">
                <label class="text-white text-xs sm:text-sm font-extrabold uppercase tracking-wide block">
                    PASSWORD
                </label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="password"
                           placeholder="Masukkan Password"
                           class="w-full rounded-tl-2xl rounded-br-2xl border-2 border-[#ff007a] px-4 py-3 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-[#ccff00] bg-[#f7f7f7] text-xs sm:text-sm font-medium pr-11 outline-none transition-all"
                           required>
                    
                    {{-- Ikon Mata (Logika sudah diperbaiki) --}}
                    <button type="button" x-on:click="showPassword = !showPassword"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition focus:outline-none">
                        {{-- Saat Password Tersembunyi -> Tampilkan Mata Dicoret --}}
                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.962 8.962 0 012.122-.163c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m-2.122 2.122A3 3 0 0112 15a3 3 0 01-3-3"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/>
                        </svg>
                        {{-- Saat Password Terbuka -> Tampilkan Mata Terbuka --}}
                        <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                @error('password') <p class="text-pink-300 text-xs mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            {{-- Lupa Password --}}
            <div class="text-right pt-1">
                <a href="{{ route('password.request') }}" class="text-white text-xs hover:underline font-semibold">
                    Lupa password?
                </a>
            </div>

            {{-- Submit Button --}}
            <button type="submit"
                    class="w-full bg-[#ccff00] text-[#3143ff] font-extrabold text-lg sm:text-xl py-3 hover:bg-[#b8e600] transition uppercase tracking-wider mt-3 shadow-md">
                Masuk
            </button>

            {{-- Register Link --}}
            <p class="text-center text-white pt-2 font-medium text-xs sm:text-sm">
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