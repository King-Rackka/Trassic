<button wire:click="toggleBookmark"
        type="button"
        class="flex items-center gap-1.5  {{ $isBookmarked ? 'bg-[#ff007a] text-white' : 'bg-[#ccff00] text-[#254bfe]' }} font-display text-xs uppercase px-3.5 py-2 active:translate-y-0.5 transition-all cursor-pointer">
    <img src="{{ asset('images/icons/bookmark.png') }}" 
         alt="Favorit" 
         class="w-3.5 h-3.5 sm:w-4 sm:h-4 object-contain {{ $isBookmarked ? 'brightness-0 invert' : '' }}">
    <span>{{ $isBookmarked ? 'Tersimpan' : 'Favorit' }}</span>
</button>