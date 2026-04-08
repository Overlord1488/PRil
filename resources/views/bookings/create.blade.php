@extends('layouts.app')

@section('title', 'Запись к тренеру — ' . $trainer->display_name)

@section('content')
<div class="bg-zinc-950 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <a href="{{ route('trainers.show', $trainer->slug) }}"
           class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-100 mb-8 text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Профиль тренера
        </a>

        <div class="bg-slate-900 rounded-2xl p-8">
            {{-- Trainer header --}}
            <div class="flex items-center gap-4 mb-8 pb-8 border-b border-slate-800">
                @if($trainer->photo_path)
                <img src="{{ Storage::url($trainer->photo_path) }}"
                     alt="{{ $trainer->display_name }}"
                     class="w-16 h-16 rounded-full object-cover object-top flex-shrink-0">
                @else
                <div class="w-16 h-16 rounded-full bg-zinc-800 flex items-center justify-center flex-shrink-0">
                    <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                @endif
                <div>
                    <h1 class="text-xl font-bold text-slate-100">Запись к {{ $trainer->display_name }}</h1>
                    @if($trainer->directions->isNotEmpty())
                    <p class="text-sm text-slate-400 mt-0.5">
                        {{ $trainer->directions->pluck('name')->join(', ') }}
                    </p>
                    @endif
                </div>
            </div>

            <livewire:booking.slot-picker :trainer="$trainer" />
        </div>
    </div>
</div>
@endsection
