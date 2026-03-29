<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@hasSection('title')@yield('title') — {{ config('app.name', 'GymHub') }}@else{{ $title ?? config('app.name', 'GymHub') }}@endif</title>

        @if(isset($meta_description))
            <meta name="description" content="{{ $meta_description }}">
        @endif

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen bg-zinc-950 text-slate-100 antialiased">

        <nav class="bg-slate-900 border-b border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-8">
                        <a href="{{ route('home') }}" class="flex items-center gap-2">
                            <span class="text-xl font-bold text-white tracking-tight">Gym<span class="text-blue-400">Hub</span></span>
                        </a>
                        <div class="hidden md:flex items-center gap-6">
                            <a href="{{ route('catalog.index') }}" class="text-sm text-slate-300 hover:text-white transition-colors">{{ __('Каталог') }}</a>
                            <a href="{{ route('trainers.index') }}" class="text-sm text-slate-300 hover:text-white transition-colors">{{ __('Тренеры') }}</a>
                            <a href="{{ route('directions.index') }}" class="text-sm text-slate-300 hover:text-white transition-colors">{{ __('Направления') }}</a>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        @auth
                            @if(auth()->user()->hasRole('trainer') || auth()->user()->hasRole('admin'))
                                <a href="{{ auth()->user()->hasRole('admin') ? route('filament.admin.pages.dashboard') : route('trainer.index') }}"
                                   class="text-sm text-slate-300 hover:text-white transition-colors">
                                    {{ auth()->user()->hasRole('admin') ? __('Админка') : __('Кабинет тренера') }}
                                </a>
                            @endif
                            <a href="{{ route('account.index') }}" class="text-sm text-slate-300 hover:text-white transition-colors">{{ __('Кабинет') }}</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-slate-400 hover:text-white transition-colors">{{ __('Выйти') }}</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-slate-300 hover:text-white transition-colors">{{ __('Войти') }}</a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-blue-900 hover:bg-blue-800 text-white text-sm font-medium rounded-lg transition-colors">{{ __('Регистрация') }}</a>
                        @endauth

                        <livewire:cart.cart-sidebar />
                    </div>
                </div>
            </div>
        </nav>

        <main>
            @hasSection('content')
                @yield('content')
            @else
                {{ $slot }}
            @endif
        </main>

        <footer class="bg-slate-900 border-t border-slate-800 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <span class="text-xl font-bold text-white">Gym<span class="text-blue-400">Hub</span></span>
                        <p class="mt-3 text-sm text-slate-400">{{ __('Ваш спортивный зал — программы, тренеры, результаты.') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider">{{ __('Каталог') }}</h3>
                        <ul class="mt-4 space-y-2">
                            <li><a href="{{ route('catalog.programs') }}" class="text-sm text-slate-400 hover:text-white transition-colors">{{ __('Программы тренировок') }}</a></li>
                            <li><a href="{{ route('catalog.nutrition') }}" class="text-sm text-slate-400 hover:text-white transition-colors">{{ __('Спортивное питание') }}</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider">{{ __('Зал') }}</h3>
                        <ul class="mt-4 space-y-2">
                            <li><a href="{{ route('trainers.index') }}" class="text-sm text-slate-400 hover:text-white transition-colors">{{ __('Тренеры') }}</a></li>
                            <li><a href="{{ route('directions.index') }}" class="text-sm text-slate-400 hover:text-white transition-colors">{{ __('Направления') }}</a></li>
                            <li><a href="{{ route('about') }}" class="text-sm text-slate-400 hover:text-white transition-colors">{{ __('О нас') }}</a></li>
                            <li><a href="{{ route('contacts') }}" class="text-sm text-slate-400 hover:text-white transition-colors">{{ __('Контакты') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-slate-800 text-center text-sm text-slate-500">
                    &copy; {{ date('Y') }} GymHub. {{ __('Все права защищены.') }}
                </div>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>
