<div class="w-full bg-grid-pattern min-h-screen py-8 sm:py-12">

    <style>
        .line-clamp-2-custom {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        /* Memastikan judul tidak dipaksa kapital oleh font atau helper lain */
        .normal-case-title {
            text-transform: none !important;
        }
    </style>
    
    {{-- Section 1: Top Works --}}
    <section class="w-full py-8 sm:py-12 px-6 sm:px-12 lg:px-[80px] max-w-[1440px] mx-auto text-center relative z-10">
        
        <h1 class="font-display text-3xl sm:text-5xl lg:text-6xl text-[#2F3AFF] normal-case-title mb-16 sm:mb-20 tracking-normal" style="text-transform: none !important;">
            Karya dengan like terbanyak minggu ini
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 sm:gap-12 lg:gap-14 max-w-6xl mx-auto items-end px-2">
            @foreach ($topWorks as $i => $work)
                <div class="group relative flex flex-col items-center cursor-pointer w-full max-w-[300px] sm:max-w-[330px] mx-auto">
                    
                    <div class="relative w-full aspect-square flex items-center justify-center p-3 mb-5">
                        <div class="absolute inset-1.5 bg-[#FC00BB] transform -rotate-3 group-hover:-rotate-8 group-hover:-translate-x-2 transition-all duration-300 ease-out origin-bottom-left"></div>
                        <div class="absolute inset-1.5 bg-[#D9FC28] transform rotate-2 group-hover:rotate-6 transition-all duration-300 ease-out origin-bottom-right"></div>
                        
                        <div class="relative w-full h-full aspect-square bg-white p-2 border-4 border-[#FC00BB] flex items-center justify-center overflow-hidden z-10 shadow-sm transform {{ $i % 2 == 0 ? 'rotate-3' : '-rotate-3' }} group-hover:rotate-0 group-hover:-translate-y-2 transition-all duration-300 ease-out">
                            <a href="{{ route('work.show', $work->slug) }}" class="block w-full">
                                <div class="w-full h-full overflow-hidden flex items-center justify-center bg-gray-100">
                                    <img src="{{ $work->cover_image ? asset('storage/' . $work->cover_image) : 'https://via.placeholder.com/400x400/eee/999?text=No+Image' }}"
                                         alt="{{ $work->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="text-center w-full space-y-1.5 mt-2">
                        <p class="font-sans text-xs sm:text-sm font-semibold text-[#2F3AFF] tracking-wider">
                            {{ $work->creator->name ?? 'RIMESA 2026' }}
                        </p>

                        <p class="font-sans text-[#2F3AFF] font-bold text-xs sm:text-sm flex items-center justify-center gap-1.5">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 fill-[#2F3AFF]" viewBox="0 0 24 24">
                                <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                            </svg>
                            <span>{{ number_format($work->weekly_likes ?? 0) }} likes</span>
                        </p>

                        <h3 class="font-display text-xl sm:text-2xl lg:text-3xl text-[#2F3AFF] normal-case-title leading-tight line-clamp-2-custom min-h-[3rem]" style="text-transform: none !important;">
                            #{{ $i + 1 }} {{ $work->title }}
                        </h3>
                    </div>

                </div>
            @endforeach
        </div>
    </section>

    {{-- Section 2: Explore / Hasil Karya --}}
    <section class="w-full relative mt-8 sm:mt-20 mb-16 z-0">

        <div class="w-full explore-banner-bg relative pt-[22%] sm:pt-[180px] pb-16 px-6 sm:px-12 lg:px-[80px]">

            <div class="w-full text-center mb-6 sm:mb-8 relative z-10">
                <h2 class="font-display text-2xl sm:text-4xl text-white normal-case-title tracking-normal drop-shadow-md leading-tight" style="text-transform: none !important;">
                    Hasil karya daur ulang
                </h2>
            </div>

            {{-- FILTER KATEGORI --}}
            <div class="flex items-center justify-start sm:justify-center gap-2 overflow-x-auto pb-4 mb-8 sm:mb-10 no-scrollbar px-2 max-w-6xl mx-auto relative z-10">
                <button wire:click="setCategory('')"
                        class="px-3.5 py-1.5 sm:px-5 sm:py-2 border-2 text-xs sm:text-sm font-display whitespace-nowrap transition-all duration-200
                        {{ $category === '' ? 'bg-[#FC00BB] text-[#D9FC28] border-[#FC00BB]' : 'bg-transparent text-white border-[#FC00BB] hover:bg-[#D9FC28] hover:text-[#2F3AFF] hover:border-transparent' }}">
                    Semua
                </button>
                @foreach ($categories as $cat)
                    <button wire:click="setCategory('{{ $cat }}')"
                            class="px-3.5 py-1.5 sm:px-5 sm:py-2 border-2 text-xs sm:text-sm font-display whitespace-nowrap transition-all duration-200
                            {{ $category === $cat ? 'bg-[#FC00BB] text-[#D9FC28] border-[#FC00BB]' : 'bg-transparent text-white border-[#FC00BB] hover:bg-[#D9FC28] hover:text-[#2F3AFF] hover:border-transparent' }}">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            {{-- GRID CARDS HASIL KARYA --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6 max-w-7xl mx-auto px-1 sm:px-6 relative z-10" wire:loading.class="opacity-60">
                @forelse ($works as $work)
                    @php
                        $displayQuantity = $category ? $work->quantityForMaterial($category) : $work->quantityForMaterial();
                    @endphp
                    <div class="group relative flex flex-col justify-between transition-transform duration-200 hover:-translate-y-2 p-1 w-full h-full">
                        
                        <a href="{{ route('work.show', $work->slug) }}" class="block w-full">
                            <div class="relative w-full aspect-square bg-gray-900 border-2 border-[#FC00BB]">
                                <div class="absolute -top-1.5 -left-1.5 w-3 h-3 bg-[#D9FC28] border-2 border-[#FC00BB] z-30 pointer-events-none"></div>
                                <div class="absolute -top-1.5 -right-1.5 w-3 h-3 bg-[#D9FC28] border-2 border-[#FC00BB] z-30 pointer-events-none"></div>
                                <div class="absolute -bottom-1.5 -left-1.5 w-3 h-3 bg-[#D9FC28] border-2 border-[#FC00BB] z-30 pointer-events-none"></div>
                                <div class="absolute -bottom-1.5 -right-1.5 w-3 h-3 bg-[#D9FC28] border-2 border-[#FC00BB] z-30 pointer-events-none"></div>

                                @if ($displayQuantity > 0)
                                    <div class="absolute top-2 left-2 z-30 bg-[#D9FC28] text-[#2F3AFF] border border-[#2F3AFF] font-sans text-[7px] sm:text-[10px] font-extrabold px-1.5 sm:px-2 py-0.5 uppercase tracking-tight">
                                        {{ $displayQuantity }}kg sampah terpakai
                                    </div>
                                @endif

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

                        <div class="mt-2.5 sm:mt-3 flex flex-col justify-between flex-grow text-center w-full">
                            <h4 class="font-display text-xs sm:text-base text-white normal-case-title leading-tight tracking-wide line-clamp-2-custom min-h-[2rem] sm:min-h-[2.5rem]" title="{{ $work->title }}" style="text-transform: none !important;">
                                {{ $work->title }}
                            </h4>

                            <div class="mt-2 pt-1 border-t border-white/10">
                                <p class="font-sans text-[9px] sm:text-xs font-normal text-white truncate">
                                    {{ $work->creator->name ?? 'RIMESA 2026' }}
                                </p>

                                @php
                                    $isLiked = auth()->check() ? $work->isAppreciatedBy(auth()->id()) : false;
                                @endphp
                                <button wire:click.prevent="toggleLike({{ $work->id }})"
                                        class="font-sans text-[10px] sm:text-xs font-semibold {{ $isLiked ? 'text-[#D9FC28]' : 'text-white' }} mt-0.5 flex items-center justify-center gap-1 mx-auto hover:opacity-80 transition">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 {{ $isLiked ? 'fill-[#D9FC28]' : 'fill-white' }}" viewBox="0 0 24 24">
                                        <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                    </svg>
                                    <span>{{ number_format($work->appreciations_count ?? 0) }} likes</span>
                                </button>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full text-center py-16 text-white">
                        <p class="font-display text-lg sm:text-xl tracking-wider">Belum ada karya untuk kategori ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-10 sm:mt-12 pb-4 relative z-10">
                <a href="{{ route('explore.more', ['category' => $category]) }}"
                   class="inline-block text-[#D9FC28] font-display text-sm sm:text-xl hover:text-white transition tracking-wider underline underline-offset-4">
                    Lihat lebih banyak →
                </a>
            </div>

        </div>
    </section>
    
    {{-- Section 3: CTA Submit --}}
    <section class="w-full py-12 sm:py-20 px-6 sm:px-12 lg:px-[80px] max-w-[1440px] mx-auto">
        <div class="flex flex-col md:flex-row items-center justify-between gap-10 sm:gap-16">
            
            <div class="flex flex-col items-center justify-center text-center flex-1 space-y-6">
                <h2 class="font-display text-4xl sm:text-6xl text-[#2F3AFF] normal-case-title leading-tight tracking-tight" style="text-transform: none !important;">
                    Ingin karyamu ada disini?
                </h2>
                
                <div class="flex justify-center w-full">
                    @auth
                        <a href="{{ route('works.create') }}" 
                        class="inline-flex items-center justify-center bg-[#FC00BB] text-[#D9FC28] font-display text-base sm:text-xl px-8 sm:px-10 py-3.5 hover:bg-[#D9FC28] hover:text-[#2F3AFF] transition duration-200 tracking-wide cursor-pointer">
                            + Submit your work!
                        </a>
                    @else
                        <button @click="$dispatch('show-login-prompt')" 
                                type="button"
                                class="inline-flex items-center justify-center bg-[#FC00BB] text-[#D9FC28] font-display text-base sm:text-xl px-8 sm:px-10 py-3.5 hover:bg-[#D9FC28] hover:text-[#2F3AFF] transition duration-200 tracking-wide cursor-pointer">
                            + Submit your work!
                        </button>
                    @endauth
                </div>
            </div>

            <div class="w-64 sm:w-72 bg-[#F9F9F9] border-2 sm:border-3 border-[#FC00BB] p-4 relative shadow-[6px_6px_0px_#2F3AFF] shrink-0">
                <div class="relative w-full aspect-square bg-[#E5E5E5] border-2 border-[#FC00BB] flex items-center justify-center">
                    <div class="absolute -top-1.5 -left-1.5 w-3 h-3 bg-[#2F3AFF] z-20 pointer-events-none"></div>
                    <div class="absolute -top-1.5 -right-1.5 w-3 h-3 bg-[#2F3AFF] z-20 pointer-events-none"></div>
                    <div class="absolute -bottom-1.5 -left-1.5 w-3 h-3 bg-[#2F3AFF] z-20 pointer-events-none"></div>
                    <div class="absolute -bottom-1.5 -right-1.5 w-3 h-3 bg-[#2F3AFF] z-20 pointer-events-none"></div>

                    <div class="absolute top-2 left-2 bg-[#D9FC28] text-[#2F3AFF] text-[10px] font-sans font-extrabold px-1.5 py-0.5 z-10">
                        ??kg terpakai
                    </div>
                </div>

                <div class="text-center space-y-2 py-1">
                    <h4 class="font-display text-3xl text-[#2F3AFF]">???</h4>
                    
                    <p class="font-sans text-xs text-[#2F3AFF] font-medium tracking-wide">
                        who is the creator ???
                    </p>
                    
                    <p class="font-sans text-xs text-[#2F3AFF] font-bold flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5 fill-[#2F3AFF]" viewBox="0 0 24 24">
                            <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                        </svg>
                        <span>???K likes</span>
                    </p>
                </div>
            </div>

        </div>
    </section>

</div>