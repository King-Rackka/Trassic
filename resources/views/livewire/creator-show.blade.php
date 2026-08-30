<div class="w-full">

    {{-- ========================================== --}}
    {{-- 1. COVER IMAGE & PROFILE AVATAR --}}
    {{-- ========================================== --}}
    <div class="relative w-full">
        {{-- Banner Cover --}}
        <div class="w-full h-56 sm:h-80 md:h-96 bg-gray-900 relative overflow-hidden">
            @if ($creator->cover_image)
                <img src="{{ asset('storage/' . $creator->cover_image) }}" 
                     alt="{{ $creator->name }} Cover" 
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-r from-[#254bfe] via-[#6366f1] to-[#ff007a] opacity-90"></div>
            @endif
            {{-- Overlay Gradasi Biru Bawah --}}
            <div class="absolute inset-0 bg-gradient-to-t from-[#254bfe]/40 via-transparent to-transparent pointer-events-none"></div>
        </div>

        {{-- Avatar Lingkaran --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-8 relative">
            <div class="absolute -bottom-16 sm:-bottom-20 left-4 sm:left-8 z-20">
                <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-full border-4 sm:border-[6px] border-white overflow-hidden bg-white shadow-[0_4px_12px_rgba(0,0,0,0.15)] flex items-center justify-center">
                    @if ($creator->profile_image)
                        <img src="{{ asset('storage/' . $creator->profile_image) }}" 
                             alt="{{ $creator->name }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-[#254bfe] text-[#ccff00] font-display text-4xl sm:text-5xl flex items-center justify-center uppercase">
                            {{ substr($creator->name, 0, 2) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 2. PROFILE DETAILS & STATS --}}
    {{-- ========================================== --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-8 pt-20 sm:pt-24 pb-8">
        
        {{-- HEADER BAR: Nama, Follow Button, Share & More --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-blue-100 pb-6">
            <div>
                <h1 class="font-display text-3xl sm:text-5xl text-[#254bfe] uppercase tracking-normal leading-tight">
                    {{ $creator->name }}
                </h1>
                <p class="font-sans text-xs sm:text-sm font-bold text-[#ff007a] uppercase mt-0.5">
                    {{ $creator->creator_type ?? 'Komunitas Kreatif Trassic' }}
                </p>
            </div>

            <div class="flex items-center gap-2.5 sm:gap-3 shrink-0">
                <button wire:click="toggleFollow"
                        class="px-5 py-2 sm:px-6 sm:py-2.5 bg-[#ccff00] hover:bg-[#ff007a] text-[#254bfe] hover:text-white font-display text-xs sm:text-sm uppercase border-2 border-black shadow-[2px_2px_0px_rgba(0,0,0,1)] active:translate-y-0.5 transition-all">
                    {{ $isFollowing ? '✓ Mengikuti' : '+ Ikuti' }}
                </button>

                <button class="w-9 h-9 sm:w-10 sm:h-10 border-2 border-black bg-white flex items-center justify-center text-[#254bfe] shadow-[2px_2px_0px_rgba(0,0,0,1)] hover:bg-[#ccff00] transition" title="Bagikan">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </button>

                <button class="w-9 h-9 sm:w-10 sm:h-10 border-2 border-black bg-white flex items-center justify-center text-[#254bfe] shadow-[2px_2px_0px_rgba(0,0,0,1)] hover:bg-[#ccff00] transition" title="Opsi">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <circle cx="5" cy="12" r="2"/>
                        <circle cx="12" cy="12" r="2"/>
                        <circle cx="19" cy="12" r="2"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- METRIK: Posts, Followers, Following --}}
        <div class="flex gap-8 sm:gap-16 py-4 text-[#254bfe] font-sans">
            <div>
                <span class="font-extrabold text-base sm:text-xl">{{ $creator->publishedWorksCount() }}</span>
                <span class="text-xs sm:text-sm uppercase font-semibold text-gray-600 ml-1">posts</span>
            </div>
            <div>
                <span class="font-extrabold text-base sm:text-xl">{{ number_format($creator->followersCount()) }}</span>
                <span class="text-xs sm:text-sm uppercase font-semibold text-gray-600 ml-1">followers</span>
            </div>
            <div>
                <span class="font-extrabold text-base sm:text-xl">{{ number_format($creator->followingCount()) }}</span>
                <span class="text-xs sm:text-sm uppercase font-semibold text-gray-600 ml-1">following</span>
            </div>
        </div>

        {{-- BIO & SOCIAL METADATA (KOLOM DUA BAGIAN) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pt-2">
            <div class="lg:col-span-2">
                <p class="font-sans text-xs sm:text-sm text-gray-700 leading-relaxed font-medium">
                    {{ $creator->bio ?? 'Belum ada deskripsi profil untuk kreator ini.' }}
                </p>
            </div>

            <div class="space-y-1.5 text-xs sm:text-sm text-[#254bfe] font-semibold">
                @php $links = json_decode($creator->social_links, true) ?? []; @endphp
                @if (!empty($links['website']))
                    <p class="flex items-center gap-2 truncate">
                        <span>🔗</span> <a href="{{ $links['website'] }}" target="_blank" class="hover:underline">{{ $links['website'] }}</a>
                    </p>
                @endif
                @if (!empty($links['instagram']))
                    <p class="flex items-center gap-2 truncate">
                        <span>📷</span> <a href="https://instagram.com/{{ ltrim($links['instagram'], '@') }}" target="_blank" class="hover:underline">{{ $links['instagram'] }}</a>
                    </p>
                @endif
                @if ($creator->location)
                    <p class="flex items-center gap-2 truncate">
                        <span>📍</span> <span>{{ $creator->location }}</span>
                    </p>
                @endif
                @if ($creator->phone)
                    <p class="flex items-center gap-2 truncate">
                        <span>📞</span> <span>{{ $creator->phone }}</span>
                    </p>
                @endif
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- 3. FILTER TABS & KARYA GRID --}}
        {{-- ========================================== --}}
        <div class="flex items-center gap-2 mt-10 mb-8 overflow-x-auto pb-2">
            <span class="font-display text-xs sm:text-sm text-[#254bfe] uppercase tracking-wider mr-2">Filter:</span>
            
            <button wire:click="setSort('all')" 
                    class="px-4 py-1.5 border-2 border-black font-display text-xs uppercase transition-all shadow-[2px_2px_0px_rgba(0,0,0,1)]
                    {{ $sort === 'all' ? 'bg-[#ff007a] text-[#ccff00]' : 'bg-white text-[#254bfe] hover:bg-[#ccff00]' }}">
                Semua
            </button>
            <button wire:click="setSort('newest')" 
                    class="px-4 py-1.5 border-2 border-black font-display text-xs uppercase transition-all shadow-[2px_2px_0px_rgba(0,0,0,1)]
                    {{ $sort === 'newest' ? 'bg-[#254bfe] text-[#ccff00]' : 'bg-white text-[#254bfe] hover:bg-[#ccff00]' }}">
                Terbaru
            </button>
            <button wire:click="setSort('liked')" 
                    class="px-4 py-1.5 border-2 border-black font-display text-xs uppercase transition-all shadow-[2px_2px_0px_rgba(0,0,0,1)]
                    {{ $sort === 'liked' ? 'bg-[#7c3aed] text-[#ccff00]' : 'bg-white text-[#254bfe] hover:bg-[#ccff00]' }}">
                Most Liked
            </button>
        </div>

        {{-- WORKS GRID --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6 items-start" wire:loading.class="opacity-60">
            @forelse ($works as $work)
                <div class="group relative flex flex-col justify-between transition-transform duration-200 hover:-translate-y-2 p-1 w-full">
                    
                    {{-- FRAME BORDER PINK + 4 KOTAK KUNING DI POJOK SUDUT LUAR --}}
                    <a href="{{ route('work.show', $work->slug) }}" class="block w-full">
                        <div class="relative w-full aspect-square bg-gray-900 border-2 border-[#ff007a] shadow-[3px_3px_0px_rgba(0,0,0,1)] shrink-0">
                            
                            {{-- 4 KOTAK KUNING SUDUT LUAR --}}
                            <div class="absolute -top-1.5 -left-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                            <div class="absolute -top-1.5 -right-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                            <div class="absolute -bottom-1.5 -left-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                            <div class="absolute -bottom-1.5 -right-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>

                            {{-- BADGE SAMPAH TERPAKAI --}}
                            @if ($work->wasteDna && $work->wasteDna->sum('quantity') > 0)
                                <div class="absolute top-2 left-2 z-30 bg-[#ccff00] text-[#254bfe] border border-black font-sans text-[7px] sm:text-[10px] font-extrabold px-1.5 sm:px-2 py-0.5 uppercase tracking-tight shadow-[1px_1px_0px_rgba(0,0,0,1)]">
                                    {{ $work->wasteDna->sum('quantity') }}kg sampah terpakai
                                </div>
                            @endif

                            {{-- CROPPER GAMBAR INTERNAL --}}
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

                    {{-- DETAIL KARYA --}}
                    <div class="mt-2.5 sm:mt-3 text-center w-full">
                        <h4 class="font-display text-xs sm:text-base text-[#254bfe] truncate uppercase leading-tight tracking-wide">
                            {{ $work->title }}
                        </h4>
                        <p class="font-sans text-[9px] sm:text-xs font-medium text-gray-500 uppercase mt-0.5 truncate">
                            {{ $creator->name }}
                        </p>
                        <p class="font-sans text-[10px] sm:text-xs font-semibold text-[#254bfe] mt-0.5 flex items-center justify-center gap-1">
                            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 fill-[#254bfe]" viewBox="0 0 24 24">
                                <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                            </svg>
                            <span>{{ number_format($work->appreciations_count ?? 0) }} likes</span>
                        </p>
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <p class="font-display text-base sm:text-lg text-gray-400 uppercase">Belum ada karya untuk filter ini.</p>
                </div>
            @endforelse
        </div>

        {{-- LINK LIHAT LEBIH BANYAK --}}
        <div class="text-center mt-12 mb-6">
            <a href="{{ route('creator.works.more', $creator->slug) }}" 
               class="inline-block font-display text-sm sm:text-lg text-[#254bfe] hover:text-[#ff007a] uppercase tracking-wider underline underline-offset-4 transition-colors">
                Lihat lebih banyak →
            </a>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- 4. SECTION BANNER BIRU BAWAH + ANIMASI LANYARD ID CARD --}}
    {{-- ========================================== --}}
    

</div>