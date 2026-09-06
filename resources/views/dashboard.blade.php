<x-app-layout title="Dashboard - Trassic">
    @if (session('show_welcome_animation'))
        <div x-data="{ 
                show: false,
                init() {
                    // 1. Masuk langsung saat komponen di-render
                    this.$nextTick(() => { this.show = true; });

                    // 2. Tahan selama 2,5 detik lalu keluar ke kanan
                    setTimeout(() => {
                        this.show = false;
                    }, 1500);
                }
             }"
             class="fixed inset-0 z-[100] bg-transparent overflow-hidden select-none pointer-events-none">

            {{-- BACKGROUND STRIPES (MASUK DARI KIRI -> KELUAR KE KANAN PER BARIS) --}}
            <div class="absolute inset-0 flex flex-col justify-between">
                @for ($i = 0; $i < 10; $i++)
                    @php
                        $delay = $i * 60; // Delay berurutan per baris (ms)
                    @endphp
                    
                    <div x-show="show"
                         x-cloak
                         x-transition:enter="transition ease-out duration-500 transform"
                         x-transition:enter-start="-translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transition ease-in duration-500 transform"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="translate-x-full"
                         style="transition-delay: {{ $delay }}ms;"
                         class="h-[10vh] w-full">
                         
                        @if ($i % 2 == 0)
                            {{-- BARIS GENAP --}}
                            <div class="w-full h-full grid grid-cols-2">
                                <div class="w-full h-full bg-gradient-to-r from-[#D9FC28] to-[#FC00BB]"></div>
                                <div class="w-full h-full bg-gradient-to-r from-[#D9FC28] to-[#FC00BB]"></div>
                            </div>
                        @else
                            {{-- BARIS GANJIL --}}
                            <div class="w-full h-full grid grid-cols-[1fr_2fr_1fr]">
                                <div class="w-full h-full bg-gradient-to-r from-[#D9FC28] to-[#FC00BB]"></div>
                                <div class="w-full h-full bg-gradient-to-r from-[#D9FC28] to-[#FC00BB]"></div>
                                <div class="w-full h-full bg-gradient-to-r from-[#D9FC28] to-[#FC00BB]"></div>
                            </div>
                        @endif
                    </div>
                @endfor
            </div>

            {{-- KOTAK TEKS BIRU (IKUT MASUK DARI KIRI & KELUAR KE KANAN) --}}
            <div x-show="show"
                 x-cloak
                 x-transition:enter="transition ease-out duration-500 transform delay-300"
                 x-transition:enter-start="-translate-x-full opacity-0"
                 x-transition:enter-end="translate-x-0 opacity-100"
                 x-transition:leave="transition ease-in duration-400 transform"
                 x-transition:leave-start="translate-x-0 opacity-100"
                 x-transition:leave-end="translate-x-full opacity-0"
                 class="absolute inset-0 flex items-center justify-center z-10 pointer-events-auto">
                 
                <div class="bg-[#254bfe] px-12 sm:px-20 py-6 sm:py-9 flex items-center justify-center">
                    <h1 class="font-display text-2xl sm:text-5xl font-normal text-[#D9FC28] tracking-wider leading-none whitespace-nowrap">
                        Halo, {{ strtoupper(auth()->user()->name ?? 'RADITYA MEYKA') }}
                    </h1>
                </div>
            </div>
        </div>
    @endif

    {{-- KONTEN DASHBOARD UTAMA --}}
    <div class="w-full">
        <livewire:dashboard />
    </div>
</x-app-layout>