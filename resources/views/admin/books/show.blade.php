<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold gradient-text">Detail Buku</h2>
                <p class="text-white/50 mt-1">Informasi lengkap dan riwayat peminjaman</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.books.edit', $book) }}" class="btn-primary">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </span>
                </a>
                <a href="{{ route('admin.books.index') }}" class="btn-secondary">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Book Detail Card -->
            <div class="glass-card overflow-hidden animate-fade-in-up mb-8">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Cover Image -->
                        <div class="flex-shrink-0">
                            <div class="relative group">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                         alt="{{ $book->title }}" 
                                         class="h-72 w-52 object-cover rounded-2xl shadow-2xl shadow-purple-500/20">
                                @else
                                    <div class="h-72 w-52 bg-gradient-to-br from-indigo-500/30 to-purple-500/30 rounded-2xl flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Book Info -->
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-white mb-2">{{ $book->title }}</h1>
                            <p class="text-xl text-white/60 mb-6">oleh {{ $book->author }}</p>

                            <!-- Details Grid -->
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="glass p-4 rounded-xl">
                                    <p class="text-white/50 text-sm mb-1">ISBN</p>
                                    <p class="font-semibold">{{ $book->isbn ?? '-' }}</p>
                                </div>
                                <div class="glass p-4 rounded-xl">
                                    <p class="text-white/50 text-sm mb-1">Kategori</p>
                                    <p class="font-semibold">{{ $book->category ?? '-' }}</p>
                                </div>
                                <div class="glass p-4 rounded-xl">
                                    <p class="text-white/50 text-sm mb-1">Tahun Terbit</p>
                                    <p class="font-semibold">{{ $book->published_year ?? '-' }}</p>
                                </div>
                                <div class="glass p-4 rounded-xl">
                                    <p class="text-white/50 text-sm mb-1">Stok</p>
                                    <p class="font-semibold">{{ $book->stock }} <span class="text-white/50">(Tersedia: <span class="{{ $book->availableStock() > 0 ? 'text-emerald-400' : 'text-red-400' }}">{{ $book->availableStock() }}</span>)</span></p>
                                </div>
                            </div>

                            @if($book->description)
                                <div>
                                    <p class="text-white/50 text-sm mb-2">Deskripsi</p>
                                    <p class="text-white/80 leading-relaxed">{{ $book->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Borrowing History -->
            <div class="glass-card overflow-hidden animate-fade-in-up" style="animation-delay: 200ms">
                <div class="p-6 border-b border-white/10">
                    <h3 class="text-lg font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Riwayat Peminjaman
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-glass">
                        <thead>
                            <tr>
                                <th>Peminjam</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Dikembalikan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($borrowings as $borrowing)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center text-sm font-bold">
                                                {{ substr($borrowing->user->name, 0, 1) }}
                                            </div>
                                            <span>{{ $borrowing->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $borrowing->borrowed_at->format('d M Y') }}</td>
                                    <td>{{ $borrowing->due_date->format('d M Y') }}</td>
                                    <td>{{ $borrowing->returned_at ? $borrowing->returned_at->format('d M Y') : '-' }}</td>
                                    <td>
                                        @if($borrowing->status === 'borrowed')
                                            <span class="badge badge-warning">Dipinjam</span>
                                        @else
                                            <span class="badge badge-success">Dikembalikan</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-white/20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            <span class="text-white/50">Belum ada riwayat peminjaman</span>
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
