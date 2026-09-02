<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil Kreator') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Perbarui deskripsi, nomor telepon, alamat, dan foto profil Anda.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Bio --}}
        <div>
            <x-input-label for="bio" :value="__('Bio / Deskripsi')" />
            <textarea id="bio" name="bio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3">{{ old('bio', $user->creatorProfile->bio ?? '') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        {{-- Phone --}}
        <div>
            <x-input-label for="phone" :value="__('Nomor Telepon')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->creatorProfile->phone ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        {{-- Address --}}
        <div>
            <x-input-label for="address" :value="__('Alamat / Lokasi')" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->creatorProfile->address ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        {{-- Foto Profil --}}
        <div>
            <x-input-label for="profile_image" :value="__('Foto Profil')" />
            <input id="profile_image" name="profile_image" type="file" class="mt-1 block w-full text-sm text-gray-500" />
            <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
        </div>
    </form>
</section>