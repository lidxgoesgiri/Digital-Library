<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-purple-600">{{ __('My Borrowings') }}</h2>
                <p class="text-white/50 mt-1">{{ __('Track your book borrowings') }}</p>
            </div>
            <a href="{{ route('user.books.index') }}" class="btn-primary hidden md:flex">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('Search Books') }}
                </span>
            </a>
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="glass-card p-4 flex items-center space-x-4 animate-fade-in-up" style="animation-delay: 100ms">
                    <div class="w-12 h-12 bg-yellow-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white/50 text-sm">{{ __('Being Borrowed') }}</p>
                        <p class="text-2xl font-bold text-yellow-400">{{ $borrowings->where('status', 'borrowed')->count() }}</p>
                    </div>
                </div>
                <div class="glass-card p-4 flex items-center space-x-4 animate-fade-in-up" style="animation-delay: 200ms">
                    <div class="w-12 h-12 bg-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white/50 text-sm">{{ __('Returned') }}</p>
                        <p class="text-2xl font-bold text-emerald-400">{{ $borrowings->where('status', 'returned')->count() }}</p>
                    </div>
                </div>
                <div class="glass-card p-4 flex items-center space-x-4 animate-fade-in-up" style="animation-delay: 300ms">
                    <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white/50 text-sm">{{ __('Borrowings') }}</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $borrowings->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="glass-card overflow-hidden animate-fade-in-up" style="animation-delay: 400ms">
                <div class="p-6 border-b border-white/10">
                    <h3 class="text-lg font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        {{ __('Borrowing History') }}
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-glass">
                        <thead>
                            <tr>
                                <th>{{ __('Book') }}</th>
                                <th>{{ __('Borrow Date') }}</th>
                                <th>{{ __('Due Date') }}</th>
                                <th>{{ __('Return Date') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Fine') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($borrowings as $borrowing)
                                <tr class="group hover:bg-white/5 transition-colors">
                                    <td>
                                        <div class="flex items-center gap-4">
                                            @if($borrowing->book->cover_image)
                                                <img src="{{ asset('storage/' . $borrowing->book->cover_image) }}" 
                                                     alt="{{ $borrowing->book->title }}" 
                                                     class="h-14 w-10 object-cover rounded-lg shadow-lg group-hover:scale-105 transition-transform duration-300">
                                            @else
                                                <div class="h-14 w-10 bg-slate-700/50 rounded-lg flex items-center justify-center">
                                                    <svg class="h-5 w-5 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-medium text-white group-hover:text-purple-600 transition-all">{{ Str::limit($borrowing->book->title, 25) }}</div>
                                                <div class="text-sm text-white/50">{{ $borrowing->book->author }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-white/70">{{ $borrowing->borrowed_at->format('d M Y') }}</span>
                                    </td>
                                    <td>
                                        <span class="{{ $borrowing->status === 'borrowed' && $borrowing->due_date->isPast() ? 'text-red-400' : 'text-white/70' }}">
                                            {{ $borrowing->due_date->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-white/70">{{ $borrowing->returned_at ? $borrowing->returned_at->format('d M Y') : '-' }}</span>
                                    </td>
                                    <td>
                                        @if($borrowing->status === 'borrowed')
                                            @if($borrowing->due_date->isPast())
                                                <span class="badge badge-danger">
                                                    <svg class="w-3 h-3 mr-1 inline animate-pulse" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                                    {{ __('Late!') }}
                                                </span>
                                            @else
                                                <span class="badge badge-warning">
                                                    <svg class="w-3 h-3 mr-1 inline" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                                                    {{ __('Borrowed') }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge badge-success">
                                                <svg class="w-3 h-3 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                {{ __('Returned') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($borrowing->fine_amount > 0)
                                            <div class="flex flex-col">
                                                <span class="text-red-400 font-semibold">Rp {{ number_format($borrowing->fine_amount, 0, ',', '.') }}</span>
                                                @if(!$borrowing->fine_paid && $borrowing->status === 'returned')
                                                    <span class="text-xs text-red-400/70">{{ __('Unpaid') }}</span>
                                                @elseif($borrowing->fine_paid)
                                                    <span class="text-xs text-emerald-400">{{ __('Paid') }}</span>
                                                @endif
                                            </div>
                                        @elseif($borrowing->status === 'borrowed' && $borrowing->due_date->isPast())
                                            <span class="text-yellow-400">Rp {{ number_format($borrowing->calculateFine(), 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-white/30">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($borrowing->status === 'borrowed')
                                            <form action="{{ route('user.borrowings.return', $borrowing) }}" method="POST">
                                                @csrf
                                                <button type="submit" 
                                                        class="px-4 py-2 bg-emerald-500/20 text-emerald-400 rounded-lg hover:bg-emerald-500/30 transition-all duration-300 flex items-center space-x-2 group/btn">
                                                    <svg class="w-4 h-4 group-hover/btn:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span>{{ __('Return') }}</span>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-white/30">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 bg-slate-700/50 rounded-2xl flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-lg font-semibold text-white/70 mb-2">{{ __('No borrowing history') }}</h4>
                                            <p class="text-white/50 mb-4">{{ __('Find your favorite book and start reading') }}</p>
                                            <a href="{{ route('user.books.index') }}" class="btn-primary">
                                                <span class="flex items-center">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                    {{ __('Book List') }}
                                                </span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($borrowings->hasPages())
                    <div class="p-6 border-t border-white/10">
                        {{ $borrowings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
