<div>
    @auth
        @if(auth()->id() !== $creator->user_id)
            <button wire:click="toggleFollow"
                    class="px-5 py-2 sm:px-6 sm:py-2.5 bg-[#ccff00] hover:bg-white text-[#254bfe] font-display text-xs sm:text-sm uppercase tracking-wide transition-all shadow-[3px_3px_0px_rgba(0,0,0,1)] active:translate-y-0.5">
                {{ $isFollowing ? '✓ Mengikuti' : '+ Ikuti' }}
            </button>
        @endif
    @else
        <button wire:click="toggleFollow"
                class="px-5 py-2 sm:px-6 sm:py-2.5 bg-[#ccff00] hover:bg-white text-[#254bfe] font-display text-xs sm:text-sm uppercase tracking-wide transition-all shadow-[3px_3px_0px_rgba(0,0,0,1)] active:translate-y-0.5">
            + Ikuti
        </button>
    @endauth
</div>