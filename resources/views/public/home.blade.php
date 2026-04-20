@extends('layouts.app')

@section('title', 'Sport Division — Ваш спортивный зал')

@section('content')

{{-- Hero --}}
<section class="relative bg-zinc-950 overflow-hidden min-h-[85vh] flex items-center">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1637430308606-86576d8fef3c?w=1600&fit=crop&q=80"
             alt="" class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-r from-zinc-950 via-zinc-950/80 to-zinc-950/40"></div>
    </div>
    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="max-w-2xl">
            <p class="text-blue-400 text-sm font-semibold uppercase tracking-widest mb-4">Спортивный клуб</p>
            <h1 class="text-5xl sm:text-6xl md:text-7xl font-extrabold text-white leading-[1.05]">
                Достигайте<br>
                <span class="text-blue-400">новых высот</span>
            </h1>
            <p class="mt-6 text-lg text-slate-300 leading-relaxed max-w-xl">
                Профессиональные тренеры, продуманные программы и онлайн-запись — всё для вашего результата в одном месте.
            </p>
            <div class="mt-10 flex flex-wrap gap-4">
                <a href="{{ route('trainers.index') }}"
                   class="inline-flex items-center gap-2 px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-semibold transition-colors text-sm">
                    Найти тренера
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="{{ route('catalog.index') }}"
                   class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 hover:bg-white/20 text-white rounded-xl font-semibold transition-colors text-sm backdrop-blur-sm">
                    В каталог
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="bg-slate-900 border-y border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <p class="text-3xl font-bold text-slate-100">{{ $trainerCount }}+</p>
                <p class="text-sm text-slate-400 mt-1">Тренеров</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-slate-100">{{ $directionCount }}+</p>
                <p class="text-sm text-slate-400 mt-1">Направлений</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-slate-100">100+</p>
                <p class="text-sm text-slate-400 mt-1">Программ</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-slate-100">24/7</p>
                <p class="text-sm text-slate-400 mt-1">Онлайн-запись</p>
            </div>
        </div>
    </div>
</section>

{{-- Directions --}}
@if($directions->isNotEmpty())
<section class="bg-zinc-950 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-slate-100">Направления тренировок</h2>
            <a href="{{ route('directions.index') }}"
               class="text-sm text-blue-400 hover:text-blue-300 transition-colors">
                Все направления →
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($directions as $dir)
            <a href="{{ route('directions.show', $dir->slug) }}"
               class="group relative overflow-hidden rounded-2xl aspect-[3/4] block">
                @if($dir->cover_path)
                <img src="{{ $dir->cover_path }}" alt="{{ $dir->name }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                <div class="w-full h-full bg-slate-800"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-3">
                    <p class="text-sm font-semibold text-white leading-tight">{{ $dir->name }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $dir->trainers_count }} тр.</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Trainers --}}
@if($trainers->isNotEmpty())
<section class="bg-slate-900/50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-slate-100">Наши тренеры</h2>
            <a href="{{ route('trainers.index') }}"
               class="text-sm text-blue-400 hover:text-blue-300 transition-colors">
                Все тренеры →
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            @foreach($trainers as $trainer)
            @include('trainers._card', ['trainer' => $trainer])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="relative overflow-hidden py-20">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1517963879433-6ad2b056d712?w=1400&fit=crop&q=80"
             alt="" class="w-full h-full object-cover opacity-20">
        <div class="absolute inset-0 bg-blue-950/60"></div>
    </div>
    <div class="relative max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Готовы начать?</h2>
        <p class="text-slate-300 mb-8">Запишитесь на тренировку онлайн — займёт меньше минуты.</p>
        <a href="{{ route('trainers.index') }}"
           class="inline-flex items-center gap-2 px-8 py-4 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-semibold transition-colors">
            Выбрать тренера
        </a>
    </div>
</section>

@endsection
