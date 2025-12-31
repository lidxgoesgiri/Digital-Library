<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">{{ __('Welcome') }}, <span class="text-purple-600">{{ auth()->user()->name }}!</span></h2>
                <p class="text-white/50 mt-1">{{ __('Explore the collection and start reading') }}</p>
            </div>
            <div class="hidden md:flex items-center space-x-3">
                <a href="{{ route('user.books.index') }}" class="btn-primary">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        {{ __('Search Books') }}
                    </span>
                </a>
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="stat-card group animate-fade-in-up" style="animation-delay: 100ms">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/50 text-sm font-medium">{{ __('Books Currently Borrowed') }}</p>
                            <p class="text-4xl font-bold text-purple-600 mt-2">{{ $activeBorrowings->count() }}</p>
                        </div>
                        <div class="w-14 h-14 bg-purple-600 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card group animate-fade-in-up" style="animation-delay: 200ms">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/50 text-sm font-medium">{{ __('Total Returned') }}</p>
                            <p class="text-4xl font-bold text-emerald-400 mt-2">{{ $returnedCount }}</p>
                        </div>
                        <div class="w-14 h-14 bg-emerald-600 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            @if($activeBorrowings->count() > 0)
                <div class="glass-card p-6 mb-8 animate-fade-in-up" style="animation-delay: 300ms">
                    <h3 class="text-lg font-semibold mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('Books Being Borrowed') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($activeBorrowings as $borrowing)
                            <div class="glass p-4 rounded-xl flex gap-4 group hover:bg-white/10 transition-all duration-300">
                                @if($borrowing->book->cover_image)
                                    <img src="{{ asset('storage/' . $borrowing->book->cover_image) }}" alt="{{ $borrowing->book->title }}" class="h-24 w-16 object-cover rounded-lg shadow-lg group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="h-24 w-16 bg-slate-700/50 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-white truncate">{{ $borrowing->book->title }}</h4>
                                    <p class="text-sm text-white/50 truncate">{{ $borrowing->book->author }}</p>
                                    <p class="text-xs mt-2 {{ $borrowing->due_date->isPast() ? 'text-red-400' : 'text-white/40' }}">
                                        {{ __('Due date') }}: {{ $borrowing->due_date->format('d M Y') }}
                                        @if($borrowing->due_date->isPast())
                                            <span class="badge badge-danger ml-1">{{ __('Late!') }}</span>
                                        @endif
                                    </p>
                                    <form action="{{ route('user.borrowings.return', $borrowing) }}" method="POST" class="mt-3">
                                        @csrf
                                        <button type="submit" class="text-sm px-4 py-1.5 bg-emerald-500/20 text-emerald-400 rounded-lg hover:bg-emerald-500/30 transition-colors">
                                            {{ __('Return') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="glass-card p-6 animate-fade-in-up" style="animation-delay: 400ms">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        {{ __('Recent Books') }}
                    </h3>
                    <a href="{{ route('user.books.index') }}" class="text-sm text-purple-400 hover:text-purple-300 transition-colors flex items-center">
                        {{ __('View All') }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach($recentBooks as $book)
                        <a href="{{ route('user.books.show', $book) }}" class="book-card rounded-xl overflow-hidden group">
                            <div class="aspect-[3/4] overflow-hidden">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-slate-700/50 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h4 class="font-medium text-sm truncate group-hover:text-purple-600 transition-all">{{ $book->title }}</h4>
                                <p class="text-xs text-white/50 truncate">{{ $book->author }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
