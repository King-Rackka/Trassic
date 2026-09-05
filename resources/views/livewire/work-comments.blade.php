<div x-data="{ showDeleteModal: false, commentToDeleteId: null }">
    {{-- JUDUL SECTION --}}
    <h2 class="font-display text-2xl sm:text-4xl text-[#254bfe] uppercase mb-6 tracking-wide">
        Komentar
    </h2>

    {{-- FORM INPUT KOMENTAR UTAMA --}}
    <div class="mb-8">
        <div class="relative">
            <textarea
                wire:model="newComment"
                rows="3"
                placeholder="{{ auth()->check() ? 'Tulis komentar kamu...' : 'Login untuk berkomentar...' }}"
                @unless(auth()->check()) onclick="$dispatch('show-login-prompt')" readonly @endunless
                class="w-full border-2 border-black bg-white p-3 sm:p-4 text-sm font-sans text-gray-900 focus:outline-none focus:border-[#ff007a] shadow-[3px_3px_0px_rgba(0,0,0,1)] resize-none"
            ></textarea>
            @error('newComment') 
                <p class="text-[#ff007a] font-sans text-xs font-bold mt-1">{{ $message }}</p> 
            @enderror
        </div>

        @auth
            <div class="flex justify-end mt-2">
                <button type="button"
                        wire:click="postComment"
                        wire:loading.attr="disabled"
                        class="bg-[#254bfe] hover:bg-[#1a3ad1] text-white font-display text-xs uppercase px-5 py-2 border-2 border-black shadow-[2px_2px_0px_rgba(0,0,0,1)] active:translate-y-0.5 transition">
                    <span wire:loading.remove wire:target="postComment">Kirim</span>
                    <span wire:loading wire:target="postComment">Mengirim...</span>
                </button>
            </div>
        @endauth
    </div>

    {{-- DAFTAR KOMENTAR --}}
    <div class="space-y-6">
        @forelse ($comments as $comment)
            <div class="relative">
                
                {{-- 1. KOMENTAR UTAMA (TOP-LEVEL) --}}
                <div class="flex items-start gap-3 sm:gap-4">
                    
                    {{-- Avatar Kotak di Luar Bubble --}}
                    <div class="w-10 h-10 sm:w-11 sm:h-11 shrink-0 border-2 border-black bg-white shadow-[2px_2px_0px_rgba(0,0,0,1)] overflow-hidden z-10">
                        @if ($comment->user->creatorProfile?->profile_image)
                            <img src="{{ asset('storage/' . $comment->user->creatorProfile->profile_image) }}" 
                                 alt="{{ $comment->user->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-[#254bfe] text-[#ccff00] font-display flex items-center justify-center text-xs uppercase">
                                {{ substr($comment->user->name, 0, 2) }}
                            </div>
                        @endif
                    </div>

                    {{-- Konten Kanan (Bubble Biru + Action) --}}
                    <div class="flex-1 min-w-0">
                        <div class="bg-[#254bfe] p-3.5 sm:p-4 text-white shadow-[2px_2px_0px_rgba(0,0,0,1)]">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="font-sans font-bold text-sm sm:text-base text-white truncate">
                                        {{ $comment->user->name }}
                                    </span>
                                    <span class="font-sans text-xs text-white/80 shrink-0">
                                        {{ $comment->created_at->translatedFormat('d F Y') }}
                                    </span>
                                </div>

                                {{-- Icon Opsi (...) + Dropdown Menu Hapus Komentar Utama --}}
                                <div class="relative" x-data="{ menuOpen: false }">
                                    <button type="button" 
                                            @click="menuOpen = !menuOpen" 
                                            class="text-white hover:text-[#ccff00] transition p-0.5 cursor-pointer focus:outline-none">
                                        <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                                            <circle cx="5" cy="12" r="2"/>
                                            <circle cx="12" cy="12" r="2"/>
                                            <circle cx="19" cy="12" r="2"/>
                                        </svg>
                                    </button>

                                    <div x-show="menuOpen" 
                                         x-cloak
                                         @click.outside="menuOpen = false"
                                         x-transition:enter="ease-out duration-150"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         class="absolute right-0 top-full mt-1 w-32 bg-white border-2 border-black shadow-[3px_3px_0px_rgba(0,0,0,1)] z-30 py-1 font-sans">
                                        
                                        @if (auth()->check() && (auth()->id() === $comment->user_id || (isset($work) && auth()->id() === $work->user_id)))
                                            <button type="button" 
                                                    @click="commentToDeleteId = {{ $comment->id }}; showDeleteModal = true; menuOpen = false"
                                                    class="w-full text-left px-3 py-1.5 text-xs font-bold text-red-600 hover:bg-red-50 flex items-center gap-2 transition-colors cursor-pointer">
                                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        @else
                                            <button type="button" 
                                                    @click="menuOpen = false"
                                                    class="w-full text-left px-3 py-1.5 text-xs font-bold text-gray-700 hover:bg-gray-100 flex items-center gap-2 transition-colors cursor-pointer">
                                                <span>Laporkan</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <p class="font-sans text-sm sm:text-base text-white leading-relaxed whitespace-pre-line break-words">
                                {{ $comment->content }}
                            </p>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-4 mt-1.5 ml-1 text-xs sm:text-sm font-bold text-[#254bfe]">
                            <button type="button" 
                                    wire:click="startReply({{ $comment->id }})" 
                                    class="flex items-center gap-1.5 hover:text-[#ff007a] transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                </svg>
                                <span>Balas</span>
                            </button>

                            @php
                                $isLiked = auth()->check() && $comment->isLikedBy(auth()->id());
                            @endphp

                            <button type="button" 
                                    wire:click="toggleLike({{ $comment->id }})" 
                                    class="flex items-center gap-1.5 transition font-bold {{ $isLiked ? 'text-[#254bfe]' : 'text-[#254bfe]/60 hover:text-[#254bfe]' }}">
                                @if ($isLiked)
                                    <svg class="w-4 h-4 fill-[#254bfe]" viewBox="0 0 24 24">
                                        <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 9V5a3 3 0 00-3-3l-4 9v11h11.28a2 2 0 002-1.7l1.38-9a2 2 0 00-2-2.3zM7 22H4a2 2 0 01-2-2v-7a2 2 0 012-2h3" />
                                    </svg>
                                @endif
                                <span>{{ $comment->likes_count ?? 0 }}</span>
                            </button>
                        </div>

                        {{-- Form Balas --}}
                        @if ($replyingTo === $comment->id)
                            <div class="mt-3 p-3 bg-white border-2 border-black shadow-[2px_2px_0px_rgba(0,0,0,1)]">
                                <textarea
                                    wire:model="replyText"
                                    rows="2"
                                    placeholder="Tulis balasan..."
                                    class="w-full border border-gray-300 p-2 text-xs sm:text-sm font-sans focus:outline-none focus:border-[#254bfe] resize-none"
                                ></textarea>
                                @error('replyText') 
                                    <p class="text-[#ff007a] text-xs mt-1 font-bold">{{ $message }}</p> 
                                @enderror

                                <div class="flex justify-end gap-2 mt-2">
                                    <button type="button" wire:click="cancelReply" class="text-xs uppercase font-bold text-gray-500 hover:text-black px-2 py-1">
                                        Batal
                                    </button>
                                    <button type="button" wire:click="postReply({{ $comment->id }})" class="bg-[#254bfe] text-white font-display text-xs uppercase px-3 py-1 border border-black shadow-[1px_1px_0px_rgba(0,0,0,1)]">
                                        Kirim Balasan
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- 2. REPLIES / BALASAN --}}
                @if ($comment->replies && $comment->replies->count() > 0)
                    <div class="relative pl-7 sm:pl-10 mt-4 space-y-4">
                        @foreach ($comment->replies as $reply)
                            <div class="relative flex items-start gap-3 sm:gap-4">
                                <div class="absolute -left-5 sm:-left-6 top-[-22px] w-5 sm:w-6 h-[38px] sm:h-[40px] border-b-2 border-l-2 border-[#254bfe] pointer-events-none"></div>

                                <div class="w-8 h-8 sm:w-9 sm:h-9 shrink-0 border-2 border-black bg-white shadow-[2px_2px_0px_rgba(0,0,0,1)] overflow-hidden z-10">
                                    @if ($reply->user->creatorProfile?->profile_image)
                                        <img src="{{ asset('storage/' . $reply->user->creatorProfile->profile_image) }}" 
                                             alt="{{ $reply->user->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-[#254bfe] text-[#ccff00] font-display flex items-center justify-center text-[10px] uppercase">
                                            {{ substr($reply->user->name, 0, 2) }}
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="bg-[#254bfe] p-3 sm:p-3.5 text-white shadow-[2px_2px_0px_rgba(0,0,0,1)]">
                                        <div class="flex items-center justify-between gap-2 mb-1">
                                            <div class="flex items-center gap-2.5 min-w-0">
                                                <span class="font-sans font-bold text-xs sm:text-sm text-white truncate">
                                                    {{ $reply->user->name }}
                                                </span>
                                                <span class="font-sans text-[11px] text-white/80 shrink-0">
                                                    {{ $reply->created_at->translatedFormat('d F Y') }}
                                                </span>
                                            </div>

                                            {{-- Icon Opsi (...) + Dropdown Menu Hapus Balasan --}}
                                            <div class="relative" x-data="{ menuOpen: false }">
                                                <button type="button" 
                                                        @click="menuOpen = !menuOpen" 
                                                        class="text-white hover:text-[#ccff00] transition p-0.5 cursor-pointer focus:outline-none">
                                                    <svg class="w-3.5 h-3.5 fill-currentColor" viewBox="0 0 24 24">
                                                        <circle cx="5" cy="12" r="2"/>
                                                        <circle cx="12" cy="12" r="2"/>
                                                        <circle cx="19" cy="12" r="2"/>
                                                    </svg>
                                                </button>

                                                <div x-show="menuOpen" 
                                                     x-cloak
                                                     @click.outside="menuOpen = false"
                                                     x-transition:enter="ease-out duration-150"
                                                     x-transition:enter-start="opacity-0 scale-95"
                                                     x-transition:enter-end="opacity-100 scale-100"
                                                     class="absolute right-0 top-full mt-1 w-32 bg-white border-2 border-black shadow-[3px_3px_0px_rgba(0,0,0,1)] z-30 py-1 font-sans">
                                                    
                                                    @if (auth()->check() && (auth()->id() === $reply->user_id || (isset($work) && auth()->id() === $work->user_id)))
                                                        <button type="button" 
                                                                @click="commentToDeleteId = {{ $reply->id }}; showDeleteModal = true; menuOpen = false"
                                                                class="w-full text-left px-3 py-1.5 text-xs font-bold text-red-600 hover:bg-red-50 flex items-center gap-2 transition-colors cursor-pointer">
                                                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                                                <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                                                            </svg>
                                                            <span>Hapus</span>
                                                        </button>
                                                    @else
                                                        <button type="button" 
                                                                @click="menuOpen = false"
                                                                class="w-full text-left px-3 py-1.5 text-xs font-bold text-gray-700 hover:bg-gray-100 flex items-center gap-2 transition-colors cursor-pointer">
                                                            <span>Laporkan</span>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <p class="font-sans text-xs sm:text-sm text-white leading-relaxed whitespace-pre-line break-words">
                                            {{ $reply->content }}
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-4 mt-1 ml-1 text-xs font-bold text-[#254bfe]">
                                        <button type="button" 
                                                wire:click="startReply({{ $comment->id }})" 
                                                class="flex items-center gap-1 hover:text-[#ff007a] transition">
                                            <svg class="w-3.5 h-3.5 fill-none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                            </svg>
                                            <span>Balas</span>
                                        </button>

                                        @php
                                            $isReplyLiked = auth()->check() && $reply->isLikedBy(auth()->id());
                                        @endphp

                                        <button type="button" 
                                                wire:click="toggleLike({{ $reply->id }})" 
                                                class="flex items-center gap-1 transition font-bold {{ $isReplyLiked ? 'text-[#254bfe]' : 'text-[#254bfe]/60 hover:text-[#254bfe]' }}">
                                            @if ($isReplyLiked)
                                                <svg class="w-3.5 h-3.5 fill-[#254bfe]" viewBox="0 0 24 24">
                                                    <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                                </svg>
                                            @else
                                                <svg class="w-3.5 h-3.5 fill-none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 9V5a3 3 0 00-3-3l-4 9v11h11.28a2 2 0 002-1.7l1.38-9a2 2 0 00-2-2.3zM7 22H4a2 2 0 01-2-2v-7a2 2 0 012-2h3" />
                                                </svg>
                                            @endif
                                            <span>{{ $reply->likes_count ?? 0 }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        @empty
            <div class="text-center py-6 text-gray-400 font-sans text-sm">
                Belum ada komentar. Jadilah yang pertama berkomentar!
            </div>
        @endforelse
    </div>

    {{-- ======================================================== --}}
    {{-- MODAL KONFIRMASI HAPUS KOMENTAR (PERSIS GAYA EDIT KARYA) --}}
    {{-- ======================================================== --}}
    <div x-show="showDeleteModal" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs transition-opacity"
         x-transition:enter="ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        {{-- Kotak Modal --}}
        <div class="relative w-full max-w-md bg-[#F8F8F8] border-4 border-[#FC00BB] rounded-tl-3xl rounded-br-3xl rounded-tr-none rounded-bl-none p-6 sm:p-8"
             @click.outside="showDeleteModal = false"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            {{-- Tombol Close X Merah --}}
            <button type="button" 
                    @click="showDeleteModal = false"
                    class="absolute -top-3.5 -right-3.5 w-9 h-9 sm:w-10 sm:h-10 bg-[#E51B24] hover:bg-[#c9121a] border-2 border-[#E51B24] ring-2 ring-white ring-inset rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none flex items-center justify-center transition-transform hover:scale-105 cursor-pointer shadow-md">
                <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>

            {{-- Teks Pertanyaan --}}
            <div class="py-6 sm:py-8 text-center">
                <p class="font-sans text-base sm:text-lg font-bold text-[#2F3AFF] tracking-wide">
                    Apakah anda ingin menghapus komentar?
                </p>
            </div>

            {{-- Tombol Ya & Tidak --}}
            <div class="grid grid-cols-2 gap-3 pt-2">
                {{-- Tombol YA (Kuning Stabilo #D9FC28) --}}
                <button type="button" 
                        @click="if (commentToDeleteId) { $wire.deleteComment(commentToDeleteId); } showDeleteModal = false"
                        class="w-full py-3 bg-[#D9FC28] hover:bg-[#bce018] text-[#2F3AFF] font-sans text-sm font-bold tracking-wider uppercase transition-colors flex items-center justify-center cursor-pointer shadow-sm">
                    YA
                </button>

                {{-- Tombol TIDAK (Pink #FC00BB) --}}
                <button type="button" 
                        @click="showDeleteModal = false"
                        class="w-full py-3 bg-[#FC00BB] hover:bg-[#d8009f] text-white font-sans text-sm font-bold tracking-wider uppercase transition-colors flex items-center justify-center cursor-pointer shadow-sm">
                    TIDAK
                </button>
            </div>

        </div>
    </div>
</div>