@extends('layouts.app')

@section('title', $direction->name)

@section('content')

{{-- Hero --}}
<section class="relative h-56 sm:h-72 overflow-hidden">
    @if($direction->cover_url)
    <img src="{{ $direction->cover_url }}" alt="{{ $direction->name }}"
         class="w-full h-full object-cover">
    @else
    <div class="w-full h-full bg-gradient-to-br from-blue-950 to-slate-900"></div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/60 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        <div class="flex items-center gap-3">
            <span class="text-4xl">{{ $direction->icon }}</span>
            <div>
                <h1 class="text-3xl font-bold text-white">{{ $direction->name }}</h1>
                @if($direction->description)
                <p class="mt-1 text-slate-300 text-sm max-w-2xl">{{ $direction->description }}</p>
                @endif
            </div>
        </div>
    </div>
</section>

<div class="bg-zinc-950 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <a href="{{ route('directions.index') }}"
           class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-100 mb-8 text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Все направления
        </a>

        @if($direction->trainers->isNotEmpty())
        <h2 class="text-xl font-semibold text-slate-100 mb-6">
            Тренеры по этому направлению
            <span class="text-slate-500 font-normal text-base ml-1">({{ $direction->trainers->count() }})</span>
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($direction->trainers as $trainer)
            @include('trainers._card', ['trainer' => $trainer])
            @endforeach
        </div>
        @else
        <div class="text-center py-20 text-slate-500">
            По этому направлению пока нет тренеров
        </div>
        @endif
    </div>
</div>
@endsection
