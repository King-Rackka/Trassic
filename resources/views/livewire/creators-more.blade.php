<div class="w-full">

    {{-- DAFTAR KREATOR --}}
    <div class="max-w-6xl mx-auto space-y-6 sm:space-y-8">
        @forelse ($creators as $creator)
            {{-- KARTU UTAMA DENGAN BORDER HITAM & HARD SHADOW BRUTALISM --}}
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 p-4 sm:p-6 bg-white border-2 border-black shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:shadow-[6px_6px_0px_rgba(0,0,0,1)] transition-all">
                
                {{-- KIRI: PROFIL & INFORMASI KREATOR --}}
                <div class="flex items-start sm:items-center gap-4 sm:gap-6 flex-1 min-w-0 w-full">
                    
                    {{-- FOTO PROFIL --}}
                    <a href="{{ route('creator.show', $creator->slug) }}" class="w-20 h-20 sm:w-28 sm:h-28 aspect-square bg-gray-900 border-2 border-black shrink-0 overflow-hidden shadow-[2px_2px_0px_rgba(0,0,0,1)] group">
                        @if ($creator->profile_image)
                            <img src="{{ asset('storage/' . $creator->profile_image) }}" alt="{{ $creator->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full bg-[#254bfe] text-[#ccff00] font-display flex items-center justify-center text-xl sm:text-2xl uppercase">
                                {{ substr($creator->name, 0, 2) }}
                            </div>
                        @endif
                    </a>

                    {{-- DESKRIPSI & TEKS --}}
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('creator.show', $creator->slug) }}" class="font-display text-lg sm:text-2xl text-[#254bfe] hover:text-[#ff007a] uppercase truncate block leading-tight transition-colors">
                            {{ $creator->name }}
                        </a>
                        
                        <p class="font-sans text-xs sm:text-sm text-[#254bfe] uppercase font-bold truncate mt-0.5">
                            {{ $creator->creator_type ?? 'Riset Mengabdi Desa' }}
                        </p>

                        @if($creator->bio)
                            <p class="font-sans text-xs text-gray-600 line-clamp-2 mt-1 leading-relaxed">
                                {{ $creator->bio }}
                            </p>
                        @endif

                        <p class="font-sans text-xs text-[#254bfe] mt-2 font-semibold">
                            <span class="font-extrabold text-sm">{{ number_format($creator->total_likes_sum ?? $creator->published_works_count) }}</span> likes 
                            <span class="mx-1 opacity-40">|</span> 
                            <span class="font-extrabold text-sm">{{ $creator->published_works_count }}</span> karya
                        </p>

                        <button wire:click="toggleFollow({{ $creator->id }})" 
                                class="mt-3 px-4 py-1.5 bg-[#ccff00] hover:bg-[#ff007a] text-[#254bfe] hover:text-[#ccff00] font-display text-xs uppercase border-2 border-black shadow-[2px_2px_0px_rgba(0,0,0,1)] active:translate-y-0.5 transition-all cursor-pointer">
                            {{ auth()->check() && $creator->isFollowedBy(auth()->id()) ? 'Mengikuti' : 'Ikuti' }}
                        </button>
                    </div>
                </div>

                {{-- KANAN: 3 PREVIEW FOTO KARYA (BINGKAI PINK + 4 KOTAK KUNING MANDIRI) --}}
                <div class="w-full lg:w-[320px] xl:w-[360px] grid grid-cols-3 gap-3 shrink-0 pt-2 lg:pt-0 border-t-2 lg:border-t-0 border-gray-100">
                    @forelse ($creator->preview_works as $work)
                        <a href="{{ route('work.show', $work->slug) }}" class="group relative aspect-square bg-gray-900 border-2 border-[#ff007a] shadow-[2px_2px_0px_rgba(0,0,0,1)] block">
                            
                            {{-- 4 KOTAK KUNING MANDIRI DI 4 POJOK OUTLINE (SAMA DENGAN EXPLORE) --}}
                            <div class="absolute -top-1.5 -left-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                            <div class="absolute -top-1.5 -right-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                            <div class="absolute -bottom-1.5 -left-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>
                            <div class="absolute -bottom-1.5 -right-1.5 w-2.5 h-2.5 bg-[#ccff00] border border-black z-30 pointer-events-none"></div>

                            {{-- CONTAINER FOTO CROPPER --}}
                            <div class="w-full h-full overflow-hidden flex items-center justify-center">
                                @if ($work->cover_image)
                                    <img src="{{ asset('storage/' . $work->cover_image) }}" alt="{{ $work->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full bg-gray-800 flex items-center justify-center text-[9px] text-gray-400 font-sans">No Image</div>
                                @endif
                            </div>
                        </a>
                    @empty
                        @for ($i = 0; $i < 3; $i++)
                            <div class="aspect-square bg-gray-100 border-2 border-gray-300 flex items-center justify-center text-[9px] text-gray-400 font-sans uppercase">No Karya</div>
                        @endfor
                    @endforelse
                </div>

            </div>
        @empty
            <div class="text-center py-16 bg-white border-2 border-black p-8 shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                <p class="font-display text-xl text-[#254bfe] uppercase">Belum ada kreator ditemukan.</p>
            </div>
        @endforelse
    </div>

    {{-- PAGINASI --}}
    <div class="mt-10 sm:mt-14 flex justify-center">
        {{ $creators->links() }}
    </div>
</div>