@extends('layouts.app')

@section('title', $trainer->display_name)

@section('content')
<div class="bg-zinc-950 min-h-screen py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <a href="{{ route('trainers.index') }}"
           class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-100 mb-8 text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Все тренеры
        </a>

        <div class="bg-slate-900 rounded-2xl overflow-hidden">
            <div class="md:flex">
                <div class="md:w-80 flex-shrink-0">
                    @if($trainer->photo_url)
                    <img src="{{ $trainer->photo_url }}"
                         alt="{{ $trainer->display_name }}"
                         class="w-full h-80 md:h-full object-cover object-top">
                    @else
                    <div class="w-full h-80 md:h-full min-h-64 bg-gradient-to-br from-blue-950 to-slate-800 flex flex-col items-center justify-center gap-3">
                        <div class="w-24 h-24 rounded-full bg-slate-700 flex items-center justify-center">
                            <span class="text-3xl font-bold text-slate-300">
                                {{ mb_strtoupper(mb_substr($trainer->display_name, 0, 1)) }}{{ mb_strtoupper(mb_substr(strrchr($trainer->display_name, ' ') ?: ' ', 1, 1)) }}
                            </span>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="p-8 flex-1">
                    <h1 class="text-3xl font-bold text-slate-100">{{ $trainer->display_name }}</h1>

                    <div class="flex flex-wrap items-center gap-4 mt-3">
                        @if($trainer->experience_years)
                        <span class="flex items-center gap-1.5 text-slate-400 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $trainer->experience_years }} лет опыта
                        </span>
                        @endif
                        @if($trainer->rating)
                        <span class="flex items-center gap-1.5 text-slate-400 text-sm">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            {{ number_format($trainer->rating, 1) }}
                            @if($trainer->reviews_count)
                            <span class="text-slate-500">({{ $trainer->reviews_count }})</span>
                            @endif
                        </span>
                        @endif
                    </div>

                    @if($trainer->directions->isNotEmpty())
                    <div class="flex flex-wrap gap-2 mt-4">
                        @foreach($trainer->directions as $dir)
                        <a href="{{ route('directions.show', $dir->slug) }}"
                           class="px-3 py-1 bg-blue-900/40 hover:bg-blue-900/70 text-blue-400 rounded-full text-sm transition-colors">
                            {{ $dir->name }}
                        </a>
                        @endforeach
                    </div>
                    @endif

                    @if($trainer->bio)
                    <div class="mt-6 text-slate-300 leading-relaxed text-sm">
                        {!! nl2br(e($trainer->bio)) !!}
                    </div>
                    @endif

                    <div class="mt-8">
                        @auth
                        <a href="{{ route('bookings.create', ['trainer' => $trainer->slug]) }}"
                           class="inline-block px-8 py-3 bg-blue-900 hover:bg-blue-800 text-slate-100 rounded-xl font-semibold transition-colors">
                            Записаться на тренировку
                        </a>
                        @else
                        <a href="{{ route('login') }}"
                           class="inline-block px-8 py-3 bg-blue-900 hover:bg-blue-800 text-slate-100 rounded-xl font-semibold transition-colors">
                            Войдите, чтобы записаться
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        {{-- Reviews --}}
        <div class="mt-8">
            @if($trainer->reviews->isNotEmpty())
            <h2 class="text-xl font-semibold text-slate-100 mb-5">
                Отзывы
                <span class="text-slate-500 font-normal text-base ml-1">({{ $trainer->reviews->count() }})</span>
            </h2>
            <div class="space-y-4 mb-8">
                @foreach($trainer->reviews as $review)
                <div class="bg-slate-900 rounded-xl px-6 py-5">
                    <div class="flex items-center justify-between gap-3 mb-2">
                        <span class="font-medium text-slate-100 text-sm">{{ $review->user->name }}</span>
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-slate-700' }}"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                        </div>
                    </div>
                    @if($review->body)
                    <p class="text-slate-300 text-sm leading-relaxed">{{ $review->body }}</p>
                    @endif
                    <p class="text-xs text-slate-600 mt-2">{{ $review->created_at->format('d.m.Y') }}</p>
                </div>
                @endforeach
            </div>
            @endif

            <div class="bg-slate-900 rounded-xl px-6 py-6">
                <h3 class="text-base font-semibold text-slate-100 mb-4">Оставить отзыв</h3>
                <livewire:review.review-form
                    :reviewable-type="\App\Models\Trainer::class"
                    :reviewable-id="$trainer->id"
                />
            </div>
        </div>

    </div>
</div>
@endsection
