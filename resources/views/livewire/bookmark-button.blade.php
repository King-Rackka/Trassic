<button wire:click="toggleBookmark"
        type="button"
        class="flex items-center gap-1.5 border-2 border-black {{ $isBookmarked ? 'bg-[#ff007a] text-white' : 'bg-[#ccff00] text-[#254bfe]' }} font-display text-xs uppercase px-3.5 py-2 shadow-[2px_2px_0px_rgba(0,0,0,1)] active:translate-y-0.5 transition-all">
    <img src="{{ asset('images/icons/bookmark.png') }}" 
         alt="Favorit" 
         class="w-3.5 h-3.5 sm:w-4 sm:h-4 object-contain">
    <span>{{ $isBookmarked ? 'Tersimpan' : 'Favorit' }}</span>
</button>