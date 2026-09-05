<div class="w-full">
    <div class="space-y-10 sm:space-y-14">
        @forelse ($creators as $creator)
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 lg:gap-8">
                
                <div class="w-full lg:w-[480px] flex items-center gap-4 shrink-0">
                    <a href="{{ route('creator.show', $creator->slug) }}" class="w-24 h-24 sm:w-32 sm:h-32 aspect-square bg-gray-900 border-2 border-[#2F3AFF] shrink-0 overflow-hidden">
                        @if ($creator->profile_image)
                            <img src="{{ asset('storage/' . $creator->profile_image) }}" alt="{{ $creator->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-[#2F3AFF] text-[#D9FC28] font-display flex items-center justify-center text-xl sm:text-2xl">
                                {{ substr($creator->name, 0, 2) }}
                            </div>
                        @endif    
                    </a>

                    <div class="flex-1 min-w-0 space-y-1">
                        <p class="font-display text-xl sm:text-3xl text-[#2F3AFF] truncate block leading-none transition-colors">
                            {{ $creator->name }}
                        </p>
                    
                        <p class="font-sans text-xs sm:text-sm text-[#2F3AFF] font-medium truncate">
                            {{ $creator->creator_type ?? 'Riset Mengabdi Desa' }}
                        </p>

                        <p class="font-sans text-xs sm:text-sm text-[#2F3AFF] whitespace-nowrap">
                            <span class="font-extrabold">{{ number_format($creator->totalInteractions()) }} likes</span> 
                            <span class="mx-1">|</span> 
                            Bergabung sejak {{ $creator->created_at->translatedFormat('d F Y') }}
                        </p>

                        <div class="pt-1">
                            @auth
                                @if (auth()->id() === $creator->user_id)
                                    <a href="{{ route('profile.show') }}" class="inline-block px-4 py-1 bg-[#2F3AFF] text-white font-display text-xs sm:text-sm hover:bg-[#FC00BB] transition">
                                        Profil Saya
                                    </a>
                                @else
                                    <button wire:click="toggleFollow({{ $creator->id }})" class="px-4 py-1 bg-[#D9FC28] hover:bg-[#FC00BB] text-[#2F3AFF] hover:text-[#D9FC28] font-display text-xs sm:text-sm active:translate-y-0.5 transition-all cursor-pointer">
                                        {{ $creator->isFollowedBy(auth()->id()) ? '✓ Mengikuti' : 'Ikuti' }}
                                    </button>
                                @endif
                            @else
                                <button wire:click="toggleFollow({{ $creator->id }})" class="px-4 py-1 bg-[#D9FC28] hover:bg-[#FC00BB] text-[#2F3AFF] hover:text-[#D9FC28] font-display text-xs sm:text-sm active:translate-y-0.5 transition-all cursor-pointer">
                                    Ikuti
                                </button>
                            @endauth
                        </div>
                    </div>
                </div>

                <div class="w-full lg:flex-1 grid grid-cols-3 gap-3 sm:gap-4">
                    @foreach ($creator->preview_works as $work)
                        <a href="{{ route('work.show', $work->slug) }}" class="group relative aspect-[4/3] bg-gray-900 border-2 border-[#FC00BB] block">
                            <div class="absolute -top-1.5 -left-1.5 w-2.5 h-2.5 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                            <div class="absolute -top-1.5 -right-1.5 w-2.5 h-2.5 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                            <div class="absolute -bottom-1.5 -left-1.5 w-2.5 h-2.5 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                            <div class="absolute -bottom-1.5 -right-1.5 w-2.5 h-2.5 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>

                            <div class="w-full h-full overflow-hidden flex items-center justify-center bg-gray-900">
                                @if ($work->cover_image)
                                    <img src="{{ asset('storage/' . $work->cover_image) }}" alt="{{ $work->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full bg-gray-800 flex items-center justify-center text-xs text-gray-400 font-sans">No Image</div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>

            </div>
        @empty
            <div class="text-center py-16 text-[#2F3AFF]">
                <p class="font-display text-lg sm:text-xl tracking-wider">Belum ada kreator ditemukan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-12 sm:mt-16 flex justify-center">
        {{ $creators->links() }}
    </div>
</div>