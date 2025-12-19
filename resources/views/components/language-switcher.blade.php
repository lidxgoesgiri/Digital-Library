<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" 
            class="relative p-2 rounded-xl glass hover:scale-110 transition-all duration-300 group flex items-center space-x-1"
            title="{{ __('Switch Language') }}">
        <span class="text-sm font-medium">{{ strtoupper(app()->getLocale()) }}</span>
        <svg class="w-3 h-3 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         x-cloak
         class="absolute right-0 mt-2 w-36 glass-card rounded-xl overflow-hidden z-50">
        <a href="{{ route('language.switch', 'id') }}" 
           class="flex items-center space-x-3 px-4 py-3 hover:bg-white/10 transition-colors {{ app()->getLocale() == 'id' ? 'bg-purple-500/20 text-purple-400' : '' }}">
            <span class="text-lg">🇮🇩</span>
            <span class="text-sm font-medium">Indonesia</span>
            @if(app()->getLocale() == 'id')
                <svg class="w-4 h-4 ml-auto text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            @endif
        </a>
        <a href="{{ route('language.switch', 'en') }}" 
           class="flex items-center space-x-3 px-4 py-3 hover:bg-white/10 transition-colors {{ app()->getLocale() == 'en' ? 'bg-purple-500/20 text-purple-400' : '' }}">
            <span class="text-lg">🇺🇸</span>
            <span class="text-sm font-medium">English</span>
            @if(app()->getLocale() == 'en')
                <svg class="w-4 h-4 ml-auto text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            @endif
        </a>
    </div>
</div>
