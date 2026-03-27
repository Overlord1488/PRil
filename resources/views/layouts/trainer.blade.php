<x-app-layout>
    <x-slot name="title">{{ $title ?? __('Кабинет тренера') }} — {{ config('app.name') }}</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex gap-8">
            <aside class="w-56 shrink-0">
                <nav class="flex flex-col gap-1">
                    <a href="{{ route('trainer.index') }}"
                       class="px-4 py-2 rounded-lg text-sm {{ request()->routeIs('trainer.index') ? 'bg-blue-900 text-white' : 'text-slate-300 hover:bg-slate-800' }} transition-colors">
                        {{ __('Дашборд') }}
                    </a>
                    <a href="{{ route('trainer.schedule.index') }}"
                       class="px-4 py-2 rounded-lg text-sm {{ request()->routeIs('trainer.schedule.*') ? 'bg-blue-900 text-white' : 'text-slate-300 hover:bg-slate-800' }} transition-colors">
                        {{ __('Расписание') }}
                    </a>
                    <a href="{{ route('trainer.bookings.index') }}"
                       class="px-4 py-2 rounded-lg text-sm {{ request()->routeIs('trainer.bookings.*') ? 'bg-blue-900 text-white' : 'text-slate-300 hover:bg-slate-800' }} transition-colors">
                        {{ __('Мои брони') }}
                    </a>
                </nav>
            </aside>
            <div class="flex-1 min-w-0">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>
