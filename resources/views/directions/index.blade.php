@extends('layouts.app')

@section('title', 'Направления тренировок')

@section('content')
<div class="bg-zinc-950 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-10">
            <h1 class="text-3xl font-bold text-slate-100">Направления тренировок</h1>
            <p class="mt-2 text-slate-400">Выберите то, что подходит именно вам</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($directions as $direction)
            <a href="{{ route('directions.show', $direction->slug) }}"
               class="group relative overflow-hidden rounded-2xl block h-64">
                @if($direction->cover_url)
                <img src="{{ $direction->cover_url }}" alt="{{ $direction->name }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                @else
                <div class="w-full h-full bg-gradient-to-br from-blue-950 to-slate-900"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                <div class="absolute top-3 right-3 text-2xl">{{ $direction->icon }}</div>
                <div class="absolute bottom-0 left-0 right-0 p-4">
                    <p class="font-semibold text-white text-sm leading-tight">{{ $direction->name }}</p>
                    <p class="text-xs text-slate-400 mt-1">
                        {{ $direction->trainers_count }}
                        {{ $direction->trainers_count === 1 ? 'тренер' : ($direction->trainers_count < 5 ? 'тренера' : 'тренеров') }}
                    </p>
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
