<div x-data="{ 
        show: false,
        triggerAnimation() {
            // Jalankan animasi menyapu
            this.show = true;
            setTimeout(() => {
                this.show = false;
            }, 500);
        },
        init() {
            this.$nextTick(() => { this.triggerAnimation(); });

            window.addEventListener('pageshow', (event) => {
                if (event.persisted) {
                    this.triggerAnimation();
                }
            });

            window.addEventListener('trigger-page-close', () => {
                this.show = true;
            });
        }
     }"
     class="fixed inset-0 z-[100] bg-transparent overflow-hidden select-none pointer-events-none">

    {{-- BACKGROUND STRIPES --}}
    <div class="absolute inset-0 flex flex-col justify-between">
        @for ($i = 0; $i < 10; $i++)
            @php
                $delay = $i * 25; // Speed delay per baris (ms)
            @endphp
            
            <div x-show="show"
                 x-cloak
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-300 transform"
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
</div>