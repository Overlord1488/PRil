@extends('layouts.app')

@section('title', 'Направления тренировок')

@section('content')
<div class="bg-zinc-950 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-10">
            <h1 class="text-3xl font-bold text-slate-100">Направления тренировок</h1>
            <p class="mt-2 text-slate-400">Выберите то, что подходит именно вам</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($directions as $direction)
            <a href="{{ route('directions.show', $direction->slug) }}"
               class="group bg-slate-900 rounded-2xl p-6 hover:ring-1 hover:ring-blue-900 transition-all flex flex-col gap-4">

                @if($direction->icon)
                <div class="w-12 h-12 bg-blue-900/30 rounded-xl flex items-center justify-center text-blue-400 text-2xl">
                    {{ $direction->icon }}
                </div>
                @else
                <div class="w-12 h-12 bg-blue-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                @endif

                <div>
                    <h2 class="text-lg font-semibold text-slate-100 group-hover:text-blue-400 transition-colors">
                        {{ $direction->name }}
                    </h2>
                    @if($direction->description)
                    <p class="mt-1 text-sm text-slate-400 line-clamp-2">{{ $direction->description }}</p>
                    @endif
                </div>

                <div class="mt-auto flex items-center justify-between">
                    <span class="text-xs text-slate-500">
                        {{ $direction->trainers_count }}
                        {{ $direction->trainers_count === 1 ? 'тренер' : ($direction->trainers_count < 5 ? 'тренера' : 'тренеров') }}
                    </span>
                    <svg class="w-4 h-4 text-slate-500 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
            @empty
            <div class="col-span-4 text-center py-20 text-slate-500">
                Направления пока не добавлены
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
