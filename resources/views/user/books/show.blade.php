<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-purple-600">{{ __('Book Detail') }}</h2>
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
                                    <div class="h-80 w-56 bg-purple-600/30 rounded-2xl flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute -inset-2 bg-purple-500 rounded-2xl blur-xl opacity-20 group-hover:opacity-40 transition-opacity -z-10"></div>
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

                            @if($book->isAvailable())
                                <form action="{{ route('user.books.borrow', $book) }}" method="POST" class="w-full">
                                    @csrf
                                    <div class="mb-6">
                                        <label for="loan_duration" class="block text-sm font-medium text-white/70 mb-3">
                                            {{ __('Loan Duration') }}
                                        </label>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                            <label class="relative cursor-pointer group">
                                                <input type="radio" name="loan_duration_type" value="7" class="peer sr-only loan-duration-radio" required onclick="selectPresetDuration(7)">
                                                <div class="glass p-4 rounded-xl text-center transition-all duration-300 peer-checked:peer-checked:bg-purple-600/20 peer-checked:border-purple-500 border-2 border-transparent hover:border-purple-500/50 h-[88px] flex flex-col items-center justify-center">
                                                    <div class="text-2xl font-bold text-white mb-1">7</div>
                                                    <div class="text-sm text-white/50">{{ __('Days') }}</div>
                                                </div>
                                            </label>
                                            <label class="relative cursor-pointer group">
                                                <input type="radio" name="loan_duration_type" value="14" class="peer sr-only loan-duration-radio" checked required onclick="selectPresetDuration(14)">
                                                <div class="glass p-4 rounded-xl text-center transition-all duration-300 peer-checked:peer-checked:bg-purple-600/20 peer-checked:border-purple-500 border-2 border-transparent hover:border-purple-500/50 h-[88px] flex flex-col items-center justify-center">
                                                    <div class="text-2xl font-bold text-white mb-1">14</div>
                                                    <div class="text-sm text-white/50">{{ __('Days') }}</div>
                                                    <div class="text-xs text-purple-400 mt-1">{{ __('Default') }}</div>
                                                </div>
                                            </label>
                                            <label class="relative cursor-pointer group">
                                                <input type="radio" name="loan_duration_type" value="21" class="peer sr-only loan-duration-radio" required onclick="selectPresetDuration(21)">
                                                <div class="glass p-4 rounded-xl text-center transition-all duration-300 peer-checked:peer-checked:bg-purple-600/20 peer-checked:border-purple-500 border-2 border-transparent hover:border-purple-500/50 h-[88px] flex flex-col items-center justify-center">
                                                    <div class="text-2xl font-bold text-white mb-1">21</div>
                                                    <div class="text-sm text-white/50">{{ __('Days') }}</div>
                                                </div>
                                            </label>
                                            <label class="relative cursor-pointer group">
                                                <input type="radio" name="loan_duration_type" value="custom" class="peer sr-only loan-duration-radio" required onclick="selectCustomDuration()">
                                                <div class="glass p-4 rounded-xl text-center transition-all duration-300 peer-checked:peer-checked:bg-purple-600/20 peer-checked:border-purple-500 border-2 border-transparent hover:border-purple-500/50 h-[88px] flex flex-col items-center justify-center">
                                                    <div class="flex items-center justify-center w-8 h-8 mb-1">
                                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="text-sm text-white/50">{{ __('Custom') }}</div>
                                                </div>
                                            </label>
                                        </div>
                                        
                                        <!-- Custom Duration Input -->
                                        <div id="custom-duration-container" class="mt-4 hidden animate-fade-in-down">
                                            <label for="custom_duration" class="block text-sm font-medium text-white/70 mb-2">
                                                {{ __('Enter Number of Days') }} (1-30 {{ __('Days') }})
                                            </label>
                                            <div class="flex gap-3 items-center">
                                                <input type="number" 
                                                       id="custom_duration" 
                                                       name="custom_duration" 
                                                       min="1" 
                                                       max="30" 
                                                       class="flex-1 bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all"
                                                       placeholder="{{ __('Enter days') }}...">
                                                <div class="glass px-4 py-3 rounded-xl">
                                                    <span class="text-white/70 text-sm">{{ __('Days') }}</span>
                                                </div>
                                            </div>
                                            <p class="text-xs text-white/40 mt-2">{{ __('Minimum 1 day, Maximum 30 days') }}</p>
                                        </div>

                                        <!-- Hidden field for actual submission -->
                                        <input type="hidden" name="loan_duration" id="loan_duration" value="14">

                                        <div class="mt-3 glass p-3 rounded-lg">
                                            <p class="text-sm text-white/60 flex items-start">
                                                <svg class="w-5 h-5 mr-2 flex-shrink-0 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                                <span>{{ __('Late return will be fined Rp 1.000 per day') }}</span>
                                            </p>
                                        </div>
                                        @error('loan_duration')
                                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                        @error('custom_duration')
                                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <script>
                                        function selectPresetDuration(days) {
                                            document.getElementById('loan_duration').value = days;
                                            document.getElementById('custom-duration-container').classList.add('hidden');
                                            document.getElementById('custom_duration').value = '';
                                            document.getElementById('custom_duration').removeAttribute('required');
                                        }

                                        function selectCustomDuration() {
                                            document.getElementById('custom-duration-container').classList.remove('hidden');
                                            document.getElementById('custom_duration').setAttribute('required', 'required');
                                            document.getElementById('custom_duration').focus();
                                            
                                            // Update hidden field when user types
                                            document.getElementById('custom_duration').addEventListener('input', function() {
                                                document.getElementById('loan_duration').value = this.value;
                                            });
                                        }

                                        // Validate on form submit
                                        document.querySelector('form').addEventListener('submit', function(e) {
                                            const customRadio = document.querySelector('input[name="loan_duration_type"][value="custom"]');
                                            if (customRadio.checked) {
                                                const customValue = parseInt(document.getElementById('custom_duration').value);
                                                if (!customValue || customValue < 1 || customValue > 30) {
                                                    e.preventDefault();
                                                    alert('{{ __("Please enter a valid number of days between 1 and 30") }}');
                                                    return false;
                                                }
                                                document.getElementById('loan_duration').value = customValue;
                                            }
                                        });
                                    </script>
                                    <button type="submit" class="btn-glow w-full"
                                            onclick="return confirm('{{ __('Confirm') }}')">
                                        <span class="flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                            {{ __('Borrow This Book') }}
                                        </span>
                                    </button>
                                </form>
                            @else
                                <button disabled class="px-8 py-3 bg-white/10 rounded-xl font-semibold text-white/50 cursor-not-allowed w-full">
                                    <span class="flex items-center justify-center">
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
</x-app-layout>
