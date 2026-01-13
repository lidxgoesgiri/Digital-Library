<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Digital Library') }} - {{ __('Explore the World of Knowledge') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.add('light');
        }
    </script>
</head>
<body class="overflow-x-hidden transition-colors duration-300"
      x-data="{
          mobileMenu: false,
          darkMode: localStorage.getItem('theme') !== 'light',
          toggleTheme() {
              this.darkMode = !this.darkMode;
              localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
              document.body.classList.toggle('light', !this.darkMode);
              window.dispatchEvent(new CustomEvent('theme-changed'));
          }
      }"
      x-init="if(localStorage.getItem('theme') === 'light') { document.body.classList.add('light') }"
      :class="{ 'light': !darkMode }">

    <!-- Animated Background -->
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute inset-0 bg-mesh transition-opacity duration-500" :class="darkMode ? 'opacity-100' : 'opacity-30'"></div>
        <div class="orb orb-1 animate-blob transition-opacity duration-500" :class="darkMode ? 'opacity-30' : 'opacity-10'"></div>
        <div class="orb orb-2 animate-blob animation-delay-2000 transition-opacity duration-500" :class="darkMode ? 'opacity-30' : 'opacity-10'"></div>
        <div class="orb orb-3 animate-blob animation-delay-4000 transition-opacity duration-500" :class="darkMode ? 'opacity-30' : 'opacity-10'"></div>
        <div class="absolute inset-0 transition-opacity duration-500" :class="darkMode ? 'opacity-100' : 'opacity-50'" style="background: linear-gradient(rgba(99,102,241,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(99,102,241,0.03) 1px, transparent 1px); background-size: 100px 100px;"></div>
        <div class="absolute inset-0" id="particles">
            @for($i = 0; $i < 30; $i++)
                <div class="particle transition-colors duration-500" :class="darkMode ? 'bg-purple-500/30' : 'bg-purple-500/10'" style="
                    width: {{ rand(2, 6) }}px;
                    height: {{ rand(2, 6) }}px;
                    left: {{ rand(0, 100) }}%;
                    top: {{ rand(0, 100) }}%;
                    animation-delay: {{ rand(0, 5) }}s;
                    animation-duration: {{ rand(6, 12) }}s;
                "></div>
            @endfor
        </div>
    </div>

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-500"
         x-data="{ scrolled: false }"
         @scroll.window="scrolled = (window.pageYOffset > 50)"
         :class="scrolled ? 'glass py-2' : 'py-4'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center transform group-hover:rotate-12 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="absolute -inset-1 bg-purple-500 rounded-xl blur opacity-30 group-hover:opacity-50 transition-opacity"></div>
                    </div>
                    <span class="text-2xl font-bold text-purple-600-animated">{{ __('Digital Library') }}</span>
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <x-language-switcher />

                    <button @click="toggleTheme()"
                    class="relative w-20 h-10 rounded-full backdrop-blur-md bg-white/20 dark:bg-black/30
                    border border-white/30 shadow-lg transition-all duration-300">

    <!-- ICON BACKGROUND -->
    <div class="absolute inset-0 flex justify-between items-center px-3 text-gray-400">

        <!-- Sun -->
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>

        <!-- Moon -->
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
    </div>

    <!-- GLASS KNOB -->
    <div
        class="absolute top-1 left-1 w-8 h-8 rounded-full
               bg-white/70 backdrop-blur-xl shadow-md
               flex items-center justify-center
               transition-all duration-300"
        :class="darkMode ? 'translate-x-10 bg-yellow-400/80' : 'translate-x-0'">

        <!-- Icon inside knob -->
        <svg x-show="darkMode" x-transition class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>

        <svg x-show="!darkMode" x-transition x-cloak class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
    </div>
</button>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-primary">
                                <span class="relative z-10">{{ __('Dashboard') }}</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="nav-link">{{ __('Login') }}</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-glow">
                                    {{ __('Register Now') }}
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <div class="flex items-center space-x-2 md:hidden">
                    <x-language-switcher />

                    <button @click="toggleTheme()"
                            class="p-2 rounded-lg glass hover:bg-white/10 transition-colors"
                            :title="darkMode ? 'Light Mode' : 'Dark Mode'">
                        <svg x-show="darkMode" class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <svg x-show="!darkMode" x-cloak class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>

                    <button @click="mobileMenu = !mobileMenu" class="p-2 rounded-lg glass">
                        <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="mobileMenu"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-cloak
             class="md:hidden glass mt-2 mx-4 rounded-2xl p-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="block py-3 px-4 rounded-xl hover:bg-white/10 transition">{{ __('Dashboard') }}</a>
                @else
                    <a href="{{ route('login') }}" class="block py-3 px-4 rounded-xl hover:bg-white/10 transition">{{ __('Login') }}</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block py-3 px-4 mt-2 bg-purple-600 rounded-xl text-center">{{ __('Register Now') }}</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <div class="inline-flex items-center space-x-2 glass-card px-4 py-2 rounded-full mb-8 animate-fade-in-down">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                    <span class="text-sm text-white/70">{{ __('Best Digital Library Platform') }}</span>
                </div>

                <h1 class="text-5xl md:text-7xl lg:text-8xl font-black mb-6 leading-tight">
                    <span class="block animate-fade-in-up">{{ __('Explore the World of') }}</span>
                    <span class="block text-purple-600-animated animate-fade-in-up animate-delay-200">{{ __('Knowledge') }}</span>
                    <span class="block text-3xl md:text-4xl lg:text-5xl font-medium text-white/60 mt-4 animate-fade-in-up animate-delay-400">{{ __('Without Limits') }}</span>
                </h1>

                <p class="max-w-2xl mx-auto text-lg md:text-xl text-white/60 mb-12 animate-fade-in-up animate-delay-500">
                    {{ __('Access thousands of digital book collections, borrow easily, and enjoy an amazing reading experience.') }}
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in-up animate-delay-700">
                    @guest
                        <a href="{{ route('register') }}" class="btn-glow group">
                            <span class="flex items-center justify-center">
                                {{ __('Start Free') }}
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </span>
                        </a>
                        <a href="{{ route('login') }}" class="btn-secondary">
                            {{ __('Already Have an Account') }}
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn-glow group">
                            <span class="flex items-center justify-center">
                                {{ __('Go to Dashboard') }}
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </span>
                        </a>
                    @endguest
                </div>

                <div class="grid grid-cols-3 gap-8 max-w-3xl mx-auto mt-20 animate-fade-in-up animate-delay-1000">
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold text-purple-600" x-data="{ count: 0 }" x-init="
                            let target = 1000;
                            let interval = setInterval(() => {
                                if (count < target) count += Math.ceil(target / 50);
                                if (count >= target) { count = target; clearInterval(interval); }
                            }, 30)
                        " x-text="count + '+'">0+</div>
                        <div class="text-white/50 mt-2">{{ __('Book Collection') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold text-purple-600" x-data="{ count: 0 }" x-init="
                            let target = 500;
                            let interval = setInterval(() => {
                                if (count < target) count += Math.ceil(target / 50);
                                if (count >= target) { count = target; clearInterval(interval); }
                            }, 30)
                        " x-text="count + '+'">0+</div>
                        <div class="text-white/50 mt-2">{{ __('Active Members') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl md:text-5xl font-bold text-purple-600" x-data="{ count: 0 }" x-init="
                            let target = 50;
                            let interval = setInterval(() => {
                                if (count < target) count += 1;
                                if (count >= target) { count = target; clearInterval(interval); }
                            }, 50)
                        " x-text="count + '+'">0+</div>
                        <div class="text-white/50 mt-2">{{ __('Categories') }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
            <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center pt-2">
                <div class="w-1.5 h-3 bg-white/50 rounded-full animate-pulse"></div>
            </div>
        </div> --}}
    </section>

    <!-- Features Section -->
    <section class="relative py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    {{ __('Featured Features') }}
                </h2>
                <p class="text-white/60 max-w-2xl mx-auto text-lg">
                    {{ __('Enjoy various advanced features that make your reading experience easier') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="glass-card p-8 card-hover group" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                    <div class="relative mb-6">
                        <div class="w-16 h-16 bg-purple-600 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="absolute -inset-2 bg-purple-500 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 group-hover:text-purple-600 transition-all duration-300">{{ __('Complete Collection') }}</h3>
                    <p class="text-white/60">{{ __('Thousands of books from various categories are available for you to access anytime and anywhere.') }}</p>
                </div>

                <div class="glass-card p-8 card-hover group">
                    <div class="relative mb-6">
                        <div class="w-16 h-16 bg-pink-600 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="absolute -inset-2 bg-pink-500 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 group-hover:text-purple-600 transition-all duration-300">{{ __('Fast Borrowing') }}</h3>
                    <p class="text-white/60">{{ __('Super fast borrowing process with just one click. No queuing, no hassle.') }}</p>
                </div>

                <div class="glass-card p-8 card-hover group">
                    <div class="relative mb-6">
                        <div class="w-16 h-16 bg-emerald-600 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div class="absolute -inset-2 bg-emerald-500 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 group-hover:text-purple-600 transition-all duration-300">{{ __('Safe & Trusted') }}</h3>
                    <p class="text-white/60">{{ __('Your data is protected with high-level security system. Privacy guaranteed.') }}</p>
                </div>

                <div class="glass-card p-8 card-hover group">
                    <div class="relative mb-6">
                        <div class="w-16 h-16 bg-orange-600 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <div class="absolute -inset-2 bg-orange-500 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 group-hover:text-purple-600 transition-all duration-300">{{ __('Smart Search') }}</h3>
                    <p class="text-white/60">{{ __("Find the book you're looking for with smart search feature and category filters.") }}</p>
                </div>

                <div class="glass-card p-8 card-hover group">
                    <div class="relative mb-6">
                        <div class="w-16 h-16 bg-cyan-600 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="absolute -inset-2 bg-cyan-500 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 group-hover:text-purple-600 transition-all duration-300">{{ __('Complete History') }}</h3>
                    <p class="text-white/60">{{ __('Track all your borrowing activities with neatly stored history.') }}</p>
                </div>

                <div class="glass-card p-8 card-hover group">
                    <div class="relative mb-6">
                        <div class="w-16 h-16 bg-violet-600 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 group-hover:scale-110 transition-all duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="absolute -inset-2 bg-violet-500 rounded-2xl blur-xl opacity-0 group-hover:opacity-30 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-xl font-bold mb-3 group-hover:text-purple-600 transition-all duration-300">{{ __('Responsive Design') }}</h3>
                    <p class="text-white/60">{{ __('Access the library from any device with always optimal display.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="relative py-32">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-card p-12 md:p-16 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-purple-500/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl"></div>

                <div class="relative z-10">
                    <h2 class="text-3xl md:text-5xl font-bold mb-6">
                        {{ __('Ready to Start an') }} <span class="text-purple-600">{{ __('Adventure?') }}</span>
                    </h2>
                    <p class="text-white/60 text-lg mb-10 max-w-2xl mx-auto">
                        {{ __('Join thousands of other readers and explore the world of limitless knowledge.') }}
                    </p>
                    @guest
                        <a href="{{ route('register') }}" class="btn-glow text-lg px-10 py-4 inline-flex items-center group">
                            {{ __('Register Free Now') }}
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="relative border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="md:col-span-2">
                    <a href="/" class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-purple-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold">{{ __('Digital Library') }}</span>
                    </a>
                    <p class="text-white/50 mb-6 max-w-md">
                        {{ __('The best digital library platform to explore the world of limitless knowledge. Read, borrow, and expand your knowledge.') }}
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 glass rounded-lg flex items-center justify-center hover:bg-white/10 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 glass rounded-lg flex items-center justify-center hover:bg-white/10 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 glass rounded-lg flex items-center justify-center hover:bg-white/10 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold mb-4 text-white">{{ __('Menu') }}</h4>
                    <ul class="space-y-3">
                        <li><a href="/" class="text-white/50 hover:text-white transition-colors">{{ __('Home') }}</a></li>
                        <li><a href="{{ route('login') }}" class="text-white/50 hover:text-white transition-colors">{{ __('Login') }}</a></li>
                        <li><a href="{{ route('register') }}" class="text-white/50 hover:text-white transition-colors">{{ __('Register Now') }}</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4 text-white">{{ __('Contact') }}</h4>
                    <ul class="space-y-3 text-white/50">
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span>info@perpusdigital.com</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Indonesia</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-white/40 text-sm">
                    &copy; {{ date('Y') }} {{ __('Digital Library') }}. {{ __('All rights reserved') }}.
                </p>
                <p class="text-white/40 text-sm mt-4 md:mt-0">
                    {{ __('Made with') }} <span class="text-red-500 animate-heartbeat inline-block">❤</span> {{ __('in Indonesia') }}
                </p>
            </div>
        </div>
    </footer>

    <button
        x-data="{ show: false }"
        @scroll.window="show = (window.pageYOffset > 500)"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-8 right-8 w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center shadow-lg shadow-purple-500/30 hover:shadow-xl hover:shadow-purple-500/50 transition-all duration-300 hover:-translate-y-1 z-50"
    >
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>
