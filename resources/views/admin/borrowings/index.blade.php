<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold gradient-text">{{ __('Borrowings') }}</h2>
                <p class="text-white/50 mt-1">{{ __('Manage book borrowings') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="glass-card p-4 flex items-center space-x-4 animate-fade-in-up" style="animation-delay: 100ms">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white/50 text-sm">Total</p>
                        <p class="text-2xl font-bold gradient-text">{{ $borrowings->total() }}</p>
                    </div>
                </div>
                <div class="glass-card p-4 flex items-center space-x-4 animate-fade-in-up" style="animation-delay: 200ms">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white/50 text-sm">{{ __('Borrowed') }}</p>
                        <p class="text-2xl font-bold text-yellow-400">{{ $borrowings->where('status', 'borrowed')->count() }}</p>
                    </div>
                </div>
                <div class="glass-card p-4 flex items-center space-x-4 animate-fade-in-up" style="animation-delay: 300ms">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white/50 text-sm">{{ __('Returned') }}</p>
                        <p class="text-2xl font-bold text-emerald-400">{{ $borrowings->where('status', 'returned')->count() }}</p>
                    </div>
                </div>
                <div class="glass-card p-4 flex items-center space-x-4 animate-fade-in-up" style="animation-delay: 400ms">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white/50 text-sm">{{ __('Late!') }}</p>
                        <p class="text-2xl font-bold text-red-400">{{ $borrowings->where('status', 'borrowed')->filter(fn($b) => $b->due_date->isPast())->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="glass-card overflow-hidden animate-fade-in-up" style="animation-delay: 500ms">
                <div class="p-6 border-b border-white/10">
                    <h3 class="text-lg font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        {{ __('Borrowings') }}
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-glass">
                        <thead>
                            <tr>
                                <th>{{ __('Borrower') }}</th>
                                <th>{{ __('Book') }}</th>
                                <th>{{ __('Borrow Date') }}</th>
                                <th>{{ __('Due Date') }}</th>
                                <th>{{ __('Return Date') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($borrowings as $borrowing)
                                <tr class="group hover:bg-white/5 transition-colors">
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center text-sm font-bold">
                                                {{ substr($borrowing->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-white">{{ $borrowing->user->name }}</div>
                                                <div class="text-sm text-white/50">{{ $borrowing->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            @if($borrowing->book->cover_image)
                                                <img src="{{ asset('storage/' . $borrowing->book->cover_image) }}" 
                                                     alt="{{ $borrowing->book->title }}" 
                                                     class="h-12 w-8 object-cover rounded-lg shadow-lg">
                                            @else
                                                <div class="h-12 w-8 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-lg flex items-center justify-center">
                                                    <svg class="h-4 w-4 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <span class="font-medium">{{ Str::limit($borrowing->book->title, 25) }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $borrowing->borrowed_at->format('d M Y') }}</td>
                                    <td>
                                        <span class="{{ $borrowing->status === 'borrowed' && $borrowing->due_date->isPast() ? 'text-red-400' : 'text-white/70' }}">
                                            {{ $borrowing->due_date->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td>{{ $borrowing->returned_at ? $borrowing->returned_at->format('d M Y') : '-' }}</td>
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-12">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-2xl flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-lg font-semibold text-white/70 mb-2">{{ __('No borrowings yet') }}</h4>
                                            <p class="text-white/50">{{ __('No data available') }}</p>
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
