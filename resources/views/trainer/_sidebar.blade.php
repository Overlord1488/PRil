@php
$links = [
    ['route' => 'trainer.index',          'label' => 'Обзор',      'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
    ['route' => 'trainer.bookings.index', 'label' => 'Записи',     'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
    ['route' => 'trainer.schedule.index', 'label' => 'Расписание', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
];
@endphp

{{-- Mobile: horizontal scroll tabs --}}
<div class="lg:hidden -mx-4 px-4 mb-5">
    <div class="flex gap-1 overflow-x-auto pb-1 scrollbar-none">
        @foreach($links as $link)
        @php $active = request()->routeIs($link['route']); @endphp
        <a href="{{ route($link['route']) }}"
           class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-medium whitespace-nowrap transition-colors flex-shrink-0
                  {{ $active ? 'bg-blue-900 text-blue-300' : 'bg-slate-900 text-slate-400 hover:text-slate-100' }}">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"/>
            </svg>
            {{ $link['label'] }}
        </a>
        @endforeach
        <a href="{{ route('account.index') }}"
           class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-medium whitespace-nowrap text-slate-500 hover:text-slate-100 bg-slate-900 transition-colors flex-shrink-0">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Личный кабинет
        </a>
    </div>
</div>

{{-- Desktop: vertical sidebar --}}
<aside class="hidden lg:block w-56 flex-shrink-0">
    <nav class="bg-slate-900 rounded-2xl p-4 space-y-1 sticky top-6">
        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider px-3 mb-2">Кабинет тренера</p>
        @foreach($links as $link)
        @php $active = request()->routeIs($link['route']); @endphp
        <a href="{{ route($link['route']) }}"
           class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-colors
                  {{ $active ? 'bg-blue-900/50 text-blue-400' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800' }}">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"/>
            </svg>
            {{ $link['label'] }}
        </a>
        @endforeach
        <div class="pt-2 border-t border-slate-800 mt-2">
            <a href="{{ route('account.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium text-slate-500 hover:text-slate-100 hover:bg-slate-800 transition-colors">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Личный кабинет
            </a>
        </div>
    </nav>
</aside>
