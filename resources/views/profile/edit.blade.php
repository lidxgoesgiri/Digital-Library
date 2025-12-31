<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-purple-600">{{ __('My Profile') }}</h2>
                <p class="text-white/50 mt-1">{{ __("Update your account's profile information and email address") }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="glass-card overflow-hidden animate-fade-in-up" style="animation-delay: 100ms">
                <div class="p-6 border-b border-white/10">
                    <h3 class="text-lg font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ __('Profile Information') }}
                    </h3>
                    <p class="text-white/50 text-sm mt-1">{{ __("Update your account's profile information and email address") }}</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="glass-card overflow-hidden animate-fade-in-up" style="animation-delay: 200ms">
                <div class="p-6 border-b border-white/10">
                    <h3 class="text-lg font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        {{ __('Update Password') }}
                    </h3>
                    <p class="text-white/50 text-sm mt-1">{{ __('Ensure your account is using a long, random password to stay secure') }}</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="glass-card overflow-hidden animate-fade-in-up border border-red-500/20" style="animation-delay: 300ms">
                <div class="p-6 border-b border-white/10">
                    <h3 class="text-lg font-semibold flex items-center text-red-400">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        {{ __('Delete Account') }}
                    </h3>
                    <p class="text-white/50 text-sm mt-1">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted') }}</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
