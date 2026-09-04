<x-app-layout>
    <x-slot:title>Edit Profil - Trassic</x-slot:title>

    @php
        $creator = $user->creatorProfile;
        $socials = $creator->social_links ?? [];
        if (is_string($socials)) {
            $socials = json_decode($socials, true) ?? [];
        }
    @endphp

    <div class="w-full bg-grid-pattern min-h-screen py-6 sm:py-8 font-sans selection:bg-[#D9FC28] selection:text-[#2F3AFF]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <nav class="mb-6 font-display text-sm text-[#2F3AFF] uppercase tracking-normal">
                <a href="{{ route('profile.show') }}" class="hover:underline">Profile</a> 
                <span class="mx-1">/</span> 
                <span class="font-normal">Edit profil</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start relative">

                <div class="lg:sticky lg:top-6 w-full space-y-6 z-10">
                    
                    <div class="bg-[#F8F8F8] border-4 border-[#FC00BB] p-5 sm:p-6 shadow-[8px_8px_0px_0px_#2F3AFF] relative w-full flex flex-col items-center text-center">
                        <h3 class="font-display text-2xl text-[#2F3AFF] uppercase mb-4">Sampul Profile</h3>
                        
                        <div class="relative w-full h-48 sm:h-60 bg-[#0c0d1a] border-2 border-[#FC00BB] overflow-hidden flex items-center justify-center mb-5">
                            @if ($creator && $creator->cover_image)
                                <img src="{{ asset('storage/' . $creator->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-r from-[#D9FC28] via-[#ff8a4c] to-[#FC00BB] flex items-center justify-center text-[#2F3AFF] font-display text-sm uppercase font-bold">
                                    Belum Ada Cover
                                </div>
                            @endif
                        </div>

                        <div class="w-full flex flex-col items-center justify-center text-center" x-data="{ fileName: '' }">
                            <span class="block font-sans text-[11px] uppercase text-[#2F3AFF] font-bold tracking-wider mb-2">PILIH SAMPUL BARU</span>
                            
                            <div class="flex items-center justify-center gap-2">
                                <label for="cover_image" class="px-5 py-2 bg-[#2F3AFF] hover:bg-[#FC00BB] hover:text-[#D9FC28] text-white font-sans text-xs font-bold uppercase transition-all cursor-pointer inline-flex items-center justify-center">
                                    Choose File
                                </label>
                                <span x-text="fileName || 'No file chosen'" class="font-sans text-xs text-[#2F3AFF] font-medium"></span>
                            </div>

                            <input type="file" id="cover_image" form="form-profile-update" name="cover_image" accept="image/*" 
                                   style="display: none !important;" 
                                   @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''">
                            
                            <x-input-error class="mt-1 text-center" :messages="$errors->get('cover_image')" />
                        </div>
                    </div>

                    <div class="bg-[#F8F8F8] border-4 border-[#FC00BB] p-5 sm:p-6 shadow-[8px_8px_0px_0px_#2F3AFF] relative w-full flex flex-col items-center text-center">
                        <h3 class="font-display text-2xl text-[#2F3AFF] uppercase mb-4">Foto Profile</h3>
                        
                        <div class="relative w-40 h-40 sm:w-48 sm:h-48 rounded-full border-4 border-[#FC00BB] p-1 bg-white shadow-[4px_4px_0px_0px_#2F3AFF] overflow-hidden mb-5">
                            @if ($creator && $creator->profile_image)
                                <img src="{{ asset('storage/' . $creator->profile_image) }}" alt="Avatar" class="w-full h-full object-cover rounded-full">
                            @elseif ($user->avatar)
                                <img src="{{ $user->avatar }}" alt="Avatar" class="w-full h-full object-cover rounded-full">
                            @else
                                <div class="w-full h-full bg-[#2F3AFF] text-[#D9FC28] font-display text-4xl flex items-center justify-center uppercase rounded-full font-black">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                            @endif
                        </div>

                            <div class="w-full flex flex-col items-center justify-center text-center" x-data="{ fileName: '' }">
                            <span class="block font-sans text-[11px] uppercase text-[#2F3AFF] font-bold tracking-wider mb-2">PILIH FOTO PROFIL BARU</span>
                            
                            <div class="flex items-center justify-center gap-2">
                                <label for="profile_image" class="px-5 py-2 bg-[#2F3AFF] hover:bg-[#FC00BB] hover:text-[#D9FC28] text-white font-sans text-xs font-bold uppercase transition-all cursor-pointer inline-flex items-center justify-center">
                                    Choose File
                                </label>
                                <span x-text="fileName || 'No file chosen'" class="font-sans text-xs text-[#2F3AFF] font-medium"></span>
                            </div>

                            <input type="file" id="profile_image" form="form-profile-update" name="profile_image" accept="image/*" 
                                   style="display: none !important;" 
                                   @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''">
                            
                            <x-input-error class="mt-1 text-center" :messages="$errors->get('profile_image')" />
                        </div>
                    </div>

                </div>


                <div class="w-full space-y-8">

                    <form id="form-profile-update" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div class="space-y-4">
                            <h2 class="font-display text-2xl sm:text-3xl text-[#2F3AFF] uppercase font-normal">Informasi Personal</h2>

                            <div>
                                <label for="name" class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">NAMA *</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required maxlength="100" 
                                       placeholder="Contoh: Raditya Meyka" 
                                       class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none px-4 py-2.5 text-sm text-[#2F3AFF] font-medium placeholder-gray-400 focus:outline-none">
                                <x-input-error class="mt-1" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <label for="creator_type" class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">KATEGORI KREATOR</label>
                                <select id="creator_type" name="creator_type" 
                                        class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none px-4 py-2.5 text-sm text-[#2F3AFF] font-medium focus:outline-none cursor-pointer">
                                    <option value="">-- Pilih Kategori Kreator --</option>
                                    @foreach (['individual' => 'Individual', 'artist' => 'Artist / Seniman', 'community' => 'Komunitas', 'umkm' => 'UMKM ', 'studio' => 'Studio Kreatif', 'organization' => 'Organisasi'] as $val => $label)
                                        <option value="{{ $val }}" {{ old('creator_type', $creator->creator_type ?? '') === $val ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-1" :messages="$errors->get('creator_type')" />
                            </div>

                            <div>
                                <label for="phone" class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">NOMOR HANDPHONE</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $creator->phone ?? '') }}" 
                                       placeholder="Contoh: 081234567890" 
                                       class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none px-4 py-2.5 text-sm text-[#2F3AFF] font-medium placeholder-gray-400 focus:outline-none">
                                <x-input-error class="mt-1" :messages="$errors->get('phone')" />
                            </div>

                            <div>
                                <label for="email" class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">EMAIL *</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required 
                                       placeholder="Contoh: raditya@gmail.com" 
                                       class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none px-4 py-2.5 text-sm text-[#2F3AFF] font-medium placeholder-gray-400 focus:outline-none">
                                <x-input-error class="mt-1" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <label for="location" class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">LOKASI</label>
                                <input type="text" id="location" name="location" value="{{ old('location', $creator->location ?? '') }}" 
                                       placeholder="Contoh: Jakarta, Indonesia" 
                                       class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none px-4 py-2.5 text-sm text-[#2F3AFF] font-medium placeholder-gray-400 focus:outline-none">
                                <x-input-error class="mt-1" :messages="$errors->get('location')" />
                            </div>

                            <div>
                                <label for="bio" class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">DESKRIPSI / BIO</label>
                                <textarea id="bio" name="bio" rows="8" 
                                          placeholder="Tuliskan cerita singkat tentang diri atau fokus daur ulang kamu..." 
                                          class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none p-4 text-sm text-[#2F3AFF] font-medium placeholder-gray-400 focus:outline-none">{{ old('bio', $creator->bio ?? '') }}</textarea>
                                <x-input-error class="mt-1" :messages="$errors->get('bio')" />
                            </div>
                        </div>

                        <hr class="border-[#2F3AFF]/30 my-6">

                        <div class="space-y-4">
                            <h2 class="font-display text-2xl text-[#2F3AFF] uppercase font-normal">Tautan</h2>

                            <div>
                                <label for="instagram" class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">INSTAGRAM</label>
                                <div class="relative flex items-center">
                                    <input type="text" id="instagram" name="instagram" value="{{ old('instagram', $socials['instagram'] ?? '') }}" 
                                           placeholder="rimesa2026" 
                                           class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none pr-4 py-2.5 text-sm text-[#2F3AFF] font-medium placeholder-gray-400 focus:outline-none">
                                </div>
                                <x-input-error class="mt-1" :messages="$errors->get('instagram')" />
                            </div>

                            <div>
                                <label for="website" class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">WEBSITE</label>
                                <div class="relative flex items-center">
                                    <input type="url" id="website" name="website" value="{{ old('website', $socials['website'] ?? '') }}" 
                                           placeholder="trassic.id" 
                                           class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none  pr-4 py-2.5 text-sm text-[#2F3AFF] font-medium placeholder-gray-400 focus:outline-none">
                                </div>
                                <x-input-error class="mt-1" :messages="$errors->get('website')" />
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" 
                                    class="w-full py-3 bg-[#FC00BB] hover:bg-[#2F3AFF] text-[#D9FC28] hover:text-white font-sans text-sm font-semibold uppercase tracking-wide transition-colors flex items-center justify-center gap-2 shadow-sm cursor-pointer">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-6 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H6V4h9v4z"/>
                                </svg>
                                <span>Simpan Perubahan Profil</span>
                            </button>
                        </div>

                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" 
                               class="font-display text-xs uppercase text-[#2F3AFF] bg-[#D9FC28] px-3 py-1.5 border border-[#2F3AFF] text-center">
                                ✓ Profil Berhasil Diperbarui
                            </p>
                        @endif

                    </form>

                    <hr class="border-[#2F3AFF]/30 my-8">

                    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                        @csrf
                        @method('put')

                        <h2 class="font-display text-2xl text-[#2F3AFF] uppercase font-normal">Keamanan & Password</h2>

                        <div>
                            <label for="update_password_current_password" class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">PASSWORD SAAT INI</label>
                            <input type="password" id="update_password_current_password" name="current_password" 
                                   placeholder="••••••••" 
                                   class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none px-4 py-2.5 text-sm text-[#2F3AFF] font-medium placeholder-gray-400 focus:outline-none">
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
                        </div>

                        <div>
                            <label for="update_password_password" class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">PASSWORD BARU</label>
                            <input type="password" id="update_password_password" name="password" 
                                   placeholder="••••••••" 
                                   class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none px-4 py-2.5 text-sm text-[#2F3AFF] font-medium placeholder-gray-400 focus:outline-none">
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
                        </div>

                        <div>
                            <label for="update_password_password_confirmation" class="block font-sans text-xs uppercase text-[#2F3AFF] font-bold tracking-wider mb-1">KONFIRMASI PASSWORD BARU</label>
                            <input type="password" id="update_password_password_confirmation" name="password_confirmation" 
                                   placeholder="••••••••" 
                                   class="w-full bg-[#F8F8F8] border-2 border-[#FC00BB] rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none px-4 py-2.5 text-sm text-[#2F3AFF] font-medium placeholder-gray-400 focus:outline-none">
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
                        </div>

                        <button type="submit" 
                                class="w-full py-2.5 bg-[#FC00BB] hover:bg-[#2F3AFF] text-[#D9FC28] hover:text-white font-sans text-xs font-semibold uppercase tracking-wide transition-colors shadow-sm cursor-pointer">
                            Update Password
                        </button>
                    </form>

                    <hr class="border-red-300 my-8">

                    <div class="bg-red-50 border-2 border-red-500 p-5 rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none space-y-3" x-data="{ confirmingUserDeletion: false }">
                        <h3 class="font-display text-xl text-red-600 uppercase">Zona Bahaya (Hapus Akun)</h3>
                        <p class="font-sans text-xs text-red-700 leading-relaxed">
                            Setelah akun kamu dihapus, semua karya, foto, dan data profil akan dihapus secara permanen dari Trassic.
                        </p>
                        
                        <button type="button" 
                                @click="confirmingUserDeletion = true" 
                                class="px-4 py-2 bg-red-600 hover:bg-black text-white font-sans text-xs font-bold uppercase transition-colors rounded-tl-lg cursor-pointer">
                            ✕ Hapus Akun Permanen
                        </button>

                        {{-- MODAL KONFIRMASI HAPUS AKUN --}}
                        <div x-show="confirmingUserDeletion" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
                            <div class="bg-white border-4 border-red-600 p-6 max-w-md w-full shadow-[8px_8px_0px_#121210] space-y-4">
                                <h3 class="font-display text-2xl text-red-600 uppercase">Apakah kamu yakin?</h3>
                                <p class="text-xs text-gray-600 font-medium">
                                    Masukkan kata sandi untuk mengonfirmasi penghapusan permanen akun ini.
                                </p>

                                <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                                    @csrf
                                    @method('delete')

                                    <input type="password" name="password" placeholder="Kata Sandi Saat Ini" required
                                           class="w-full border-2 border-red-600 p-2.5 text-xs font-bold text-red-600 focus:outline-none">
                                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1" />

                                    <div class="flex justify-end gap-3 pt-2">
                                        <button type="button" @click="confirmingUserDeletion = false" class="px-4 py-2 bg-gray-200 text-gray-700 font-display text-xs uppercase">
                                            Batal
                                        </button>
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white font-display text-xs uppercase">
                                            Hapus Permanen
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>