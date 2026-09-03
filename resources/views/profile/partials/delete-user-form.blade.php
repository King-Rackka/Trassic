            <div class="border-2 border-red-500 bg-white p-6 sm:p-8 shadow-[6px_6px_0px_red]" x-data="{ confirmingUserDeletion: false }">
                <header class="border-b-2 border-red-500 pb-3 mb-4">
                    <h2 class="font-display text-2xl text-red-600 uppercase">
                        Hapus Akun
                    </h2>
                    <p class="text-xs sm:text-sm text-red-500 font-medium mt-1">
                        Setelah akun dihapus, seluruh data karya dan informasi profil akan terhapus secara permanen.
                    </p>
                </header>

                <button @click="confirmingUserDeletion = true" class="px-6 py-2 bg-red-600 hover:bg-black text-white font-display text-xs uppercase transition shadow-[3px_3px_0px_#121210]">
                    Hapus Akun Saya
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