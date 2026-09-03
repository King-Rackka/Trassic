{{-- SATU FORM UTAMA (USER + CREATOR DATA) --}}
            <div class="border-2 border-[#FC00BB] bg-white p-6 sm:p-10 shadow-[8px_8px_0px_#2F3AFF]">
                <header class="border-b-2 border-[#FC00BB] pb-3 mb-8">
                    <h2 class="font-display text-2xl sm:text-3xl text-[#2F3AFF] uppercase">
                        Informasi Akun & Kreator
                    </h2>
                    <p class="text-xs sm:text-sm text-[#2F3AFF] font-medium mt-1">
                        Perbarui data akun login dan identitas publik kamu dalam satu langkah.
                    </p>
                </header>

                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('patch')

                    {{-- 1. NAMA & EMAIL (AKUN LOGIN) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-[#F8F9FA] p-4 sm:p-6 border-2 border-[#2F3AFF]">
                        <div>
                            <label for="name" class="block font-bold text-xs uppercase text-[#2F3AFF] mb-1">Nama Lengkap *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full border-2 border-[#2F3AFF] p-2.5 text-xs sm:text-sm font-bold text-[#2F3AFF] focus:outline-none focus:border-[#FC00BB]">
                            <x-input-error class="mt-1" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <label for="email" class="block font-bold text-xs uppercase text-[#2F3AFF] mb-1">Alamat Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full border-2 border-[#2F3AFF] p-2.5 text-xs sm:text-sm font-bold text-[#2F3AFF] focus:outline-none focus:border-[#FC00BB]">
                            <x-input-error class="mt-1" :messages="$errors->get('email')" />
                        </div>
                    </div>

                    {{-- 2. COVER IMAGE --}}
                    <div>
                        <label class="block font-bold text-xs uppercase text-[#2F3AFF] mb-2">Sampul Profil (Cover Image)</label>
                        <div class="relative w-full h-36 sm:h-48 bg-gray-100 border-2 border-[#2F3AFF] overflow-hidden mb-2">
                            @if ($creator && $creator->cover_image)
                                <img src="{{ asset('storage/' . $creator->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-r from-[#D9FC28] via-[#ff8a4c] to-[#FC00BB] flex items-center justify-center text-[#2F3AFF] font-display text-lg uppercase">
                                    Belum Ada Cover
                                </div>
                            @endif
                        </div>
                        <input type="file" name="cover_image" accept="image/*" 
                               class="block w-full text-xs text-[#2F3AFF] file:mr-4 file:py-2 file:px-4 file:border-2 file:border-[#2F3AFF] file:bg-[#D9FC28] file:text-[#2F3AFF] file:font-bold file:uppercase hover:file:bg-[#FC00BB] hover:file:text-white transition cursor-pointer">
                        <x-input-error class="mt-1" :messages="$errors->get('cover_image')" />
                    </div>

                    {{-- 3. FOTO PROFIL & TIPE KREATOR --}}
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                        <div class="md:col-span-5">
                            <label class="block font-bold text-xs uppercase text-[#2F3AFF] mb-2">Foto Profil</label>
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 bg-gray-900 border-2 border-[#2F3AFF] overflow-hidden shrink-0">
                                    @if ($creator && $creator->profile_image)
                                        <img src="{{ asset('storage/' . $creator->profile_image) }}" alt="Avatar" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-[#2F3AFF] text-[#D9FC28] font-display flex items-center justify-center text-xl uppercase">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                    @endif
                                </div>
                                <input type="file" name="profile_image" accept="image/*" 
                                       class="block w-full text-xs text-[#2F3AFF] file:mr-2 file:py-1.5 file:px-3 file:border-2 file:border-[#2F3AFF] file:bg-[#D9FC28] file:text-[#2F3AFF] file:font-bold file:uppercase cursor-pointer">
                            </div>
                            <x-input-error class="mt-1" :messages="$errors->get('profile_image')" />
                        </div>

                        <div class="md:col-span-7">
                            <label for="creator_type" class="block font-bold text-xs uppercase text-[#2F3AFF] mb-1">Tipe / Kategori Kreator</label>
                            <select id="creator_type" name="creator_type" 
                                    class="w-full border-2 border-[#2F3AFF] p-2.5 text-xs sm:text-sm font-bold text-[#2F3AFF] bg-white focus:outline-none focus:border-[#FC00BB]">
                                <option value="">-- Pilih Tipe Kreator --</option>
                                @foreach (['individual' => 'Individual', 'artist' => 'Artist / Seniman', 'community' => 'Komunitas', 'umkm' => 'UMKM', 'studio' => 'Studio Kreatif', 'organization' => 'Organisasi'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('creator_type', $creator->creator_type ?? '') === $val ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-1" :messages="$errors->get('creator_type')" />
                        </div>
                    </div>

                    {{-- 4. BIO --}}
                    <div>
                        <label for="bio" class="block font-bold text-xs uppercase text-[#2F3AFF] mb-1">Bio / Deskripsi Kreator</label>
                        <textarea id="bio" name="bio" rows="3" placeholder="Ceritakan singkat tentang karya dan komitmen daur ulang kamu..." 
                                  class="w-full border-2 border-[#2F3AFF] p-3 text-xs sm:text-sm font-medium text-[#2F3AFF] focus:outline-none focus:border-[#FC00BB]">{{ old('bio', $creator->bio ?? '') }}</textarea>
                        <x-input-error class="mt-1" :messages="$errors->get('bio')" />
                    </div>

                    {{-- 5. LOKASI & TELEPON --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="location" class="block font-bold text-xs uppercase text-[#2F3AFF] mb-1">Lokasi / Alamat</label>
                            <input type="text" id="location" name="location" value="{{ old('location', $creator->location ?? '') }}" placeholder="Contoh: Jakarta, Indonesia" 
                                   class="w-full border-2 border-[#2F3AFF] p-2.5 text-xs sm:text-sm font-medium text-[#2F3AFF] focus:outline-none focus:border-[#FC00BB]">
                            <x-input-error class="mt-1" :messages="$errors->get('location')" />
                        </div>

                        <div>
                            <label for="phone" class="block font-bold text-xs uppercase text-[#2F3AFF] mb-1">Nomor Telepon / WA</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $creator->phone ?? '') }}" placeholder="08123456789" 
                                   class="w-full border-2 border-[#2F3AFF] p-2.5 text-xs sm:text-sm font-medium text-[#2F3AFF] focus:outline-none focus:border-[#FC00BB]">
                            <x-input-error class="mt-1" :messages="$errors->get('phone')" />
                        </div>
                    </div>

                    {{-- 6. MEDIA SOSIAL --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-[#2F3AFF]/20">
                        <div>
                            <label for="website" class="block font-bold text-xs uppercase text-[#2F3AFF] mb-1">Website URL</label>
                            <input type="url" id="website" name="website" value="{{ old('website', $socials['website'] ?? '') }}" placeholder="https://websitekamu.com" 
                                   class="w-full border-2 border-[#2F3AFF] p-2.5 text-xs sm:text-sm font-medium text-[#2F3AFF] focus:outline-none focus:border-[#FC00BB]">
                            <x-input-error class="mt-1" :messages="$errors->get('website')" />
                        </div>

                        <div>
                            <label for="instagram" class="block font-bold text-xs uppercase text-[#2F3AFF] mb-1">Username Instagram</label>
                            <div class="flex items-center">
                                <span class="border-2 border-r-0 border-[#2F3AFF] bg-[#2F3AFF] text-white px-3 py-2.5 text-xs sm:text-sm font-bold">@</span>
                                <input type="text" id="instagram" name="instagram" value="{{ old('instagram', $socials['instagram'] ?? '') }}" placeholder="username_ig" 
                                       class="w-full border-2 border-[#2F3AFF] p-2.5 text-xs sm:text-sm font-medium text-[#2F3AFF] focus:outline-none focus:border-[#FC00BB]">
                            </div>
                            <x-input-error class="mt-1" :messages="$errors->get('instagram')" />
                        </div>
                    </div>

                    {{-- TOMBOL SIMPAN UTAMA --}}
                    <div class="pt-4 flex items-center gap-4">
                        <button type="submit" 
                                class="px-8 py-3 bg-[#D9FC28] hover:bg-[#FC00BB] text-[#2F3AFF] hover:text-white font-display text-base uppercase transition cursor-pointer border-2 border-[#2F3AFF] shadow-[4px_4px_0px_#2F3AFF]">
                            Simpan Perubahan
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" 
                               class="font-display text-xs uppercase text-[#2F3AFF] bg-[#D9FC28] px-3 py-1.5 border border-[#2F3AFF]">
                                ✓ Profil Berhasil Diperbarui
                            </p>
                        @endif
                    </div>

                </form>
            </div>