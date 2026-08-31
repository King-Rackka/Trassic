<div class="w-full bg-grid-pattern min-h-screen py-8 sm:py-12">

    <section class="w-full py-6 sm:py-10 px-4 sm:px-8 max-w-7xl mx-auto text-center relative z-10">
        <h1 class="font-display text-3xl sm:text-5xl text-[#254bfe] uppercase mb-10 sm:mb-14 tracking-normal">
            Karya dengan like terbanyak minggu ini
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 sm:gap-8 max-w-5xl mx-auto items-end">
            @foreach ($topWorks as $i => $work)
                <div class="group relative flex flex-col items-center cursor-pointer transition-transform duration-300 hover:-translate-y-2">
                    
                    {{-- Floating Backdrop Card Pink & Lime --}}
                    <div class="relative w-full aspect-square flex items-center justify-center p-4">
                        <div class="absolute inset-0 bg-[#ff007a] transform -rotate-3 scale-95 group-hover:rotate-0 transition-transform"></div>
                        <div class="absolute inset-0 bg-[#ccff00] transform rotate-3 scale-95 group-hover:rotate-0 transition-transform"></div>
                        
                        {{-- Image Display --}}
                        <div class="relative w-full h-full bg-white p-2 border-2 border-black shadow-[4px_4px_0px_rgba(0,0,0,1)] flex items-center justify-center overflow-hidden">
                            <img src="{{ $work->cover_image ? asset('storage/' . $work->cover_image) : 'https://via.placeholder.com/400x400/eee/999?text=No+Image' }}"
                                 alt="{{ $work->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                    </div>

                    {{-- Work Details --}}
                    <div class="mt-4 text-center">
                        <p class="font-sans text-[#254bfe] font-bold text-sm sm:text-base flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4 fill-[#254bfe]" viewBox="0 0 24 24">
                                <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                            </svg>
                            <span>{{ number_format($work->weekly_likes ?? 0) }} likes</span>
                        </p>
                        <h3 class="font-display text-xl sm:text-2xl text-[#254bfe] uppercase mt-1 leading-tight">
                            #{{ $i + 1 }} {{ $work->title }}
                        </h3>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="w-full relative mt-8 sm:mt-20 mb-16 z-0">

        <div class="w-full explore-banner-bg relative pt-[22%] sm:pt-[180px] pb-16 px-4 sm:px-12">

            <div class="w-full text-center mb-6 sm:mb-8 relative z-10">
                <h2 class="font-display text-2xl sm:text-5xl text-white uppercase tracking-normal drop-shadow-md leading-tight">
                    Hasil karya daur ulang
                </h2>
            </div>

            <div class="flex items-center justify-start sm:justify-center gap-2 overflow-x-auto pb-4 mb-8 sm:mb-10 no-scrollbar px-2 max-w-6xl mx-auto relative z-10">
                <button wire:click="setCategory('')"
                        class="px-3.5 py-1.5 sm:px-5 sm:py-2 border-2 text-xs sm:text-sm font-display uppercase whitespace-nowrap transition-all duration-200
                        {{ $category === '' ? 'bg-[#ff007a] text-[#ccff00] border-white shadow-[2px_2px_0px_rgba(255,255,255,1)]' : 'bg-transparent text-white border-white hover:bg-[#ccff00] hover:text-[#254bfe] hover:border-transparent' }}">
                    Semua
                </button>
                @foreach ($categories as $cat)
                    <button wire:click="setCategory('{{ $cat }}')"
                            class="px-3.5 py-1.5 sm:px-5 sm:py-2 border-2 text-xs sm:text-sm font-display uppercase whitespace-nowrap transition-all duration-200
                            {{ $category === $cat ? 'bg-[#ff007a] text-[#ccff00] border-white shadow-[2px_2px_0px_rgba(255,255,255,1)]' : 'bg-transparent text-white border-white hover:bg-[#ccff00] hover:text-[#254bfe] hover:border-transparent' }}">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6 max-w-7xl mx-auto px-1 sm:px-6 relative z-10" wire:loading.class="opacity-60">
                @forelse ($works as $work)
                    @php
                        $displayQuantity = $category ? $work->quantityForMaterial($category) : $work->quantityForMaterial();
                    @endphp
                    <div class="group relative flex flex-col justify-between transition-transform duration-200 hover:-translate-y-2 p-1 w-full">
                        
                        <a href="{{ route('work.show', $work->slug) }}" class="block w-full">
                            {{-- BINGKAI FOTO DENGAN RATING 1:1 SERAGAM --}}
                            <div class="relative w-full aspect-square bg-gray-900 border-2 border-[#ff007a] shadow-[3px_3px_0px_rgba(0,0,0,1)]">
                                
                                {{-- 4 KOTAK KUNING PRESISI DI 4 POJOK SUDUT LUAR --}}
                                <div class="absolute -top-1.5 -left-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                                <div class="absolute -top-1.5 -right-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                                <div class="absolute -bottom-1.5 -left-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                                <div class="absolute -bottom-1.5 -right-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>

                                {{-- BADGE SAMPAH TERPAKAI --}}
                                @if ($displayQuantity > 0)
                                    <div class="absolute top-2 left-2 z-30 bg-[#ccff00] text-[#254bfe] border border-black font-sans text-[7px] sm:text-[10px] font-extrabold px-1.5 sm:px-2 py-0.5 uppercase tracking-tight shadow-[1px_1px_0px_rgba(0,0,0,1)]">
                                        {{ $displayQuantity }}kg sampah terpakai
                                    </div>
                                @endif

                                {{-- GAMBAR TER-CROP SEHINGGA TINGGI DAN LEBAR 100% PERSIS --}}
                                <div class="w-full h-full overflow-hidden flex items-center justify-center">
                                    @if ($work->cover_image)
                                        <img src="{{ asset('storage/' . $work->cover_image) }}"
                                             alt="{{ $work->title }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-bold font-sans">No Image</div>
                                    @endif
                                </div>
                            </div>
                        </a>

                        {{-- DETAIL TEKS DI BAWAH BINGKAI --}}
                        <div class="mt-2.5 sm:mt-3 text-center w-full">
                            <h4 class="font-display text-xs sm:text-base text-white truncate uppercase leading-tight tracking-wide">
                                {{ $work->title }}
                            </h4>
                            <p class="font-sans text-[9px] sm:text-xs font-normal text-white uppercase mt-0.5 sm:mt-1 truncate">
                                {{ $work->creator->name ?? 'RIMESA 2026' }}
                            </p>
                            <p class="font-sans text-[10px] sm:text-xs font-semibold text-white mt-0.5 sm:mt-1 flex items-center justify-center gap-1">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 fill-white" viewBox="0 0 24 24">
                                    <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                </svg>
                                <span>{{ number_format($work->appreciations_count ?? 0) }} likes</span>
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16 text-white">
                        <p class="font-display text-lg sm:text-xl uppercase tracking-wider">Belum ada karya untuk kategori ini.</p>
                    </div>
                @endforelse
            </div>

            {{-- TOMBOL LIHAT LEBIH BANYAK --}}
            <div class="text-center mt-10 sm:mt-12 pb-4 relative z-10">
                <a href="{{ route('explore.more', ['category' => $category]) }}"
                   class="inline-block text-[#ccff00] font-display text-sm sm:text-xl hover:text-white transition uppercase tracking-wider underline underline-offset-4">
                    Lihat lebih banyak →
                </a>
            </div>

        </div>
    </section>
    
    <section class="w-full py-12 px-4 sm:px-8 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8 p-6 sm:p-12 ">
            <div class="space-y-4 text-center md:text-left">
                <h2 class="font-display text-3xl sm:text-5xl text-[#254bfe] uppercase leading-tight">
                    Ingin karyamu ada disini?
                </h2>
                <p class="font-sans text-gray-700 text-sm sm:text-base font-medium max-w-md">
                    Bagikan karya daur ulang kreatifmu dan beri inspirasi bagi komunitas Trassic.
                </p>
                <div>
                    <a href="#" class="inline-block bg-[#ff007a] text-[#ccff00] font-display text-base sm:text-lg px-6 sm:px-8 py-3 border-2 border-black hover:bg-[#ccff00] hover:text-[#254bfe] transition uppercase shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                        + Submit your work!
                    </a>
                </div>
            </div>

            <div class="w-44 sm:w-56 bg-white border-2 border-black p-2 relative shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                <div class="absolute -top-1 -left-1 w-2.5 h-2.5 bg-[#ff007a] border border-black"></div>
                <div class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-[#ff007a] border border-black"></div>
                <div class="w-full aspect-square bg-gray-200 border border-black flex items-center justify-center">
                    <span class="font-display text-3xl text-gray-400">???</span>
                </div>
                <div class="mt-2 text-center">
                    <p class="font-display text-base text-[#254bfe]">KARYAMU</p>
                    <p class="font-sans text-[10px] text-gray-500 uppercase">JOIN TRASSIC 2026</p>
                </div>
            </div>
        </div>
    </section>

</div>