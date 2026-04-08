@extends('layouts.app')

@section('title', 'Запись #' . $booking->id)

@section('content')
<div class="bg-zinc-950 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        @if(session('success'))
        <div class="mb-6 rounded-xl bg-green-900/30 border border-green-700/40 px-5 py-4 text-green-400 text-sm">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-slate-900 rounded-2xl overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-800 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-slate-100">Запись #{{ $booking->id }}</h1>
                    <p class="text-sm text-slate-400 mt-0.5">
                        Создана {{ $booking->created_at->format('d.m.Y в H:i') }}
                    </p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    @switch($booking->status->value)
                        @case('pending') bg-yellow-900/40 text-yellow-400 @break
                        @case('confirmed') bg-green-900/40 text-green-400 @break
                        @case('cancelled') bg-red-900/40 text-red-400 @break
                        @case('completed') bg-slate-700 text-slate-400 @break
                    @endswitch">
                    {{ $booking->status->label() }}
                </span>
            </div>

            <div class="px-8 py-6 space-y-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-slate-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <p class="text-xs text-slate-500">Дата и время</p>
                        <p class="text-slate-100">
                            {{ $booking->scheduled_at->isoFormat('dddd, D MMMM YYYY') }}
                            в {{ $booking->scheduled_at->format('H:i') }}
                        </p>
                        <p class="text-xs text-slate-400">{{ $booking->duration_minutes }} минут</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-slate-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <div>
                        <p class="text-xs text-slate-500">Тренер</p>
                        <a href="{{ route('trainers.show', $booking->trainer->slug) }}"
                           class="text-slate-100 hover:text-blue-400 transition-colors">
                            {{ $booking->trainer->display_name }}
                        </a>
                    </div>
                </div>

                @if($booking->direction)
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-slate-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <div>
                        <p class="text-xs text-slate-500">Направление</p>
                        <p class="text-slate-100">{{ $booking->direction->name }}</p>
                    </div>
                </div>
                @endif

                @if($booking->notes)
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-slate-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                    </svg>
                    <div>
                        <p class="text-xs text-slate-500">Примечания</p>
                        <p class="text-slate-300 text-sm">{{ $booking->notes }}</p>
                    </div>
                </div>
                @endif
            </div>

            @if($booking->status->isCancellable())
            <div class="px-8 pb-8">
                <form action="{{ route('bookings.cancel', $booking) }}" method="POST">
                    @csrf
                    <button type="submit"
                            onclick="return confirm('Отменить запись?')"
                            class="px-5 py-2 bg-red-900/30 hover:bg-red-900/60 text-red-400 rounded-lg text-sm font-medium transition-colors border border-red-800/40">
                        Отменить запись
                    </button>
                </form>
            </div>
            @endif
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('dashboard') }}" class="text-sm text-slate-400 hover:text-slate-100 transition-colors">
                Перейти в личный кабинет
            </a>
        </div>
    </div>
</div>
@endsection
