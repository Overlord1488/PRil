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
                class="px-4 py-2 rounded-xl text-sm font-medium transition-colors">
                Все
            </button>
            @foreach($directions as $dir)
            <button
                @click="active = '{{ $dir->slug }}'; filterTrainers('{{ $dir->slug }}')"
                :class="active === '{{ $dir->slug }}' ? 'bg-blue-900 text-slate-100' : 'bg-slate-900 text-slate-400 hover:text-slate-100'"
                class="px-4 py-2 rounded-xl text-sm font-medium transition-colors">
                {{ $dir->name }}
            </button>
            @endforeach
        </div>
        @endif

        <div id="trainers-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($trainers as $trainer)
            <div class="trainer-card" data-directions="{{ $trainer->directions->pluck('slug')->join(',') }}">
                @include('trainers._card', ['trainer' => $trainer])
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
