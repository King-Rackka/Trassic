<div class="w-full bg-white font-sans bg-grid-pattern" 
     x-data="{ 
        activeImage: '{{ $work->cover_image ? asset('storage/'.$work->cover_image) : '' }}',
        showShareModal: false,
        showReportModal: false,
        showDeleteModal: false,
        copied: false,
        reportReason: '',
        reportDetails: ''
     }">

    @push('scripts')
        @viteReactRefresh
        @vite(['resources/js/creator-lanyard-entry.jsx'])
    @endpush

    {{-- BREADCRUMB --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-8 pt-4 pb-2">
        <nav class="text-left pt-4 sm:pt-6 mb-4 sm:mb-6">
            <p class="text-xs sm:text-sm font-semibold uppercase tracking-widest flex items-center gap-2">
                <a href="{{ route('explore') }}" class="text-gray-500 hover:text-[#254bfe] hover:underline">Explore</a> 
                <span class="text-gray-400">/</span>
                <a href="{{ route('explore') }}" class="text-gray-500 hover:text-[#254bfe] hover:underline">Karya lainnya</a> 
                <span class="text-gray-400">/</span>
                <span class="text-[#254bfe] font-bold">{{ $work->title }} by {{ $work->creator->name ?? 'Creator' }}</span>
            </p>
        </nav>
    </div>

    

    <div class="max-w-7xl mx-auto px-4 sm:px-8 py-4 sm:py-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10">

            {{-- KIRI: Galeri --}}
            <div>
                <div class="relative w-full max-w-[560px] aspect-[4/3] bg-gray-900 border-2 border-[#FC00BB] shadow-[4px_4px_0px_rgba(0,0,0,1)] overflow-hidden">
                    <img :src="activeImage" class="w-full h-full object-cover" alt="{{ $work->title }}">
                    
                    {{-- BADGE KARYA DENGAN LIKE TERBANYAK --}}
                    @if (isset($isTopLiked) && $isTopLiked)
                        <div class="absolute top-2 left-2 z-30 bg-[#ccff00] text-[#2F3AFF] border border-black font-sans text-xs font-extrabold px-2.5 py-1 tracking-tight shadow-[2px_2px_0px_rgba(0,0,0,1)]">
                            #1 KARYA TERFAVORIT
                        </div>
                    @endif
                </div>

                @if ($work->cover_image)
                    <div class="grid grid-cols-4 gap-2 sm:gap-3 mt-3">
                        {{-- THUMBNAIL 1: FOTO COVER UTAMA --}}
                        <button type="button"
                                @click="activeImage = '{{ asset('storage/'.$work->cover_image) }}'"
                                class="aspect-square border-2 border-[#ff007a] overflow-hidden hover:opacity-80 transition cursor-pointer">
                            <img src="{{ asset('storage/'.$work->cover_image) }}" alt="" class="w-full h-full object-cover">
                        </button>

                        {{-- THUMBNAIL TAMBAHAN (HANYA MUNCUL JIKA BEDA DENGAN COVER) --}}
                        @if ($work->images && $work->images->count() > 0)
                            @foreach ($work->images as $img)
                                @if ($img->image_path !== $work->cover_image)
                                    <button type="button"
                                            @click="activeImage = '{{ asset('storage/'.$img->image_path) }}'"
                                            class="aspect-square border-2 border-[#ff007a] overflow-hidden hover:opacity-80 transition cursor-pointer">
                                        <img src="{{ asset('storage/'.$img->image_path) }}" alt="" class="w-full h-full object-cover">
                                    </button>
                                @endif
                            @endforeach
                        @endif
                    </div>
                @endif
            </div>

            {{-- KANAN: Info --}}
            <div>
                <div class="flex items-start justify-between gap-4 mb-1">
                    <h1 class="font-display text-3xl sm:text-4xl text-[#254bfe] leading-tight">
                        {{ $work->title }}
                    </h1>

                    <div class="flex items-center gap-2 shrink-0">
                        
                        @auth
                            <livewire:bookmark-button :work="$work" :is-bookmarked="$isBookmarked" />
                        @else
                            {{-- TOMBOL SAAT BELUM LOGIN (STYLING SAMA PERSIS & SHADOW DIHAPUS) --}}
                            <button @click="$dispatch('show-login-prompt')"
                                    type="button"
                                    class="flex items-center gap-1.5  bg-[#ccff00] text-[#254bfe] font-display text-xs uppercase px-3.5 py-2 active:translate-y-0.5 transition-all cursor-pointer">
                                <img src="{{ asset('images/icons/bookmark.png') }}" 
                                    alt="Favorit" 
                                    class="w-3.5 h-3.5 sm:w-4 sm:h-4 object-contain">
                                <span>Favorit</span>
                            </button>
                        @endauth
                        
                        @php
                            $isLiked = auth()->check() && $work->isAppreciatedBy(auth()->id());
                        @endphp

                        {{-- TOMBOL LIKE (LANGSUNG WIRE:CLICK SAMA SEPERTI BOOKMARK) --}}
                        <button wire:click="toggleLike({{ $work->id }})"
                                type="button"
                                class="w-9 h-9 flex items-center justify-center active:translate-y-0.5 transition-transform cursor-pointer"
                                title="Suka">
                            @if ($isLiked)
                                <img src="{{ asset('images/icons/like_1.png') }}" 
                                    alt="Liked" 
                                    class="w-5 h-5 object-contain">
                            @else
                                <img src="{{ asset('images/icons/like.png') }}" 
                                    alt="Like" 
                                    class="w-5 h-5 object-contain">
                            @endif
                        </button>

                        {{-- SHARE BUTTON --}}
                        <button type="button" @click="showShareModal = true"
                                class="w-9 h-9 flex items-center justify-center text-[#254bfe] transition hover:text-[#ff007a]" title="Bagikan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </button>

                        @php
                            // Cek apakah user yang login adalah pemilik karya ini
                            $isOwner = auth()->check() && (
                                auth()->id() === ($work->creator->user_id ?? null) || 
                                (isset(auth()->user()->creatorProfile) && auth()->user()->creatorProfile->id === $work->creator_id)
                            );
                        @endphp

                        @if ($isOwner)
                            {{-- TOMBOL HAPUS (KARYA SENDIRI) --}}
                            <button type="button" 
                                    @click="showDeleteModal = true"
                                    class="w-9 h-9 flex items-center justify-center text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition cursor-pointer" 
                                    title="Hapus Karya">
                                <svg class="w-5 h-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        @else
                            {{-- TOMBOL LAPORKAN (KARYA ORANG LAIN) --}}
                            <button type="button" 
                                    @click="{{ auth()->check() ? 'showReportModal = true' : "\$dispatch('show-login-prompt')" }}"
                                    class="w-9 h-9 flex items-center justify-center text-[#ff007a] hover:text-red-600 transition cursor-pointer" 
                                    title="Laporkan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
                

                <p class="text-sm text-gray-600 mb-4">
                    by <a href="{{ route('creator.show', $work->creator->slug) }}" class="text-[#254bfe] font-bold hover:underline">{{ $work->creator->name }}</a>
                </p>

                {{-- TAGS --}}
                <div class="flex flex-wrap items-center gap-2.5 mb-4">
                    <span class="text-[#2F3AFF] font-bold text-sm sm:text-base mr-1">Tags:</span>
                    
                    @if ($work->category)
                        @foreach (array_filter(array_map('trim', explode(',', $work->category))) as $cat)
                            <span class="bg-[#2F3AFF] text-white font-bold text-xs sm:text-sm px-3.5 py-1 border-2 border-[#FC00BB] inline-flex items-center justify-center">
                                {{ $cat }}
                            </span>
                        @endforeach
                    @endif

                    @foreach ($work->wasteDna->pluck('waste_type')->filter()->unique() as $wasteType)
                        <span class="bg-[#2F3AFF] text-white font-bold text-xs sm:text-sm px-3.5 py-1 border-2 border-[#FC00BB] inline-flex items-center justify-center">
                            {{ $wasteType }}
                        </span>
                    @endforeach

                    @if ($work->location)
                        <span class="bg-[#2F3AFF] text-white font-bold text-xs sm:text-sm px-3.5 py-1 border-2 border-[#FC00BB] inline-flex items-center justify-center">
                            {{ Str::before($work->location, ',') }}
                        </span>
                    @endif
                </div>

                <p class="font-sans text-base sm:text-[16px] text-[#2F3AFF] leading-relaxed font-normal mb-6">
                    {{ $work->description }}
                </p>

                {{-- DETAIL PENGGUNAAN SAMPAH --}}
                @foreach ($work->wasteDna as $dna)
    @php
        $suppMaterials = [];
        if (!empty($dna->supporting_materials)) {
            $suppMaterials = is_array($dna->supporting_materials) 
                ? $dna->supporting_materials 
                : json_decode($dna->supporting_materials, true);
        }

        // Penanganan Satuan Berat (Gram / Kg / Item)
        $unit = strtolower($dna->unit ?? 'gram');
        $qty = (float) $dna->quantity;
        
        if (in_array($unit, ['g', 'gram', 'grams'])) {
            $formattedQty = $qty >= 1000 
                ? str_replace('.', ',', (string) round($qty / 1000, 2)) . ' kg' 
                : number_format($qty, 0, ',', '.') . ' gram';
        } elseif ($unit === 'item') {
            $formattedQty = number_format($qty, 0, ',', '.') . ' item';
        } else {
            // Default kg
            $formattedQty = $qty < 1 
                ? number_format($qty * 1000, 0, ',', '.') . ' gram' 
                : str_replace('.', ',', (string) $qty) . ' kg';
        }
    @endphp

    <div class="bg-white border-[3px] sm:border-4 border-[#FC00BB] shadow-[6px_6px_0px_#2F3AFF] p-5 sm:p-6 mb-6">
        <h3 class="font-display text-2xl sm:text-3xl text-[#2F3AFF] tracking-wide mb-4">
            Detail penggunaan sampah
        </h3>

        <div class="grid grid-cols-[140px_16px_1fr] sm:grid-cols-[160px_20px_1fr] gap-y-3 text-sm sm:text-base text-[#2F3AFF] items-start">
            
            <span class="font-sans font-bold">Jenis sampah</span>
            <span>:</span>
            <span class="font-sans font-medium">
                {{ $dna->waste_type ?? $dna->material }}
            </span>

            @if ($dna->source)
                <span class="font-sans font-bold">Sumber</span>
                <span>:</span>
                <span class="font-sans font-medium">{{ $dna->source }}</span>
            @endif

            @if ($dna->quantity)
                <span class="font-sans font-bold">Berat</span>
                <span>:</span>
                <span class="font-sans font-medium">
                    ± {{ $formattedQty }}
                </span>
            @endif

            @if (is_array($suppMaterials) && count(array_filter($suppMaterials)) > 0)
                <span class="font-sans font-bold">Bahan pendukung</span>
                <span>:</span>
                <ol class="list-decimal list-inside space-y-0.5 font-medium">
                    @foreach (array_filter($suppMaterials) as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ol>
            @endif

            <span class="font-sans font-bold">Hasil pemanfaatan</span>
            <span>:</span>
            <span class="font-sans font-medium">{{ $dna->usage_result ?? $work->title }}</span>

        </div>
    </div>
@endforeach

{{-- PROGRESS BAR SAMPAH TERPAKAI --}}
@php
    // Hitung total berat aktual dalam satuan Gram
    $totalGramUsed = 0;
    foreach ($work->wasteDna as $dna) {
        $u = strtolower($dna->unit ?? 'gram');
        $q = (float) $dna->quantity;

        if (in_array($u, ['g', 'gram', 'grams'])) {
            $totalGramUsed += $q;
        } elseif ($u === 'kg') {
            $totalGramUsed += ($q * 1000);
        } else {
            // Jika disimpan sebagai decimal kg di DB (< 100 berarti kg, > 100 dianggp gram)
            $totalGramUsed += ($q < 100) ? ($q * 1000) : $q;
        }
    }

    $targetInput = (float) ($work->target_quantity ?? 4);
    $targetGram = $targetInput < 100 ? ($targetInput * 1000) : $targetInput;

    $pct = $targetGram > 0 ? min(100, round(($totalGramUsed / $targetGram) * 100)) : 0;

    $usedText = $totalGramUsed >= 1000 
        ? str_replace('.', ',', (string) round($totalGramUsed / 1000, 2)) . ' kg' 
        : number_format($totalGramUsed, 0, ',', '.') . ' gram';

    // Format Tampilan Target
    $targetText = $targetGram >= 1000 
        ? str_replace('.', ',', (string) round($targetGram / 1000, 2)) . ' kg' 
        : number_format($targetGram, 0, ',', '.') . ' gram';
@endphp

@if ($totalGramUsed > 0)
    <div class="flex items-center gap-3.5 sm:gap-5 bg-[#2F3AFF] text-white px-5 sm:px-6 py-3 sm:py-3.5 rounded-tl-2xl rounded-br-2xl sm:rounded-tl-[26px] sm:rounded-br-[26px] shadow-sm">
        <svg class="w-6 h-6 text-white shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>

        <span class="font-sans text-xs sm:text-sm font-medium whitespace-nowrap">
            <strong class="font-extrabold text-sm sm:text-base">{{ $usedText }}</strong> dari {{ $targetText }} sampah terpakai
        </span>

        <div class="flex-1 h-3 sm:h-3.5 border-2 border-white rounded-full p-[1.5px] flex items-center ml-1">
            <div class="h-full bg-white rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
        </div>
    </div>
@endif
            </div>
        </div>
    </div>

    {{-- SECTION CREATOR --}}
    <div class="w-full bg-[#2F3AFF] border-y-4 sm:border-y-[6px] border-[#FC00BB] py-8 sm:py-12 relative z-20 mt-10 sm:mt-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">
             <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-14">

                <div class="w-full max-w-[280px] sm:max-w-xs lg:w-80 shrink-0 flex items-center justify-center -mt-8 sm:-mt-12">
                    <div id="creator-lanyard-react-root"
                        data-name="{{ $work->creator->name }}"
                        data-join="{{ optional($work->creator->created_at)->format('d/m/Y') }}"
                        class="w-full h-[460px] sm:h-[520px] cursor-pointer">
                    </div>
                 </div>

                <div class="flex-1 min-w-0 w-full flex flex-col justify-between space-y-5">
                    <div class="flex items-center justify-between gap-4 w-full">
                        <div class="flex items-center gap-4 sm:gap-6 min-w-0">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 lg:w-32 lg:h-32 rounded-full border-4 sm:border-[5px] border-white overflow-hidden bg-white shrink-0 shadow-xl flex items-center justify-center">
                                @if ($work->creator->profile_image)
                                    <img src="{{ asset('storage/' . $work->creator->profile_image) }}"
                                         alt="{{ $work->creator->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-[#254bfe] text-[#ccff00] font-display text-xl sm:text-3xl flex items-center justify-center ">
                                        {{ substr($work->creator->name, 0, 2) }}
                                    </div>
                                @endif
                            </div>

                           <div class="min-w-0">
                                <h2 class="font-display text-3xl sm:text-5xl text-white tracking-normal leading-none truncate">
                                    <a href="{{ $isOwner ? route('profile.show') : route('creator.show', $work->creator->slug) }}" 
                                    class="hover:text-[#ccff00] transition">
                                        {{ $work->creator->name }}
                                    </a>
                                </h2>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                            <livewire:follow-button :creator="$work->creator" :key="'follow-'.$work->creator->id" />

                            <button type="button" @click="showShareModal = true" 
                                    class="text-white hover:text-[#ccff00] transition p-1" title="Bagikan">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center gap-8 sm:gap-12 text-white font-display text-lg sm:text-2xl tracking-wide pt-1">
                        <span><strong>{{ method_exists($work->creator, 'publishedWorksCount') ? $work->creator->publishedWorksCount() : 0 }}</strong> posts</span>
                        <span><strong>{{ method_exists($work->creator, 'followersCount') ? number_format($work->creator->followersCount()) : 0 }}</strong> followers</span>
                        <span><strong>{{ method_exists($work->creator, 'followingCount') ? number_format($work->creator->followingCount()) : 0 }}</strong> following</span>
                    </div>

                    @if($work->creator->bio)
                        <p class="text-white/95 text-sm sm:text-base leading-relaxed font-normal w-full pt-1">
                            {{ $work->creator->bio }}
                        </p>
                    @endif

                    <div class="flex flex-wrap lg:flex-nowrap items-center justify-between gap-y-3 gap-x-4 pt-2 text-white text-xs sm:text-sm md:text-base font-bold w-full">
                        @if (method_exists($work->creator, 'website') && $work->creator->website())
                            <a href="{{ $work->creator->website() }}" target="_blank" rel="noopener" class="flex items-center gap-2 hover:text-[#ccff00] transition whitespace-nowrap">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                </svg>
                                <span>{{ str($work->creator->website())->replace(['https://', 'http://'], '') }}</span>
                            </a>
                        @endif

                        @if (method_exists($work->creator, 'instagramHandle') && $work->creator->instagramHandle())
                            <a href="https://instagram.com/{{ ltrim($work->creator->instagramHandle(), '@') }}" target="_blank" rel="noopener" class="flex items-center gap-2 hover:text-[#ccff00] transition whitespace-nowrap">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="5" />
                                    <circle cx="12" cy="12" r="4" />
                                    <circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none" />
                                </svg>
                                <span>{{ ltrim($work->creator->instagramHandle(), '@') }}</span>
                            </a>
                        @endif

                        @if ($work->creator->location)
                            <span class="flex items-center gap-2 whitespace-nowrap">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.5-7.5 11.25-7.5 11.25S4.5 18 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                <span>{{ $work->creator->location }}</span>
                            </span>
                        @endif

                        @if ($work->creator->phone)
                            <span class="flex items-center gap-2 whitespace-nowrap">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a1.5 1.5 0 001.5-1.5v-3.75a1.5 1.5 0 00-1.5-1.5h-3.75a1.5 1.5 0 00-1.5 1.5v.75c0 .414-.336.75-.75.75h-.75a13.5 13.5 0 01-12-12v-.75c0-.414.336-.75.75-.75h.75a1.5 1.5 0 001.5-1.5V3.75a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v3z" />
                                </svg>
                                <span>{{ $work->creator->phone }}</span>
                            </span>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if (isset($creatorWorks) && $creatorWorks->count() > 0)
        <div class="max-w-7xl mx-auto px-4 sm:px-8 py-10 sm:py-14 mt-6 sm:mt-10">
            <h2 class="font-display text-3xl sm:text-5xl text-[#254bfe] text-center mb-8 tracking-wide leading-tight">
                Karya lainnya dari {{ $work->creator->name }}
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
                @foreach ($creatorWorks as $cw)
                    @php
                        $qty = (float) $cw->wasteDna->sum('quantity');
                        $qtyStr = str_replace('.', ',', (string) $qty);
                    @endphp

                    <div class="group relative flex flex-col justify-between transition-transform duration-200 hover:-translate-y-2 p-1 w-full h-full">
                        <a href="{{ route('work.show', $cw->slug) }}" class="block w-full">
                            <div class="relative w-full aspect-square bg-gray-900 border-2 border-[#FC00BB] shrink-0">
                                <div class="absolute -top-1.5 -left-1.5 w-3 h-3 bg-[#ccff00] border-2 border-[#FC00BB] z-30 pointer-events-none"></div>
                                <div class="absolute -top-1.5 -right-1.5 w-3 h-3 bg-[#ccff00] border-2 border-[#FC00BB] z-30 pointer-events-none"></div>
                                <div class="absolute -bottom-1.5 -left-1.5 w-3 h-3 bg-[#ccff00] border-2 border-[#FC00BB] z-30 pointer-events-none"></div>
                                <div class="absolute -bottom-1.5 -right-1.5 w-3 h-3 bg-[#ccff00] border-2 border-[#FC00BB] z-30 pointer-events-none"></div>

                                @if ($qty > 0)
                                    <div class="absolute top-2 left-2 z-30 bg-[#ccff00] text-[#254bfe] border border-black font-sans text-[7px] sm:text-[10px] font-extrabold px-1.5 sm:px-2 py-0.5 tracking-tight shadow-[1px_1px_0px_rgba(0,0,0,1)]">
                                        {{ $qtyStr }}kg sampah terpakai
                                    </div>
                                @endif

                                <div class="w-full h-full overflow-hidden flex items-center justify-center">
                                    @if ($cw->cover_image)
                                        <img src="{{ asset('storage/' . $cw->cover_image) }}" 
                                             alt="{{ $cw->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-bold font-sans">No Image</div>
                                    @endif
                                </div>
                            </div>
                        </a>

                        <div class="mt-2.5 sm:mt-3 text-center w-full">
                            <h4 class="font-display text-xs sm:text-base text-[#2F3AFF] leading-tight tracking-wide line-clamp-2-custom min-h-[2rem] sm:min-h-[2.5rem]" title="#{{ $loop->iteration }} {{$cw->title }}">
                                #{{ $loop->iteration }} {{ $cw->title }}
                            </h4>
                            <p class="font-sans text-[9px] sm:text-xs font-medium text-[#254bfe] mt-0.5 sm:mt-1 truncate">
                                {{ $work->creator->name }}
                            </p>

                            <button type="button" 
                                    wire:click="toggleLike({{ $cw->id }})" 
                                     class="font-sans text-[10px] sm:text-xs font-semibold {{ $cw->isAppreciatedBy(auth()->id()) ? 'fill-[#FC00BB]' : 'fill-[#2F3AFF]' }} mt-0.5 flex items-center justify-center gap-1 mx-auto hover:opacity-80 transition cursor-pointer">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 {{ $cw->isAppreciatedBy(auth()->id()) ? 'fill-[#FC00BB]' : 'fill-[#2F3AFF]' }}" viewBox="0 0 24 24">
                                    <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                </svg>
                                <span>{{ number_format($cw->appreciations_count ?? 0) }} likes</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('creator.show', $work->creator->slug) }}" class="font-display text-sm sm:text-lg text-[#254bfe] hover:text-[#ff007a] underline underline-offset-4">
                    Lihat lebih banyak →
                </a>
            </div>
        </div>
    @endif

    {{-- KOMENTAR + KARYA SERUPA --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-8 pb-14 mt-6 sm:mt-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">

            <div class="lg:col-span-2">
                @if ($work->allow_comments)
                    <livewire:work-comments :work="$work" />
                @else
                    <div class="bg-white border-2 border-[#2F3AFF]/20 rounded-xl p-6 text-center">
                        <p class="font-sans text-sm text-gray-500 font-medium">
                            Komentar dinonaktifkan oleh kreator untuk karya ini.
                        </p>
                    </div>
                @endif
            </div>

            @if (isset($similarWorks) && $similarWorks->count() > 0)
                <div>
                    <h2 class="font-display text-2xl sm:text-3xl text-[#254bfe] mb-6 tracking-wide">
                        Karya serupa
                    </h2>

                    <div class="grid grid-cols-2 gap-4 sm:gap-5">
                        @foreach ($similarWorks as $sw)
                            @php
                                $swQty = (float) $sw->wasteDna->sum('quantity');
                                $swQtyStr = str_replace('.', ',', (string) $swQty);
                            @endphp

                            <div class="group relative flex flex-col justify-between transition-transform duration-200 hover:-translate-y-2 p-1 w-full h-full">
                                <a href="{{ route('work.show', $sw->slug) }}" class="block w-full">
                                    <div class="relative w-full aspect-square bg-gray-900 border-2 border-[#FC00BB] shrink-0">
                                        <div class="absolute -top-1.5 -left-1.5 w-3 h-3 bg-[#ccff00] border-2 border-[#FC00BB] z-30 pointer-events-none"></div>
                                        <div class="absolute -top-1.5 -right-1.5 w-3 h-3 bg-[#ccff00] border-2 border-[#FC00BB] z-30 pointer-events-none"></div>
                                        <div class="absolute -bottom-1.5 -left-1.5 w-3 h-3 bg-[#ccff00] border-2 border-[#FC00BB] z-30 pointer-events-none"></div>
                                        <div class="absolute -bottom-1.5 -right-1.5 w-3 h-3 bg-[#ccff00] border-2 border-[#FC00BB] z-30 pointer-events-none"></div>

                                        @if ($swQty > 0)
                                            <div class="absolute top-2 left-2 z-30 bg-[#ccff00] text-[#254bfe] border border-black font-sans text-[7px] sm:text-[10px] font-extrabold px-1.5 sm:px-2 py-0.5 tracking-tight shadow-[1px_1px_0px_rgba(0,0,0,1)]">
                                                {{ $swQtyStr }}kg sampah terpakai
                                            </div>
                                        @endif

                                        <div class="w-full h-full overflow-hidden flex items-center justify-center">
                                            @if ($sw->cover_image)
                                                <img src="{{ asset('storage/' . $sw->cover_image) }}" alt="{{ $sw->title }}">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-bold font-sans">No Image</div>
                                            @endif
                                        </div>
                                    </div>
                                </a>

                                <div class="mt-2.5 sm:mt-3 text-center w-full">
                                    <h4 class="font-display text-xs sm:text-sm text-[#254bfe] truncate leading-tight tracking-wide">
                                        #{{ $loop->iteration }} {{ $sw->title }}
                                    </h4>
                                    <p class="font-sans text-[9px] sm:text-xs font-medium text-[#254bfe] mt-0.5 sm:mt-1 truncate">
                                        {{ $sw->creator->name ?? '' }}
                                    </p>
                                    
                                    <button type="button" 
                                            wire:click="toggleLike({{ $sw->id }})" 
                                            class="font-sans text-[10px] sm:text-xs font-semibold text-[#254bfe] hover:text-[#ff007a] mt-0.5 sm:mt-1 flex items-center justify-center gap-1 transition-colors mx-auto">
                                        <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 {{ $sw->isAppreciatedBy(auth()->id()) ? 'fill-[#ff007a]' : 'fill-[#254bfe]' }}" viewBox="0 0 24 24">
                                            <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                        </svg>
                                        <span>{{ number_format($sw->appreciations_count ?? 0) }} likes</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- MODAL SHARE --}}
            <div x-show="showShareModal" 
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
            
            <div @click.outside="showShareModal = false" 
                class="w-full max-w-md bg-white border-4 border-[#2F3AFF] shadow-[8px_8px_0px_#2F3AFF] p-6 text-left relative font-sans">
                
                {{-- HEADER MODAL --}}
                <div class="flex items-center justify-between border-b-2 border-[#2F3AFF]/20 pb-4 mb-5">
                    <h3 class="font-display text-xl sm:text-2xl text-[#2F3AFF] tracking-wide">
                        BAGIKAN KARYA INI
                    </h3>
                    <button @click="showShareModal = false" class="text-[#2F3AFF] hover:text-[#FC00BB] text-2xl font-bold leading-none cursor-pointer">
                        &times;
                    </button>
                </div>

                {{-- OPSI MEDIA SOSIAL --}}
                <div class="grid grid-cols-4 gap-4 mb-6 text-center">
                    
                    {{-- WHATSAPP --}}
                    <a :href="'https://api.whatsapp.com/send?text=' + encodeURIComponent('Cek karya {{ $work->title }} oleh {{ $work->creator->name ?? 'Kreator' }} di TRASSIC: ' + window.location.href)" 
                    target="_blank" 
                    class="flex flex-col items-center gap-2 group">
                        <div class="w-12 h-12 rounded-full bg-[#25D366] text-white flex items-center justify-center group-hover:scale-110 transition-transform shadow-[2px_2px_0px_#000]">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        </div>
                        <span class="text-xs font-bold text-[#2F3AFF] group-hover:text-[#FC00BB]">WhatsApp</span>
                    </a>

                    {{-- INSTAGRAM --}}
                    <button type="button" 
                            @click="
                                navigator.clipboard.writeText(window.location.href);
                                instaCopied = true;
                                setTimeout(() => instaCopied = false, 3000);
                                window.open('https://instagram.com', '_blank');
                            "
                            class="flex flex-col items-center gap-2 group cursor-pointer relative">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] text-white flex items-center justify-center group-hover:scale-110 transition-transform shadow-[2px_2px_0px_#000]">
                            <svg class="w-6 h-6 fill-none stroke-current" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-[#2F3AFF] group-hover:text-[#FC00BB]">Instagram</span>
                    </button>

                    {{-- FACEBOOK --}}
                    <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href)" 
                    target="_blank" 
                    class="flex flex-col items-center gap-2 group">
                        <div class="w-12 h-12 rounded-full bg-[#1877F2] text-white flex items-center justify-center group-hover:scale-110 transition-transform shadow-[2px_2px_0px_#000]">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.592 0 9 1.583 9 4.615V8z"/></svg>
                        </div>
                        <span class="text-xs font-bold text-[#2F3AFF] group-hover:text-[#FC00BB]">Facebook</span>
                    </a>

                    {{-- TWITTER / X --}}
                    <a :href="'https://twitter.com/intent/tweet?text=' + encodeURIComponent('Cek karya {{ $work->title }} oleh {{ $work->creator->name ?? 'Kreator' }} di TRASSIC: ') + '&url=' + encodeURIComponent(window.location.href)" 
                    target="_blank" 
                    class="flex flex-col items-center gap-2 group">
                        <div class="w-12 h-12 rounded-full bg-black text-white flex items-center justify-center group-hover:scale-110 transition-transform shadow-[2px_2px_0px_#000]">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </div>
                        <span class="text-xs font-bold text-[#2F3AFF] group-hover:text-[#FC00BB]">Twitter / X</span>
                    </a>

                    {{-- NOTIFIKASI SALIN UTK INSTAGRAM --}}
                    <div x-show="instaCopied" x-cloak class="col-span-4 text-center text-xs font-bold text-[#25D366] mt-1">
                        ✓ Link disalin! Tinggal paste/tempel di Instagram.
                    </div>
                </div>

                {{-- INPUT COPY LINK --}}
                <div class="space-y-2">
                    <div class="flex items-center gap-2 border-2 border-[#2F3AFF] p-1 bg-[#F8F8F8] relative">
                        <input type="text" 
                            readonly 
                            :value="window.location.href" 
                            class="w-full bg-transparent px-2 text-xs font-medium text-[#2F3AFF] focus:outline-none">
                        
                        <button type="button" 
                                @click="
                                    navigator.clipboard.writeText(window.location.href);
                                    copied = true;
                                    setTimeout(() => copied = false, 2000);
                                "
                                class="px-4 py-2 bg-[#D9FC28] text-[#2F3AFF] hover:bg-[#2F3AFF] hover:text-[#D9FC28] font-display text-xs tracking-wider transition whitespace-nowrap cursor-pointer border border-black shadow-[2px_2px_0px_#000]">
                            <span x-text="copied ? 'Tersalin!' : 'Salin Link'"></span>
                        </button>
                    </div>

                    <div x-show="copied" x-cloak class="text-xs font-bold text-[#25D366] text-right">
                        ✓ Link berhasil disalin ke clipboard!
                    </div>
                </div>

            </div>
        </div>

                    {{-- =================================================== --}}
                        {{-- 1. MODAL LAPORKAN KARYA (Untuk Pengunjung/Orang Lain) --}}
                        {{-- =================================================== --}}
                        <div x-show="showReportModal" 
                            x-cloak 
                            x-transition.opacity
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-xs p-4">
                            
                            <div @click.away="showReportModal = false" 
                                class="relative w-full max-w-lg bg-[#F8F9FA] border-[5px] border-[#FC00BB] rounded-[28px] p-6 sm:p-8 shadow-2xl">
                                
                                {{-- Tombol Close --}}
                                <button type="button" 
                                        @click="showReportModal = false"
                                        class="absolute -top-4 -right-4 w-10 h-10 bg-[#E60023] text-white font-bold text-lg rounded-tl-[18px] rounded-br-[18px] rounded-tr-sm rounded-bl-sm border-2 border-white ring-2 ring-[#E60023] shadow-md flex items-center justify-center hover:scale-105 active:scale-95 transition-transform cursor-pointer z-10">
                                    <svg class="w-5 h-5 stroke-current stroke-[3]" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <h3 class="font-display text-2xl sm:text-3xl text-[#2F3AFF] text-center mb-2 tracking-wide">
                                    Laporkan Karya Ini
                                </h3>
                                <p class="font-sans text-xs sm:text-sm text-gray-600 text-center mb-6 font-medium">
                                    Pilih alasan kamu melaporkan karya ini kepada tim verifikasi TRASSIC:
                                </p>

                                <form wire:submit.prevent="submitReport" class="space-y-4">
                                    <div class="space-y-2.5 text-left font-sans text-xs sm:text-sm text-[#2F3AFF] font-bold">
                                        <label class="flex items-center gap-3 p-2.5 bg-white border-2 border-[#2F3AFF]/20 rounded-xl cursor-pointer hover:border-[#FC00BB] transition">
                                            <input type="radio" wire:model.live="reportReason" value="Konten tidak relevan/spam" class="w-4 h-4 accent-[#FC00BB]">
                                            <span>Konten tidak relevan / Spam</span>
                                        </label>
                                        
                                        <label class="flex items-center gap-3 p-2.5 bg-white border-2 border-[#2F3AFF]/20 rounded-xl cursor-pointer hover:border-[#FC00BB] transition">
                                            <input type="radio" wire:model.live="reportReason" value="Klaim penggunaan sampah palsu" class="w-4 h-4 accent-[#FC00BB]">
                                            <span>Klaim penggunaan sampah palsu</span>
                                        </label>
                                        
                                        <label class="flex items-center gap-3 p-2.5 bg-white border-2 border-[#2F3AFF]/20 rounded-xl cursor-pointer hover:border-[#FC00BB] transition">
                                            <input type="radio" wire:model.live="reportReason" value="Pelanggaran hak cipta" class="w-4 h-4 accent-[#FC00BB]">
                                            <span>Pelanggaran hak cipta karya</span>
                                        </label>
                                        
                                        <label class="flex items-center gap-3 p-2.5 bg-white border-2 border-[#2F3AFF]/20 rounded-xl cursor-pointer hover:border-[#FC00BB] transition">
                                            <input type="radio" wire:model.live="reportReason" value="Lainnya" class="w-4 h-4 accent-[#FC00BB]">
                                            <span>Alasan lainnya</span>
                                        </label>
                                    </div>
                                    @error('reportReason') 
                                        <span class="text-red-500 font-bold text-xs block text-left">{{ $message }}</span> 
                                    @enderror

                                    <div class="pt-1">
                                        <textarea wire:model="reportDetails" 
                                                rows="3" 
                                                placeholder="Tuliskan detail laporan tambahan..." 
                                                class="w-full bg-white border-2 border-[#2F3AFF]/30 rounded-xl p-3 text-xs sm:text-sm font-sans text-gray-800 focus:outline-none focus:border-[#FC00BB] focus:ring-1 focus:ring-[#FC00BB]"></textarea>
                                        @error('reportDetails') 
                                            <span class="text-red-500 font-bold text-xs block text-left">{{ $message }}</span> 
                                        @enderror
                                    </div>

                                    <div class="flex items-center justify-center gap-3 sm:gap-4 pt-3">
                                        <button type="submit" 
                                                wire:loading.attr="disabled"
                                                class="flex-1 bg-[#D9FC28] hover:bg-[#c2e61a] text-[#2F3AFF] font-display text-sm sm:text-base py-3 sm:py-3.5 rounded-xl uppercase tracking-wider transition active:scale-95 shadow-sm font-black cursor-pointer disabled:opacity-50">
                                            <span wire:loading.remove wire:target="submitReport">KIRIM</span>
                                            <span wire:loading wire:target="submitReport">MENGIRIM...</span>
                                        </button>

                                        <button type="button" 
                                                @click="showReportModal = false" 
                                                class="flex-1 bg-[#FC00BB] hover:bg-[#e000a5] text-white font-display text-sm sm:text-base py-3 sm:py-3.5 rounded-xl uppercase tracking-wider transition active:scale-95 shadow-sm font-black cursor-pointer">
                                            BATAL
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>


                        {{-- =================================================== --}}
                        {{-- 2. MODAL HAPUS KARYA (Untuk Pemilik Karya)          --}}
                        {{-- =================================================== --}}
                        <div x-show="showDeleteModal" 
                            x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs transition-opacity"
                            x-transition:enter="ease-out duration-200"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in duration-150"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0">

                            <div class="relative w-full max-w-md bg-[#F8F8F8] border-4 border-[#FC00BB] rounded-tl-3xl rounded-br-3xl rounded-tr-none rounded-bl-none p-6 sm:p-8"
                                @click.outside="showDeleteModal = false"
                                x-transition:enter="ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95">

                                {{-- Tombol Close Merah --}}
                                <button type="button" 
                                        @click="showDeleteModal = false"
                                        class="absolute -top-3.5 -right-3.5 w-9 h-9 sm:w-10 sm:h-10 bg-[#E51B24] hover:bg-[#c9121a] border-2 border-[#E51B24] ring-2 ring-white ring-inset rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none flex items-center justify-center transition-transform hover:scale-105 cursor-pointer shadow-md">
                                    <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                </button>

                                {{-- Form Delete --}}
                                <form action="{{ route('works.destroy', $work->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <div class="py-6 sm:py-8 text-center">
                                        <p class="font-sans text-base sm:text-lg font-bold text-[#2F3AFF] tracking-wide">
                                            Apakah anda yakin ingin menghapus karya?
                                        </p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 pt-2">
                                        <button type="submit" 
                                                class="w-full py-3 bg-[#D9FC28] hover:bg-[#bce018] text-[#2F3AFF] font-sans text-sm font-bold tracking-wider transition-colors flex items-center justify-center cursor-pointer shadow-sm">
                                            Ya
                                        </button>

                                        <button type="button" 
                                                @click="showDeleteModal = false"
                                                class="w-full py-3 bg-[#FC00BB] hover:bg-[#d8009f] text-white font-sans text-sm font-bold tracking-wider transition-colors flex items-center justify-center cursor-pointer shadow-sm">
                                            Tidak
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>

                        {{-- MODAL SHARE --}}
                        <div x-show="showShareModal" 
                            x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                            
                            <div @click.outside="showShareModal = false" 
                                class="w-full max-w-md bg-white border-4 border-[#2F3AFF] shadow-[8px_8px_0px_#2F3AFF] p-6 text-left relative font-sans">
                                
                                {{-- HEADER MODAL --}}
                                <div class="flex items-center justify-between border-b-2 border-[#2F3AFF]/20 pb-4 mb-5">
                                    <h3 class="font-display text-xl sm:text-2xl text-[#2F3AFF] tracking-wide">
                                        BAGIKAN KARYA INI
                                    </h3>
                                    <button @click="showShareModal = false" class="text-[#2F3AFF] hover:text-[#FC00BB] text-2xl font-bold leading-none cursor-pointer">
                                        &times;
                                    </button>
                                </div>

                                {{-- OPSI MEDIA SOSIAL --}}
                                <div class="grid grid-cols-4 gap-4 mb-6 text-center" x-data="{ instaCopied: false }">
                                    
                                    {{-- WHATSAPP --}}
                                    <a :href="'https://api.whatsapp.com/send?text=' + encodeURIComponent('Cek karya {{ $work->title }} oleh {{ $work->creator->name ?? 'Kreator' }} di TRASSIC: ' + window.location.href)" 
                                    target="_blank" 
                                    class="flex flex-col items-center gap-2 group">
                                        <div class="w-12 h-12 rounded-full bg-[#25D366] text-white flex items-center justify-center group-hover:scale-110 transition-transform shadow-[2px_2px_0px_#000]">
                                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                        </div>
                                        <span class="text-xs font-bold text-[#2F3AFF] group-hover:text-[#FC00BB]">WhatsApp</span>
                                    </a>

                                    {{-- INSTAGRAM --}}
                                    <button type="button" 
                                            @click="
                                                navigator.clipboard.writeText(window.location.href);
                                                instaCopied = true;
                                                setTimeout(() => instaCopied = false, 3000);
                                                window.open('https://instagram.com', '_blank');
                                            "
                                            class="flex flex-col items-center gap-2 group cursor-pointer relative">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] text-white flex items-center justify-center group-hover:scale-110 transition-transform shadow-[2px_2px_0px_#000]">
                                            <svg class="w-6 h-6 fill-none stroke-current" stroke-width="2" viewBox="0 0 24 24">
                                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                            </svg>
                                        </div>
                                        <span class="text-xs font-bold text-[#2F3AFF] group-hover:text-[#FC00BB]">Instagram</span>
                                    </button>

                                    {{-- FACEBOOK --}}
                                    <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href)" 
                                    target="_blank" 
                                    class="flex flex-col items-center gap-2 group">
                                        <div class="w-12 h-12 rounded-full bg-[#1877F2] text-white flex items-center justify-center group-hover:scale-110 transition-transform shadow-[2px_2px_0px_#000]">
                                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.592 0 9 1.583 9 4.615V8z"/></svg>
                                        </div>
                                        <span class="text-xs font-bold text-[#2F3AFF] group-hover:text-[#FC00BB]">Facebook</span>
                                    </a>

                                    {{-- TWITTER / X --}}
                                    <a :href="'https://twitter.com/intent/tweet?text=' + encodeURIComponent('Cek karya {{ $work->title }} oleh {{ $work->creator->name ?? 'Kreator' }} di TRASSIC: ') + '&url=' + encodeURIComponent(window.location.href)" 
                                    target="_blank" 
                                    class="flex flex-col items-center gap-2 group">
                                        <div class="w-12 h-12 rounded-full bg-black text-white flex items-center justify-center group-hover:scale-110 transition-transform shadow-[2px_2px_0px_#000]">
                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                        </div>
                                        <span class="text-xs font-bold text-[#2F3AFF] group-hover:text-[#FC00BB]">Twitter / X</span>
                                    </a>

                                    {{-- NOTIFIKASI SALIN UTK INSTAGRAM --}}
                                    <div x-show="instaCopied" x-cloak class="col-span-4 text-center text-xs font-bold text-[#25D366] mt-1">
                                        ✓ Link disalin! Tinggal paste/tempel di Instagram.
                                    </div>
                                </div>

                                {{-- INPUT COPY LINK --}}
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2 border-2 border-[#2F3AFF] p-1 bg-[#F8F8F8] relative">
                                        <input type="text" 
                                            readonly 
                                            :value="window.location.href" 
                                            class="w-full bg-transparent px-2 text-xs font-medium text-[#2F3AFF] focus:outline-none">
                                        
                                        <button type="button" 
                                                @click="
                                                    navigator.clipboard.writeText(window.location.href);
                                                    copied = true;
                                                    setTimeout(() => copied = false, 2000);
                                                "
                                                class="px-4 py-2 bg-[#D9FC28] text-[#2F3AFF] hover:bg-[#2F3AFF] hover:text-[#D9FC28] font-display text-xs tracking-wider transition whitespace-nowrap cursor-pointer border border-black shadow-[2px_2px_0px_#000]">
                                            <span x-text="copied ? 'Tersalin!' : 'Salin Link'"></span>
                                        </button>
                                    </div>

                                    <div x-show="copied" x-cloak class="text-xs font-bold text-[#25D366] text-right">
                                        ✓ Link berhasil disalin ke clipboard!
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div> 
            </form>
            

        </div>
    </div>

</div>