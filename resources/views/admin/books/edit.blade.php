<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold gradient-text">Edit Buku</h2>
                <p class="text-white/50 mt-1">Perbarui informasi buku</p>
            </div>
            <a href="{{ route('admin.books.index') }}" class="btn-secondary">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-card overflow-hidden animate-fade-in-up">
                <div class="p-8">
                    <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="title" class="block text-sm font-medium text-white/70 mb-2">Judul Buku <span class="text-red-400">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" required
                                class="input-glass" placeholder="Masukkan judul buku">
                            @error('title')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="author" class="block text-sm font-medium text-white/70 mb-2">Penulis <span class="text-red-400">*</span></label>
                            <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" required
                                class="input-glass" placeholder="Nama penulis">
                            @error('author')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="isbn" class="block text-sm font-medium text-white/70 mb-2">ISBN</label>
                                <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book->isbn) }}"
                                    class="input-glass" placeholder="978-xxx-xxx">
                                @error('isbn')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-white/70 mb-2">Kategori</label>
                                <input type="text" name="category" id="category" value="{{ old('category', $book->category) }}"
                                    class="input-glass" placeholder="Novel, Sejarah, dll">
                                @error('category')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="published_year" class="block text-sm font-medium text-white/70 mb-2">Tahun Terbit</label>
                                <input type="number" name="published_year" id="published_year" value="{{ old('published_year', $book->published_year) }}" 
                                    min="1000" max="{{ date('Y') }}"
                                    class="input-glass" placeholder="{{ date('Y') }}">
                                @error('published_year')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="stock" class="block text-sm font-medium text-white/70 mb-2">Stok <span class="text-red-400">*</span></label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', $book->stock) }}" min="1" required
                                    class="input-glass" placeholder="1">
                                @error('stock')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-white/70 mb-2">Deskripsi</label>
                            <textarea name="description" id="description" rows="4"
                                class="input-glass resize-none" placeholder="Deskripsi singkat tentang buku...">{{ old('description', $book->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cover_image" class="block text-sm font-medium text-white/70 mb-2">Cover Buku</label>
                            @if($book->cover_image)
                                <div class="mb-4 flex items-center gap-4">
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" 
                                         class="h-32 w-24 object-cover rounded-xl shadow-lg">
                                    <div>
                                        <p class="text-white/50 text-sm">Cover saat ini</p>
                                        <p class="text-white/30 text-xs">Upload gambar baru untuk mengganti</p>
                                    </div>
                                </div>
                            @endif
                            <div class="glass p-4 rounded-xl">
                                <input type="file" name="cover_image" id="cover_image" accept="image/*"
                                    class="block w-full text-sm text-white/50
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-lg file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-purple-500/20 file:text-purple-400
                                        hover:file:bg-purple-500/30 file:transition-colors file:cursor-pointer">
                                <p class="mt-2 text-xs text-white/40">Format: JPG, PNG. Maksimal 2MB</p>
                            </div>
                            @error('cover_image')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-4 pt-4">
                            <a href="{{ route('admin.books.index') }}" class="btn-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn-glow">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Buku
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
