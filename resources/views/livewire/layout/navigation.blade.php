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
            <div class="flex items-center gap-3">
                @auth
                    @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('filament.admin.pages.dashboard') }}"
                       class="hidden sm:block text-sm text-slate-300 hover:text-white transition-colors">Админка</a>
                    @elseif(auth()->user()->hasRole('trainer'))
                    <a href="{{ route('trainer.index') }}"
                       class="hidden sm:block text-sm text-slate-300 hover:text-white transition-colors">Кабинет тренера</a>
                    @endif

                    {{-- Cart --}}
                    <livewire:cart.cart-sidebar />

                    {{-- User dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center gap-2 text-sm text-slate-300 hover:text-white transition-colors">
                            <div class="w-8 h-8 rounded-full bg-blue-900 flex items-center justify-center text-xs font-bold text-white">
                                {{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <a href="{{ auth()->user()->hasRole('admin') ? route('filament.admin.pages.dashboard') : (auth()->user()->hasRole('trainer') ? route('trainer.index') : route('account.index')) }}" wire:navigate
                               class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-slate-700 rounded-t-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ auth()->user()->hasRole('admin') ? 'Админ-панель' : (auth()->user()->hasRole('trainer') ? 'Кабинет тренера' : 'Личный кабинет') }}
                            </a>
                            @if(!auth()->user()->hasRole('admin'))
                            <a href="{{ route('account.profile.edit') }}" wire:navigate
                               class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-slate-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Настройки
                            </a>
                            @endif
                            <div class="border-t border-slate-700 my-1"></div>
                            <button wire:click="logout"
                                    class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-slate-400 hover:text-red-400 hover:bg-slate-700 rounded-b-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Выйти
                            </button>
                        </div>
                    </div>
                @else
                    {{-- Cart for guests --}}
                    <livewire:cart.cart-sidebar />

                    <a href="{{ route('login') }}" wire:navigate
                       class="text-sm text-slate-300 hover:text-white transition-colors">Войти</a>
                    <a href="{{ route('register') }}" wire:navigate
                       class="inline-flex items-center px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white text-sm font-semibold rounded-xl transition-colors">
                        Регистрация
                    </a>
                @endauth

                {{-- Mobile menu button --}}
                <button @click="open = !open" class="md:hidden text-slate-400 hover:text-white ml-1">
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
            @auth
            <a href="{{ auth()->user()->hasRole('admin') ? route('filament.admin.pages.dashboard') : (auth()->user()->hasRole('trainer') ? route('trainer.index') : route('account.index')) }}" wire:navigate class="block py-2 text-sm text-slate-300 hover:text-white">
                {{ auth()->user()->hasRole('admin') ? 'Админ-панель' : (auth()->user()->hasRole('trainer') ? 'Кабинет тренера' : 'Личный кабинет') }}
            </a>
            @else
            <a href="{{ route('login') }}" wire:navigate class="block py-2 text-sm text-slate-300 hover:text-white">Войти</a>
            <a href="{{ route('register') }}" wire:navigate class="block py-2 text-sm text-slate-300 hover:text-white">Регистрация</a>
            @endauth
        </div>
    </div>
</nav>
