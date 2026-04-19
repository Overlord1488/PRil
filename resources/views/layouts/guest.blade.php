<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'GymHub') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen bg-zinc-950 text-slate-100 antialiased font-sans">

        <nav class="bg-slate-900 border-b border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <svg width="28" height="28" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="1" y="11" width="5" height="10" rx="2" fill="#60a5fa"/>
                        <rect x="6" y="13" width="2.5" height="6" rx="1" fill="#60a5fa"/>
                        <rect x="8.5" y="14.5" width="15" height="3" rx="1.5" fill="#93c5fd"/>
                        <rect x="23.5" y="13" width="2.5" height="6" rx="1" fill="#60a5fa"/>
                        <rect x="26" y="11" width="5" height="10" rx="2" fill="#60a5fa"/>
                    </svg>
                    <span class="text-base font-bold text-white tracking-tight">SPORT<span class="text-blue-400"> DIVISION</span></span>
                </a>
            </div>
        </nav>

        <div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </div>

        @livewireScripts
    </body>
</html>
