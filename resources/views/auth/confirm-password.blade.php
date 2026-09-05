<x-app-layout :fullscreen="true">
    <x-slot:title>Konfirmasi Password - Trassic</x-slot:title>

    <div class="w-full h-full min-h-[calc(100vh-60px)] flex flex-col items-center justify-center relative bg-[#2F3AFF] px-6 py-12 bg-grid-pattern">
        
        <div class="max-w-md w-full bg-white border-4 border-[#FC00BB] shadow-[8px_8px_0px_#2F3AFF] p-6 sm:p-8 text-left relative font-sans">
            
            <h1 class="font-display text-xl sm:text-2xl text-[#2F3AFF] uppercase tracking-wide mb-3">
                AREA AMAN
            </h1>

            <p class="text-xs sm:text-sm text-gray-700 font-medium mb-6 leading-relaxed">
                Ini adalah area aman aplikasi. Harap konfirmasikan password Anda sebelum melanjutkan.
            </p>

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-[#2F3AFF] text-xs font-extrabold uppercase tracking-wide block mb-1">
                        PASSWORD
                    </label>
                    <input type="password" name="password"
                           placeholder="Masukkan password Anda"
                           class="w-full rounded-tl-xl rounded-br-xl border-2 border-[#FC00BB] px-4 py-2.5 text-gray-800 bg-[#f7f7f7] text-xs sm:text-sm font-medium outline-none"
                           required autocomplete="current-password" />
                    @error('password') <p class="text-[#FC00BB] text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full bg-[#D9FC28] text-[#2F3AFF] hover:bg-[#FC00BB] hover:text-[#D9FC28] border-2 border-[#2F3AFF] font-display text-sm sm:text-base py-3 transition uppercase tracking-wider cursor-pointer shadow-[4px_4px_0px_#2F3AFF]">
                        Konfirmasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>