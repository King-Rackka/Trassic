<div class="w-full bg-grid-pattern min-h-screen relative flex flex-col justify-between overflow-hidden">

    <style>
        .line-clamp-2-custom {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    {{-- PITA SAYAP VEKTOR ATAS --}}
    <div class="w-full flex justify-between items-start pointer-events-none z-10 pt-0">
        <img src="{{ asset('images/vector/vector_sayap_atas.png') }}" alt="Vector Wing Top Left" class="h-6 sm:h-12 object-contain">
        <img src="{{ asset('images/vector/vector_sayap_atas.png') }}" alt="Vector Wing Top Right" class="h-6 sm:h-12 object-contain -scale-x-100">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20 sm:space-y-28 w-full my-4 flex-1">

        <section class="space-y-8">
            <div class="text-center">
                <h2 class="font-display text-3xl sm:text-5xl lg:text-6xl text-[#2F3AFF] uppercase tracking-normal">
                    Rekomendasi harian
                </h2>
            </div>

            {{-- Filter Kategori --}}
            <div class="flex items-center justify-start sm:justify-center gap-2 overflow-x-auto pb-2 scrollbar-none px-2 max-w-6xl mx-auto">
                <button wire:click="setCategory('')" 
                        class="px-3.5 py-1.5 sm:px-5 sm:py-2 border-2 text-xs sm:text-sm font-display uppercase whitespace-nowrap transition-all duration-200 cursor-pointer
                        {{ $wasteType === '' ? 'bg-[#FC00BB] text-[#D9FC28] border-[#FC00BB]' : 'bg-[#2F3AFF] text-white border-[#FC00BB] hover:bg-[#D9FC28] hover:text-[#2F3AFF]' }}">
                    Semua
                </button>
                @foreach ($categories as $cat)
                    <button wire:click="setCategory('{{ $cat }}')" 
                            class="px-3.5 py-1.5 sm:px-5 sm:py-2 border-2 text-xs sm:text-sm font-display uppercase whitespace-nowrap transition-all duration-200 cursor-pointer
                            {{ $wasteType === $cat ? 'bg-[#FC00BB] text-[#D9FC28] border-[#FC00BB]' : 'bg-[#2F3AFF] text-white border-[#FC00BB] hover:bg-[#D9FC28] hover:text-[#2F3AFF]' }}">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            {{-- Grid Karya (5 Kolom) --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6 items-stretch" wire:loading.class="opacity-60">
                @forelse ($dailyRecommendations as $work)
                    <div class="group relative flex flex-col justify-between transition-transform duration-200 hover:-translate-y-2 p-1 w-full h-full">
                        
                        <a href="{{ route('work.show', $work->slug ?? $work->id) }}" class="block w-full">
                            <div class="relative w-full aspect-square bg-gray-900 border-2 border-[#FC00BB] shrink-0">
                                
                                {{-- 4 Kotak Kuning Lime di Sudut Bingkai --}}
                                <div class="absolute -top-1.5 -left-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                                <div class="absolute -top-1.5 -right-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                                <div class="absolute -bottom-1.5 -left-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                                <div class="absolute -bottom-1.5 -right-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>

                                {{-- Badge Sampah Terpakai --}}
                                @if (isset($work->wasteDna) && $work->wasteDna->sum('quantity') > 0)
                                    <div class="absolute top-2 left-2 z-30 bg-[#D9FC28] text-[#2F3AFF] border border-[#2F3AFF] font-sans text-[7px] sm:text-[10px] font-extrabold px-1.5 sm:px-2 py-0.5 uppercase tracking-tight">
                                        {{ $work->wasteDna->sum('quantity') }}kg sampah terpakai
                                    </div>
                                @endif

                                {{-- Gambar Cover --}}
                                <div class="w-full h-full overflow-hidden flex items-center justify-center">
                                    @if ($work->cover_image)
                                        <img src="{{ asset('storage/' . $work->cover_image) }}" alt="{{ $work->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-bold font-sans">No Image</div>
                                    @endif
                                </div>
                            </div>
                        </a>

                        <div class="mt-2.5 sm:mt-3 flex flex-col justify-between flex-grow text-center w-full">
                            <h4 class="font-display text-xs sm:text-base text-[#2F3AFF] uppercase leading-tight tracking-wide line-clamp-2-custom min-h-[2rem] sm:min-h-[2.5rem]" title="{{ $work->title }}">
                                #{{ $loop->iteration }} {{ $work->title }}
                            </h4>

                            <div class="mt-2 pt-1 border-t border-[#2F3AFF]/10">
                                <p class="font-sans text-[9px] sm:text-xs font-medium text-[#2F3AFF] uppercase truncate">
                                    {{ $work->creator->name ?? 'RIMESA 2026' }}
                                </p>

                                @php $isLiked = auth()->check() ? $work->isAppreciatedBy(auth()->id()) : false; @endphp
                                <button wire:click.prevent="toggleLike({{ $work->id }})" class="font-sans text-[10px] sm:text-xs font-semibold {{ $isLiked ? 'text-[#FC00BB]' : 'text-[#2F3AFF]' }} mt-0.5 flex items-center justify-center gap-1 mx-auto hover:opacity-80 transition cursor-pointer">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 {{ $isLiked ? 'fill-[#FC00BB]' : 'fill-[#2F3AFF]' }}" viewBox="0 0 24 24">
                                        <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                    </svg>
                                    <span>{{ number_format($work->appreciations_count ?? 0) }} likes</span>
                                </button>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full text-center py-16 text-[#2F3AFF]">
                        <p class="font-display text-lg sm:text-xl uppercase tracking-wider">Belum ada rekomendasi karya.</p>
                    </div>
                @endforelse
            </div>

            <div class="text-center pt-4">
                <a href="{{ route('explore.more', ['category' => $wasteType]) }}" class="inline-block text-[#2F3AFF] hover:text-[#FC00BB] font-display text-sm sm:text-xl transition uppercase tracking-wider underline underline-offset-4">
                    Lihat lebih banyak →
                </a>
            </div>
        </section>

        <section class="w-full text-center space-y-12 sm:space-y-16">
            <h2 class="font-display text-3xl sm:text-5xl lg:text-6xl text-[#2F3AFF] uppercase tracking-normal">
                Karya dengan like terbanyak minggu ini
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 sm:gap-12 lg:gap-14 max-w-6xl mx-auto items-end px-2">
                @foreach ($topWorksWeekly as $i => $work)
                    <div class="group relative flex flex-col items-center cursor-pointer w-full max-w-[300px] sm:max-w-[330px] mx-auto">
                        
                        {{-- Kartu Miring Lapis 3 (Pink -> Lime -> White Frame) --}}
                        <div class="relative w-full aspect-square flex items-center justify-center p-3 mb-5">
                            <div class="absolute inset-1.5 bg-[#FC00BB] transform -rotate-3 group-hover:-rotate-8 group-hover:-translate-x-2 transition-all duration-300 ease-out origin-bottom-left"></div>
                            <div class="absolute inset-1.5 bg-[#D9FC28] transform rotate-2 group-hover:rotate-6 transition-all duration-300 ease-out origin-bottom-right"></div>
                            
                            <div class="relative w-full h-full aspect-square bg-white p-2 border-4 border-[#FC00BB] flex items-center justify-center overflow-hidden z-10 shadow-sm transform {{ $i % 2 == 0 ? 'rotate-3' : '-rotate-3' }} group-hover:rotate-0 group-hover:-translate-y-2 transition-all duration-300 ease-out">
                                <a href="{{ route('work.show', $work->slug ?? $work->id) }}" class="w-full h-full block">
                                    <div class="w-full h-full overflow-hidden flex items-center justify-center bg-gray-100">
                                        @if($work->cover_image)
                                            <img src="{{ asset('storage/' . $work->cover_image) }}" alt="{{ $work->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-bold font-sans">No Image</div>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        </div>

                        {{-- Teks Detail Karya --}}
                        <div class="text-center w-full space-y-1.5 mt-2">
                            <p class="font-sans text-xs sm:text-sm font-semibold text-[#2F3AFF] uppercase tracking-wider">
                                {{ $work->creator->name ?? 'RIMESA 2026' }}
                            </p>

                            <p class="font-sans text-[#2F3AFF] font-bold text-xs sm:text-sm flex items-center justify-center gap-1.5">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 fill-[#2F3AFF]" viewBox="0 0 24 24">
                                    <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                </svg>
                                <span>{{ number_format($work->weekly_likes ?? $work->appreciations_count ?? 0) }} likes</span>
                            </p>

                            <h3 class="font-display text-xl sm:text-2xl lg:text-3xl text-[#2F3AFF] uppercase leading-tight line-clamp-2-custom min-h-[3rem]">
                                #{{ $i + 1 }} {{ $work->title }}
                            </h3>
                        </div>

                    </div>
                @endforeach
            </div>
        </section>

        <section class="space-y-10 sm:space-y-14">
            <div class="text-center">
                <h2 class="font-display text-3xl sm:text-5xl text-[#2F3AFF] uppercase tracking-normal">
                    Jelajahi kreator lainnya
                </h2>
            </div>

            <div class="space-y-10 sm:space-y-14">
                @foreach ($exploreCreators as $creator)
                    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 lg:gap-8">
                        
                        {{-- Kiri: Profil & Teks --}}
                        <div class="w-full lg:w-[420px] flex items-center gap-4 shrink-0">
                            <a href="{{ route('creator.show', $creator->slug ?? $creator->id) }}" class="w-24 h-24 sm:w-28 sm:h-28 aspect-square bg-gray-900 border-2 border-[#2F3AFF] shrink-0 overflow-hidden">
                                @if ($creator->profile_image)
                                    <img src="{{ asset('storage/' . $creator->profile_image) }}" alt="{{ $creator->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-[#2F3AFF] text-[#D9FC28] font-display flex items-center justify-center text-xl sm:text-2xl uppercase">
                                        {{ substr($creator->name, 0, 2) }}
                                    </div>
                                @endif    
                            </a>

                            <div class="flex-1 min-w-0 space-y-1">
                                <a href="{{ route('creator.show', $creator->slug ?? $creator->id) }}" class="font-display text-xl sm:text-3xl text-[#2F3AFF] hover:text-[#FC00BB] uppercase truncate block leading-none transition-colors">
                                    {{ $creator->name }}
                                </a>
                                
                                <p class="font-sans text-xs sm:text-sm text-[#2F3AFF] font-medium truncate">
                                    {{ $creator->creator_type ?? 'Riset Mengabdi Desa' }}
                                </p>

                                <p class="font-sans text-xs sm:text-sm text-[#2F3AFF]">
                                    <span class="font-extrabold">{{ number_format($creator->total_likes_count ?? $creator->totalInteractions()) }} likes</span>
                                    <span class="mx-1 opacity-50">|</span> 
                                    Bergabung sejak {{ $creator->created_at ? $creator->created_at->format('d F Y') : '17 Agustus 2026' }}
                                </p>

                                <div class="pt-1">
                                    <button wire:click="toggleFollow({{ $creator->id }})" 
                                            class="px-4 py-1 bg-[#D9FC28] hover:bg-[#FC00BB] text-[#2F3AFF] hover:text-[#D9FC28] font-display text-xs sm:text-sm uppercase active:translate-y-0.5 transition">
                                        {{ $creator->isFollowedBy(auth()->id()) ? 'Mengikuti' : 'Ikuti' }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Kanan: Grid 3 Karya --}}
                        <div class="w-full lg:flex-1 grid grid-cols-3 gap-3 sm:gap-4">
                            @forelse ($creator->preview_works as $work)
                                <a href="{{ route('work.show', $work->slug ?? $work->id) }}" class="group relative aspect-[4/3] bg-gray-900 border-2 border-[#FC00BB] block">
                                    
                                    {{-- 4 Kotak Kuning Lime --}}
                                    <div class="absolute -top-1.5 -left-1.5 w-2.5 h-2.5 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                                    <div class="absolute -top-1.5 -right-1.5 w-2.5 h-2.5 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                                    <div class="absolute -bottom-1.5 -left-1.5 w-2.5 h-2.5 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                                    <div class="absolute -bottom-1.5 -right-1.5 w-2.5 h-2.5 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>

                                    <div class="w-full h-full overflow-hidden flex items-center justify-center bg-gray-900">
                                        @if ($work->cover_image)
                                            <img src="{{ asset('storage/' . $work->cover_image) }}" alt="{{ $work->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full bg-gray-800 flex items-center justify-center text-xs text-gray-400 font-sans">No Image</div>
                                        @endif
                                    </div>
                                </a>
                            @empty
                                @for ($i = 0; $i < 3; $i++)
                                    <div class="aspect-[4/3] bg-gray-100 border border-[#2F3AFF]"></div>
                                @endfor
                            @endforelse
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="text-center pt-4">
                <a href="{{ route('creators.more') }}" class="inline-block text-[#2F3AFF] hover:text-[#FC00BB] font-display text-sm sm:text-xl transition uppercase tracking-wider underline underline-offset-4">
                    Lihat lebih banyak →
                </a>
            </div>
        </section>

        <section class="space-y-12 sm:space-y-16">
            <div class="text-center">
                <h2 class="font-display text-3xl sm:text-5xl text-[#2F3AFF] uppercase tracking-normal">
                    Kreator dengan kontribusi tertinggi
                </h2>
            </div>

            <div class="space-y-16 sm:space-y-24 max-w-6xl mx-auto">
                @foreach ($topCreators as $index => $creator)
                    @php
                        $rank = $index + 1;
                        $isEven = $rank % 2 === 0;
                        $tiltAnimationClass = $isEven ? 'animate-float-left' : 'animate-float-right';
                        $cSlug = $creator->slug ?? $creator->id;
                    @endphp

                    <div class="flex flex-col {{ $isEven ? 'lg:flex-row-reverse' : 'lg:flex-row' }} items-center justify-between gap-8 lg:gap-14">
                        
                        {{-- Frame Foto Utama + Animasi Melayang + Badge Ranking + Banner Nama --}}
                        <div class="w-full lg:w-1/2 relative flex justify-center">
                            
                            <div class="group relative w-full max-w-md aspect-[4/3] bg-gray-900 border-8 border-[#FC00BB] 
                                        {{ $tiltAnimationClass }} hover:[animation-play-state:paused] transition-all duration-300 hover:scale-105 hover:z-30 cursor-pointer">
                                
                                <a href="{{ route('creator.show', $cSlug) }}" class="block w-full h-full overflow-hidden">
                                    @if ($creator->profile_image)
                                        <img src="{{ asset('storage/' . $creator->profile_image) }}" alt="{{ $creator->name }}" class="w-full h-full object-cover">
                                    @elseif ($creator->cover_image)
                                        <img src="{{ asset('storage/' . $creator->cover_image) }}" alt="{{ $creator->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-[#2F3AFF] flex items-center justify-center text-[#D9FC28] font-display text-3xl uppercase">
                                            {{ $creator->name }}
                                        </div>
                                    @endif   
                                </a>

                                {{-- BADGE RANKING (#1, #2, DSN) --}}
                                <div class="absolute -top-6 {{ $isEven ? '-right-6' : '-left-6' }} z-30 w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-[#D9FC28] border-4 border-[#FC00BB] flex items-center justify-center transform {{ $isEven ? 'rotate-[6deg]' : '-rotate-[6deg]' }}">
                                    <span class="font-display text-2xl sm:text-3xl text-[#2F3AFF]">#{{ $rank }}</span>
                                </div>

                                {{-- BADGE BANNER NAMA KREATOR --}}
                                <div class="absolute -bottom-4 {{ $isEven ? '-left-3 sm:-left-5' : '-right-3 sm:-right-5' }} z-30 
                                            w-max max-w-full inline-flex items-center justify-center 
                                            bg-[#D9FC28] bg-[url('{{ asset('images/garis-kuning.png') }}')] bg-cover bg-center 
                                            border-4 border-[#FC00BB] px-1.5 py-0.5 leading-none 
                                            transform {{ $isEven ? 'rotate-[2deg]' : '-rotate-[2deg]' }}">
                                    <span class="font-display text-xl sm:text-3xl lg:text-4xl text-[#2F3AFF] uppercase tracking-wider whitespace-nowrap truncate px-0.5">
                                        {{ $creator->name }}
                                    </span>
                                </div>

                            </div>
                        </div>

                        {{-- Info Kreator & Grid 4 Karya --}}
                        <div class="w-full lg:w-1/2 space-y-3 sm:space-y-4">
                            <div class="flex flex-wrap items-center justify-between gap-2 pb-1 sm:pb-2">
                                <div>
                                    <p class="font-sans text-[11px] sm:text-xs text-[#2F3AFF] uppercase font-bold tracking-wide">
                                        {{ $creator->creator_type ?? 'Riset Mengabdi Desa' }}
                                    </p>
                                    <p class="font-sans text-xs sm:text-sm font-semibold text-[#2F3AFF]">
                                        <span class="font-extrabold text-sm sm:text-lg">{{ number_format($creator->published_works_count) }}</span> karya 
                                            <span class="mx-1 opacity-50">|</span> 
                                            <span class="font-extrabold text-sm sm:text-lg">{{ number_format($creator->totalInteractions()) }}</span> likes 
                                        <span class="mx-1 opacity-50">|</span> 
                                        Bergabung sejak {{ $creator->created_at ? $creator->created_at->format('d F Y') : '-' }}
                                    </p>
                                </div>

                                <button wire:click="toggleFollow({{ $creator->id }})" 
                                        class="px-4 py-1 bg-[#D9FC28] hover:bg-[#FC00BB] text-[#2F3AFF] hover:text-[#D9FC28] font-display text-xs sm:text-sm uppercase active:translate-y-0.5 transition">
                                    {{ auth()->check() && $creator->isFollowedBy(auth()->id()) ? 'Mengikuti' : 'Ikuti' }}
                                </button>
                            </div>

                            {{-- Grid 4 Preview Karya --}}
                            <div class="grid grid-cols-2 gap-3 sm:gap-4 pt-1">
                                @forelse ($creator->preview_works as $work)
                                    <a href="{{ route('work.show', $work->slug ?? $work->id) }}" class="group relative aspect-[4/3] bg-gray-900 border-2 border-[#FC00BB] block">
                                        
                                        <div class="absolute -top-1.5 -left-1.5 w-2.5 h-2.5 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                                        <div class="absolute -top-1.5 -right-1.5 w-2.5 h-2.5 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                                        <div class="absolute -bottom-1.5 -left-1.5 w-2.5 h-2.5 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                                        <div class="absolute -bottom-1.5 -right-1.5 w-2.5 h-2.5 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>

                                        <div class="w-full h-full overflow-hidden flex items-center justify-center">
                                            @if ($work->cover_image)
                                                <img src="{{ asset('storage/' . $work->cover_image) }}" alt="{{ $work->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                            @else
                                                <div class="w-full h-full bg-gray-800 flex items-center justify-center text-[10px] text-gray-400 font-sans">No Cover</div>
                                            @endif
                                        </div>
                                    </a>
                                @empty
                                    @for ($i = 0; $i < 4; $i++)
                                        <div class="aspect-[4/3] bg-gray-100 border-2 border-[#2F3AFF] flex items-center justify-center text-[10px] text-gray-400 font-sans">No Karya</div>
                                    @endfor
                                @endforelse
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </section>

    </div>

        <section class="w-full my-10 sm:my-16 px-2 sm:px-6">
        <div class="w-full bg-[#D9FC28] rounded-2xl sm:rounded-[32px] p-6 sm:p-10 lg:p-12 flex flex-col md:flex-row items-center justify-between gap-6">
            
            {{-- Sisi Kiri: Teks Utama --}}
            <div class="shrink-0 text-left">
                <h2 class="font-display text-3xl sm:text-5xl lg:text-6xl text-[#2F3AFF] uppercase leading-tight tracking-normal">
                    MULAI TAMBAH<br>KARYAMU DISINI!
                </h2>
            </div>

            {{-- Sisi Tengah: Teks NICE Recycle --}}
            <div class="flex-1 text-center px-4 hidden md:block">
                <p class="font-sans text-xs sm:text-sm lg:text-base font-bold text-[#2F3AFF] leading-snug">
                    NICE Recycle<br>
                    Gallery Art Here
                </p>
            </div>

            {{-- Sisi Kanan: Tombol Panah --}}
            <div class="shrink-0 flex items-center gap-4">
                <p class="font-sans text-xs font-bold text-[#2F3AFF] leading-snug md:hidden text-right">
                    NICE Recycle<br>
                    Gallery Art Here
                </p>

                @auth
                    <a href="{{ route('works.create') }}" 
                    class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 rounded-xl sm:rounded-2xl border-2 sm:border-3 border-[#2F3AFF] flex items-center justify-center text-[#2F3AFF] hover:bg-[#2F3AFF] hover:text-[#D9FC28] transition-all duration-200 cursor-pointer">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 fill-none stroke-current" stroke-width="2.5" viewBox="0 0 24 24">
                            <line x1="7" y1="17" x2="17" y2="7"></line>
                            <polyline points="7 7 17 7 17 17"></polyline>
                        </svg>
                    </a>
                @else
                    <button type="button" 
                            wire:click="$dispatch('show-login-prompt')" 
                            class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 rounded-xl sm:rounded-2xl border-2 sm:border-3 border-[#2F3AFF] flex items-center justify-center text-[#2F3AFF] hover:bg-[#2F3AFF] hover:text-[#D9FC28] transition-all duration-200 cursor-pointer">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 lg:w-12 lg:h-12 fill-none stroke-current" stroke-width="2.5" viewBox="0 0 24 24">
                            <line x1="7" y1="17" x2="17" y2="7"></line>
                            <polyline points="7 7 17 7 17 17"></polyline>
                        </svg>
                    </button>
                @endauth
            </div>

        </div>
    </section>

    {{-- PITA SAYAP VEKTOR BAWAH --}}
    <div class="w-full flex justify-between items-end pointer-events-none z-10 pb-0 mt-8 sm:mt-12">
        <img src="{{ asset('images/vector/vector_sayap_Bawah.png') }}" alt="Vector Wing Bottom Left" class="h-6 sm:h-12 object-contain">
        <img src="{{ asset('images/vector/vector_sayap_Bawah.png') }}" alt="Vector Wing Bottom Right" class="h-6 sm:h-12 object-contain -scale-x-100">
    </div>

</div>