@extends('layouts.app')

@section('title', 'GymHub — Ваш спортивный зал')

@section('content')

{{-- Hero --}}
<section class="relative bg-zinc-950 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-950/40 via-zinc-950 to-zinc-950 pointer-events-none"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-36">
        <div class="max-w-2xl">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-slate-100 leading-tight">
                Достигайте<br>
                <span class="text-blue-400">новых высот</span>
            </h1>
            <p class="mt-6 text-lg text-slate-400 leading-relaxed max-w-xl">
                Профессиональные тренеры, продуманные программы и онлайн-запись — всё для вашего результата в одном месте.
            </p>
            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('trainers.index') }}"
                   class="inline-flex items-center gap-2 px-7 py-3.5 bg-blue-900 hover:bg-blue-800 text-slate-100 rounded-xl font-semibold transition-colors text-sm">
                    Найти тренера
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="{{ route('catalog.index') }}"
                   class="inline-flex items-center gap-2 px-7 py-3.5 bg-slate-800 hover:bg-slate-700 text-slate-100 rounded-xl font-semibold transition-colors text-sm">
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
               class="group bg-slate-900 rounded-2xl p-5 text-center hover:ring-1 hover:ring-blue-900 transition-all">
                @if($dir->icon)
                <div class="text-3xl mb-3">{{ $dir->icon }}</div>
                @else
                <div class="w-10 h-10 mx-auto mb-3 bg-blue-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                @endif
                <p class="text-sm font-medium text-slate-100 group-hover:text-blue-400 transition-colors">{{ $dir->name }}</p>
                <p class="text-xs text-slate-500 mt-1">{{ $dir->trainers_count }} тр.</p>
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
            <div class="bg-slate-900 rounded-2xl overflow-hidden hover:ring-1 hover:ring-blue-900 transition-all">
                <a href="{{ route('trainers.show', $trainer->slug) }}">
                    @if($trainer->photo_path)
                    <img src="{{ Storage::url($trainer->photo_path) }}"
                         alt="{{ $trainer->display_name }}"
                         class="w-full h-56 object-cover object-top">
                    @else
                    <div class="w-full h-56 bg-zinc-800 flex items-center justify-center">
                        <svg class="w-16 h-16 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    @endif
                </a>
                <div class="p-5">
                    <a href="{{ route('trainers.show', $trainer->slug) }}"
                       class="font-semibold text-slate-100 hover:text-blue-400 transition-colors">
                        {{ $trainer->display_name }}
                    </a>
                    @if($trainer->directions->isNotEmpty())
                    <p class="text-xs text-slate-400 mt-1">{{ $trainer->directions->pluck('name')->join(', ') }}</p>
                    @endif
                    <div class="flex items-center gap-3 mt-2 text-xs text-slate-500">
                        @if($trainer->experience_years)
                        <span>{{ $trainer->experience_years }} лет опыта</span>
                        @endif
                        @if($trainer->rating)
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            {{ number_format($trainer->rating, 1) }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="bg-blue-950/40 border-t border-blue-900/30 py-16">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-slate-100 mb-4">Готовы начать?</h2>
        <p class="text-slate-400 mb-8">Запишитесь на тренировку онлайн — займёт меньше минуты.</p>
        <a href="{{ route('trainers.index') }}"
           class="inline-flex items-center gap-2 px-8 py-4 bg-blue-900 hover:bg-blue-800 text-slate-100 rounded-xl font-semibold transition-colors">
            Выбрать тренера
        </a>
    </div>
</section>

@endsection
