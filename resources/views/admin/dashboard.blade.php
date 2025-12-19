<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold gradient-text">{{ __('Admin Dashboard') }}</h2>
                <p class="text-white/50 mt-1">{{ __('Welcome back') }}, {{ auth()->user()->name }}!</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="badge badge-info">
                    <svg class="w-3 h-3 mr-1 inline" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3"/></svg>
                    {{ __('Administrator') }}
                </span>
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="stat-card group animate-fade-in-up" style="animation-delay: 100ms">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/50 text-sm font-medium">{{ __('Total Books') }}</p>
                            <p class="text-4xl font-bold gradient-text mt-2">{{ $totalBooks }}</p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-emerald-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            {{ __('Collection') }}
                        </span>
                        <span class="text-white/30 ml-2">{{ __('library') }}</span>
                    </div>
                </div>

                <div class="stat-card group animate-fade-in-up" style="animation-delay: 200ms">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/50 text-sm font-medium">{{ __('Being Borrowed') }}</p>
                            <p class="text-4xl font-bold text-yellow-400 mt-2">{{ $totalBorrowings }}</p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-yellow-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                            </svg>
                            {{ __('Active') }}
                        </span>
                        <span class="text-white/30 ml-2">{{ __('borrowings') }}</span>
                    </div>
                </div>

                <div class="stat-card group animate-fade-in-up" style="animation-delay: 300ms">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white/50 text-sm font-medium">{{ __('Returned') }}</p>
                            <p class="text-4xl font-bold text-emerald-400 mt-2">{{ $totalReturned }}</p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-emerald-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ __('Completed') }}
                        </span>
                        <span class="text-white/30 ml-2">{{ __('returned') }}</span>
                    </div>
                </div>
            </div>

            <div class="glass-card overflow-hidden animate-fade-in-up" style="animation-delay: 400ms">
                <div class="p-6 border-b border-white/10">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            {{ __('Recent Borrowings') }}
                        </h3>
                        <a href="{{ route('admin.borrowings.index') }}" class="text-sm text-purple-400 hover:text-purple-300 transition-colors flex items-center">
                            {{ __('View All') }}
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-glass">
                        <thead>
                            <tr>
                                <th>{{ __('Borrower') }}</th>
                                <th>{{ __('Book') }}</th>
                                <th>{{ __('Borrow Date') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBorrowings as $borrowing)
                                <tr class="group">
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center text-sm font-bold">
                                                {{ substr($borrowing->user->name, 0, 1) }}
                                            </div>
                                            <span>{{ $borrowing->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="font-medium">{{ Str::limit($borrowing->book->title, 30) }}</span>
                                    </td>
                                    <td>{{ $borrowing->borrowed_at->format('d M Y') }}</td>
                                    <td>
                                        @if($borrowing->status === 'borrowed')
                                            <span class="badge badge-warning">{{ __('Borrowed') }}</span>
                                        @else
                                            <span class="badge badge-success">{{ __('Returned') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-8">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-white/20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            <span class="text-white/50">{{ __('No borrowings yet') }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
