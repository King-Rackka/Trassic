<div class="py-8 sm:py-12">
    <div class="w-full bg-grid-pattern min-h-screen py-8 sm:py-12">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- SECTION 1: KREATOR DENGAN KONTRIBUSI TERTINGGI --}}
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
                            
                            <div class="w-full lg:w-1/2 relative flex justify-center">
                                
                                <div class="group relative w-full max-w-md aspect-[4/3] bg-gray-900 border-4 border-[#ff007a] 
                                            {{ $tiltAnimationClass }} hover:[animation-play-state:paused] transition-all duration-300 hover:scale-105 hover:z-30 cursor-pointer">
                                    
                                    <a href="{{ route('creator.show', $creator->slug) }}">
                                        @if ($creator->profile_image)
                                            <img src="{{ asset('storage/' . $creator->profile_image) }}" 
                                            alt="{{ $creator->name }}" 
                                            class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-[#254bfe] flex items-center justify-center text-[#ccff00] font-display text-2xl uppercase">
                                                {{ $creator->name }}
                                            </div>
                                        @endif   
                                    </a>


                                    <div class="absolute -top-6 {{ $isEven ? '-right-6' : '-left-6' }} z-30 w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-[#ccff00] border-4 border-[#ff007a] flex items-center justify-center transform {{ $isEven ? 'rotate-[6deg]' : '-rotate-[6deg]' }}">
                                        <span class="font-display text-2xl sm:text-3xl text-[#254bfe]">#{{ $rank }}</span>
                                    </div>

                                    <div class="absolute -bottom-4 {{ $isEven ? '-left-3 sm:-left-5' : '-right-3 sm:-right-5' }} z-30 
                                                w-max max-w-full inline-flex items-center justify-center 
                                                bg-[#ccff00] bg-[url('{{ asset('images/garis-kuning.png') }}')] bg-cover bg-center 
                                                border-4 border-[#ff007a] px-1.5 py-0.5 leading-none 
                                                transform {{ $isEven ? 'rotate-[2deg]' : '-rotate-[2deg]' }}">
                                        <span class="font-display text-xl sm:text-3xl lg:text-4xl text-[#254bfe] uppercase tracking-wider whitespace-nowrap truncate px-0.5">
                                            {{ $creator->name }}
                                        </span>
                                    </div>

                                </div>
                            </div>

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
                                            class="px-3.5 py-1 sm:px-4 sm:py-1.5 bg-[#ccff00] hover:bg-[#ff007a] text-[#254bfe] hover:text-[#ccff00] font-display text-[11px] sm:text-xs uppercase border-2 border-black active:translate-y-0.5 transition">
                                        {{ $creator->isFollowedBy(auth()->id()) ? 'Mengikuti' : 'Ikuti' }}
                                    </button>
                                </div>

                                <div class="grid grid-cols-2 gap-3 sm:gap-4 pt-1">
                                    @forelse ($creator->preview_works as $work)
                                        <a href="{{ route('work.show', $work->slug) }}" 
                                           class="group relative aspect-[4/3] bg-gray-900 border-2 border-[#ff007a] block">
                                            
                                            <div class="absolute -top-1.5 -left-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30"></div>
                                            <div class="absolute -top-1.5 -right-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30"></div>
                                            <div class="absolute -bottom-1.5 -left-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30"></div>
                                            <div class="absolute -bottom-1.5 -right-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30"></div>

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

            {{-- SECTION 2: JELAJAHI KREATOR LAINNYA --}}
            <div class="pt-10 sm:pt-16 max-w-7xl mx-auto">
                <h2 class="font-display text-3xl sm:text-5xl text-[#254bfe] uppercase tracking-normal text-center mb-10 sm:mb-16">
                    Jelajahi kreator lainnya
                </h2>

                <div class="space-y-10 sm:space-y-14">
                    @foreach ($creators as $creator)
                        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 lg:gap-8">
                            
                            {{-- KIRI: PROFIL KREATOR --}}
                            <div class="w-full lg:w-[420px] flex items-center gap-4 shrink-0">
                                <a href="{{ route('creator.show', $creator->slug) }}" class="w-24 h-24 sm:w-28 sm:h-28 aspect-square bg-gray-900 border-2 border-black shrink-0 overflow-hidden">
                                    @if ($creator->profile_image)
                                        <img src="{{ asset('storage/' . $creator->profile_image) }}" alt="{{ $creator->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-[#254bfe] text-[#ccff00] font-display flex items-center justify-center text-xl sm:text-2xl">
                                            {{ substr($creator->name, 0, 2) }}
                                        </div>
                                    @endif    
                                </a>

                                <div class="flex-1 min-w-0 space-y-1">
                                    <h3 class="font-display text-xl sm:text-3xl text-[#254bfe] uppercase truncate leading-none">
                                        {{ $creator->name }}
                                    </h3>
                                    <p class="font-sans text-xs sm:text-sm text-[#254bfe] font-medium truncate">
                                        {{ $creator->creator_type ?? 'Riset Mengabdi Desa' }}
                                    </p>
                                    <p class="font-sans text-xs sm:text-sm text-[#254bfe]">
                                        <span class="font-extrabold">{{ number_format($creator->total_likes_sum ?? $creator->published_works_count) }} likes</span> 
                                        <span class="mx-1">|</span> 
                                        Bergabung sejak {{ $creator->created_at->translatedFormat('d F Y') }}
                                    </p>

                                    <div class="pt-1">
                                        <button wire:click="toggleFollow({{ $creator->id }})" 
                                                class="px-4 py-1 bg-[#ccff00] hover:bg-[#ff007a] text-[#254bfe] hover:text-[#ccff00] font-display text-xs sm:text-sm uppercase border border-black active:translate-y-0.5 transition">
                                            {{ $creator->isFollowedBy(auth()->id()) ? 'Mengikuti' : 'Ikuti' }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- KANAN: 3 KARYA DENGAN KOTAK KUNING PADA 4 UJUNG FRAME --}}
                            <div class="w-full lg:flex-1 grid grid-cols-3 gap-3 sm:gap-4">
                                @forelse ($creator->preview_works as $work)
                                    <a href="{{ route('work.show', $work->slug) }}" 
                                       class="group relative aspect-[4/3] bg-gray-900 border-2 border-[#ff007a] block">
                                        
                                        {{-- PERSEGI KUNING PADA 4 UJUNG FRAME --}}
                                        <div class="absolute -top-1.5 -left-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30"></div>
                                        <div class="absolute -top-1.5 -right-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30"></div>
                                        <div class="absolute -bottom-1.5 -left-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30"></div>
                                        <div class="absolute -bottom-1.5 -right-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30"></div>

                                        @if (isset($work->waste_weight) || isset($work->waste_usage_label))
                                            <div class="absolute top-2 left-2 z-20 bg-[#ccff00] border border-black px-2 py-0.5 text-[10px] font-bold text-black font-sans">
                                                {{ $work->waste_usage_label ?? ($work->waste_weight . 'kg sampah terpakai') }}
                                            </div>
                                        @endif

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
                                        <div class="aspect-[4/3] bg-gray-200 border border-gray-400"></div>
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