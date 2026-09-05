<div class="w-full bg-grid-pattern min-h-screen relative flex flex-col justify-between overflow-hidden">
    
    {{-- 1. PITA SAYAP VEKTOR ATAS --}}
    <div class="w-full flex justify-between items-start pointer-events-none z-10 pt-0">
        <img src="{{ asset('images/vector/vector_sayap_atas.png') }}" alt="Vector Wing Top Left" class="h-6 sm:h-12 object-contain">
        <img src="{{ asset('images/vector/vector_sayap_atas.png') }}" alt="Vector Wing Top Right" class="h-6 sm:h-12 object-contain -scale-x-100">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12 sm:space-y-16 w-full my-4 flex-1">
        
        @if (strlen($query) >= 2)

            @php
            $previousUrl = url()->previous();
            
            $fromLabel = 'BERANDA';
            $fromRoute = url('/');

            if (str_contains($previousUrl, route('explore'))) {
                $fromLabel = 'EXPLORE';
                $fromRoute = route('explore');
            } elseif (str_contains($previousUrl, route('creators'))) {
                $fromLabel = 'CREATORS';
                $fromRoute = route('creators');
            } elseif (str_contains($previousUrl, 'waste-impact') || str_contains($previousUrl, 'waste')) {
                $fromLabel = 'WASTE & IMPACT';
                $fromRoute = Route::has('waste-impact') ? route('waste-impact') : url('/');
            } elseif (str_contains($previousUrl, 'about')) {
                $fromLabel = 'ABOUT';
                $fromRoute = route('about');
            }
        @endphp
        
        <div class="flex items-center gap-2 text-xs sm:text-sm font-sans uppercase tracking-[0.15em] border-b border-[#2F3AFF]/10 pb-4 mb-6">
            <a href="{{ $fromRoute }}" class="text-[#2F3AFF] hover:text-[#FC00BB] transition-colors font-bold">
                {{ $fromLabel }}
            </a>
            
            <span class="text-[#2F3AFF]/40">/</span>

            <span class="text-[#2F3AFF] font-bold">
                SEARCH
            </span>

            <span class="text-[#2F3AFF]/40">/</span>
            
            <span class="text-[#FC00BB] font-extrabold tracking-wider truncate max-w-[200px] sm:max-w-none">
                {{ strtoupper($query) }}
            </span>
        </div>

            <section class="space-y-6">
                <h2 class="font-display text-2xl sm:text-4xl text-[#2F3AFF] uppercase tracking-wide">
                    Hasil karya pencarian ‘{{ $query }}’
                </h2>

                @if ($works->isNotEmpty())
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-6 items-stretch">
                        @foreach ($works as $work)
                            <div class="group relative flex flex-col justify-between transition-transform duration-200 hover:-translate-y-2 p-1 w-full h-full">
                
                            <a href="{{ route('work.show', $work->slug) }}" class="block w-full">
                                <div class="relative w-full aspect-square bg-gray-900 border-2 border-[#FC00BB] shrink-0">
                                    
                                    <div class="absolute -top-1.5 -left-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                                    <div class="absolute -top-1.5 -right-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                                    <div class="absolute -bottom-1.5 -left-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                                    <div class="absolute -bottom-1.5 -right-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>

                                    @php
                                        $totalWaste = isset($work->wasteDna) ? $work->wasteDna->sum('quantity') : ($work->waste_used ?? 0);
                                    @endphp
                                    @if($totalWaste > 0)
                                        <div class="absolute top-1.5 left-1.5 z-30 bg-[#D9FC28] text-[#2F3AFF] border border-[#2F3AFF] font-sans text-[8px] sm:text-[10px] font-extrabold px-1.5 py-0.5 uppercase tracking-tight">
                                            {{ number_format($totalWaste, 2) }}KG SAMPAH TERPAKAI
                                        </div>
                                    @endif

                                    {{-- GAMBAR COVER --}}
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
                                
                                <h4 class="font-display text-xs sm:text-base text-[#2F3AFF] uppercase leading-tight tracking-wide line-clamp-2-custom min-h-[2rem] sm:min-h-[2.5rem]" title="#{{ $loop->iteration }} {{ $work->title }}">
                                    {{ $work->title }}
                                </h4>

                                <div class="mt-2 pt-1 border-t border-[#2F3AFF]/10">
                                    <p class="font-sans text-[9px] sm:text-xs font-medium text-[#2F3AFF] uppercase truncate">
                                        {{ $work->creator->name ?? 'RIMESA 2026' }}
                                    </p>
                                    @php
                                        $isLiked = auth()->check() ? $work->isAppreciatedBy(auth()->id()) : false;
                                    @endphp
                                    <button wire:click.prevent="toggleLike({{ $work->id }})"
                                            class="font-sans text-[10px] sm:text-xs font-semibold {{ $isLiked ? 'text-[#FC00BB]' : 'text-[#2F3AFF]' }} mt-0.5 flex items-center justify-center gap-1 mx-auto hover:opacity-80 transition cursor-pointer">
                                        <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 {{ $isLiked ? 'fill-[#FC00BB]' : 'fill-[#2F3AFF]' }}" viewBox="0 0 24 24">
                                            <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                        </svg>
                                        <span>{{ number_format($work->appreciations_count ?? 0) }} likes</span>
                                    </button>
                                </div>

                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if ($hasMoreWorks)
                        <div class="text-center mt-6 sm:mt-8">
                            <button wire:click="loadMoreWorks" 
                                    type="button" 
                                    class="inline-flex items-center gap-1 font-display text-xs sm:text-base text-[#2F3AFF] hover:text-[#FC00BB] uppercase tracking-wider transition cursor-pointer font-extrabold hover:underline">
                                <span wire:loading.remove wire:target="loadMoreWorks">LIHAT LAINNYA →</span>
                                <span wire:loading wire:target="loadMoreWorks" class="animate-pulse">MEMUAT KARYA...</span>
                            </button>
                        </div>
                    @endif
                @else
                    {{-- CARD EMPTY STATE HASIL KARYA KOSONG --}}
                    <div class="relative w-full max-w-4xl mx-auto my-6 sm:my-10">
                        <div class="bg-[#F8F8F8] border-2 border-[#FC00BB] shadow-[6px_6px_0px_#2F3AFF] sm:shadow-[8px_8px_0px_#2F3AFF] p-6 sm:p-12 text-center relative">
                            <div class="absolute -top-6 -right-4 sm:-top-7 sm:-right-5 w-12 h-12 sm:w-14 sm:h-14 shrink-0 pointer-events-none">
                                <img src="{{ asset('images/emote-sedih.png') }}" alt="Sedih" class="w-full h-full object-contain" onerror="this.style.display='none'">
                            </div>

                            <h3 class="font-display text-base sm:text-2xl text-[#2F3AFF] uppercase tracking-wide">
                                Kami tidak menemukan kata kunci "{{ $query }}"
                            </h3>
                            <p class="font-sans text-xs sm:text-sm font-semibold text-[#2F3AFF]/70 mt-1.5">
                                Coba kata kunci lain
                            </p>
                        </div>
                    </div>
                @endif
            </section>



            <section class="space-y-8 pt-6 border-t border-[#2F3AFF]/15">
                <h2 class="font-display text-2xl sm:text-4xl text-[#2F3AFF] uppercase tracking-wide">
                    Hasil kreator pencarian ‘{{ $query }}’
                </h2>

                @if ($creators->isNotEmpty())
                    <div class="space-y-10">
                        @foreach ($creators as $creator)
                            @php
                                $cName = $creator->name ?? $creator->user->name ?? 'Kreator';
                                $cBio = $creator->bio ?? $creator->role ?? 'umkm';
                                $cSlug = $creator->slug ?? $creator->id;
                                $cImage = $creator->profile_image ?? $creator->user->profile_image ?? null;
                                $cDate = $creator->created_at ? \Carbon\Carbon::parse($creator->created_at)->format('d F Y') : '31 August 2026';
                                $cFollowers = method_exists($creator, 'followersCount') ? $creator->followersCount() : ($creator->followers_count ?? 0);
                                $creatorWorks = isset($creator->works) ? $creator->works->take(3) : collect();
                            @endphp

                            <div class="flex flex-col lg:flex-row items-start lg:items-center gap-6 sm:gap-8 w-full">
                                
                                {{-- KIRI: KARTU PROFIL KREATOR --}}
                                <div class="flex items-center gap-4 w-full lg:w-[420px] shrink-0">
                                    
                                    {{-- Persegi Biru Solid Avatar (Bisa Diklik Direct ke Profil Kreator) --}}
                                    <a href="{{ route('creator.show', $cSlug) }}" class="w-24 h-24 sm:w-28 sm:h-28 bg-[#2F3AFF] shrink-0 flex items-center justify-center overflow-hidden hover:opacity-90 transition">
                                        @if ($cImage)
                                            <img src="{{ asset('storage/' . $cImage) }}" alt="{{ $cName }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-[#D9FC28] font-display text-2xl sm:text-3xl font-bold uppercase tracking-wider">
                                                {{ strtoupper(substr($cName, 0, 2)) }}
                                            </span>
                                        @endif
                                    </a>

                                    <div class="flex-1 min-w-0 space-y-1">
                                    <h3 class="font-display text-xl sm:text-3xl text-[#2F3AFF] uppercase truncate leading-none">
                                        {{ $creator->name }}
                                    </h3>
                                    <p class="font-sans text-xs sm:text-sm text-[#2F3AFF] font-medium truncate">
                                        {{ $creator->creator_type ?? 'Riset Mengabdi Desa' }}
                                    </p>
                                    <p class="font-sans text-xs sm:text-sm text-[#2F3AFF] whitespace-nowrap">
                                        <span class="font-extrabold">{{ number_format($creator->total_likes_sum ?? $creator->published_works_count) }} likes</span> 
                                        <span class="mx-1">|</span> 
                                        Bergabung sejak {{ $creator->created_at->translatedFormat('d F Y') }}
                                    </p>

                                    <div class="pt-1">
                                        @auth
                                            @if (auth()->id() === $creator->user_id)
                                                <a href="{{ route('profile.show') }}" class="inline-block px-4 py-1 bg-[#2F3AFF] text-white font-display text-xs sm:text-sm uppercase hover:bg-[#FC00BB] transition">
                                                    Profil Saya
                                                </a>
                                            @else
                                                <button wire:click="toggleFollow({{ $creator->id }})" class="px-4 py-1 bg-[#D9FC28] hover:bg-[#FC00BB] text-[#2F3AFF] hover:text-[#D9FC28] font-display text-xs sm:text-sm uppercase active:translate-y-0.5 transition-all cursor-pointer">
                                                    {{ $creator->isFollowedBy(auth()->id()) ? '✓ Mengikuti' : 'Ikuti' }}
                                                </button>
                                            @endif
                                        @else
                                            <button wire:click="toggleFollow({{ $creator->id }})" class="px-4 py-1 bg-[#D9FC28] hover:bg-[#FC00BB] text-[#2F3AFF] hover:text-[#D9FC28] font-display text-xs sm:text-sm uppercase active:translate-y-0.5 transition-all cursor-pointer">
                                                Ikuti
                                            </button>
                                        @endauth
                                    </div>
                                </div>
                                </div>

                                {{-- KANAN: LIST FOTO KARYA (BINGKAI PINK + 4 POINTS KUNING) --}}
                                <div class="grid grid-cols-3 gap-4 sm:gap-6 w-full flex-1">
                                    @foreach ($creatorWorks as $cWork)
                                        <div class="relative w-full aspect-[4/3] bg-gray-100 border-2 border-[#FC00BB] group">
                                            
                                            {{-- 4 Points/Kotak Aksen Kuning Lime di Tiap Sudut Bounding Box --}}
                                            <div class="absolute -top-1.5 -left-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-20 pointer-events-none"></div>
                                            <div class="absolute -top-1.5 -right-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-20 pointer-events-none"></div>
                                            <div class="absolute -bottom-1.5 -left-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-20 pointer-events-none"></div>
                                            <div class="absolute -bottom-1.5 -right-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-20 pointer-events-none"></div>

                                            <a href="{{ route('work.show', $cWork->slug ?? $cWork->id) }}" class="block w-full h-full overflow-hidden">
                                                @if ($cWork->cover_image)
                                                    <img src="{{ asset('storage/' . $cWork->cover_image) }}" alt="{{ $cWork->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-sans">No Image</div>
                                                @endif
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        @endforeach
                    </div>

                    @if ($hasMoreWorks)
                        <div class="text-center mt-6 sm:mt-8">
                            <button wire:click="loadMoreWorks" 
                                    type="button" 
                                    class="inline-flex items-center gap-1 font-display text-xs sm:text-base text-[#2F3AFF] hover:text-[#FC00BB] uppercase tracking-wider transition cursor-pointer font-extrabold hover:underline">
                                <span wire:loading.remove wire:target="loadMoreWorks">LIHAT LAINNYA →</span>
                                <span wire:loading wire:target="loadMoreWorks" class="animate-pulse">MEMUAT KARYA...</span>
                            </button>
                        </div>
                    @endif
                @else
                    {{-- CARD EMPTY STATE KREATOR KOSONG --}}
                    <div class="relative w-full max-w-4xl mx-auto my-6 sm:my-10">
                        <div class="bg-[#F8F8F8] border-2 border-[#FC00BB] shadow-[6px_6px_0px_#2F3AFF] sm:shadow-[8px_8px_0px_#2F3AFF] p-6 sm:p-12 text-center relative">
                            <div class="absolute -top-6 -right-4 sm:-top-7 sm:-right-5 w-12 h-12 sm:w-14 sm:h-14 shrink-0 pointer-events-none">
                                <img src="{{ asset('images/emote-sedih.png') }}" alt="Sedih" class="w-full h-full object-contain" onerror="this.style.display='none'">
                            </div>

                            <h3 class="font-display text-base sm:text-2xl text-[#2F3AFF] uppercase tracking-wide">
                                Kami tidak menemukan kreator "{{ $query }}"
                            </h3>
                            <p class="font-sans text-xs sm:text-sm font-semibold text-[#2F3AFF]/70 mt-1.5">
                                Coba kata kunci lain
                            </p>
                        </div>
                    </div>
                @endif
            </section>

        @else
            <div class="text-center py-20">
                <h3 class="font-display text-lg sm:text-xl text-[#2F3AFF] uppercase tracking-wide">Ketikkan minimal 2 karakter untuk mencari karya atau kreator.</h3>
            </div>
        @endif
    </div>

    <div class="w-full flex justify-between items-end pointer-events-none z-10 pb-0 mt-8 sm:mt-12">
        <img src="{{ asset('images/vector/vector_sayap_Bawah.png') }}" alt="Vector Wing Bottom Left" class="h-6 sm:h-12 object-contain">
        <img src="{{ asset('images/vector/vector_sayap_Bawah.png') }}" alt="Vector Wing Bottom Right" class="h-6 sm:h-12 object-contain -scale-x-100">
    </div>

</div>