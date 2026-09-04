<div class="w-full bg-grid-pattern min-h-screen pb-16 font-sans" x-data="{ activeFilter: @entangle('activeFilter'), shareModalOpen: false, instaCopied: false, copied: false }">

        <style>
            .line-clamp-2-custom {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        </style>

        <div class="relative w-full">
            <div class="w-full h-64 sm:h-80 md:h-[380px] lg:h-[420px] bg-gray-900 relative overflow-hidden z-10">
                @if (isset($creator->cover_image) && $creator->cover_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($creator->cover_image))
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
                        @if (isset($creator->profile_image) && $creator->profile_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($creator->profile_image))
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

        <div class="max-w-7xl mx-auto px-4 sm:px-8 pt-20 sm:pt-24">

        {{-- HEADER NAMA & TOMBOL AKSI --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-[#2F3AFF]/10 pb-6 relative">
            <div>
                <h1 class="font-display text-3xl sm:text-5xl text-[#2F3AFF] uppercase tracking-normal leading-tight">
                    {{ $user->name }}
                </h1>
            </div>

            <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                <a href="{{ route('profile.edit') }}" 
                   class="px-5 py-2.5 bg-[#D9FC28] hover:bg-[#c8f01b] text-[#2F3AFF] font-bold text-xs sm:text-sm flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4 text-[#2F3AFF]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit Profil
                </a>

                <button type="button" 
                        @click="shareModalOpen = true" 
                        class="text-[#2F3AFF] hover:text-[#FC00BB] p-1 transition-colors cursor-pointer" 
                        title="Bagikan">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </button>

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

        {{-- STATISTIK (POSTS, FOLLOWERS, FOLLOWING) --}}
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

        {{-- GRID UTAMA: BIO DI KIRI & KONTAK DI KANAN ATAS (MENEMPEL DI BAWAH TOMBOL AKSI) --}}
        <div class="relative pt-2 pb-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                {{-- DESKRIPSI / BIO DI KIRI --}}
                <div class="lg:col-span-7 pr-0 lg:pr-12">
                    <p class="text-xs sm:text-sm text-[#2F3AFF] leading-relaxed font-medium">
                        {{ $creator->bio ?? 'Belum ada deskripsi profil.' }}
                    </p>
                </div>

                {{-- KONTAK & SOSMED DI KANAN ATAS (JARAK SUDAH DITURUNKAN) --}}
                <div class="lg:col-span-5 lg:absolute lg:right-0 lg:-top-14 w-full lg:w-auto">
                    <div class="space-y-2 sm:space-y-2.5 text-sm sm:text-base text-[#2F3AFF] font-semibold text-left">
                        @php $links = $creator->social_links ?? []; @endphp
                        
                        @if ($creator->phone)
                            <p class="flex items-center gap-2.5 sm:gap-3">
                                <svg class="w-5 h-5 text-[#2F3AFF] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span>{{ $creator->phone }}</span>
                            </p>
                        @endif

                        @if ($user->email)
                            <p class="flex items-center gap-2.5 sm:gap-3">
                                <svg class="w-5 h-5 text-[#2F3AFF] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <a href="mailto:{{ $user->email }}" class="hover:underline">{{ $user->email }}</a>
                            </p>
                        @endif

                        @if ($creator->location)
                            <p class="flex items-center gap-2.5 sm:gap-3">
                                <svg class="w-5 h-5 text-[#2F3AFF] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ $creator->location }}</span>
                            </p>
                        @endif

                        @if (!empty($links['instagram']))
                            <p class="flex items-center gap-2.5 sm:gap-3">
                                <svg class="w-5 h-5 text-[#2F3AFF] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                    <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                                </svg>
                                <a href="https://instagram.com/{{ ltrim($creator->instagramHandle(), '@') }}" target="_blank" rel="noopener" class="hover:underline">
                                    {{ ltrim($creator->instagramHandle(), '@') }}
                                </a>
                            </p>
                        @endif

                        @if (!empty($links['website']))
                            <p class="flex items-center gap-2.5 sm:gap-3">
                                <svg class="w-5 h-5 text-[#2F3AFF] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                </svg>
                                <a href="{{ $creator->website() }}" target="_blank" rel="noopener" class="hover:underline">
                                    {{ str($creator->website())->replace(['https://', 'http://'], '') }}
                                </a>
                            </p>
                        @endif
                    </div>
                </div>

            </div>
        </div>

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mt-10 mb-8">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="font-display text-xs sm:text-sm text-[#2F3AFF] uppercase tracking-wider mr-1">Filter:</span>

                    <button type="button" 
                            wire:click="setFilter('diposting')" 
                            class="px-2.5 sm:px-4 py-1 sm:py-1.5 border-2 border-[#2F3AFF] font-display text-[10px] sm:text-xs uppercase transition-all cursor-pointer {{ $activeFilter === 'diposting' ? 'bg-[#FC00BB] text-[#D9FC28] border-[#FC00BB]' : 'bg-[#2F3AFF] text-white' }}">
                        Diposting
                    </button>

                    <button type="button" 
                            wire:click="setFilter('favorit')" 
                            class="px-2.5 sm:px-4 py-1 sm:py-1.5 border-2 border-[#2F3AFF] font-display text-[10px] sm:text-xs uppercase transition-all cursor-pointer {{ $activeFilter === 'favorit' ? 'bg-[#FC00BB] text-[#D9FC28] border-[#FC00BB]' : 'bg-[#2F3AFF] text-white' }}">
                        Favorit
                    </button>

                    <button type="button" 
                            wire:click="setFilter('disukai')" 
                            class="px-2.5 sm:px-4 py-1 sm:py-1.5 border-2 border-[#2F3AFF] font-display text-[10px] sm:text-xs uppercase transition-all cursor-pointer {{ $activeFilter === 'disukai' ? 'bg-[#FC00BB] text-[#D9FC28] border-[#FC00BB]' : 'bg-[#2F3AFF] text-white' }}">
                        Disukai
                    </button>

                    <button type="button" 
                            wire:click="setFilter('dilaporkan')" 
                            class="px-2.5 sm:px-4 py-1 sm:py-1.5 border-2 border-[#2F3AFF] font-display text-[10px] sm:text-xs uppercase transition-all cursor-pointer {{ $activeFilter === 'dilaporkan' ? 'bg-[#FC00BB] text-[#D9FC28] border-[#FC00BB]' : 'bg-[#2F3AFF] text-white' }}">
                        Dilaporkan
                    </button>
                </div>

                {{-- TOMBOL AKSI TAMBAH/EDIT KARYA --}}
                <div class="flex flex-wrap items-center gap-2 shrink-0">
                    <a href="{{ route('works.create') }}" 
                       class="px-4 sm:px-5 py-2.5 bg-[#D9FC28] hover:bg-[#c8f01b] text-[#2F3AFF] font-bold text-xs sm:text-sm flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Tambah Karya
                    </a>

                    <button type="button"
                            wire:click="toggleEditMode"
                            class="px-4 sm:px-5 py-2.5 font-bold text-xs sm:text-sm flex items-center gap-2 transition-colors cursor-pointer {{ $isEditMode ? 'bg-[#FC00BB] text-white hover:bg-[#d900a0]' : 'bg-[#2F3AFF] text-white hover:bg-[#252ed9]' }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        <span>{{ $isEditMode ? 'Selesai Edit' : 'Edit Karya' }}</span>
                    </button>
                </div>
            </div>

            {{-- WORKS GRID & DINAMIS EMPTY STATE --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6 items-start min-h-[300px]">
                @forelse ($works as $work)
                    <div class="group relative flex flex-col transition-transform duration-200 hover:-translate-y-1 p-1 w-full">
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

                                @if ($isEditMode && $activeFilter === 'diposting')
                                    <a href="{{ route('works.edit', $work->id) }}" 
                                    class="absolute top-2 right-2 z-40 bg-[#FC00BB] text-white p-2 border-2 border-white shadow-lg hover:scale-110 hover:bg-[#2F3AFF] transition-all cursor-pointer"
                                    title="Edit Karya Ini">
                                        <svg class="w-4 h-4 fill-current text-white" viewBox="0 0 24 24">
                                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                        </svg>
                                    </a>
                                @endif

                                <div class="w-full h-full overflow-hidden flex items-center justify-center">
                                    @if ($work->cover_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($work->cover_image))
                                        <img src="{{ asset('storage/' . $work->cover_image) }}" alt="{{ $work->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-bold">No Image</div>
                                    @endif
                                </div>
                            </div>
                        </a>

                        {{-- BAGIAN JUDUL & CREATOR DENGAN JARAK RAPAT (MAKSIMAL 2 BARIS) --}}
                        <div class="mt-2.5 flex flex-col text-center w-full">
                            <h4 class="font-display text-xs sm:text-base text-[#2F3AFF] uppercase leading-tight tracking-wide line-clamp-2-custom min-h-[2rem] sm:min-h-[2.5rem]" title="{{ $work->title }}">
                                {{ $work->title }}
                            </h4>

                            <div class="mt-1 pt-1.5 border-t border-[#2F3AFF]/10">
                                <p class="font-sans text-[9px] sm:text-xs font-medium text-[#2F3AFF] uppercase truncate">
                                    {{ $work->creator->user->name ?? $user->name }}
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
                @empty
                    <div class="col-span-full border-2 border-dashed border-[#2F3AFF]/20 p-8 sm:p-12 text-center bg-white/50 space-y-4 my-auto">
                        <div class="w-14 h-14 bg-[#D9FC28] text-[#2F3AFF] rounded-full flex items-center justify-center mx-auto">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                        
                        <div>
                            <h3 class="font-display text-xl text-[#2F3AFF] uppercase">
                                @if ($activeFilter === 'disukai')
                                    Belum Ada Karya Yang Disukai
                                @elseif ($activeFilter === 'favorit')
                                    Belum Ada Karya Favorit
                                @elseif ($activeFilter === 'dilaporkan')
                                    Tidak Ada Karya Yang Dilaporkan
                                @else
                                    Belum Ada Karya
                                @endif
                            </h3>
                            
                            <p class="font-sans text-xs text-gray-600 mt-1 max-w-md mx-auto">
                                @if ($activeFilter === 'disukai')
                                    Kamu belum menekan tombol like pada karya manapun. Jelajahi karya kreator lain dan berikan apresiasimu!
                                @elseif ($activeFilter === 'favorit')
                                    Kamu belum menandai karya buatanmu sebagai favorit.
                                @elseif ($activeFilter === 'dilaporkan')
                                    Aman! Tidak ada karya milikmu yang ditandai atau dilaporkan bermasalah.
                                @else
                                    Kamu belum mengunggah karya apapun. Mulai bagikan karya daur ulangmu sekarang!
                                @endif
                            </p>
                        </div>

                        <div class="pt-2">
                            @if ($activeFilter === 'disukai')
                                <a href="{{ route('home') }}" class="inline-block px-5 py-2.5 bg-[#2F3AFF] text-white font-bold text-xs uppercase hover:bg-[#FC00BB] transition">
                                    Jelajahi Karya
                                </a>
                            @elseif ($activeFilter === 'diposting')
                                <a href="{{ route('works.create') }}" class="inline-block px-5 py-2.5 bg-[#D9FC28] text-[#2F3AFF] font-bold text-xs uppercase hover:bg-[#c8f01b] transition">
                                    + Tambah Karya Pertama
                                </a>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="flex justify-center pt-8">
                {{ $works->links() }}
            </div>

            {{-- SHARE MODAL --}}
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