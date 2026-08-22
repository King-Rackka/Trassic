<div>
    {{-- ========================================== --}}
    {{-- SECTION 1: TOP 3 LIKES MINGGU INI --}}
    {{-- ========================================== --}}
    <section class="w-full py-12 px-4 sm:px-8 max-w-7xl mx-auto text-center relative">
        <h1 class="font-display text-3xl sm:text-5xl text-[#254bfe] uppercase mb-12 tracking-normal">
            Karya dengan like terbanyak minggu ini
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 sm:gap-8 max-w-5xl mx-auto items-end">
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
                        {{-- SVG Thumbs Up Biru menggantikan emoji --}}
                        <p class="text-[#254bfe] font-bold text-sm sm:text-base flex items-center justify-center gap-1.5">
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

    {{-- ========================================== --}}
    {{-- SECTION 2: HASIL KARYA DAUR ULANG --}}
    {{-- ========================================== --}}
    <section class="w-full bg-grid-pattern relative pt-12 pb-20 mt-12 border-t-2 border-[#254bfe]">
        
        <div class="w-full flex justify-center -mt-16 mb-8 relative z-20 pointer-events-none">
            <div class="bg-[#ff007a] px-8 py-2 border-2 border-black -rotate-1 shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                <div class="bg-[#ccff00] px-6 py-1 border border-black rotate-2">
                    <span class="font-display text-lg text-[#254bfe] uppercase tracking-wider">FEATURED WORKS</span>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="bg-[#254bfe] border-2 border-black p-6 sm:p-12 shadow-[8px_8px_0px_rgba(0,0,0,1)] relative overflow-hidden">
                
                <h2 class="font-display text-3xl sm:text-5xl text-white uppercase text-center mb-8 tracking-normal">
                    Hasil karya daur ulang
                </h2>

                {{-- Filter Chips --}}
                <div class="flex items-center justify-start sm:justify-center gap-2 overflow-x-auto pb-4 mb-10 no-scrollbar">
                    <button wire:click="setCategory('')"
                            class="px-5 py-2 rounded-full border-2 text-xs sm:text-sm font-bold uppercase whitespace-nowrap transition-all duration-200
                            {{ $category === '' ? 'bg-[#ff007a] text-white border-black shadow-[2px_2px_0px_rgba(0,0,0,1)]' : 'bg-white text-[#254bfe] border-black hover:bg-[#ccff00]' }}">
                        Semua
                    </button>
                    @foreach ($categories as $cat)
                        <button wire:click="setCategory('{{ $cat }}')"
                                class="px-5 py-2 rounded-full border-2 text-xs sm:text-sm font-bold uppercase whitespace-nowrap transition-all duration-200
                                {{ $category === $cat ? 'bg-[#ff007a] text-white border-black shadow-[2px_2px_0px_rgba(0,0,0,1)]' : 'bg-white text-[#254bfe] border-black hover:bg-[#ccff00]' }}">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>

                {{-- Works Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6" wire:loading.class="opacity-60">
                    @forelse ($works as $work)
                        @php
                            $displayQuantity = $category ? $work->quantityForMaterial($category) : $work->quantityForMaterial();
                        @endphp
                        <a href="{{ route('work.show', $work->slug) }}" 
                           class="group relative bg-white border-2 border-black p-2 flex flex-col justify-between transition-transform duration-200 hover:-translate-y-1.5 shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                            
                            {{-- Siku-siku Merah --}}
                            <div class="absolute -top-1 -left-1 w-2.5 h-2.5 bg-[#ff007a] border border-black z-20"></div>
                            <div class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-[#ff007a] border border-black z-20"></div>
                            <div class="absolute -bottom-1 -left-1 w-2.5 h-2.5 bg-[#ff007a] border border-black z-20"></div>
                            <div class="absolute -bottom-1 -right-1 w-2.5 h-2.5 bg-[#ff007a] border border-black z-20"></div>

                            @if ($displayQuantity > 0)
                                <div class="absolute top-3 left-3 z-30 bg-[#ccff00] text-black border border-black text-[9px] font-extrabold px-1.5 py-0.5 uppercase tracking-tight shadow-[1px_1px_0px_rgba(0,0,0,1)]">
                                    {{ $displayQuantity }}kg sampah terpakai
                                </div>
                            @endif

                            <div class="w-full aspect-square bg-gray-100 overflow-hidden border border-black relative">
                                @if ($work->cover_image)
                                    <img src="{{ asset('storage/' . $work->cover_image) }}" 
                                         alt="{{ $work->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-bold">No Image</div>
                                @endif
                            </div>

                            <div class="mt-2 text-center">
                                <h4 class="font-display text-base text-[#254bfe] truncate uppercase leading-tight">
                                    {{ $work->title }}
                                </h4>
                                <p class="text-[11px] font-semibold text-gray-500 uppercase mt-0.5 truncate">
                                    {{ $work->creator->name ?? 'Anonim' }}
                                </p>
                                
                                {{-- SVG Thumbs Up Biru --}}
                                <p class="text-[11px] font-bold text-[#254bfe] mt-1 flex items-center justify-center gap-1">
                                    <svg class="w-3.5 h-3.5 fill-[#254bfe]" viewBox="0 0 24 24">
                                        <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                    </svg>
                                    <span>{{ $work->appreciations_count }} likes</span>
                                </p>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-12 text-white">
                            <p class="font-display text-xl uppercase tracking-wider">Belum ada karya untuk kategori ini.</p>
                        </div>
                    @endforelse
                </div>

                <div class="text-center mt-12">
                    <a href="{{ route('explore.more', ['category' => $category]) }}"
                       class="inline-block bg-[#ccff00] text-[#254bfe] font-display text-lg px-8 py-3 border-2 border-black hover:bg-lime-300 transition uppercase shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                        Lihat lebih banyak →
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================== --}}
    {{-- SECTION 3: CALL TO ACTION --}}
    {{-- ========================================== --}}
    <section class="w-full py-16 px-4 sm:px-8 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8 bg-white border-2 border-black p-8 sm:p-12 shadow-[6px_6px_0px_rgba(0,0,0,1)]">
            <div class="space-y-4 text-center md:text-left">
                <h2 class="font-display text-3xl sm:text-5xl text-[#254bfe] uppercase leading-tight">
                    Ingin karyamu ada disini?
                </h2>
                <p class="text-gray-700 text-base font-medium max-w-md">
                    Bagikan karya daur ulang kreatifmu dan beri inspirasi bagi komunitas Trassic.
                </p>
                <div>
                    <a href="#" class="inline-block bg-[#ff007a] text-white font-display text-lg px-8 py-3 border-2 border-black hover:bg-pink-600 transition uppercase shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                        + Submit your work!
                    </a>
                </div>
            </div>

            <div class="w-48 sm:w-56 bg-white border-2 border-black p-2 relative shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                <div class="absolute -top-1 -left-1 w-2.5 h-2.5 bg-[#ff007a] border border-black"></div>
                <div class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-[#ff007a] border border-black"></div>
                <div class="w-full aspect-square bg-gray-200 border border-black flex items-center justify-center">
                    <span class="font-display text-3xl text-gray-400">???</span>
                </div>
                <div class="mt-2 text-center">
                    <p class="font-display text-base text-[#254bfe]">KARYAMU</p>
                    <p class="text-[10px] text-gray-500 uppercase">JOIN TRASSIC 2026</p>
                </div>
            </div>
        </div>
    </section>
</div>