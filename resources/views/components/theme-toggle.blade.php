<button 
    x-data="{ 
        darkMode: localStorage.getItem('theme') !== 'light',
        toggle() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
            document.body.classList.toggle('light', !this.darkMode);
            window.dispatchEvent(new CustomEvent('theme-changed'));
        }
    }"
    x-init="document.body.classList.toggle('light', !darkMode)"
    @click="toggle()"
    class="relative p-2 rounded-xl glass hover:scale-110 transition-all duration-300 group"
    :title="darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
>
    <!-- Sun Icon (Light Mode) -->
    <svg 
        x-show="darkMode" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 rotate-90 scale-0"
        x-transition:enter-end="opacity-100 rotate-0 scale-100"
        class="w-5 h-5 text-yellow-400" 
        fill="none" 
        stroke="currentColor" 
        viewBox="0 0 24 24"
    >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
    </svg>
    
    <!-- Moon Icon (Dark Mode) -->
    <svg 
        x-show="!darkMode" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -rotate-90 scale-0"
        x-transition:enter-end="opacity-100 rotate-0 scale-100"
        class="w-5 h-5 text-indigo-400" 
        fill="none" 
        stroke="currentColor" 
        viewBox="0 0 24 24"
    >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
    </svg>

    <!-- Glow effect -->
    <div class="absolute inset-0 rounded-xl bg-yellow-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-show="darkMode"></div>
    <div class="absolute inset-0 rounded-xl bg-purple-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300" x-show="!darkMode"></div>
</button>
