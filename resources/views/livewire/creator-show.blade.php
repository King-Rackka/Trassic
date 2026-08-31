<div class="w-full bg-grid-pattern min-h-screen">

    {{-- ========================================== --}}
    {{-- 1. COVER IMAGE, BREADCRUMBS & AVATAR --}}
    {{-- ========================================== --}}
    <div class="relative w-full">
        
        {{-- Banner Cover Full --}}
        <div class="w-full h-64 sm:h-80 md:h-[380px] lg:h-[420px] bg-gray-900 relative overflow-hidden">
            
                {{-- Breadcrumbs Melayang di Pojok Kiri Atas Banner --}}
            <div class="absolute top-4 sm:top-6 left-4 sm:left-8 z-30 flex items-center gap-2 text-xs sm:text-sm font-semibold text-white/90 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                <a href="{{ route('explore') }}" class="hover:text-[#ccff00] transition">Explore</a>
                <span class="text-white/60">/</span>
                <a href="{{ route('creators') }}" class="hover:text-[#ccff00] transition">Creators</a>
                <span class="text-white/60">/</span>
                <span class="text-[#ccff00] font-bold truncate max-w-[200px] sm:max-w-md">{{ $creator->name }}</span>
            </div>
            {{-- Background Gambar Cover / Fallback Gradasi --}}
            @if ($creator->cover_image)
                <img src="{{ asset('storage/' . $creator->cover_image) }}" 
                     alt="{{ $creator->name }} Cover" 
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-r from-[#254bfe] via-[#6366f1] to-[#ff007a] opacity-90"></div>
            @endif

            {{-- Overlay Gradasi Atas (Supaya breadcrumb jelas) & Bawah (Gradasi Biru Halus) --}}
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-[#254bfe]/40 pointer-events-none"></div>
        </div>

        {{-- Avatar Lingkaran (Menindih batas bawah cover) --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-8 relative">
            <div class="absolute -bottom-16 sm:-bottom-20 left-4 sm:left-8 z-20">
                <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-full border-4 sm:border-[6px] border-white overflow-hidden bg-white shadow-[0_4px_16px_rgba(0,0,0,0.25)] flex items-center justify-center">
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
                @auth
                    @if(auth()->id() !== $creator->user_id)
                        <button wire:click="toggleFollow"
                                class="px-5 py-2 sm:px-6 sm:py-2.5 bg-[#ccff00] hover:bg-[#ff007a] text-[#254bfe] hover:text-white font-display text-xs sm:text-sm uppercase border-2 border-black shadow-[2px_2px_0px_rgba(0,0,0,1)] active:translate-y-0.5 transition-all">
                            {{ $isFollowing ? '✓ Mengikuti' : '+ Ikuti' }}
                        </button>
                    @endif
                @else
                    <button wire:click="toggleFollow"
                            class="px-5 py-2 sm:px-6 sm:py-2.5 bg-[#ccff00] hover:bg-[#ff007a] text-[#254bfe] hover:text-white font-display text-xs sm:text-sm uppercase border-2 border-black shadow-[2px_2px_0px_rgba(0,0,0,1)] active:translate-y-0.5 transition-all">
                        + Ikuti
                    </button>
                @endauth

                <button type="button" onclick="navigator.clipboard.writeText(window.location.href)"
                        class="w-9 h-9 sm:w-10 sm:h-10 border-2 border-black bg-white flex items-center justify-center text-[#254bfe] shadow-[2px_2px_0px_rgba(0,0,0,1)] hover:bg-[#ccff00] transition" title="Bagikan">
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

            {{-- Kolom Kontak & Sosmed --}}
            <div class="space-y-2.5 sm:space-y-3 text-sm sm:text-base text-[#254bfe] font-semibold lg:pl-48 lg:-mt-14">
                {{-- Website --}}
                @if ($creator->website())
                    <p class="flex items-center gap-2.5 sm:gap-3 truncate">
                        <img src="{{ asset('images/icons/link.png') }}" 
                             alt="Website" 
                             class="w-5 h-5 sm:w-6 sm:h-6 object-contain shrink-0">
                        <a href="{{ $creator->website() }}" target="_blank" rel="noopener" class="hover:underline">
                            {{ str($creator->website())->replace(['https://', 'http://'], '') }}
                        </a>
                    </p>
                @endif

                {{-- Instagram --}}
                @if ($creator->instagramHandle())
                    <p class="flex items-center gap-2.5 sm:gap-3 truncate">
                        <img src="{{ asset('images/icons/instagram.png') }}" 
                             alt="Instagram" 
                             class="w-5 h-5 sm:w-6 sm:h-6 object-contain shrink-0">
                        <a href="https://instagram.com/{{ ltrim($creator->instagramHandle(), '@') }}" target="_blank" rel="noopener" class="hover:underline">
                            {{ ltrim($creator->instagramHandle(), '@') }}
                        </a>
                    </p>
                @endif

                {{-- Lokasi --}}
                @if ($creator->location)
                    <p class="flex items-center gap-2.5 sm:gap-3 truncate">
                        <img src="{{ asset('images/icons/placeholder.png') }}" 
                             alt="Lokasi" 
                             class="w-5 h-5 sm:w-6 sm:h-6 object-contain shrink-0">
                        <span>{{ $creator->location }}</span>
                    </p>
                @endif

                {{-- Telepon --}}
                @if ($creator->phone)
                    <p class="flex items-center gap-2.5 sm:gap-3 truncate">
                        <img src="{{ asset('images/icons/telephone.png') }}" 
                             alt="Telepon" 
                             class="w-5 h-5 sm:w-6 sm:h-6 object-contain shrink-0">
                        <span>{{ $creator->phone }}</span>
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
                    <a href="{{ route('work.show', $work->slug) }}" class="block w-full">
                        <div class="relative w-full aspect-square bg-gray-900 border-2 border-[#ff007a] shadow-[3px_3px_0px_rgba(0,0,0,1)] shrink-0">
                            <div class="absolute -top-1.5 -left-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                            <div class="absolute -top-1.5 -right-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                            <div class="absolute -bottom-1.5 -left-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                            <div class="absolute -bottom-1.5 -right-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>

                            @if ($work->wasteDna && $work->wasteDna->sum('quantity') > 0)
                                <div class="absolute top-2 left-2 z-30 bg-[#ccff00] text-[#254bfe] border border-black font-sans text-[7px] sm:text-[10px] font-extrabold px-1.5 sm:px-2 py-0.5 uppercase tracking-tight shadow-[1px_1px_0px_rgba(0,0,0,1)]">
                                    {{ $work->wasteDna->sum('quantity') }}kg sampah terpakai
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
    {{-- 4. SECTION BANNER BIRU BAWAH + LANYARD ID CARD + INFO PROFIL --}}
    {{-- ========================================== --}}
    @push('scripts')
        @viteReactRefresh
        @vite(['resources/js/creator-lanyard-entry.jsx'])
    @endpush

    {{-- Garis Pinggir Pink Atas & Bawah (border-y-4 / border-y-6) --}}
    <div class="w-full bg-[#254bfe] border-y-4 sm:border-y-[6px] border-[#ff007a] py-6 sm:py-10 relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-14">

                {{-- KIRI: Kartu Lanyard 3D --}}
                <div class="w-full max-w-[280px] sm:max-w-xs lg:w-88 shrink-0 flex items-center justify-center">
                    <div id="creator-lanyard-react-root"
                         data-name="{{ $creator->name }}"
                         data-join="{{ $creator->created_at->format('d/m/Y') }}"
                         class="w-full h-[360px] sm:h-[420px] cursor-pointer">
                    </div>
                </div>

                {{-- KANAN: Detail Kreator --}}
                <div class="flex-1 min-w-0 w-full space-y-4">

                    {{-- Baris 1: Avatar + Nama + Role + Tombol Ikuti --}}
                    <div class="flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4 sm:gap-5 min-w-0">
                            {{-- Avatar --}}
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full border-4 border-white overflow-hidden bg-white shrink-0 shadow-md">
                                @if ($creator->profile_image)
                                    <img src="{{ asset('storage/' . $creator->profile_image) }}" 
                                         alt="{{ $creator->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-[#254bfe] text-[#ccff00] font-display text-xl sm:text-3xl flex items-center justify-center uppercase">
                                        {{ substr($creator->name, 0, 2) }}
                                    </div>
                                @endif
                            </div>

                            {{-- Nama & Tipe Kreator --}}
                            <div class="min-w-0">
                                <h2 class="font-display text-2xl sm:text-4xl text-white uppercase tracking-normal leading-tight truncate">
                                    {{ $creator->name }}
                                </h2>
                                <p class="font-sans text-xs sm:text-sm font-extrabold text-[#ccff00] uppercase mt-0.5 tracking-wider">
                                    {{ $creator->creator_type ?? 'Kreator Trassic' }}
                                </p>
                            </div>
                        </div>

                        {{-- Tombol Ikuti --}}
                        <div class="shrink-0">
                            @auth
                                @if(auth()->id() !== $creator->user_id)
                                    <button wire:click="toggleFollow"
                                            class="px-5 py-2 sm:px-6 sm:py-2.5 bg-[#ccff00] hover:bg-white text-[#254bfe] font-display text-xs sm:text-sm uppercase tracking-wide transition-all shadow-[3px_3px_0px_rgba(0,0,0,1)] active:translate-y-0.5">
                                        {{ $isFollowing ? '✓ Mengikuti' : '+ Ikuti' }}
                                    </button>
                                @endif
                            @else
                                <button wire:click="toggleFollow"
                                        class="px-5 py-2 sm:px-6 sm:py-2.5 bg-[#ccff00] hover:bg-white text-[#254bfe] font-display text-xs sm:text-sm uppercase tracking-wide transition-all shadow-[3px_3px_0px_rgba(0,0,0,1)] active:translate-y-0.5">
                                    + Ikuti
                                </button>
                            @endauth
                        </div>
                    </div>

                    {{-- Baris 2: Stats (Posts, Followers, Following) --}}
                    <div class="flex flex-wrap items-center gap-x-6 sm:gap-x-10 text-white font-display text-base sm:text-xl tracking-wide pt-1">
                        <span><strong>{{ $creator->publishedWorksCount() }}</strong> posts</span>
                        <span><strong>{{ number_format($creator->followersCount()) }}</strong> followers</span>
                        <span><strong>{{ number_format($creator->followingCount()) }}</strong> following</span>
                    </div>

                    {{-- Baris 3: Deskripsi Bio --}}
                    @if($creator->bio)
                        <p class="text-white/95 text-sm sm:text-base leading-relaxed max-w-2xl font-medium pt-1">
                            {{ $creator->bio }}
                        </p>
                    @endif

                    {{-- Baris 4: Link Sosial & Kontak --}}
                    <div class="flex flex-wrap items-center gap-x-6 sm:gap-x-8 gap-y-3 pt-2 text-white text-sm sm:text-base font-bold">
                        @if ($creator->website())
                            <a href="{{ $creator->website() }}" target="_blank" rel="noopener" class="flex items-center gap-2 hover:text-[#ccff00] transition group">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                </svg>
                                <span>{{ str($creator->website())->replace(['https://', 'http://'], '') }}</span>
                            </a>
                        @endif

                        @if ($creator->instagramHandle())
                            <a href="https://instagram.com/{{ ltrim($creator->instagramHandle(), '@') }}" target="_blank" rel="noopener" class="flex items-center gap-2 hover:text-[#ccff00] transition group">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="5" />
                                    <circle cx="12" cy="12" r="4" />
                                    <circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none" />
                                </svg>
                                <span>{{ ltrim($creator->instagramHandle(), '@') }}</span>
                            </a>
                        @endif

                        @if ($creator->location)
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.5-7.5 11.25-7.5 11.25S4.5 18 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                <span>{{ $creator->location }}</span>
                            </span>
                        @endif

                        @if ($creator->phone)
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a1.5 1.5 0 001.5-1.5v-3.75a1.5 1.5 0 00-1.5-1.5h-3.75a1.5 1.5 0 00-1.5 1.5v.75c0 .414-.336.75-.75.75h-.75a13.5 13.5 0 01-12-12v-.75c0-.414.336-.75.75-.75h.75a1.5 1.5 0 001.5-1.5V3.75a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v3z" />
                                </svg>
                                <span>{{ $creator->phone }}</span>
                            </span>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>