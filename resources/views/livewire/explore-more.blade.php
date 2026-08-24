<div class="w-full">
    
    {{-- 1. FILTER CATEGORIES CHIPS (RAPI DI MOBILE & DESKTOP) --}}
    <div class="flex items-center justify-start sm:justify-center gap-2 overflow-x-auto pb-4 mb-8 sm:mb-10 no-scrollbar px-1">
        <button wire:click="setCategory('')" 
                class="px-4 py-1.5 sm:px-5 sm:py-2 border-2 text-xs sm:text-sm font-display uppercase whitespace-nowrap transition-all duration-200
                {{ $category === '' ? 'bg-[#ff007a] text-[#ccff00] border-transparent shadow-[2px_2px_0px_rgba(0,0,0,1)]' : 'bg-[#254bfe] text-white border-transparent hover:bg-[#ccff00] hover:text-[#254bfe]' }}">
            Semua
        </button>
        @foreach ($categories as $cat)
            <button wire:click="setCategory('{{ $cat }}')" 
                    class="px-4 py-1.5 sm:px-5 sm:py-2 border-2 text-xs sm:text-sm font-display uppercase whitespace-nowrap transition-all duration-200
                    {{ $category === $cat ? 'bg-[#ff007a] text-[#ccff00] border-transparent shadow-[2px_2px_0px_rgba(0,0,0,1)]' : 'bg-[#254bfe] text-white border-transparent hover:bg-[#ccff00] hover:text-[#254bfe]' }}">
                {{ $cat }}
            </button>
        @endforeach
    </div>

    {{-- 2. GRID KARYA (2 KOLOM DI MOBILE, 5 KOLOM DI DESKTOP) --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-6" wire:loading.class="opacity-60">
        @forelse ($works as $work)
            @php
                $displayQuantity = $category ? $work->quantityForMaterial($category) : $work->quantityForMaterial();
            @endphp
            <a href="{{ route('work.show', $work->slug) }}" 
               class="group relative flex flex-col justify-between transition-transform duration-200 hover:-translate-y-1.5 p-0.5 sm:p-1">
                
                {{-- FRAME OUTLINE PINK & AKSEN KOTAK LIME DI 4 CORNER --}}
                <div class="relative w-full aspect-square bg-gray-900 overflow-hidden border-2 border-[#ff007a]">
                    <div class="absolute -top-1 -left-1 w-2 h-2 sm:w-2.5 sm:h-2.5 bg-[#ccff00] z-20"></div>
                    <div class="absolute -top-1 -right-1 w-2 h-2 sm:w-2.5 sm:h-2.5 bg-[#ccff00] z-20"></div>
                    <div class="absolute -bottom-1 -left-1 w-2 h-2 sm:w-2.5 sm:h-2.5 bg-[#ccff00] z-20"></div>
                    <div class="absolute -bottom-1 -right-1 w-2 h-2 sm:w-2.5 sm:h-2.5 bg-[#ccff00] z-20"></div>

                    {{-- BADGE SAMPAH TERPAKAI (KUNING/LIME TEKS BIRU) --}}
                    @if ($displayQuantity > 0)
                        <div class="absolute top-1 left-1 sm:top-2 sm:left-2 z-30 bg-[#ccff00] text-[#254bfe] font-sans text-[7px] sm:text-[10px] font-extrabold px-1 sm:px-2 py-0.5 uppercase tracking-tight">
                            {{ $displayQuantity }}kg sampah terpakai
                        </div>
                    @endif

                    {{-- GAMBAR KARYA --}}
                    @if ($work->cover_image)
                        <img src="{{ asset('storage/' . $work->cover_image) }}" 
                             alt="{{ $work->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-bold font-sans">No Image</div>
                    @endif
                </div>

                {{-- INFO KARYA TEKS BIRU (#254bfe) RATA TENGAH --}}
                <div class="mt-2 sm:mt-3 text-center">
                    <h4 class="font-display text-xs sm:text-base text-[#254bfe] truncate uppercase leading-tight tracking-wide">
                        #{{ $loop->iteration }} {{ $work->title }}
                    </h4>
                    <p class="font-sans text-[9px] sm:text-xs font-medium text-[#254bfe] uppercase mt-0.5 sm:mt-1 truncate">
                        {{ $work->creator->name ?? 'RIMESA 2026' }}
                    </p>
                    <p class="font-sans text-[10px] sm:text-xs font-semibold text-[#254bfe] mt-0.5 sm:mt-1 flex items-center justify-center gap-1">
                        <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 fill-[#254bfe]" viewBox="0 0 24 24">
                            <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                        </svg>
                        <span>{{ number_format($work->appreciations_count) }} likes</span>
                    </p>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-16 text-[#254bfe]">
                <p class="font-display text-lg sm:text-xl uppercase tracking-wider">Belum ada karya ditemukan.</p>
            </div>
        @endforelse
    </div>

    {{-- 3. PAGINATION / LIHAT LAINNYA --}}
    <div class="mt-10 sm:mt-14 flex justify-center">
        {{ $works->links() }}
    </div>
</div>