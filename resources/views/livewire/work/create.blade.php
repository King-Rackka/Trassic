
<div class="w-full bg-grid-pattern min-h-screen py-6 sm:py-8 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <nav class="text-left pt-4 sm:pt-6 mb-4 sm:mb-6">
            <p class="text-xs sm:text-sm font-semibold uppercase tracking-widest flex items-center gap-2">
                <a href="{{ route('profile.show') }}" class="text-gray-500 hover:text-[#254bfe] hover:underline">Profile</a> 
                <span class="text-gray-400">/</span> 
                <span class="text-[#254bfe] font-bold">Tambah Karya</span>
            </p>
        </nav>

        <form wire:submit.prevent="save" class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">

            <div class="lg:sticky lg:top-6 w-full">
                <div class="bg-[#F8F8F8] border-4 border-[#FC00BB] p-6 shadow-[8px_8px_0px_0px_#2F3AFF] relative w-full flex flex-col items-center">
                    
                    <div class="w-full flex items-center justify-between font-sans text-xs text-[#2F3AFF] font-bold uppercase mb-6">
                        <span>{{ count($images) }}/10 files</span>

                        @if (count($images) > 0)
                            <label class="cursor-pointer text-[#2F3AFF] hover:text-[#FC00BB] transition flex items-center gap-1 font-bold">
                                <span>↺ Replace Image</span>
                                <input type="file" wire:model="replacementImage" class="hidden" accept="image/*">
                            </label>
                        @endif
                    </div>

                    <div class="relative w-[280px] sm:w-[320px] aspect-square bg-[#FFD6F6] border-2 border-[#FC00BB] mb-6 flex items-center justify-center overflow-hidden">
                        
                        {{-- KODE BARU --}}
                        <div wire:loading.flex wire:target="images, replacementImage" class="absolute inset-0 bg-[#0c0d1a]/90 z-30 flex-col items-center justify-center p-4">
                            <svg class="animate-spin h-8 w-8 text-[#D9FC28] mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="2" x2="12" y2="6"></line>
                                <line x1="12" y1="18" x2="12" y2="22"></line>
                                <line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line>
                                <line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line>
                                <line x1="2" y1="12" x2="6" y2="12"></line>
                                <line x1="18" y1="12" x2="22" y2="12"></line>
                                <line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line>
                                <line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line>
                            </svg>
                            <span class="font-display text-xs text-[#D9FC28] uppercase tracking-widest text-center">
                                Mengunggah Foto...
                            </span>
                        </div>

                        @if (isset($images[$activeImageIndex]))
                            <img src="{{ $images[$activeImageIndex]->temporaryUrl() }}" class="w-full h-full object-cover">
                            
                            <button type="button" 
                                    wire:click="removeImage({{ $activeImageIndex }})" 
                                    class="absolute top-2 right-2 bg-[#FC00BB] text-white p-1.5 text-xs font-bold hover:bg-red-600 transition z-20 cursor-pointer">
                                ✕
                            </button>
                        @else
                            <label class="cursor-pointer flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-[#FC00BB] transition p-4">
                                <span class="text-3xl font-light mb-1">+</span>
                                <span class="font-sans text-[11px] uppercase font-bold tracking-wider text-center">PILIH FOTO UTAMA</span>
                                <input type="file" wire:model="images" multiple class="hidden" accept="image/*">
                            </label>
                        @endif
                    </div>

                    <div class="w-full flex flex-wrap gap-3 items-center justify-start">
                        @foreach ($images as $index => $img)
                            <div wire:click="$set('activeImageIndex', {{ $index }})" 
                                class="relative w-16 h-16 sm:w-20 sm:h-20 border-2 cursor-pointer overflow-hidden transition-all {{ $activeImageIndex === $index ? 'border-[#FC00BB] ring-2 ring-[#FC00BB]' : 'border-black hover:border-[#FC00BB]' }}">
                                <img src="{{ $img->temporaryUrl() }}" class="w-full h-full object-cover">
                            </div>
                        @endforeach

                        @if (count($images) < 10)
                            <label class="w-16 h-16 sm:w-20 sm:h-20 bg-[#FFD6F6]/60 border-2 border-[#FC00BB] flex items-center justify-center cursor-pointer hover:bg-[#FFD6F6] transition shrink-0">
                                <span class="text-2xl font-normal text-[#FC00BB]">+</span>
                                <input type="file" wire:model="images" multiple class="hidden" accept="image/*">
                            </label>
                        @endif
                    </div>

                    @error('images') 
                        <span class="text-xs text-red-600 font-bold mt-3 block w-full text-left">{{ $message }}</span> 
                    @enderror
                </div>
            </div>


            {{-- ========================================== --}}
            {{-- KANAN: FORM ISIAN DESKRIPSI & SAMPAH (50%) --}}
            {{-- ========================================== --}}
            <div class="w-full space-y-6">

                {{-- SECTION 1: UTAMA --}}
                <div class="space-y-4">
                    <h2 class="font-display text-2xl sm:text-3xl text-[#2F3AFF] uppercase font-normal">Utama</h2>

                    {{-- JUDUL --}}
                    <div>
                        <label class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">JUDUL</label>
                        <div class="relative">
                            <input type="text" 
                                   wire:model.live="title" 
                                   maxlength="100" 
                                   placeholder="Contoh: Lilin Jelantah" 
                                   class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none px-4 py-2.5 text-sm text-[#2F3AFF] placeholder-gray-400 focus:outline-none pr-16">
                            <span class="absolute right-3.5 top-3 text-xs font-sans text-[#2F3AFF] opacity-70">
                                {{ strlen($title) }}/100
                            </span>
                        </div>
                        @error('title') <span class="text-xs text-red-600 font-medium">{{ $message }}</span> @enderror
                    </div>

                    {{-- TAGS (CHIPS + DROPDOWN LIST PERSIS GAMBAR) --}}
                    <div class="relative" x-data="{ isOpen: false }">
                        <label class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">TAGS</label>

                        {{-- Wadah Input Utama Berbingkai Retro Trassic --}}
                        <div @click="isOpen = true; $refs.tagInput.focus()"
                             class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none p-2 flex flex-wrap items-center gap-1.5 min-h-[46px] relative cursor-text focus-within:ring-2 focus-within:ring-[#2F3AFF]/30">
                            
                            {{-- Kotak Tag Terpilih (Chips) --}}
                            @foreach ($selectedTags as $idx => $tag)
                                <span class="inline-flex items-center gap-2 bg-[#2F3AFF] border-2 border-[#FC00BB] text-white px-3.5 py-1.5 text-xs font-bold font-sans">
                                    <span>{{ $tag }}</span>
                                    <button type="button" 
                                            wire:click.stop="removeTag({{ $idx }})" 
                                            class="text-white hover:text-[#D9FC28] font-bold text-sm leading-none cursor-pointer">
                                        &times;
                                    </button>
                                </span>
                            @endforeach

                            {{-- Input Ketik Tag --}}
                            <input type="text" 
                                   x-ref="tagInput"
                                   @focus="isOpen = true"
                                   wire:model.live="tagSearch"
                                   wire:keydown.enter.prevent="addTag(tagSearch); isOpen = false"
                                   placeholder="{{ count($selectedTags) == 0 ? 'Ketik nama sampah...' : '' }}" 
                                   class="flex-1 bg-transparent border-none text-xs text-[#2F3AFF] placeholder-gray-400 focus:outline-none min-w-[120px] px-1 py-1 font-semibold">

                            {{-- Icon Panah Dropdown di Kanan --}}
                            <div class="pr-2 text-[#2F3AFF] pointer-events-none shrink-0" :class="isOpen ? 'rotate-180' : ''">
                                <svg class="w-3.5 h-3.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </div>

                        {{-- DROPDOWN PILIHAN KE BAWAH --}}
                        <div x-show="isOpen" 
                             x-cloak
                             @click.outside="isOpen = false"
                             class="absolute left-0 right-0 top-full mt-1 bg-white border-2 border-black shadow-[4px_4px_0px_rgba(0,0,0,1)] z-50 max-h-52 overflow-y-auto">
                            
                            @if (!empty($this->tagSuggestions))
                                <div class="flex flex-col divide-y divide-gray-100">
                                    @foreach ($this->tagSuggestions as $suggestion)
                                        <button type="button" 
                                                wire:click="addTag('{{ $suggestion }}'); isOpen = false"
                                                class="w-full text-left px-4 py-2 text-sm font-bold text-black hover:bg-[#2F3AFF] hover:text-white transition-none cursor-pointer">
                                            {{ $suggestion }}
                                        </button>
                                    @endforeach
                                </div>
                            @else
                                <div class="px-4 py-3 text-xs text-gray-500 font-semibold text-center">
                                    Tidak ada tag sampah yang cocok. Tekan <span class="text-black font-bold">Enter</span> untuk menambahkan sebagai tag baru.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- SUGGESTED TAGS (OTOMATIS HILANG JIKA SUDAH DIPILIH) --}}
                    @php
                        $suggestedList = ['Organik', 'Anorganik', 'Plastik HDPE', 'Minyak Jelantah', 'Kardus', 'Kain Perca'];
                        $availableSuggestions = array_diff($suggestedList, $selectedTags ?? []);
                    @endphp

                    @if (!empty($availableSuggestions))
                        <div>
                            <label class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1.5">SUGGESTED TAGS</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($availableSuggestions as $sTag)
                                    <button type="button" 
                                            wire:click="selectSuggestedTag('{{ $sTag }}')" 
                                            class="px-3.5 py-1.5 bg-[#2F3AFF] hover:bg-[#FC00BB] border-2 border-[#FC00BB] text-white hover:text-[#D9FC28] font-sans text-xs font-bold transition-colors cursor-pointer">
                                        + {{ $sTag }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- DESKRIPSI --}}
                    <div>
                        <label class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">DESKRIPSI</label>
                        <textarea wire:model="description" 
                                  rows="4" 
                                  placeholder="Contoh: Raditya Meyka" 
                                  class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none p-4 text-sm text-[#2F3AFF] placeholder-gray-400 focus:outline-none"></textarea>
                        @error('description') <span class="text-xs text-red-600 font-medium">{{ $message }}</span> @enderror
                    </div>

                    
                    {{-- KOMENTAR TOGGLE (Animasi Tilt Meluncur Persis Video) --}}
                    <div class="flex items-center justify-between pt-2"
                        x-data="{
                            on: @entangle('allowComments').live,
                            tilting: false,
                            toggle() {
                                this.tilting = true;
                                this.on = !this.on;
                                setTimeout(() => { this.tilting = false }, 220);
                            }
                        }">
                        <span class="font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider">KOMENTAR</span>
                        
                        <div class="flex items-center gap-3">
                            {{-- Teks Status ON / OFF --}}
                            <span class="font-sans text-xs uppercase font-bold tracking-wider min-w-[28px] text-right select-none transition-colors"
                                :class="on ? 'text-[#FC00BB]' : 'text-[#2F3AFF]'"
                                x-text="on ? 'ON' : 'OFF'">
                                {{ $allowComments ? 'ON' : 'OFF' }}
                            </span>

                            {{-- Tombol Toggle --}}
                            <button type="button" 
                                    @click="toggle()" 
                                    class="w-12 h-6 flex items-center border-2 p-0.5 cursor-pointer transition-all duration-200 focus:outline-none"
                                    :class="on ? 'bg-[#FC00BB]/40 border-[#FC00BB]' : 'bg-[#a2a8fb] border-[#2F3AFF]'">
                                
                                {{-- Kotak Dalam yang Meluncur Sambil Miring --}}
                                <div class="w-4 h-4 transition-all duration-200 ease-out transform"
                                    :class="{
                                        'translate-x-6 bg-[#D9FC28] border-2 border-[#FC00BB]': on,
                                        'translate-x-0 bg-[#2F3AFF]': !on,
                                        '-rotate-12 scale-95': tilting
                                    }">
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                <hr class="border-[#2F3AFF]/30 my-6">

                {{-- SECTION 2: DETAIL PENGGUNAAN SAMPAH --}}
                <div class="space-y-5">
                    <div class="flex items-center justify-between flex-wrap gap-2">
                        <h2 class="font-display text-2xl sm:text-3xl text-[#2F3AFF] uppercase font-normal">Detail penggunaan sampah</h2>
                        
                        <button type="button" 
                                wire:click="addWasteCategory" 
                                class="px-4 py-2 bg-[#FC00BB] hover:bg-[#2F3AFF] text-[#D9FC28] hover:text-white font-sans text-xs font-semibold uppercase transition-colors cursor-pointer">
                            + Tambah Kategori
                        </button>
                    </div>

                    @foreach ($wasteDetails as $wIndex => $waste)
                        <div class="space-y-4 pt-2 relative">
                            @if (count($wasteDetails) > 1)
                                <div class="flex justify-end">
                                    <button type="button" 
                                            wire:click="removeWasteCategory({{ $wIndex }})" 
                                            class="text-xs font-semibold text-red-600 hover:text-red-800 flex items-center gap-1 transition cursor-pointer">
                                        <span>✕ Hapus Kategori</span>
                                    </button>
                                </div>
                            @endif

                            {{-- JENIS SAMPAH --}}
                            <div>
                                <label class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">JENIS SAMPAH</label>
                                <input type="text" 
                                       wire:model="wasteDetails.{{ $wIndex }}.waste_type" 
                                       placeholder="Contoh: Lilin Jelantah" 
                                       class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none px-4 py-2.5 text-sm text-[#2F3AFF] placeholder-gray-400 focus:outline-none">
                            </div>

                            {{-- SUMBER SAMPAH --}}
                            <div>
                                <label class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">SUMBER SAMPAH</label>
                                <input type="text" 
                                       wire:model="wasteDetails.{{ $wIndex }}.waste_source" 
                                       placeholder="Contoh: Limbah rumah tangga" 
                                       class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none px-4 py-2.5 text-sm text-[#2F3AFF] placeholder-gray-400 focus:outline-none">
                            </div>

                            {{-- TOTAL BERAT SAMPAH --}}
                            <div>
                                <label class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">
                                    TOTAL BERAT SAMPAH YANG DIGUNAKAN / TOTAL BERAT KARYA
                                </label>
                                <div class="flex items-center gap-2">
                                    {{-- Input Angka Berat (Tinggi h-11 & Panah Angka Bawaan Dimatikan) --}}
                                    <input type="number" 
                                        step="any"
                                        wire:model="wasteDetails.{{ $wIndex }}.weight" 
                                        placeholder="Contoh: 500" 
                                        class="flex-1 h-11 bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-bl-none rounded-tr-none rounded-br-none px-4 text-sm text-[#2F3AFF] placeholder-gray-400 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">

                                    {{-- Dropdown Satuan (Tinggi h-11 Presisi & Bebas Panah Ganda) --}}
                                    <div class="relative shrink-0 h-11">
                                        <select wire:model="wasteDetails.{{ $wIndex }}.unit" 
                                                class="h-11 appearance-none bg-none bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-br-2xl rounded-tl-none rounded-tr-none rounded-bl-none pl-4 pr-9 text-xs font-bold text-[#2F3AFF] focus:outline-none cursor-pointer min-w-[95px]">
                                            <option value="gram">gram</option>
                                            <option value="kg">kg</option>
                                        </select>

                                        {{-- Satu Ikon Panah Biru Custom --}}
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-[#2F3AFF]">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- BAHAN PENDUKUNG --}}
                            <div>
                                <label class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-2">BAHAN PENDUKUNG</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @for ($m = 0; $m < 4; $m++)
                                        <div class="relative flex items-center">
                                            <span class="absolute left-3 text-xs font-bold text-[#2F3AFF]">{{ $m + 1 }}</span>
                                            <input type="text" 
                                                   wire:model="wasteDetails.{{ $wIndex }}.support_materials.{{ $m }}" 
                                                   placeholder="Contoh: Lilin" 
                                                   class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none pl-7 pr-3 py-2 text-xs text-[#2F3AFF] placeholder-gray-400 focus:outline-none">
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-6">
                    <button type="submit" 
                            class="w-full py-3 bg-[#FC00BB] hover:bg-[#2F3AFF] text-[#D9FC28] hover:text-white font-sans text-sm font-semibold uppercase tracking-wide transition-colors flex items-center justify-center gap-2 shadow-sm cursor-pointer">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-6 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H6V4h9v4z"/>
                        </svg>
                        <span>Simpan</span>
                    </button>
                </div>

            </div>

        </form>
    </div>

</div>