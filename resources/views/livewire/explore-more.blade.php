<div class="w-full">
    {{-- Filter Chips Rata Tengah --}}
    <div class="flex items-center justify-start sm:justify-center gap-2 overflow-x-auto pb-4 mb-10 no-scrollbar">
        <button wire:click="setCategory('')" 
                class="px-5 py-2 rounded-full border-2 text-xs sm:text-sm font-bold uppercase whitespace-nowrap transition-all duration-200
                {{ $category === '' ? 'bg-[#ff007a] text-white border-black shadow-[2px_2px_0px_rgba(0,0,0,1)]' : 'bg-white text-[#254bfe] border-black hover:bg-[#ccff00]' }}">
            Semua
        </button>
        @foreach ($categories as $cat)
            <button wire:click="setCategory('{{ $cat }}')" 
                    class="px-5 py-2 rounded-full border-2 text-xs sm:text-sm font-bold uppercase whitespace-nowrap transition-all duration-200
                    {{ $category === $cat ? 'bg-[#ff007a] text-white border-black shadow-[2px_2px_0px_rgba(0,0,0,1)]' : 'bg-white text-[#254bfe] border-black hover:bg-[#ccff00]' }}">
                {{ $cat }}
            </button>
        @endforeach
    </div>

    {{-- Grid Card 5 Kolom --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6" wire:loading.class="opacity-60">
        @forelse ($works as $work)
            @php
                $displayQuantity = $category ? $work->quantityForMaterial($category) : $work->quantityForMaterial();
            @endphp
            <a href="{{ route('work.show', $work->slug) }}" 
               class="group relative bg-white border-2 border-black p-2 flex flex-col justify-between transition-transform duration-200 hover:-translate-y-1.5 shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                
                {{-- Siku-siku Merah Brutalist --}}
                <div class="absolute -top-1 -left-1 w-2.5 h-2.5 bg-[#ff007a] border border-black z-20"></div>
                <div class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-[#ff007a] border border-black z-20"></div>
                <div class="absolute -bottom-1 -left-1 w-2.5 h-2.5 bg-[#ff007a] border border-black z-20"></div>
                <div class="absolute -bottom-1 -right-1 w-2.5 h-2.5 bg-[#ff007a] border border-black z-20"></div>

                {{-- Badge Sampah Terpakai --}}
                @if ($displayQuantity > 0)
                    <div class="absolute top-3 left-3 z-30 bg-[#ccff00] text-black border border-black text-[9px] font-extrabold px-1.5 py-0.5 uppercase tracking-tight shadow-[1px_1px_0px_rgba(0,0,0,1)]">
                        {{ $displayQuantity }}kg sampah terpakai
                    </div>
                @endif

                {{-- Gambar Karya --}}
                <div class="w-full aspect-square bg-gray-100 overflow-hidden border border-black relative">
                    @if ($work->cover_image)
                        <img src="{{ asset('storage/' . $work->cover_image) }}" 
                             alt="{{ $work->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs font-bold">No Image</div>
                    @endif
                </div>

                {{-- Info Karya Rata Tengah --}}
                <div class="mt-2 text-center">
                    <h4 class="font-display text-sm sm:text-base text-[#254bfe] truncate uppercase leading-tight">
                        {{ $work->title }}
                    </h4>
                    <p class="text-[10px] sm:text-[11px] font-semibold text-gray-500 uppercase mt-0.5 truncate">
                        {{ $work->creator->name ?? 'RIMESA 2026' }}
                    </p>
                    
                    {{-- SVG Thumbs Up Biru --}}
                    <div class="text-[11px] font-bold text-[#254bfe] mt-1 flex items-center justify-center gap-1">
                        <svg class="w-3.5 h-3.5 fill-[#254bfe]" viewBox="0 0 24 24">
                            <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                        </svg>
                        <span>{{ number_format($work->appreciations_count) }} likes</span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full text-center py-16 text-gray-500">
                <p class="font-display text-xl uppercase tracking-wider">Belum ada karya ditemukan.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-12 flex justify-center">
        {{ $works->links() }}
    </div>
</div>