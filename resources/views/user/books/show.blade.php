<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold gradient-text">{{ __('Book Detail') }}</h2>
                <p class="text-white/50 mt-1">{{ __('Book Details') }}</p>
            </div>
            <a href="{{ route('user.books.index') }}" class="btn-secondary">
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
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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

            <div class="glass-card overflow-hidden animate-fade-in-up">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="flex-shrink-0">
                            <div class="relative group">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                         alt="{{ $book->title }}" 
                                         class="h-80 w-56 object-cover rounded-2xl shadow-2xl shadow-purple-500/20 group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="h-80 w-56 bg-gradient-to-br from-indigo-500/30 to-purple-500/30 rounded-2xl flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute -inset-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl blur-xl opacity-20 group-hover:opacity-40 transition-opacity -z-10"></div>
                            </div>
                        </div>

                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-white mb-2">{{ $book->title }}</h1>
                            <p class="text-xl text-white/60 mb-6">{{ __('Author') }}: {{ $book->author }}</p>

                            <div class="grid grid-cols-2 gap-6 mb-6">
                                <div class="glass p-4 rounded-xl">
                                    <p class="text-white/50 text-sm mb-1">{{ __('ISBN') }}</p>
                                    <p class="font-semibold">{{ $book->isbn ?? '-' }}</p>
                                </div>
                                <div class="glass p-4 rounded-xl">
                                    <p class="text-white/50 text-sm mb-1">{{ __('Category') }}</p>
                                    <p class="font-semibold">{{ $book->category ?? '-' }}</p>
                                </div>
                                <div class="glass p-4 rounded-xl">
                                    <p class="text-white/50 text-sm mb-1">{{ __('Year') }}</p>
                                    <p class="font-semibold">{{ $book->published_year ?? '-' }}</p>
                                </div>
                                <div class="glass p-4 rounded-xl">
                                    <p class="text-white/50 text-sm mb-1">{{ __('Available') }}</p>
                                    @if($book->isAvailable())
                                        <p class="font-semibold text-emerald-400">{{ $book->availableStock() }} {{ __('of') }} {{ $book->stock }} {{ __('available') }}</p>
                                    @else
                                        <p class="font-semibold text-red-400">{{ __('Book not available') }}</p>
                                    @endif
                                </div>
                            </div>

                            @if($book->description)
                                <div class="mb-6">
                                    <p class="text-white/50 text-sm mb-2">{{ __('Description') }}</p>
                                    <p class="text-white/80 leading-relaxed">{{ $book->description }}</p>
                                </div>
                            @endif

                            <div class="flex gap-4">
                                @if($book->isAvailable())
                                    <form action="{{ route('user.books.borrow', $book) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-glow"
                                                onclick="return confirm('{{ __('Confirm') }}')">
                                            <span class="flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                                {{ __('Borrow This Book') }}
                                            </span>
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="px-8 py-3 bg-white/10 rounded-xl font-semibold text-white/50 cursor-not-allowed">
                                        <span class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                            </svg>
                                            {{ __('Book not available') }}
                                        </span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
