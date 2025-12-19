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
      x-data="{ sidebarOpen: false, darkMode: localStorage.getItem('theme') !== 'light' }" 
      :class="{ 'light': !darkMode }"
      x-init="if(localStorage.getItem('theme') === 'light') { document.body.classList.add('light') }"
      @theme-changed.window="darkMode = localStorage.getItem('theme') !== 'light'">
    <!-- Background Effects -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none transition-all duration-500">
        <!-- Dark mode background -->
        <div class="absolute inset-0 bg-mesh opacity-50 transition-opacity duration-500" :class="{ 'opacity-20': !darkMode }"></div>
        <div class="absolute top-0 right-0 w-96 h-96 rounded-full blur-3xl transition-all duration-500" :class="darkMode ? 'bg-purple-600/20' : 'bg-purple-400/10'"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 rounded-full blur-3xl transition-all duration-500" :class="darkMode ? 'bg-indigo-600/20' : 'bg-indigo-400/10'"></div>
    </div>

    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="pt-20">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="glass-card p-6 animate-fade-in-down">
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="animate-fade-in">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="mt-auto border-t border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row justify-between items-center text-white/40 text-sm">
                    <p>&copy; {{ date('Y') }} Perpustakaan Digital. All rights reserved.</p>
                    <p class="mt-2 md:mt-0">Made with <span class="text-red-500 animate-heartbeat inline-block">❤</span> in Indonesia</p>
                </div>
            </div>
        </footer>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>
