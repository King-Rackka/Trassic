<div class="w-full">

    {{-- DAFTAR KREATOR --}}
    <div class="space-y-10 sm:space-y-14">
        @forelse ($creators as $creator)
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 lg:gap-8">
                
                {{-- KIRI: PROFIL & INFORMASI KREATOR (TANPA CARD & SHADOW) --}}
                <div class="w-full lg:w-[420px] flex items-center gap-4 shrink-0">
                    <a href="{{ route('creator.show', $creator->slug) }}" class="w-24 h-24 sm:w-28 sm:h-28 aspect-square bg-gray-900 border-2 border-black shrink-0 overflow-hidden">
                        @if ($creator->profile_image)
                            <img src="{{ asset('storage/' . $creator->profile_image) }}" alt="{{ $creator->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-[#254bfe] text-[#ccff00] font-display flex items-center justify-center text-xl sm:text-2xl uppercase">
                                {{ substr($creator->name, 0, 2) }}
                            </div>
                        @endif    
                    </a>

                    <div class="flex-1 min-w-0 space-y-1">
                        <a href="{{ route('creator.show', $creator->slug) }}" class="font-display text-xl sm:text-3xl text-[#254bfe] hover:text-[#ff007a] uppercase truncate block leading-none transition-colors">
                            {{ $creator->name }}
                        </a>
                        
                        <p class="font-sans text-xs sm:text-sm text-[#254bfe] font-medium truncate">
                            {{ $creator->creator_type ?? 'Riset Mengabdi Desa' }}
                        </p>

                        <p class="font-sans text-xs sm:text-sm text-[#254bfe]">
                            <span class="font-extrabold">{{ number_format($creator->total_likes_sum ?? $creator->published_works_count) }} likes</span> 
                            <span class="mx-1 opacity-50">|</span> 
                            Bergabung sejak {{ $creator->created_at->translatedFormat('d F Y') }}
                        </p>

                        <div class="pt-1">
                            <button wire:click="toggleFollow({{ $creator->id }})" 
                                    class="px-4 py-1 bg-[#ccff00] hover:bg-[#ff007a] text-[#254bfe] hover:text-[#ccff00] font-display text-xs sm:text-sm uppercase border border-black active:translate-y-0.5 transition-all cursor-pointer">
                                {{ auth()->check() && $creator->isFollowedBy(auth()->id()) ? 'Mengikuti' : 'Ikuti' }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- KANAN: 3 PREVIEW FOTO KARYA (ASPECT 4/3 + BINGKAI PINK + 4 KOTAK KUNING) --}}
                <div class="w-full lg:flex-1 grid grid-cols-3 gap-3 sm:gap-4">
                    @forelse ($creator->preview_works as $work)
                        <a href="{{ route('work.show', $work->slug) }}" class="group relative aspect-[4/3] bg-gray-900 border-2 border-[#ff007a] block">
                            
                            {{-- 4 KOTAK KUNING MANDIRI DI 4 POJOK OUTLINE --}}
                            <div class="absolute -top-1.5 -left-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                            <div class="absolute -top-1.5 -right-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                            <div class="absolute -bottom-1.5 -left-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                            <div class="absolute -bottom-1.5 -right-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>

                            {{-- CONTAINER FOTO CROPPER --}}
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
                            <div class="aspect-[4/3] bg-gray-100 border border-gray-300"></div>
                        @endfor
                    @endforelse
                </div>

            </div>
        @empty
            <div class="text-center py-16 text-[#254bfe]">
                <p class="font-display text-lg sm:text-xl uppercase tracking-wider">Belum ada kreator ditemukan.</p>
            </div>
        @endforelse
    </div>

    {{-- PAGINASI --}}
    <div class="mt-12 sm:mt-16 flex justify-center">
        {{ $creators->links() }}
    </div>
</div>