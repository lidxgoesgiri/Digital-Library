<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Perpustakaan Digital') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.add('light');
        }
    </script>
</head>
<body class="antialiased transition-colors duration-300"
      x-data="{ darkMode: localStorage.getItem('theme') !== 'light' }"
      x-init="if(localStorage.getItem('theme') === 'light') { document.body.classList.add('light') }"
      :class="{ 'light': !darkMode }"
      @theme-changed.window="darkMode = localStorage.getItem('theme') !== 'light'">
    <!-- Background -->
    <div class="fixed inset-0 -z-10 transition-all duration-500" :class="darkMode ? 'bg-slate-900' : 'bg-slate-50'"></div>

    <!-- Language & Theme Toggle - Fixed Position -->
    <div class="fixed top-4 right-4 z-50 flex items-center space-x-2">
        <x-language-switcher />
        <x-theme-toggle />
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Logo -->
        <a href="/" class="flex items-center space-x-3 group mb-8 animate-fade-in-down">
            <div class="w-14 h-14 bg-purple-600 rounded-2xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <span class="text-2xl font-bold text-purple-600">Perpustakaan Digital</span>
        </a>

        <!-- Card -->
        <div class="w-full sm:max-w-md px-6 py-8 glass-card rounded-2xl animate-fade-in-up">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <p class="mt-8 text-slate-500 text-sm animate-fade-in">
            &copy; {{ date('Y') }} Perpustakaan Digital. All rights reserved.
        </p>
    </div>
</body>
</html>
