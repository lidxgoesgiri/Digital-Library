<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold gradient-text">{{ __('Add New Book') }}</h2>
                <p class="text-white/50 mt-1">{{ __('Manage library book collection') }}</p>
            </div>
            <a href="{{ route('admin.books.index') }}" class="btn-secondary">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back') }}
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-card overflow-hidden animate-fade-in-up">
                <div class="p-8">
                    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label for="title" class="block text-sm font-medium text-white/70 mb-2">{{ __('Title') }} <span class="text-red-400">*</span></label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                class="input-glass" placeholder="{{ __('Title') }}">
                            @error('title')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="author" class="block text-sm font-medium text-white/70 mb-2">{{ __('Author') }} <span class="text-red-400">*</span></label>
                            <input type="text" name="author" id="author" value="{{ old('author') }}" required
                                class="input-glass" placeholder="{{ __('Author') }}">
                            @error('author')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="isbn" class="block text-sm font-medium text-white/70 mb-2">{{ __('ISBN') }}</label>
                                <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}"
                                    class="input-glass" placeholder="978-xxx-xxx">
                                @error('isbn')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-white/70 mb-2">{{ __('Category') }}</label>
                                <input type="text" name="category" id="category" value="{{ old('category') }}"
                                    class="input-glass" placeholder="{{ __('Category') }}">
                                @error('category')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="published_year" class="block text-sm font-medium text-white/70 mb-2">{{ __('Year') }}</label>
                                <input type="number" name="published_year" id="published_year" value="{{ old('published_year') }}" 
                                    min="1000" max="{{ date('Y') }}"
                                    class="input-glass" placeholder="{{ date('Y') }}">
                                @error('published_year')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="stock" class="block text-sm font-medium text-white/70 mb-2">{{ __('Stock') }} <span class="text-red-400">*</span></label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', 1) }}" min="1" required
                                    class="input-glass" placeholder="1">
                                @error('stock')
                                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-white/70 mb-2">{{ __('Description') }}</label>
                            <textarea name="description" id="description" rows="4"
                                class="input-glass resize-none" placeholder="{{ __('Description') }}">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cover_image" class="block text-sm font-medium text-white/70 mb-2">{{ __('Cover Image') }}</label>
                            <div class="glass p-4 rounded-xl">
                                <input type="file" name="cover_image" id="cover_image" accept="image/*"
                                    class="block w-full text-sm text-white/50
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-lg file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-purple-500/20 file:text-purple-400
                                        hover:file:bg-purple-500/30 file:transition-colors file:cursor-pointer">
                                <p class="mt-2 text-xs text-white/40">Format: JPG, PNG. Max 2MB</p>
                            </div>
                            @error('cover_image')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-4 pt-4">
                            <a href="{{ route('admin.books.index') }}" class="btn-secondary">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn-glow">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ __('Save') }}
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
