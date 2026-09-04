<div class="w-full">

    <style>
        .line-clamp-2-custom {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    
    <div class="flex items-center justify-start sm:justify-center gap-2 overflow-x-auto pb-4 mb-8 sm:mb-10 no-scrollbar px-1">
        <button wire:click="setCategory('')" 
                class="px-4 py-1.5 sm:px-5 sm:py-2 border-2 text-xs sm:text-sm font-display uppercase whitespace-nowrap transition-all duration-200 cursor-pointer
                {{ (!$category || $category === '') ? 'bg-[#FC00BB] text-[#D9FC28] border-[#FC00BB]' : 'bg-[#2F3AFF] text-white border-[#FC00BB] hover:bg-[#D9FC28] hover:text-[#2F3AFF]' }}">
            Semua
        </button>

        @foreach ($categories as $cat)
            <button wire:click="setCategory('{{ $cat }}')" 
                    class="px-4 py-1.5 sm:px-5 sm:py-2 border-2 text-xs sm:text-sm font-display uppercase whitespace-nowrap transition-all duration-200 cursor-pointer
                    {{ $category === $cat ? 'bg-[#FC00BB] text-[#D9FC28] border-[#2F3AFF]' : 'bg-[#2F3AFF] text-white border-[#FC00BB] hover:bg-[#D9FC28] hover:text-[#2F3AFF]' }}">
                {{ $cat }}
            </button>
        @endforeach
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6 items-stretch" wire:loading.class="opacity-60">
        @forelse ($works as $work)
            @php
                $displayQuantity = $category ? $work->quantityForMaterial($category) : $work->quantityForMaterial();
            @endphp
            <div class="group relative flex flex-col justify-between transition-transform duration-200 hover:-translate-y-2 p-1 w-full h-full">
                
                <a href="{{ route('work.show', $work->slug) }}" class="block w-full">
                    <div class="relative w-full aspect-square bg-gray-900 border-2 border-[#FC00BB] shrink-0">
                        
                        <div class="absolute -top-1.5 -left-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                        <div class="absolute -top-1.5 -right-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                        <div class="absolute -bottom-1.5 -left-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>
                        <div class="absolute -bottom-1.5 -right-1.5 w-3 h-3 bg-[#D9FC28] border border-[#2F3AFF] z-30 pointer-events-none"></div>

                        @if ($displayQuantity > 0)
                            <div class="absolute top-2 left-2 z-30 bg-[#D9FC28] text-[#2F3AFF] border border-[#2F3AFF] font-sans text-[7px] sm:text-[10px] font-extrabold px-1.5 sm:px-2 py-0.5 uppercase tracking-tight">
                                {{ $displayQuantity }}kg sampah terpakai
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
        @empty
            <div class="col-span-full text-center py-16 text-[#2F3AFF]">
                <p class="font-display text-lg sm:text-xl uppercase tracking-wider">Belum ada karya ditemukan.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-10 sm:mt-14 flex justify-center">
        {{ $works->links() }}
    </div>
</div>