<section class="space-y-6" x-data="{ confirmingUserDeletion: false }">
    <p class="text-white/60 text-sm">
        Setelah akun Anda dihapus, semua data dan resource akan dihapus secara permanen. 
        Sebelum menghapus akun, silakan unduh data atau informasi yang ingin Anda simpan.
    </p>

    <button type="button" @click="confirmingUserDeletion = true" 
            class="px-4 py-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-colors">
        <span class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Hapus Akun
        </span>
    </button>

    <!-- Modal -->
    <div x-show="confirmingUserDeletion" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" @click="confirmingUserDeletion = false"></div>
            
            <!-- Modal Content -->
            <div class="relative glass-card p-6 w-full max-w-md mx-auto rounded-2xl"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">
                
                <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6">
                    @csrf
                    @method('delete')

                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Hapus Akun?</h3>
                        <p class="text-white/60 text-sm">
                            Apakah Anda yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-white/70 mb-2">Masukkan Password untuk Konfirmasi</label>
                        <input id="password" name="password" type="password" 
                               class="input-glass" 
                               placeholder="Password Anda">
                        @error('password', 'userDeletion')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="confirmingUserDeletion = false" class="btn-secondary">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 rounded-xl font-semibold text-white transition-colors">
                            Hapus Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
