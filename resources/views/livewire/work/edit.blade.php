<div class="w-full bg-grid-pattern min-h-screen py-6 sm:py-8 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- BREADCRUMB --}}
        <nav class="text-left pt-4 sm:pt-6 mb-4 sm:mb-6">
            <p class="text-xs sm:text-sm font-semibold uppercase tracking-widest flex items-center gap-2">
                <a href="{{ route('profile.show') }}" class="text-gray-500 hover:text-[#2F3AFF] hover:underline">Profile</a> 
                <span class="text-gray-400">/</span> 
                <span class="text-[#2F3AFF] font-bold flex items-center gap-1.5">
                    <svg class="w-4 h-4 fill-current text-[#FC00BB]" viewBox="0 0 24 24">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                    </svg>
                    Edit Karya
                </span>
            </p>
        </nav>

        <form wire:submit.prevent="update" class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">

            {{-- KIRI: PREVIEW GAMBAR & MANAGEMENT FOTO --}}
            <div class="lg:sticky lg:top-6 w-full">
                <div class="bg-[#F8F8F8] border-4 border-[#FC00BB] p-6 shadow-[8px_8px_0px_0px_#2F3AFF] relative w-full flex flex-col items-center">
                    
                    <div class="w-full flex items-center justify-between font-sans text-xs text-[#2F3AFF] font-bold uppercase mb-6">
                        <span>{{ count($existingImages) + count($newImages) }}/10 files</span>

                        <label class="cursor-pointer text-[#2F3AFF] hover:text-[#FC00BB] transition flex items-center gap-1 font-bold">
                            <span>↺ Tambah Foto</span>
                            <input type="file" wire:model="newImages" multiple class="hidden" accept="image/*">
                        </label>
                    </div>

                    {{-- DISPLAY PREVIEW UTAMA --}}
                    <div class="relative w-[280px] sm:w-[320px] aspect-square bg-[#FFD6F6] border-2 border-[#FC00BB] mb-6 flex items-center justify-center overflow-hidden">
    
    <div wire:loading wire:target="newImages" class="absolute inset-0 bg-[#0c0d1a]/90 z-30 flex flex-col items-center justify-center p-4">
        <svg class="animate-spin h-8 w-8 text-[#D9FC28] mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
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

    @if ($this->currentPreviewUrl)
        <img src="{{ $this->currentPreviewUrl }}" class="w-full h-full object-cover">
        
        <div class="absolute top-2 left-2 bg-[#D9FC28] text-[#2F3AFF] border border-[#2F3AFF] text-[10px] font-extrabold px-2 py-0.5 uppercase z-20">
            Foto Utama
        </div>
    @else
        <label class="cursor-pointer flex flex-col items-center justify-center w-full h-full text-gray-400 hover:text-[#FC00BB] transition p-4">
            <span class="text-3xl font-light mb-1">+</span>
            <span class="font-sans text-[11px] uppercase font-bold tracking-wider text-center">TAMBAH FOTO</span>
            <input type="file" wire:model="newImages" multiple class="hidden" accept="image/*">
        </label>
    @endif
</div>

                    {{-- THUMBNAILS GRID --}}
                    <div class="w-full flex flex-wrap gap-3 items-center justify-start">
                        @foreach ($existingImages as $eIndex => $eImg)
                            <div wire:click="setPreview('existing', {{ $eIndex }})" 
                                class="relative w-16 h-16 sm:w-20 sm:h-20 border-2 cursor-pointer overflow-hidden transition-all {{ $activeType === 'existing' && $activeIndex === $eIndex ? 'border-[#FC00BB] ring-2 ring-[#FC00BB]' : 'border-black hover:border-[#FC00BB]' }}">
                                <img src="{{ asset('storage/' . $eImg) }}" class="w-full h-full object-cover">
                                <button type="button" 
                                        wire:click.stop="removeExistingImage({{ $eIndex }})" 
                                        class="absolute top-0 right-0 bg-[#FC00BB] text-white text-[10px] px-1 font-bold hover:bg-red-600 z-10">✕</button>
                            </div>
                        @endforeach

                        @foreach ($newImages as $nIndex => $nImg)
                            <div wire:click="setPreview('new', {{ $nIndex }})" 
                                class="relative w-16 h-16 sm:w-20 sm:h-20 border-2 cursor-pointer overflow-hidden transition-all {{ $activeType === 'new' && $activeIndex === $nIndex ? 'border-[#FC00BB] ring-2 ring-[#FC00BB]' : 'border-black hover:border-[#FC00BB]' }}">
                                <img src="{{ $nImg->temporaryUrl() }}" class="w-full h-full object-cover">
                                <span class="absolute bottom-0 left-0 bg-[#D9FC28] text-[#2F3AFF] text-[8px] font-bold px-1 uppercase">Baru</span>
                                <button type="button" 
                                        wire:click.stop="removeNewImage({{ $nIndex }})" 
                                        class="absolute top-0 right-0 bg-[#FC00BB] text-white text-[10px] px-1 font-bold hover:bg-red-600 z-10">✕</button>
                            </div>
                        @endforeach

                        @if ((count($existingImages) + count($newImages)) < 10)
                            <label class="w-16 h-16 sm:w-20 sm:h-20 bg-[#FFD6F6]/60 border-2 border-[#FC00BB] flex items-center justify-center cursor-pointer hover:bg-[#FFD6F6] transition shrink-0">
                                <span class="text-2xl font-normal text-[#FC00BB]">+</span>
                                <input type="file" wire:model="newImages" multiple class="hidden" accept="image/*">
                            </label>
                        @endif
                    </div>

                    @error('images') 
                        <span class="text-xs text-red-600 font-bold mt-3 block w-full text-left">{{ $message }}</span> 
                    @enderror
                </div>
            </div>

            {{-- KANAN: FORM DATA KARYA & SAMPAH --}}
            <div class="w-full space-y-6">

                <div class="space-y-4">
                    <h2 class="font-display text-2xl sm:text-3xl text-[#2F3AFF] uppercase font-normal">Informasi Utama</h2>

                    {{-- JUDUL --}}
                    <div>
                        <label class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">JUDUL KARYA</label>
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

                    {{-- TAGS --}}
                    <div>
                        <label class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">TAGS</label>
                        <input type="text" 
                            wire:model="tags" 
                            placeholder="Contoh: Organik, Daur Ulang" 
                            class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none px-4 py-2.5 text-sm text-[#2F3AFF] placeholder-gray-400 focus:outline-none">
                    </div>

                    {{-- SUGGESTED TAGS --}}
                    <div>
                        <label class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1.5">SUGGESTED TAGS</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach (['Organik', 'Anorganik', 'K3', 'Plastik'] as $sTag)
                                <button type="button" 
                                        wire:click="selectSuggestedTag('{{ $sTag }}')" 
                                        class="px-3.5 py-1.5 bg-[#2F3AFF] hover:bg-[#FC00BB] border border-[#FC00BB] text-white hover:text-[#D9FC28] font-sans text-xs font-medium uppercase transition-colors cursor-pointer">
                                    + {{ $sTag }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div>
                        <label class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">DESKRIPSI KARYA</label>
                        <textarea wire:model="description" 
                                  rows="4" 
                                  placeholder="Tuliskan deskripsi lengkap karya..." 
                                  class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none p-4 text-sm text-[#2F3AFF] placeholder-gray-400 focus:outline-none"></textarea>
                        @error('description') <span class="text-xs text-red-600 font-medium">{{ $message }}</span> @enderror
                    </div>

                    {{-- KOMENTAR TOGGLE --}}
                    <div class="flex items-center justify-between pt-2">
                        <span class="font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider">IZINKAN KOMENTAR</span>
                        <div class="flex items-center gap-3">
                            <span class="font-sans text-xs uppercase text-[#2F3AFF] font-medium">
                                {{ $allowComments ? 'ON' : 'OFF' }}
                            </span>
                            <button type="button" 
                                    wire:click="$toggle('allowComments')" 
                                    class="w-12 h-6 flex items-center bg-[#a2a8fb] border-2 border-[#2F3AFF] p-0.5 cursor-pointer transition">
                                <div class="bg-[#2F3AFF] w-4 h-4 transition-transform duration-200 {{ $allowComments ? 'translate-x-6' : '' }}"></div>
                            </button>
                        </div>
                    </div>
                </div>

                <hr class="border-[#2F3AFF]/30 my-6">

                {{-- DETAIL SAMPAH --}}
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

                            <div>
                                <label class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">JENIS SAMPAH</label>
                                <input type="text" 
                                       wire:model="wasteDetails.{{ $wIndex }}.waste_type" 
                                       placeholder="Contoh: Plastik Botol" 
                                       class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none px-4 py-2.5 text-sm text-[#2F3AFF] placeholder-gray-400 focus:outline-none">
                            </div>

                            <div>
                                <label class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">SUMBER SAMPAH</label>
                                <input type="text" 
                                    wire:model="wasteDetails.{{ $wIndex }}.waste_source" 
                                    placeholder="Contoh: Limbah Rumah Tangga" 
                                    class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none px-4 py-2.5 text-sm text-[#2F3AFF] placeholder-gray-400 focus:outline-none">
                            </div>

                            <div>
                                <label class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">TOTAL BERAT SAMPAH</label>
                                <div class="flex gap-2">
                                    <input type="number" 
                                           step="any"
                                           wire:model="wasteDetails.{{ $wIndex }}.weight" 
                                           placeholder="Contoh: 500" 
                                           class="flex-1 bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-bl-none rounded-tr-none rounded-br-none px-4 py-2.5 text-sm text-[#2F3AFF] placeholder-gray-400 focus:outline-none">
                                    <select wire:model="wasteDetails.{{ $wIndex }}.unit" 
                                            class="bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-br-2xl rounded-tl-none rounded-tr-none rounded-bl-none px-3 py-2.5 text-xs font-semibold text-[#2F3AFF] focus:outline-none cursor-pointer">
                                        <option value="gram">gram ∨</option>
                                        <option value="kg">kg ∨</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-2">BAHAN PENDUKUNG</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @for ($m = 0; $m < 4; $m++)
                                        <div class="relative flex items-center">
                                            <span class="absolute left-3 text-xs font-bold text-[#2F3AFF]">{{ $m + 1 }}</span>
                                            <input type="text" 
                                                   wire:model="wasteDetails.{{ $wIndex }}.support_materials.{{ $m }}" 
                                                   placeholder="Contoh: Lem, Cat" 
                                                   class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none pl-7 pr-3 py-2 text-xs text-[#2F3AFF] placeholder-gray-400 focus:outline-none">
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- TOMBOL SUBMIT --}}
                <div class="pt-6 flex flex-col sm:flex-row gap-3">
                    <button type="submit" 
                            class="flex-1 py-3 bg-[#FC00BB] hover:bg-[#2F3AFF] text-[#D9FC28] hover:text-white font-sans text-sm font-semibold uppercase tracking-wide transition-colors flex items-center justify-center gap-2 shadow-sm cursor-pointer">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                        </svg>
                        <span>Simpan Perubahan</span>
                    </button>

                    <a href="{{ route('profile.show') }}" 
                       class="py-3 px-6 border-2 border-gray-400 text-gray-600 hover:bg-gray-100 font-sans text-sm font-semibold uppercase tracking-wide transition-colors text-center">
                        Batal
                    </a>
                </div>

            </div>

        </form>
    </div>
</div>