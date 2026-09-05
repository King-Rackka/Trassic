<x-app-layout :fullscreen="true">
    <x-slot:title>Verifikasi Email - Trassic</x-slot:title>

    <div class="w-full h-full min-h-[calc(100vh-60px)] flex flex-col items-center justify-center relative bg-[#2F3AFF] px-6 py-12 bg-grid-pattern">
        
        <div class="max-w-md w-full bg-white border-4 border-[#FC00BB] shadow-[8px_8px_0px_#2F3AFF] p-6 sm:p-8 text-left relative font-sans">
            
            <h1 class="font-display text-2xl sm:text-3xl text-[#2F3AFF] uppercase tracking-wide mb-3">
                VERIFIKASI EMAIL
            </h1>

            <p class="text-xs sm:text-sm text-gray-700 font-medium mb-6 leading-relaxed">
                Terima kasih telah mendaftar! Sebelum mulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan? Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan ulang.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 bg-[#D9FC28] text-[#2F3AFF] text-xs font-bold px-4 py-2.5 border-2 border-[#2F3AFF]">
                    Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.
                </div>
            @endif

            <div class="space-y-3 pt-2">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                            class="w-full bg-[#D9FC28] text-[#2F3AFF] hover:bg-[#FC00BB] hover:text-[#D9FC28] border-2 border-[#2F3AFF] font-display text-xs sm:text-sm py-3 transition uppercase tracking-wider cursor-pointer shadow-[4px_4px_0px_#2F3AFF]">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>

                <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs font-bold text-[#FC00BB] hover:underline uppercase">
                            Keluar (Log Out)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>