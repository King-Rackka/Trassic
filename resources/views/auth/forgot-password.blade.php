<x-app-layout :fullscreen="true">
    <x-slot:title>Lupa Password - Trassic</x-slot:title>

    <div class="w-full h-full min-h-[calc(100vh-60px)] flex flex-col items-center justify-center relative bg-[#2F3AFF] px-6 py-12 bg-grid-pattern">
        
        <div class="max-w-md w-full bg-white border-4 border-[#FC00BB] shadow-[8px_8px_0px_#2F3AFF] p-6 sm:p-8 text-left relative font-sans">
            
            <h1 class="font-display text-2xl sm:text-3xl text-[#2F3AFF] uppercase tracking-wide mb-3">
                LUPA PASSWORD
            </h1>

            <p class="text-xs sm:text-sm text-gray-700 font-medium mb-6 leading-relaxed">
                Lupa password? Tidak masalah. Cukup beritahu kami alamat email Anda dan kami akan mengirimkan tautan reset password yang memungkinkan Anda memilih yang baru.
            </p>

            @if (session('status'))
                <div class="mb-4 bg-[#D9FC28] text-[#2F3AFF] text-xs font-bold px-4 py-2.5 border-2 border-[#2F3AFF]">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-[#2F3AFF] text-xs font-extrabold uppercase tracking-wide block mb-1">
                        EMAIL
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="Masukkan email Anda"
                           class="w-full rounded-tl-xl rounded-br-xl border-2 border-[#FC00BB] px-4 py-2.5 text-gray-800 placeholder-gray-400 bg-[#f7f7f7] text-xs sm:text-sm font-medium outline-none focus:ring-2 focus:ring-[#2F3AFF]"
                           required autofocus />
                    @error('email') <p class="text-[#FC00BB] text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full bg-[#D9FC28] text-[#2F3AFF] hover:bg-[#FC00BB] hover:text-[#D9FC28] border-2 border-[#2F3AFF] font-display text-sm sm:text-base py-3 transition uppercase tracking-wider cursor-pointer shadow-[4px_4px_0px_#2F3AFF]">
                        Kirim Tautan Reset Password
                    </button>
                </div>

                <div class="text-center pt-2">
                    <a href="{{ route('login') }}" class="text-xs font-bold text-[#2F3AFF] hover:underline uppercase">
                        ← Kembali ke halaman Masuk
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>