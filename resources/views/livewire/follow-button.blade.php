<div>
    @auth
        @if(auth()->id() !== $creator->user_id)
            <button wire:click="toggleFollow"
                class="px-5 py-2 sm:px-6 sm:py-2.5 bg-[#D9FC28] hover:bg-[#cbf21d] text-[#2F3AFF] font-display text-xs sm:text-sm uppercase transition-all cursor-pointer">
                    {{ $isFollowing ? '✓ Mengikuti' : '+ Ikuti' }}
            </button>
        @endif
    @else
        <button wire:click="toggleFollow"
                class="px-5 py-2 sm:px-6 sm:py-2.5 bg-[#D9FC28] hover:bg-[#cbf21d] text-[#2F3AFF] font-display text-xs sm:text-sm uppercase transition-all cursor-pointer">
            + Ikuti
        </button>
    @endauth
    
</div>