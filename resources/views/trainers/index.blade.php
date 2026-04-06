@extends('layouts.app')

@section('title', 'Тренеры')

@section('content')
<div class="bg-zinc-950 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-10">
            <h1 class="text-3xl font-bold text-slate-100">Наши тренеры</h1>
            <p class="mt-2 text-slate-400">Профессиональные наставники для достижения ваших целей</p>
        </div>

        @if($directions->isNotEmpty())
        <div class="flex flex-wrap gap-2 mb-8" x-data="{ active: 'all' }">
            <button
                @click="active = 'all'; filterTrainers('all')"
                :class="active === 'all' ? 'bg-blue-900 text-slate-100' : 'bg-slate-900 text-slate-400 hover:text-slate-100'"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                Все
            </button>
            @foreach($directions as $dir)
            <button
                @click="active = '{{ $dir->slug }}'; filterTrainers('{{ $dir->slug }}')"
                :class="active === '{{ $dir->slug }}' ? 'bg-blue-900 text-slate-100' : 'bg-slate-900 text-slate-400 hover:text-slate-100'"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                {{ $dir->name }}
            </button>
            @endforeach
        </div>
        @endif

        <div id="trainers-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($trainers as $trainer)
            <div class="trainer-card bg-slate-900 rounded-2xl overflow-hidden hover:ring-1 hover:ring-blue-900 transition-all"
                 data-directions="{{ $trainer->directions->pluck('slug')->join(',') }}">
                <a href="{{ route('trainers.show', $trainer->slug) }}">
                    @if($trainer->photo_path)
                    <img src="{{ Storage::url($trainer->photo_path) }}"
                         alt="{{ $trainer->display_name }}"
                         class="w-full h-64 object-cover object-top">
                    @else
                    <div class="w-full h-64 bg-zinc-800 flex items-center justify-center">
                        <svg class="w-20 h-20 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    @endif
                </a>
                <div class="p-5">
                    <a href="{{ route('trainers.show', $trainer->slug) }}"
                       class="text-xl font-semibold text-slate-100 hover:text-blue-400 transition-colors">
                        {{ $trainer->display_name }}
                    </a>

                    @if($trainer->directions->isNotEmpty())
                    <div class="flex flex-wrap gap-1 mt-2">
                        @foreach($trainer->directions as $dir)
                        <span class="px-2 py-0.5 bg-blue-900/40 text-blue-400 rounded text-xs">
                            {{ $dir->name }}
                        </span>
                        @endforeach
                    </div>
                    @endif

                    <div class="flex items-center gap-4 mt-3 text-sm text-slate-400">
                        @if($trainer->experience_years)
                        <span>{{ $trainer->experience_years }} лет опыта</span>
                        @endif
                        @if($trainer->rating)
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            {{ number_format($trainer->rating, 1) }}
                        </span>
                        @endif
                    </div>

                    <a href="{{ route('trainers.show', $trainer->slug) }}"
                       class="mt-4 inline-block w-full text-center py-2 bg-blue-900 hover:bg-blue-800 text-slate-100 rounded-lg text-sm font-medium transition-colors">
                        Подробнее
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-20 text-slate-500">
                Тренеры пока не добавлены
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function filterTrainers(slug) {
    document.querySelectorAll('.trainer-card').forEach(card => {
        if (slug === 'all') { card.style.display = ''; return; }
        const dirs = card.dataset.directions ? card.dataset.directions.split(',') : [];
        card.style.display = dirs.includes(slug) ? '' : 'none';
    });
}
</script>
@endsection
