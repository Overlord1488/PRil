<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<nav class="bg-slate-900 border-b border-slate-800" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo + main links --}}
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2.5">
                    <svg width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="1" y="11" width="5" height="10" rx="2" fill="#60a5fa"/>
                        <rect x="6" y="13" width="2.5" height="6" rx="1" fill="#60a5fa"/>
                        <rect x="8.5" y="14.5" width="15" height="3" rx="1.5" fill="#93c5fd"/>
                        <rect x="23.5" y="13" width="2.5" height="6" rx="1" fill="#60a5fa"/>
                        <rect x="26" y="11" width="5" height="10" rx="2" fill="#60a5fa"/>
                    </svg>
                    <span class="text-sm font-bold text-white tracking-tight">SPORT<span class="text-blue-400"> DIVISION</span></span>
                </a>
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('catalog.index') }}" wire:navigate class="text-sm text-slate-300 hover:text-white transition-colors">Каталог</a>
                    <a href="{{ route('trainers.index') }}" wire:navigate class="text-sm text-slate-300 hover:text-white transition-colors">Тренеры</a>
                    <a href="{{ route('directions.index') }}" wire:navigate class="text-sm text-slate-300 hover:text-white transition-colors">Направления</a>
                </div>
            </div>

            {{-- Right side --}}
            <div class="flex items-center gap-4">
                @if(auth()->user()?->hasRole('admin'))
                <a href="{{ route('filament.admin.pages.dashboard') }}"
                   class="hidden sm:block text-sm text-slate-300 hover:text-white transition-colors">Админка</a>
                @elseif(auth()->user()?->hasRole('trainer'))
                <a href="{{ route('trainer.index') }}"
                   class="hidden sm:block text-sm text-slate-300 hover:text-white transition-colors">Кабинет тренера</a>
                @endif

                {{-- User dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-2 text-sm text-slate-300 hover:text-white transition-colors">
                        <div class="w-8 h-8 rounded-full bg-blue-900 flex items-center justify-center text-xs font-semibold text-white">
                            {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" @click.outside="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-slate-800 border border-slate-700 rounded-xl shadow-lg z-50 py-1"
                         style="display:none;">
                        <a href="{{ route('account.index') }}" wire:navigate
                           class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Личный кабинет
                        </a>
                        <a href="{{ route('account.profile.edit') }}" wire:navigate
                           class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Профиль
                        </a>
                        <div class="border-t border-slate-700 my-1"></div>
                        <button wire:click="logout"
                                class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-slate-400 hover:text-red-400 hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Выйти
                        </button>
                    </div>
                </div>

                {{-- Mobile menu button --}}
                <button @click="open = !open" class="md:hidden text-slate-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden md:hidden border-t border-slate-800">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('catalog.index') }}" wire:navigate class="block py-2 text-sm text-slate-300 hover:text-white">Каталог</a>
            <a href="{{ route('trainers.index') }}" wire:navigate class="block py-2 text-sm text-slate-300 hover:text-white">Тренеры</a>
            <a href="{{ route('directions.index') }}" wire:navigate class="block py-2 text-sm text-slate-300 hover:text-white">Направления</a>
            <a href="{{ route('account.index') }}" wire:navigate class="block py-2 text-sm text-slate-300 hover:text-white">Личный кабинет</a>
        </div>
    </div>
</nav>
