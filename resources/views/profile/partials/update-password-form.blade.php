<div class="border-2 border-[#2F3AFF] bg-white p-6 sm:p-8 shadow-[6px_6px_0px_#FC00BB]">
                <header class="border-b-2 border-[#2F3AFF] pb-3 mb-6">
                    <h2 class="font-display text-2xl text-[#2F3AFF] uppercase">
                        Ganti Kata Sandi
                    </h2>
                    <p class="text-xs sm:text-sm text-[#2F3AFF] font-medium mt-1">
                        Pastikan akun kamu menggunakan kata sandi yang kuat dan acak.
                    </p>
                </header>

                <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('put')

                    <div>
                        <label for="update_password_current_password" class="block font-bold text-xs uppercase text-[#2F3AFF] mb-1">Kata Sandi Saat Ini</label>
                        <input type="password" id="update_password_current_password" name="current_password" 
                               class="w-full border-2 border-[#2F3AFF] p-2.5 text-xs sm:text-sm font-bold text-[#2F3AFF] focus:outline-none focus:border-[#FC00BB]">
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="update_password_password" class="block font-bold text-xs uppercase text-[#2F3AFF] mb-1">Kata Sandi Baru</label>
                            <input type="password" id="update_password_password" name="password" 
                                   class="w-full border-2 border-[#2F3AFF] p-2.5 text-xs sm:text-sm font-bold text-[#2F3AFF] focus:outline-none focus:border-[#FC00BB]">
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
                        </div>

                        <div>
                            <label for="update_password_password_confirmation" class="block font-bold text-xs uppercase text-[#2F3AFF] mb-1">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" id="update_password_password_confirmation" name="password_confirmation" 
                                   class="w-full border-2 border-[#2F3AFF] p-2.5 text-xs sm:text-sm font-bold text-[#2F3AFF] focus:outline-none focus:border-[#FC00BB]">
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="px-6 py-2 bg-[#2F3AFF] hover:bg-[#FC00BB] text-white font-display text-xs uppercase transition border-2 border-[#2F3AFF] shadow-[3px_3px_0px_#D9FC28]">
                            Perbarui Password
                        </button>
                    </div>
                </form>
            </div>