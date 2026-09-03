<div>
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
                        {{-- Bubble Biru --}}
                        <div class="bg-[#254bfe] p-3.5 sm:p-4 text-white shadow-[2px_2px_0px_rgba(0,0,0,1)]">
                            {{-- Header: Nama + Tanggal + Menu --}}
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="font-sans font-bold text-sm sm:text-base text-white truncate">
                                        {{ $comment->user->name }}
                                    </span>
                                    <span class="font-sans text-xs text-white/80 shrink-0">
                                        {{ $comment->created_at->translatedFormat('d F Y') }}
                                    </span>
                                </div>

                                {{-- Icon Opsi (...) --}}
                                <button type="button" class="text-white hover:text-[#ccff00] transition p-0.5">
                                    <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                                        <circle cx="5" cy="12" r="2"/>
                                        <circle cx="12" cy="12" r="2"/>
                                        <circle cx="19" cy="12" r="2"/>
                                    </svg>
                                </button>
                            </div>

                            {{-- Teks Komentar --}}
                            <p class="font-sans text-sm sm:text-base text-white leading-relaxed whitespace-pre-line break-words">
                                {{ $comment->content }}
                            </p>
                        </div>

                        {{-- Action Buttons di Bawah Bubble --}}
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
                                    {{-- Icon Jempol Full Biru (Saat sudah di-like) --}}
                                    <svg class="w-4 h-4 fill-[#254bfe]" viewBox="0 0 24 24">
                                        <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                    </svg>
                                @else
                                    {{-- Icon Jempol Garis (Saat belum di-like) --}}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 9V5a3 3 0 00-3-3l-4 9v11h11.28a2 2 0 002-1.7l1.38-9a2 2 0 00-2-2.3zM7 22H4a2 2 0 01-2-2v-7a2 2 0 012-2h3" />
                                    </svg>
                                @endif
                                <span>{{ $comment->likes_count ?? 0 }}</span>
                            </button>
                        </div>

                        {{-- FORM BALAS (JIKA AKTIF) --}}
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

                {{-- 2. REPLIES / BALASAN (DENGAN GARIS CABANG SIKU-SIKU) --}}
                @if ($comment->replies && $comment->replies->count() > 0)
                    <div class="relative pl-7 sm:pl-10 mt-4 space-y-4">
                        @foreach ($comment->replies as $reply)
                            <div class="relative flex items-start gap-3 sm:gap-4">
                                
                                {{-- Garis Cabang Siku (L-Shape Tree Connector) --}}
                                <div class="absolute -left-5 sm:-left-6 top-[-22px] w-5 sm:w-6 h-[38px] sm:h-[40px] border-b-2 border-l-2 border-[#254bfe] pointer-events-none"></div>

                                {{-- Avatar Reply --}}
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

                                {{-- Konten Balasan Kanan --}}
                                <div class="flex-1 min-w-0">
                                    {{-- Bubble Biru Reply --}}
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

                                            <button type="button" class="text-white hover:text-[#ccff00] transition p-0.5">
                                                <svg class="w-3.5 h-3.5 fill-currentColor" viewBox="0 0 24 24">
                                                    <circle cx="5" cy="12" r="2"/>
                                                    <circle cx="12" cy="12" r="2"/>
                                                    <circle cx="19" cy="12" r="2"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <p class="font-sans text-xs sm:text-sm text-white leading-relaxed whitespace-pre-line break-words">
                                            {{ $reply->content }}
                                        </p>
                                    </div>

                                    {{-- Action Buttons Reply --}}
                                    <div class="flex items-center gap-4 mt-1 ml-1 text-xs font-bold text-[#254bfe]">
                                        <button type="button" 
                                                wire:click="startReply({{ $comment->id }})" 
                                                class="flex items-center gap-1 hover:text-[#ff007a] transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
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
                                                {{-- Icon Solid Full Biru --}}
                                                <svg class="w-3.5 h-3.5 fill-[#254bfe]" viewBox="0 0 24 24">
                                                    <path d="M2 20h2V8H2v12zm20-9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 2 7.58 7.59C7.22 7.95 7 8.45 7 9v9c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-2z"/>
                                                </svg>
                                            @else
                                                {{-- Icon Outline --}}
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
</div>