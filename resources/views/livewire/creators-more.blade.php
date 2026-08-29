<div x-data="{ showLoginPrompt: false }" x-on:show-login-prompt.window="showLoginPrompt = true">

    <div x-show="showLoginPrompt" x-cloak class="fixed inset-0 z-50 bg-black/60 flex items-center justify-center p-4" x-transition>
        <div class="bg-white rounded-xl p-6 max-w-sm w-full text-center border-4 border-[#254bfe]">
            <p class="font-bold text-[#254bfe] mb-4">Join TRASSIC to follow this creator.</p>
            <div class="flex gap-3 justify-center">
                <a href="{{ route('login') }}" class="bg-[#ccff00] text-[#254bfe] font-bold px-4 py-2 rounded">Login</a>
                <a href="{{ route('register') }}" class="bg-[#ff007a] text-white font-bold px-4 py-2 rounded">Register</a>
            </div>
            <button @click="showLoginPrompt = false" class="text-xs text-gray-400 mt-4 underline">Tutup</button>
        </div>
    </div>

    <div class="max-w-5xl mx-auto space-y-6 px-4">
        @forelse ($creators as $creator)
            <div class="flex flex-col sm:flex-row gap-4 items-start">
                <a href="{{ route('creator.show', $creator->slug) }}" class="w-full sm:w-32 shrink-0">
                    @if ($creator->profile_image)
                        <img src="{{ asset('storage/' . $creator->profile_image) }}" class="w-full aspect-square object-cover border-2 border-[#254bfe]">
                    @else
                        <div class="w-full aspect-square bg-gray-100 border-2 border-[#254bfe]"></div>
                    @endif
                </a>
                <div class="flex-1">
                    <a href="{{ route('creator.show', $creator->slug) }}" class="font-display text-lg text-[#254bfe]">{{ $creator->name }}</a>
                    <p class="text-xs text-gray-500">{{ \Illuminate\Support\Str::limit($creator->bio, 60) }}</p>
                    <p class="text-xs font-bold text-[#254bfe]">{{ $creator->published_works_count }} karya</p>
                    <button wire:click="toggleFollow({{ $creator->id }})"
                            class="inline-block bg-[#ccff00] text-[#254bfe] text-xs font-bold px-3 py-1 rounded mt-1">
                        {{ auth()->check() && $creator->isFollowedBy(auth()->id()) ? 'Mengikuti' : 'Ikuti' }}
                    </button>
                </div>
                <div class="grid grid-cols-3 gap-2 sm:w-64">
                    @foreach ($creator->preview_works as $work)
                        <a href="{{ route('work.show', $work->slug) }}" class="block border-2 border-[#ff007a]">
                            @if ($work->cover_image)
                                <img src="{{ asset('storage/' . $work->cover_image) }}" class="w-full aspect-square object-cover">
                            @else
                                <div class="w-full aspect-square bg-gray-100"></div>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-center text-gray-400">Belum ada kreator.</p>
        @endforelse
    </div>

    <div class="mt-10">{{ $creators->links() }}</div>
</div>