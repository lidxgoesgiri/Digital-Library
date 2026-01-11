<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-purple-600">{{ __('Manage Books') }}</h2>
                <p class="text-white/50 mt-1">{{ __('Manage library book collection') }}</p>
            </div>
            <a href="{{ route('admin.books.create') }}" class="btn-glow">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('Add Book') }}
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

            <div class="glass-card overflow-hidden animate-fade-in-up">
                <div class="p-6 border-b border-white/10">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            {{ __('Book List') }}
                        </h3>
                        <span class="text-white/50 text-sm">Total: {{ $books->total() }} {{ __('books') }}</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-glass">
                        <thead>
                            <tr>
                                <th>{{ __('Cover Image') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Author') }}</th>
                                <th>{{ __('Category') }}</th>
                                <th>{{ __('Stock') }}</th>
                                <th>{{ __('Available') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $book)
                                <tr class="group hover:bg-white/5 transition-colors">
                                    <td>
                                        @if($book->cover_image)
                                            <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                                 alt="{{ $book->title }}" 
                                                 class="h-16 w-12 object-cover rounded-lg shadow-lg group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="h-16 w-12 bg-slate-700/50 rounded-lg flex items-center justify-center">
                                                <svg class="h-6 w-6 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="font-medium text-white group-hover:text-purple-600 transition-all">{{ Str::limit($book->title, 30) }}</span>
                                    </td>
                                    <td>{{ $book->author }}</td>
                                    <td>
                                        @if($book->category)
                                            <span class="px-2 py-1 bg-white/5 rounded-lg text-white/60 text-sm">{{ $book->category }}</span>
                                        @else
                                            <span class="text-white/30">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="font-semibold">{{ $book->stock }}</span>
                                    </td>
                                    <td>
                                        @if($book->availableStock() > 0)
                                            <span class="badge badge-success">{{ $book->availableStock() }}</span>
                                        @else
                                            <span class="badge badge-danger">0</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.books.show', $book) }}" 
                                               class="p-2 bg-indigo-500/20 text-indigo-400 rounded-lg hover:bg-indigo-500/30 transition-colors"
                                               title="{{ __('Book Detail') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.books.edit', $book) }}" 
                                               class="p-2 bg-yellow-500/20 text-yellow-400 rounded-lg hover:bg-yellow-500/30 transition-colors"
                                               title="{{ __('Edit') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline" 
                                                  onsubmit="return confirm('{{ __('Are you sure you want to delete this book?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-colors"
                                                        title="{{ __('Delete') }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 bg-slate-700/50 rounded-2xl flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-lg font-semibold text-white/70 mb-2">{{ __('No books found') }}</h4>
                                            <p class="text-white/50 mb-4">{{ __('Manage library book collection') }}</p>
                                            <a href="{{ route('admin.books.create') }}" class="btn-primary">
                                                <span class="flex items-center">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                    {{ __('Add Book') }}
                                                </span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($books->hasPages())
                    <div class="p-6 border-t border-white/10">
                        {{ $books->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
