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
                <a href="{{ route('home') }}" class="text-xl font-bold text-white tracking-tight">
                    Gym<span class="text-blue-400">Hub</span>
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
