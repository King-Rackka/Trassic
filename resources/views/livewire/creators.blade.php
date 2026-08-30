<div>
    {{-- BACKGROUND PATTERN UTAMA --}}
    <div class="w-full bg-grid-pattern min-h-screen pt-8 sm:pt-12 pb-8 sm:pb-12">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ========================================== --}}
            {{-- SECTION 1: KREATOR DENGAN KONTRIBUSI TERTINGGI --}}
            {{-- ========================================== --}}
            <div class="mb-16 sm:mb-24">
                <h1 class="font-display text-3xl sm:text-5xl text-[#254bfe] uppercase tracking-normal text-center mb-10 sm:mb-16">
                    Kreator dengan kontribusi tertinggi
                </h1>

                <div class="space-y-16 sm:space-y-24">
                    @foreach ($topCreators as $index => $creator)
                        @php
                            $rank = $index + 1;
                            $isEven = $rank % 2 === 0;
                            $tiltAnimationClass = $isEven ? 'animate-float-left' : 'animate-float-right';
                        @endphp

                        <div class="flex flex-col {{ $isEven ? 'lg:flex-row-reverse' : 'lg:flex-row' }} items-center justify-between gap-8 lg:gap-14">
                            
                            {{-- CARD FOTO PROFILE UTAMA --}}
                            <div class="w-full lg:w-1/2 relative flex justify-center">
                                <div class="group relative w-full max-w-md aspect-[4/3] bg-gray-900 border-4 border-[#ff007a] shadow-[6px_6px_0px_rgba(0,0,0,1)] 
                                            {{ $tiltAnimationClass }} hover:[animation-play-state:paused] transition-all duration-300 hover:scale-105 hover:z-30 cursor-pointer">
                                    
                                    {{-- BADGE RANKING --}}
                                    <div class="absolute -top-6 {{ $isEven ? '-right-6' : '-left-6' }} z-30 w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-[#ccff00] border-4 border-[#ff007a] flex items-center justify-center shadow-[3px_3px_0px_rgba(0,0,0,1)]">
                                        <span class="font-display text-2xl sm:text-3xl text-[#254bfe]">#{{ $rank }}</span>
                                    </div>

                                    {{-- FOTO UTAMA --}}
                                    @if ($creator->profile_image)
                                        <img src="{{ asset('storage/' . $creator->profile_image) }}" 
                                             alt="{{ $creator->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-[#254bfe] flex items-center justify-center text-[#ccff00] font-display text-2xl uppercase">
                                            {{ $creator->name }}
                                        </div>
                                    @endif

                                    {{-- BANNER NAMA --}}
                                    <div class="absolute -bottom-5 {{ $isEven ? '-left-4 sm:-left-6' : '-right-4 sm:-right-6' }} z-30 bg-[#ccff00] border-4 border-[#ff007a] px-4 sm:px-6 py-1.5 shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                                        <span class="font-display text-lg sm:text-2xl text-[#254bfe] uppercase tracking-wider whitespace-nowrap">
                                            {{ $creator->name }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- META INFO & PREVIEW KARYA SECTION 1 --}}
                            <div class="w-full lg:w-1/2 space-y-3 sm:space-y-4">
                                <div class="flex flex-wrap items-center justify-between gap-2 pb-1 sm:pb-2">
                                    <div>
                                        <p class="font-sans text-[11px] sm:text-xs text-[#254bfe] uppercase font-bold tracking-wide">
                                            {{ $creator->creator_type ?? 'Riset Mengabdi Desa' }}
                                        </p>
                                        <p class="font-sans text-xs sm:text-sm font-semibold text-[#254bfe]">
                                            <span class="font-extrabold text-sm sm:text-lg">{{ number_format($creator->total_likes_sum ?? $creator->published_works_count) }}</span> likes 
                                            <span class="mx-1 opacity-50">|</span> 
                                            Bergabung sejak {{ $creator->created_at->translatedFormat('d F Y') }}
                                        </p>
                                    </div>

                                    <button wire:click="toggleFollow({{ $creator->id }})" 
                                            class="px-3.5 py-1 sm:px-4 sm:py-1.5 bg-[#ccff00] hover:bg-[#ff007a] text-[#254bfe] hover:text-[#ccff00] font-display text-[11px] sm:text-xs uppercase border-2 border-black shadow-[2px_2px_0px_rgba(0,0,0,1)] active:translate-y-0.5 transition">
                                        {{ $creator->isFollowedBy(auth()->id()) ? 'Mengikuti' : 'Ikuti' }}
                                    </button>
                                </div>

                                <div class="grid grid-cols-2 gap-3 sm:gap-4 pt-1">
                                    @forelse ($creator->preview_works as $work)
                                        <a href="{{ route('work.show', $work->slug) }}" 
                                           class="group relative aspect-[4/3] bg-gray-900 border-2 border-[#ff007a] shadow-[3px_3px_0px_rgba(0,0,0,1)] block">
                                            
                                            {{-- PERSEGI KUNING PADA 4 UJUNG FRAME (TERPISAH DARI CROPPER GAMBAR) --}}
                                            <div class="absolute -top-1.5 -left-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30"></div>
                                            <div class="absolute -top-1.5 -right-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30"></div>
                                            <div class="absolute -bottom-1.5 -left-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30"></div>
                                            <div class="absolute -bottom-1.5 -right-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30"></div>

                                            {{-- CONTAINER GAMBAR DENGAN OVERFLOW-HIDDEN KHUSUS ANIMASI HOVER --}}
                                            <div class="w-full h-full overflow-hidden flex items-center justify-center">
                                                @if ($work->cover_image)
                                                    <img src="{{ asset('storage/' . $work->cover_image) }}" 
                                                         alt="{{ $work->title }}" 
                                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                @else
                                                    <div class="w-full h-full bg-gray-800 flex items-center justify-center text-[10px] text-gray-400 font-sans">No Cover</div>
                                                @endif
                                            </div>
                                        </a>
                                    @empty
                                        @for ($i = 0; $i < 4; $i++)
                                            <div class="aspect-[4/3] bg-gray-200 border-2 border-gray-400 flex items-center justify-center text-[10px] text-gray-500 font-sans">No Karya</div>
                                        @endfor
                                    @endforelse
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- SECTION 2: JELAJAHI KREATOR LAINNYA (5 KREATOR) --}}
            {{-- ========================================== --}}
            <div class="pt-10 sm:pt-16 max-w-7xl mx-auto">
                <h2 class="font-display text-3xl sm:text-5xl text-[#254bfe] uppercase tracking-normal text-center mb-10 sm:mb-16">
                    Jelajahi kreator lainnya
                </h2>

                <div class="space-y-12 sm:space-y-16">
                    @foreach ($creators as $creator)
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-center gap-6 lg:gap-8">
                            
                            {{-- KIRI: PROFIL KREATOR --}}
                            <div class="w-full md:w-[320px] lg:w-[350px] flex items-center gap-3.5 sm:gap-4 shrink-0">
                                
                            <a href="{{ route('creator.show', $creator->slug) }}" class="w-20 h-20 sm:w-28 sm:h-28 aspect-square bg-gray-900 border-2 border-black shrink-0 overflow-hidden shadow-[3px_3px_0px_rgba(0,0,0,1)]">
                                 @if ($creator->profile_image)
                                        <img src="{{ asset('storage/' . $creator->profile_image) }}" alt="{{ $creator->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-[#254bfe] text-[#ccff00] font-display flex items-center justify-center text-xl sm:text-2xl">
                                            {{ substr($creator->name, 0, 2) }}
                                        </div>
                                    @endif    
                            </a>

                                <div class="flex-1 min-w-0">
                                    <h3 class="font-display text-xl sm:text-2xl text-[#254bfe] uppercase truncate leading-tight">
                                        {{ $creator->name }}
                                    </h3>
                                    <p class="font-sans text-xs sm:text-sm text-[#254bfe] uppercase font-bold truncate mt-1">
                                        {{ $creator->creator_type ?? 'Riset Mengabdi Desa' }}
                                    </p>
                                    <p class="font-sans text-xs sm:text-sm text-[#254bfe] mt-1">
                                        <span class="font-extrabold">{{ number_format($creator->total_likes_sum ?? $creator->published_works_count) }}</span> likes 
                                        <span class="mx-1">|</span> 
                                        Bergabung sejak {{ $creator->created_at->translatedFormat('d F Y') }}
                                    </p>

                                    <button wire:click="toggleFollow({{ $creator->id }})" 
                                            class="mt-2.5 px-4 py-1.5 bg-[#ccff00] hover:bg-[#ff007a] text-[#254bfe] hover:text-[#ccff00] font-display text-xs uppercase border border-black shadow-[2px_2px_0px_rgba(0,0,0,1)] active:translate-y-0.5 transition">
                                        {{ $creator->isFollowedBy(auth()->id()) ? 'Mengikuti' : 'Ikuti' }}
                                    </button>
                                </div>
                            </div>

                            {{-- KANAN: 3 KARYA DENGAN LEBAR PAS & EFEK BORDER AMAN SAAT HOVER --}}
                            <div class="w-full md:flex-1 max-w-[650px] lg:max-w-[720px] grid grid-cols-3 gap-3.5 sm:gap-4 shrink-0">
                                @forelse ($creator->preview_works as $work)
                                    <a href="{{ route('work.show', $work->slug) }}" 
                                       class="group relative aspect-[4/3] bg-gray-900 border-2 sm:border-[3px] border-[#ff007a] shadow-[4px_4px_0px_rgba(0,0,0,1)] block">
                                        
                                        {{-- PERSEGI KUNING PADA 4 UJUNG FRAME (DI LUAR CONTAINER CROPPER) --}}
                                        <div class="absolute -top-1.5 -left-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30"></div>
                                        <div class="absolute -top-1.5 -right-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30"></div>
                                        <div class="absolute -bottom-1.5 -left-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30"></div>
                                        <div class="absolute -bottom-1.5 -right-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30"></div>

                                        {{-- BADGE JUMLAH SAMPAH TERPAKAI --}}
                                        @if (isset($work->waste_weight) || isset($work->waste_usage_label))
                                            <div class="absolute top-2 left-2 z-20 bg-[#ccff00] border border-black px-2 py-0.5 text-[10px] font-bold text-black font-sans shadow-[1px_1px_0px_rgba(0,0,0,1)]">
                                                {{ $work->waste_usage_label ?? ($work->waste_weight . 'kg sampah terpakai') }}
                                            </div>
                                        @endif

                                        {{-- CROPPER UTAMA GAMBAR KARYA (OBJECT-COVER/CONTAIN MIX) --}}
                                        <div class="w-full h-full overflow-hidden flex items-center justify-center bg-gray-900">
                                            @if ($work->cover_image)
                                                <img src="{{ asset('storage/' . $work->cover_image) }}" 
                                                     alt="{{ $work->title }}" 
                                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                            @else
                                                <div class="w-full h-full bg-gray-800 flex items-center justify-center text-xs text-gray-400 font-sans">No Image</div>
                                            @endif
                                        </div>
                                    </a>
                                @empty
                                    @for ($i = 0; $i < 3; $i++)
                                        <div class="aspect-[4/3] bg-gray-100 border border-gray-300"></div>
                                    @endfor
                                @endforelse
                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- TOMBOL LIHAT LEBIH BANYAK --}}
                <div class="mt-14 sm:mt-20 mb-10 sm:mb-16 text-center">
                    <a href="{{ route('creators.more') }}" class="inline-flex items-center gap-2 font-display text-lg sm:text-2xl text-[#254bfe] hover:text-[#ff007a] uppercase tracking-wider transition-colors">
                        <span>Lihat lebih banyak</span>
                        <span class="text-xl sm:text-2xl">→</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>