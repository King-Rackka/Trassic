<x-app-layout>
    <x-slot:title>{{ $work->title }} - Trassic</x-slot:title>

    @push('scripts')
        @viteReactRefresh
        @vite(['resources/js/creator-lanyard-entry.jsx'])
    @endpush

    <div class="w-full bg-white font-sans bg-grid-pattern" x-data="{ activeImage: '{{ $work->cover_image ? asset('storage/'.$work->cover_image) : '' }}' }">

        {{-- BREADCRUMB --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-8 pt-4 pb-2">
            <p class="font-sans text-[14px] sm:text-[14px] font-semibold tracking-wider text-gray-500">
                <a href="{{ route('explore') }}" class="hover:text-[#254bfe] transition-colors">Explore</a>
                <span class="mx-1">/</span>
                <a href="{{ route('explore') }}" class="hover:text-[#254bfe] transition-colors">Karya lainnya</a>
                <span class="mx-1">/</span>
                <span class="text-[#254bfe] font-bold">{{ $work->title }} by {{ $work->creator->name ?? 'Creator' }}</span>
            </p>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-8 py-4 sm:py-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-10">

                {{-- KIRI: Galeri --}}
                <div>
                    <div class="w-full max-w-[560px] aspect-[4/3] bg-gray-900 border-2 border-[#FC00BB] shadow-[4px_4px_0px_rgba(0,0,0,1)] overflow-hidden">
                        <img :src="activeImage" class="w-full h-full object-cover" alt="{{ $work->title }}">
                    </div>

                    @if ($work->images && $work->images->count() > 0)
                        <div class="grid grid-cols-4 gap-2 sm:gap-3 mt-3">
                            <button type="button"
                                    @click="activeImage = '{{ asset('storage/'.$work->cover_image) }}'"
                                    class="aspect-square border-2 border-[#ff007a] overflow-hidden hover:opacity-80 transition">
                                <img src="{{ asset('storage/'.$work->cover_image) }}" alt="" class="w-full h-full object-cover">
                            </button>

                            @foreach ($work->images as $img)
                                <button type="button"
                                        @click="activeImage = '{{ asset('storage/'.$img->image_path) }}'"
                                        class="aspect-square border-2 border-[#ff007a] overflow-hidden hover:opacity-80 transition">
                                    <img src="{{ asset('storage/'.$img->image_path) }}" alt="" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- KANAN: Info --}}
                <div>
                    <div class="flex items-start justify-between gap-4 mb-1">
                        <h1 class="font-display text-3xl sm:text-4xl text-[#254bfe] uppercase leading-tight">
                            {{ $work->title }}
                        </h1>

                        <div class="flex items-center gap-2 shrink-0">
                            @auth
                                <livewire:bookmark-button :work="$work" :is-bookmarked="$isBookmarked" />
                            @else
                                <button onclick="$dispatch('show-login-prompt')"
                                        type="button"
                                        class="flex items-center gap-1.5 border-2 border-black bg-[#ccff00] hover:bg-[#ff007a] text-[#254bfe] hover:text-white font-display text-xs uppercase px-3.5 py-2 shadow-[2px_2px_0px_rgba(0,0,0,1)] active:translate-y-0.5 transition-all">
                                    <img src="{{ asset('images/icons/bookmark.png') }}" 
                                         alt="Favorit" 
                                         class="w-3.5 h-3.5 sm:w-4 sm:h-4 object-contain">
                                    <span>Favorit</span>
                                </button>
                            @endauth

                            <button type="button" onclick="navigator.clipboard.writeText(window.location.href)"
                                    class="w-9 h-9 border-2 border-black bg-white flex items-center justify-center text-[#254bfe] shadow-[2px_2px_0px_rgba(0,0,0,1)] hover:bg-[#ccff00] transition" title="Bagikan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </button>
                            <button class="w-9 h-9 border-2 border-black bg-white flex items-center justify-center text-[#254bfe] shadow-[2px_2px_0px_rgba(0,0,0,1)] hover:bg-[#ccff00] transition" title="Opsi">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>
                            </button>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 mb-4">
                        by <a href="{{ route('creator.show', $work->creator->slug) }}" class="text-[#254bfe] font-bold hover:underline">{{ $work->creator->name }}</a>
                    </p>

                    {{-- TAGS --}}
                    <div class="flex flex-wrap items-center gap-2.5 mb-4">
                        <span class="text-[#2F3AFF] font-bold text-sm sm:text-base mr-1">Tags:</span>
                        
                        @if ($work->category)
                            <span class="bg-[#2F3AFF] text-white font-bold text-xs sm:text-sm px-3.5 py-1 border-2 border-[#FC00BB] inline-flex items-center justify-center">
                                {{ $work->category }}
                            </span>
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
                            // Mengubah string JSON dari DB menjadi array PHP murni secara aman
                            $suppMaterials = [];
                            if (!empty($dna->supporting_materials)) {
                                $suppMaterials = is_array($dna->supporting_materials) 
                                    ? $dna->supporting_materials 
                                    : json_decode($dna->supporting_materials, true);
                            }
                        @endphp

                        <div class="bg-white border-[3px] sm:border-4 border-[#FC00BB] shadow-[6px_6px_0px_#2F3AFF] p-5 sm:p-6 mb-6">
                            <h3 class="font-display text-2xl sm:text-3xl text-[#2F3AFF] tracking-wide mb-4">
                                Detail penggunaan sampah
                            </h3>

                            <div class="grid grid-cols-[140px_16px_1fr] sm:grid-cols-[160px_20px_1fr] gap-y-3 text-sm sm:text-base text-[#2F3AFF] items-start">
                                
                                {{-- Jenis Sampah --}}
                                <span class="font-sans font-bold">Jenis sampah</span>
                                <span>:</span>
                                <span class="font-sans font-medium">
                                    {{ $dna->waste_type ?? $dna->material }}
                                </span>

                                {{-- Sumber --}}
                                @if ($dna->source)
                                    <span class="font-sans font-bold">Sumber</span>
                                    <span>:</span>
                                    <span class="font-sans font-medium">{{ $dna->source }}</span>
                                @endif

                                {{-- Berat --}}
                                @if ($dna->quantity)
                                    <span class="font-sans font-bold">Berat</span>
                                    <span>:</span>
                                    <span class="font-sans font-medium">
                                        ± {{ $dna->unit === 'g' || $dna->unit === 'gram' ? ($dna->quantity < 1 ? $dna->quantity * 1000 : $dna->quantity) : $dna->quantity }} {{ $dna->unit === 'item' ? 'item' : 'gram' }}
                                    </span>
                                @endif

                                {{-- Bahan Pendukung --}}
                                @if (is_array($suppMaterials) && count(array_filter($suppMaterials)) > 0)
                                    <span class="font-sans font-bold">Bahan pendukung</span>
                                    <span>:</span>
                                    <ol class="list-decimal list-inside space-y-0.5 font-medium">
                                        @foreach (array_filter($suppMaterials) as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ol>
                                @endif

                                {{-- Hasil Pemanfaatan --}}
                                <span class="font-sans font-bold">Hasil pemanfaatan</span>
                                <span>:</span>
                                <span class="font-sans font-medium">{{ $dna->usage_result ?? $work->title }}</span>

                            </div>
                        </div>
                    @endforeach

                    {{-- PROGRESS BAR SAMPAH TERPAKAI --}}
                    @php
                        $used = (float) ($work->totalWasteQuantity() ?? $work->wasteDna->sum('quantity'));
                        $target = (float) ($work->target_quantity ?? 4);
                        $pct = $target > 0 ? min(100, round(($used / $target) * 100)) : 0;
                    @endphp

                    @if ($used > 0)
                        <div class="flex items-center gap-3.5 sm:gap-5 bg-[#2F3AFF] text-white px-5 sm:px-6 py-3 sm:py-3.5 rounded-tl-2xl rounded-br-2xl sm:rounded-tl-[26px] sm:rounded-br-[26px] shadow-sm">
                            <svg class="w-6 h-6 text-white shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>

                            <span class="font-sans text-xs sm:text-sm font-medium whitespace-nowrap">
                                <strong class="font-extrabold text-sm sm:text-base">{{ str_replace('.', ',', (string)$used) }} kg</strong> dari {{ str_replace('.', ',', (string)$target) }}kg sampah terpakai
                            </span>

                            <div class="flex-1 h-3 sm:h-3.5 border-2 border-white rounded-full p-[1.5px] flex items-center ml-1">
                                <div class="h-full bg-white rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="w-full bg-[#2F3AFF] border-y-4 sm:border-y-[6px] border-[#FC00BB] py-8 sm:py-12 relative z-20 mt-10 sm:mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-8">
                <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-14">

                    <div class="w-full max-w-[280px] sm:max-w-xs lg:w-80 shrink-0 flex items-center justify-center">
                        <div id="creator-lanyard-react-root"
                             data-name="{{ $work->creator->name }}"
                             data-join="{{ optional($work->creator->created_at)->format('d/m/Y') }}"
                             class="w-full h-[360px] sm:h-[420px] cursor-pointer">
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
                                        <div class="w-full h-full bg-[#254bfe] text-[#ccff00] font-display text-xl sm:text-3xl flex items-center justify-center uppercase">
                                            {{ substr($work->creator->name, 0, 2) }}
                                        </div>
                                    @endif
                                </div>

                                <div class="min-w-0">
                                    <h2 class="font-display text-3xl sm:text-5xl text-white uppercase tracking-normal leading-none truncate">
                                        {{ $work->creator->name }}
                                    </h2>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                                <livewire:follow-button :creator="$work->creator" :key="'follow-'.$work->creator->id" />

                                <button type="button" onclick="navigator.clipboard.writeText(window.location.href)" 
                                        class="text-white hover:text-[#ccff00] transition p-1" title="Bagikan">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                </button>

                                <button type="button" class="text-white hover:text-[#ccff00] transition p-1" title="Opsi">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <circle cx="5" cy="12" r="2"/>
                                        <circle cx="12" cy="12" r="2"/>
                                        <circle cx="19" cy="12" r="2"/>
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

        {{-- KARYA LAINNYA DARI CREATOR --}}
        @if (isset($creatorWorks) && $creatorWorks->count() > 0)
            <div class="max-w-7xl mx-auto px-4 sm:px-8 py-10 sm:py-14 mt-6 sm:mt-10">
                <h2 class="font-display text-3xl sm:text-5xl text-[#254bfe] uppercase text-center mb-8 tracking-wide leading-tight">
                    Karya lainnya dari {{ $work->creator->name }}
                </h2>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
                    @foreach ($creatorWorks as $cw)
                        @php
                            $qty = (float) $cw->wasteDna->sum('quantity');
                            $qtyStr = str_replace('.', ',', (string) $qty);
                        @endphp

                        <div class="group flex flex-col items-center w-full">
                            <a href="{{ route('work.show', $cw->slug) }}" class="block w-full">
                                <div class="relative w-full aspect-square bg-gray-900 border-2 border-[#ff007a] shadow-[3px_3px_0px_rgba(0,0,0,1)] shrink-0">
                                    <div class="absolute -top-1.5 -left-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                                    <div class="absolute -top-1.5 -right-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                                    <div class="absolute -bottom-1.5 -left-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                                    <div class="absolute -bottom-1.5 -right-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>

                                    @if ($qty > 0)
                                        <div class="absolute top-2 left-2 z-30 bg-[#ccff00] text-[#254bfe] border border-black font-sans text-[7px] sm:text-[10px] font-extrabold px-1.5 sm:px-2 py-0.5 uppercase tracking-tight shadow-[1px_1px_0px_rgba(0,0,0,1)]">
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
                                <h4 class="font-display text-xs sm:text-base text-[#254bfe] truncate uppercase leading-tight tracking-wide">
                                    #{{ $loop->iteration }} {{ $cw->title }}
                                </h4>
                                <p class="font-sans text-[9px] sm:text-xs font-medium text-[#254bfe] uppercase mt-0.5 sm:mt-1 truncate">
                                    {{ $work->creator->name }}
                                </p>
                                <p class="font-sans text-[10px] sm:text-xs font-semibold text-[#254bfe] mt-0.5 sm:mt-1 flex items-center justify-center gap-1">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 fill-[#254bfe]" viewBox="0 0 24 24">
                                        <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                    </svg>
                                    <span>{{ number_format($cw->appreciations_count ?? 0) }} likes</span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-10">
                    <a href="{{ route('creator.show', $work->creator->slug) }}" class="font-display text-sm sm:text-lg text-[#254bfe] hover:text-[#ff007a] uppercase underline underline-offset-4">
                        Lihat lebih banyak →
                    </a>
                </div>
            </div>
        @endif

        {{-- KOMENTAR + KARYA SERUPA --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-8 pb-14 mt-6 sm:mt-10">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">

                <div class="lg:col-span-2">
                    <livewire:work-comments :work="$work" />
                </div>

                @if (isset($similarWorks) && $similarWorks->count() > 0)
                    <div>
                        <h2 class="font-display text-2xl sm:text-3xl text-[#254bfe] uppercase mb-6 tracking-wide">
                            Karya serupa
                        </h2>

                        <div class="grid grid-cols-2 gap-4 sm:gap-5">
                            @foreach ($similarWorks as $sw)
                                @php
                                    $swQty = (float) $sw->wasteDna->sum('quantity');
                                    $swQtyStr = str_replace('.', ',', (string) $swQty);
                                @endphp

                                <div class="group flex flex-col items-center w-full">
                                    <a href="{{ route('work.show', $sw->slug) }}" class="block w-full">
                                        <div class="relative w-full aspect-square bg-gray-900 border-2 border-[#ff007a] shadow-[3px_3px_0px_rgba(0,0,0,1)] shrink-0">
                                            <div class="absolute -top-1.5 -left-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                                            <div class="absolute -top-1.5 -right-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                                            <div class="absolute -bottom-1.5 -left-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                                            <div class="absolute -bottom-1.5 -right-1.5 w-3 h-3 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>

                                            @if ($swQty > 0)
                                                <div class="absolute top-2 left-2 z-30 bg-[#ccff00] text-[#254bfe] border border-black font-sans text-[7px] sm:text-[9px] font-extrabold px-1.5 py-0.5 uppercase tracking-tight shadow-[1px_1px_0px_rgba(0,0,0,1)]">
                                                    {{ $swQtyStr }}kg sampah terpakai
                                                </div>
                                            @endif

                                            <div class="w-full h-full overflow-hidden flex items-center justify-center">
                                                @if ($sw->cover_image)
                                                    <img src="{{ asset('storage/' . $sw->cover_image) }}" 
                                                         alt="{{ $sw->title }}" 
                                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-bold font-sans">No Image</div>
                                                @endif
                                            </div>
                                        </div>
                                    </a>

                                    <div class="mt-2.5 sm:mt-3 text-center w-full">
                                        <h4 class="font-display text-xs sm:text-sm text-[#254bfe] truncate uppercase leading-tight tracking-wide">
                                            #{{ $loop->iteration }} {{ $sw->title }}
                                        </h4>
                                        <p class="font-sans text-[9px] sm:text-xs font-medium text-[#254bfe] uppercase mt-0.5 sm:mt-1 truncate">
                                            {{ $sw->creator->name ?? '' }}
                                        </p>
                                        <p class="font-sans text-[10px] sm:text-xs font-semibold text-[#254bfe] mt-0.5 sm:mt-1 flex items-center justify-center gap-1">
                                            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 fill-[#254bfe]" viewBox="0 0 24 24">
                                                <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                            </svg>
                                            <span>{{ number_format($sw->appreciations_count ?? 0) }} likes</span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>