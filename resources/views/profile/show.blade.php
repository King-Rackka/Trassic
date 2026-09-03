<x-app-layout>
    <x-slot:title>Profil Saya - Trassic</x-slot:title>

    <div class="w-full bg-grid-pattern min-h-screen pb-16 font-sans" x-data="{ activeFilter: 'diposting', shareModalOpen: false, instaCopied: false, copied: false }">

        <style>
            .line-clamp-2-custom {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        </style>

        {{-- ========================================== --}}
        {{-- 1. COVER BANNER & AVATAR                   --}}
        {{-- ========================================== --}}
        <div class="relative w-full">
            <div class="w-full h-64 sm:h-80 md:h-[380px] lg:h-[420px] bg-gray-900 relative overflow-hidden z-10">
                @if (isset($creator->cover_image) && $creator->cover_image)
                    <img src="{{ asset('storage/' . $creator->cover_image) }}" 
                         alt="{{ $user->name }} Cover" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-r from-[#2F3AFF] via-[#6366f1] to-[#FC00BB]"></div>
                @endif

                <div class="absolute inset-0 bg-gradient-to-b from-[#2F3AFF]/40 via-transparent to-[#2F3AFF]/80 pointer-events-none z-20"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-8 relative">
                <div class="absolute -bottom-16 sm:-bottom-20 left-6 sm:left-12 z-30">
                    <div class="w-32 h-32 sm:w-44 sm:h-44 rounded-full border-4 sm:border-[6px] border-white overflow-hidden bg-[#2F3AFF] flex items-center justify-center shrink-0">
                        @if (isset($creator->profile_image) && $creator->profile_image)
                            <img src="{{ asset('storage/' . $creator->profile_image) }}" 
                                 alt="{{ $user->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <span class="text-[#D9FC28] font-display text-4xl sm:text-6xl uppercase">
                                {{ substr($user->name, 0, 2) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- 2. INFORMASI PROFIL & AKSI USER            --}}
        {{-- ========================================== --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-8 pt-20 sm:pt-24">

            {{-- NAMA & TOMBOL AKSI (SESUAI UI REFERENCE GAMBAR 2) --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#2F3AFF]/10 pb-6">
                <div>
                    <h1 class="font-display text-3xl sm:text-5xl text-[#2F3AFF] uppercase tracking-normal leading-tight">
                        {{ $user->name }}
                    </h1>
                </div>

                {{-- AKSI PROFIL: EDIT PROFIL, SHARE, OPSI --}}
                <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                    <a href="{{ route('profile.edit') }}" 
                       class="px-5 py-2.5 bg-[#D9FC28] hover:bg-[#c8f01b] text-[#2F3AFF] font-bold text-xs sm:text-sm flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4 text-[#2F3AFF]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        Edit Profil
                    </a>

                    {{-- SHARE BUTTON (ICON ONLY) --}}
                    <button type="button" 
                            @click="shareModalOpen = true" 
                            class="text-[#2F3AFF] hover:text-[#FC00BB] p-1 transition-colors cursor-pointer" 
                            title="Bagikan">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                    </button>

                    {{-- OPTIONS 3 DOTS (ICON ONLY) --}}
                    <button type="button" 
                            class="text-[#2F3AFF] hover:text-[#FC00BB] p-1 transition-colors cursor-pointer" 
                            title="Opsi">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                            <circle cx="5" cy="12" r="2"/>
                            <circle cx="12" cy="12" r="2"/>
                            <circle cx="19" cy="12" r="2"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- STATISTIK --}}
            <div class="flex gap-8 sm:gap-16 py-4 text-[#2F3AFF]">
                <div>
                    <span class="font-extrabold text-base sm:text-xl">{{ number_format($postsCount ?? 0) }}</span>
                    <span class="text-xs sm:text-sm text-gray-600 uppercase font-semibold ml-1">posts</span>
                </div>
                <div>
                    <span class="font-extrabold text-base sm:text-xl">{{ number_format($followersCount ?? 0) }}</span>
                    <span class="text-xs sm:text-sm text-gray-600 uppercase font-semibold ml-1">followers</span>
                </div>
                <div>
                    <span class="font-extrabold text-base sm:text-xl">{{ number_format($followingCount ?? 0) }}</span>
                    <span class="text-xs sm:text-sm text-gray-600 uppercase font-semibold ml-1">following</span>
                </div>
            </div>

            {{-- DESKRIPSI & KONTAK --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pt-2">
                <div class="lg:col-span-2">
                    <p class="text-xs sm:text-sm text-[#2F3AFF] leading-relaxed font-medium">
                        {{ $creator->bio ?? 'Belum ada deskripsi profil.' }}
                    </p>
                </div>

                <div class="space-y-2.5 sm:space-y-3 text-sm sm:text-base text-[#2F3AFF] font-semibold lg:pl-12">
                    @if (isset($creator->phone) && $creator->phone)
                        <p class="flex items-center gap-2.5 sm:gap-3 truncate text-xs sm:text-sm">
                            <svg class="w-4 h-4 text-[#2F3AFF] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>{{ $creator->phone }}</span>
                        </p>
                    @endif

                    @if ($user->email)
                        <p class="flex items-center gap-2.5 sm:gap-3 truncate text-xs sm:text-sm">
                            <svg class="w-4 h-4 text-[#2F3AFF] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ $user->email }}</span>
                        </p>
                    @endif

                    @if (isset($creator->location) && $creator->location)
                        <p class="flex items-center gap-2.5 sm:gap-3 truncate text-xs sm:text-sm">
                            <svg class="w-4 h-4 text-[#2F3AFF] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $creator->location }}</span>
                        </p>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-4 mt-10 mb-8">
                <div class="flex items-center gap-2 mt-10 mb-8 overflow-x-auto pb-2">
                    <span class="font-display text-xs sm:text-sm text-[#2F3AFF] uppercase tracking-wider mr-2">Filter:</span>

                    <button type="button" 
                            @click="activeFilter = 'diposting'" 
                            :class="activeFilter === 'diposting' ? 'bg-[#FC00BB] text-[#D9FC28] border-2 border-[#FC00BB]' : 'bg-[#2F3AFF] text-white'"
                            class="px-4 py-1.5 border-2 border-[#2F3AFF] font-display text-xs uppercase transition-all cursor-pointer">
                        Diposting
                    </button>

                    <button type="button" 
                            @click="activeFilter = 'favorit'" 
                            :class="activeFilter === 'favorit' ? 'bg-[#FC00BB] text-[#D9FC28] border-2 border-[#FC00BB]' : 'bg-[#2F3AFF] text-white'"
                            class="px-4 py-1.5 border-2 border-[#2F3AFF] font-display text-xs uppercase transition-all cursor-pointer">
                        Favorit
                    </button>

                    <button type="button" 
                            @click="activeFilter = 'disukai'" 
                            :class="activeFilter === 'disukai' ? 'bg-[#FC00BB] text-[#D9FC28] border-2 border-[#FC00BB]' : 'bg-[#2F3AFF] text-white'"
                            class="px-4 py-1.5 border-2 border-[#2F3AFF] font-display text-xs uppercase transition-all cursor-pointer">
                        Disukai
                    </button>

                    <button type="button" 
                            @click="activeFilter = 'dilaporkan'" 
                            :class="activeFilter === 'dilaporkan' ? 'bg-[#FC00BB] text-[#D9FC28] border-2 border-[#FC00BB]' : 'bg-[#2F3AFF] text-white'"
                            class="px-4 py-1.5 border-2 border-[#2F3AFF] font-display text-xs uppercase transition-all cursor-pointer">
                        Dilaporkan
                    </button>
                </div>

                {{-- TOMBOL TAMBAH KARYA & EDIT KARYA (SESUAI GAMBAR 3) --}}
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('works.create') }}" 
                       class="px-5 py-2.5 bg-[#D9FC28] hover:bg-[#c8f01b] text-[#2F3AFF] font-bold text-xs sm:text-sm flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Tambah Karya
                    </a>

                    <a href="#"
                        class="px-5 py-2.5 bg-[#2F3AFF] text-white hover:bg-[#252ed9] font-bold text-xs sm:text-sm flex items-center gap-2 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        Edit Karya
                    </a>
                </div>
            </div>

            {{-- WORKS GRID --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6 items-stretch">
                @forelse ($works as $work)
                    <div class="group relative flex flex-col justify-between transition-transform duration-200 hover:-translate-y-1 p-1 w-full h-full">
                        <a href="{{ route('work.show', $work->slug) }}" class="block w-full">
                            <div class="relative w-full aspect-square bg-gray-900 border-2 border-[#FC00BB] shrink-0">
                                <div class="absolute -top-1.5 -left-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                                <div class="absolute -top-1.5 -right-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                                <div class="absolute -bottom-1.5 -left-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                                <div class="absolute -bottom-1.5 -right-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>

                                @if ($work->wasteDna && $work->wasteDna->sum('quantity') > 0)
                                    <div class="absolute top-2 left-2 z-30 bg-[#D9FC28] text-[#2F3AFF] border border-[#2F3AFF] font-sans text-[7px] sm:text-[10px] font-extrabold px-1.5 py-0.5 uppercase">
                                        {{ $work->wasteDna->sum('quantity') }}kg sampah terpakai
                                    </div>
                                @endif

                                <div class="w-full h-full overflow-hidden flex items-center justify-center">
                                    @if ($work->cover_image)
                                        <img src="{{ asset('storage/' . $work->cover_image) }}" alt="{{ $work->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-bold">No Image</div>
                                    @endif
                                </div>
                            </div>
                        </a>

                        <div class="mt-2.5 flex flex-col justify-between flex-grow text-center w-full">
                            <h4 class="font-display text-xs sm:text-sm text-[#2F3AFF] uppercase leading-tight line-clamp-2-custom">
                                #{{ $loop->iteration }} {{ $work->title }}
                            </h4>

                            <div class="mt-2 pt-1 border-t border-[#2F3AFF]/10">
                                <p class="font-sans text-[9px] sm:text-xs font-medium text-[#2F3AFF] uppercase truncate">
                                    {{ $user->name }}
                                </p>
                                <span class="text-[10px] sm:text-xs font-semibold text-[#2F3AFF] mt-0.5 inline-flex items-center gap-1">
                                    👍 {{ number_format($work->appreciations_count ?? 0) }} likes
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- EMPTY STATE --}}
                    <div class="col-span-full border-2 border-dashed border-[#2F3AFF]/20 p-8 sm:p-12 text-center bg-white/50 space-y-4">
                        <div class="w-14 h-14 bg-[#D9FC28] text-[#2F3AFF] rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-display text-xl text-[#2F3AFF] uppercase">Belum Ada Karya</h3>
                            <p class="font-sans text-xs text-gray-600 mt-1">Kamu belum mengunggah karya apapun di kategori ini.</p>
                        </div>
                        <a href="{{ route('works.create') }}" 
                           class="inline-block px-5 py-2.5 bg-[#D9FC28] text-[#2F3AFF] font-bold text-xs uppercase hover:bg-[#c8f01b] transition">
                            + Tambah Karya Pertama
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="flex justify-center pt-8">
                {{ $works->links() }}
            </div>

            <div x-show="shareModalOpen" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                
                <div @click.outside="shareModalOpen = false" 
                     class="w-full max-w-md bg-white border-2 border-[#2F3AFF] p-6 text-left relative font-sans">
                    
                    <div class="flex items-center justify-between border-b border-[#2F3AFF]/20 pb-4 mb-5">
                        <h3 class="font-display text-xl sm:text-2xl text-[#2F3AFF] uppercase tracking-wide">
                            BAGIKAN PROFIL
                        </h3>
                        <button @click="shareModalOpen = false" class="text-[#2F3AFF] hover:text-[#FC00BB] text-2xl font-bold leading-none cursor-pointer">
                            &times;
                        </button>
                    </div>

                    <div class="grid grid-cols-4 gap-4 mb-6 text-center">
                        <a :href="'https://api.whatsapp.com/send?text=' + encodeURIComponent('Cek profil {{ $user->name }} di Trassic: ' + window.location.href)" 
                           target="_blank" 
                           class="flex flex-col items-center gap-2 group">
                            <div class="w-12 h-12 rounded-full bg-[#25D366] text-white flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            </div>
                            <span class="text-xs font-bold text-[#2F3AFF] group-hover:text-[#FC00BB]">WhatsApp</span>
                        </a>

                        <button type="button" 
                                @click="
                                    navigator.clipboard.writeText(window.location.href);
                                    instaCopied = true;
                                    setTimeout(() => instaCopied = false, 3000);
                                    window.open('https://instagram.com', '_blank');
                                "
                                class="flex flex-col items-center gap-2 group cursor-pointer relative">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] text-white flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 fill-none stroke-current" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-[#2F3AFF] group-hover:text-[#FC00BB]">Instagram</span>
                        </button>

                        <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href)" 
                           target="_blank" 
                           class="flex flex-col items-center gap-2 group">
                            <div class="w-12 h-12 rounded-full bg-[#1877F2] text-white flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.592 0 9 1.583 9 4.615V8z"/></svg>
                            </div>
                            <span class="text-xs font-bold text-[#2F3AFF] group-hover:text-[#FC00BB]">Facebook</span>
                        </a>

                        <a :href="'https://twitter.com/intent/tweet?text=' + encodeURIComponent('Cek profil {{ $user->name }} di Trassic: ') + '&url=' + encodeURIComponent(window.location.href)" 
                           target="_blank" 
                           class="flex flex-col items-center gap-2 group">
                            <div class="w-12 h-12 rounded-full bg-black text-white flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </div>
                            <span class="text-xs font-bold text-[#2F3AFF] group-hover:text-[#FC00BB]">Twitter / X</span>
                        </a>

                        <div x-show="instaCopied" x-cloak class="col-span-4 text-center text-xs font-bold text-[#25D366] mt-1">
                            ✓ Link disalin! Tinggal paste/tempel di Instagram.
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center gap-2 border border-[#2F3AFF] p-1 bg-[#F8F8F8] relative">
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
                                    class="px-4 py-2 bg-[#D9FC28] text-[#2F3AFF] hover:bg-[#2F3AFF] hover:text-[#D9FC28] font-bold text-xs uppercase tracking-wider transition whitespace-nowrap cursor-pointer">
                                <span x-text="copied ? 'Tersalin!' : 'SALIN LINK'"></span>
                            </button>
                        </div>

                        <div x-show="copied" x-cloak class="text-xs font-bold text-[#25D366] text-right">
                            ✓ Link berhasil disalin ke clipboard!
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>