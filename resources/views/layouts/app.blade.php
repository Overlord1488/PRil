<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@hasSection('title')@yield('title') — {{ config('app.name', 'Sport Division') }}@else{{ $title ?? config('app.name', 'Sport Division') }}@endif</title>

        @if(isset($meta_description))
            <meta name="description" content="{{ $meta_description }}">
        @endif

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen bg-zinc-950 text-slate-100 antialiased font-sans flex flex-col">

        <livewire:layout.navigation />

        <main class="flex-1">
            @hasSection('content')
                @yield('content')
            @else
                {{ $slot }}
            @endif
        </main>

        <footer class="bg-slate-900 border-t border-slate-800 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

                {{-- Mobile --}}
                <div class="md:hidden text-center">
                    <div class="flex items-center justify-center gap-2.5 mb-2">
                        <svg width="20" height="20" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="1" y="11" width="5" height="10" rx="2" fill="#60a5fa"/>
                            <rect x="6" y="13" width="2.5" height="6" rx="1" fill="#60a5fa"/>
                            <rect x="8.5" y="14.5" width="15" height="3" rx="1.5" fill="#93c5fd"/>
                            <rect x="23.5" y="13" width="2.5" height="6" rx="1" fill="#60a5fa"/>
                            <rect x="26" y="11" width="5" height="10" rx="2" fill="#60a5fa"/>
                        </svg>
                        <span class="text-sm font-bold text-white tracking-tight">SPORT<span class="text-blue-400"> DIVISION</span></span>
                    </div>
                    <p class="text-xs text-slate-500 mb-6">Тренеры, программы, результаты</p>

                    <div class="grid grid-cols-2 gap-x-8 gap-y-1 text-sm border-t border-slate-800 pt-6">
                        <div class="text-left">
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Каталог</p>
                            <ul class="space-y-3">
                                <li><a href="{{ route('catalog.programs') }}" class="text-slate-300 hover:text-white transition-colors">Программы</a></li>
                                <li><a href="{{ route('catalog.nutrition') }}" class="text-slate-300 hover:text-white transition-colors">Питание</a></li>
                            </ul>
                        </div>
                        <div class="text-left">
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Клуб</p>
                            <ul class="space-y-3">
                                <li><a href="{{ route('trainers.index') }}" class="text-slate-300 hover:text-white transition-colors">Тренеры</a></li>
                                <li><a href="{{ route('directions.index') }}" class="text-slate-300 hover:text-white transition-colors">Направления</a></li>
                                <li><a href="{{ route('about') }}" class="text-slate-300 hover:text-white transition-colors">О нас</a></li>
                                <li><a href="{{ route('contacts') }}" class="text-slate-300 hover:text-white transition-colors">Контакты</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Desktop: 3-col --}}
                <div class="hidden md:grid md:grid-cols-3 gap-8">
                    <div>
                        <div class="flex items-center gap-2.5 mb-3">
                            <svg width="24" height="24" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="1" y="11" width="5" height="10" rx="2" fill="#60a5fa"/>
                                <rect x="6" y="13" width="2.5" height="6" rx="1" fill="#60a5fa"/>
                                <rect x="8.5" y="14.5" width="15" height="3" rx="1.5" fill="#93c5fd"/>
                                <rect x="23.5" y="13" width="2.5" height="6" rx="1" fill="#60a5fa"/>
                                <rect x="26" y="11" width="5" height="10" rx="2" fill="#60a5fa"/>
                            </svg>
                            <span class="text-base font-bold text-white tracking-tight">SPORT<span class="text-blue-400"> DIVISION</span></span>
                        </div>
                        <p class="text-sm text-slate-400">Ваш спортивный клуб — тренеры, программы, результаты.</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider">Каталог</h3>
                        <ul class="mt-4 space-y-2">
                            <li><a href="{{ route('catalog.programs') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Программы тренировок</a></li>
                            <li><a href="{{ route('catalog.nutrition') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Спортивное питание</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider">Клуб</h3>
                        <ul class="mt-4 space-y-2">
                            <li><a href="{{ route('trainers.index') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Тренеры</a></li>
                            <li><a href="{{ route('directions.index') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Направления</a></li>
                            <li><a href="{{ route('about') }}" class="text-sm text-slate-400 hover:text-white transition-colors">О нас</a></li>
                            <li><a href="{{ route('contacts') }}" class="text-sm text-slate-400 hover:text-white transition-colors">Контакты</a></li>
                        </ul>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-800 text-center text-xs text-slate-500">
                    &copy; {{ date('Y') }} Sport Division. Все права защищены.
                </div>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>
