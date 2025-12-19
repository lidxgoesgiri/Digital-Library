<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold gradient-text">{{ __('Book List') }}</h2>
                <p class="text-white/50 mt-1">{{ __('Find your favorite book and start reading') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 glass-card p-4 border-l-4 border-emerald-500 animate-fade-in-down">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-emerald-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-emerald-400">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 glass-card p-4 border-l-4 border-red-500 animate-fade-in-down">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-red-400">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <div class="glass-card p-6 mb-8 animate-fade-in-down">
                <form action="{{ route('user.books.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search title, author, or category...') }}"
                            class="input-glass pl-12">
                    </div>
                    <div>
                        <select name="category" class="input-glass min-w-[180px]">
                            <option value="">{{ __('All Categories') }}</option>
                            @foreach($categories as $category)
                                @if($category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-primary">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                {{ __('Search') }}
                            </span>
                        </button>
                        @if(request('search') || request('category'))
                            <a href="{{ route('user.books.index') }}" class="btn-secondary">
                                {{ __('Reset') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @forelse($books as $index => $book)
                    <a href="{{ route('user.books.show', $book) }}" 
                       class="book-card rounded-2xl overflow-hidden animate-fade-in-up"
                       style="animation-delay: {{ ($index % 10) * 50 }}ms">
                        <div class="aspect-[3/4] overflow-hidden relative">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-indigo-500/30 to-purple-500/30 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="absolute top-3 right-3">
                                @if($book->isAvailable())
                                    <span class="badge badge-success">{{ __('Available') }}</span>
                                @else
                                    <span class="badge badge-danger">{{ __('Out of Stock') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-semibold text-white truncate group-hover:gradient-text transition-all">{{ $book->title }}</h4>
                            <p class="text-sm text-white/50 truncate mt-1">{{ $book->author }}</p>
                            @if($book->category)
                                <span class="inline-block mt-2 text-xs px-2 py-1 bg-white/5 rounded-lg text-white/40">{{ $book->category }}</span>
                            @endif
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-xs {{ $book->isAvailable() ? 'text-emerald-400' : 'text-red-400' }}">
                                    {{ $book->availableStock() }} {{ __('available') }}
                                </span>
                                <svg class="w-5 h-5 text-purple-400 opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="glass-card p-12 max-w-md mx-auto">
                            <svg class="w-16 h-16 text-white/20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold mb-2">{{ __('No books found') }}</h3>
                            <p class="text-white/50">{{ __('Try changing your search keywords or category filter') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $books->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
