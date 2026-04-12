<x-app-layout>
<div class="bg-zinc-950 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-8">
            @include('trainer._sidebar')

            <main class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold text-slate-100 mb-6">Кабинет тренера</h1>

                @if(! $trainer)
                <div class="bg-slate-900 rounded-2xl p-10 text-center">
                    <p class="text-slate-400 mb-4">Профиль тренера не найден. Обратитесь к администратору.</p>
                </div>
                @else

                @if(session('success'))
                <div class="mb-6 rounded-xl bg-green-900/30 border border-green-700/40 px-5 py-4 text-green-400 text-sm">
                    {{ session('success') }}
                </div>
                @endif

                {{-- Stats --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                    <div class="bg-slate-900 rounded-2xl p-5">
                        <p class="text-xs text-slate-500 uppercase tracking-wider mb-2">Сегодня</p>
                        <p class="text-3xl font-bold text-slate-100">{{ $todayCount }}</p>
                        <p class="text-xs text-slate-500 mt-1">тренировок</p>
                    </div>
                    <a href="{{ route('trainer.bookings.index') }}"
                       class="bg-slate-900 rounded-2xl p-5 hover:ring-1 hover:ring-blue-900 transition-all group">
                        <p class="text-xs text-slate-500 uppercase tracking-wider mb-2">Всего предстоит</p>
                        <p class="text-3xl font-bold text-slate-100">{{ $totalCount }}</p>
                        <p class="text-xs text-blue-400 mt-1 group-hover:underline">Все записи →</p>
                    </a>
                    <a href="{{ route('trainer.schedule.index') }}"
                       class="bg-slate-900 rounded-2xl p-5 hover:ring-1 hover:ring-blue-900 transition-all group">
                        <p class="text-xs text-slate-500 uppercase tracking-wider mb-2">Расписание</p>
                        <p class="text-3xl font-bold text-slate-100">
                            {{ $trainer->schedules()->where('is_active', true)->count() }}
                        </p>
                        <p class="text-xs text-blue-400 mt-1 group-hover:underline">Рабочих дней →</p>
                    </a>
                </div>

                {{-- Upcoming bookings --}}
                <h2 class="text-lg font-semibold text-slate-100 mb-4">Ближайшие записи</h2>
                @if($upcoming->isEmpty())
                <div class="bg-slate-900 rounded-xl p-8 text-center text-slate-500">
                    Предстоящих записей нет
                </div>
                @else
                <div class="space-y-3">
                    @foreach($upcoming as $booking)
                    <div class="bg-slate-900 rounded-xl px-5 py-4 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="font-medium text-slate-100">{{ $booking->user->name }}</p>
                            <p class="text-sm text-slate-400">
                                {{ $booking->scheduled_at->isoFormat('D MMMM, H:mm') }}
                                · {{ $booking->duration_minutes }} мин
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @switch($booking->status->value)
                                @case('pending') bg-yellow-900/40 text-yellow-400 @break
                                @case('confirmed') bg-green-900/40 text-green-400 @break
                                @default bg-slate-700 text-slate-400
                            @endswitch">
                            {{ $booking->status->label() }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @endif

                @endif
            </main>
        </div>
    </div>
</div>
</x-app-layout>
