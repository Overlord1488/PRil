<x-app-layout>
<div class="bg-zinc-950 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            @include('trainer._sidebar')

            <main class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold text-slate-100 mb-6">Записи клиентов</h1>

                @if(session('success'))
                <div class="mb-6 rounded-xl bg-green-900/30 border border-green-700/40 px-5 py-4 text-green-400 text-sm">
                    {{ session('success') }}
                </div>
                @endif

                @if(! $trainer)
                <div class="bg-slate-900 rounded-2xl p-10 text-center text-slate-500">
                    Профиль тренера не найден
                </div>
                @else

                {{-- Upcoming --}}
                @if($upcoming->isNotEmpty())
                <h2 class="text-base font-semibold text-slate-400 uppercase tracking-wider mb-3">Предстоящие</h2>
                <div class="space-y-3 mb-8">
                    @foreach($upcoming as $booking)
                    <div class="bg-slate-900 rounded-xl px-6 py-5">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="font-semibold text-slate-100">{{ $booking->user->name }}</p>
                                @if($booking->direction)
                                <span class="inline-block mt-0.5 px-2 py-0.5 bg-blue-900/30 text-blue-400 rounded text-xs">
                                    {{ $booking->direction->name }}
                                </span>
                                @endif
                                <p class="text-sm text-slate-400 mt-1">
                                    {{ $booking->scheduled_at->isoFormat('dddd, D MMMM YYYY') }}
                                    в {{ $booking->scheduled_at->format('H:i') }}
                                    · {{ $booking->duration_minutes }} мин
                                </p>
                                @if($booking->notes)
                                <p class="text-xs text-slate-500 mt-1 italic">{{ $booking->notes }}</p>
                                @endif
                            </div>

                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @switch($booking->status->value)
                                        @case('pending') bg-yellow-900/40 text-yellow-400 @break
                                        @case('confirmed') bg-green-900/40 text-green-400 @break
                                        @default bg-slate-700 text-slate-400
                                    @endswitch">
                                    {{ $booking->status->label() }}
                                </span>

                                @if($booking->scheduled_at->isPast())
                                <form action="{{ route('trainer.bookings.complete', $booking) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="px-3 py-1 bg-green-900/40 hover:bg-green-900/70 text-green-400 rounded-lg text-xs font-medium transition-colors">
                                        Завершить
                                    </button>
                                </form>
                                <form action="{{ route('trainer.bookings.no-show', $booking) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="px-3 py-1 bg-slate-800 hover:bg-slate-700 text-slate-400 rounded-lg text-xs font-medium transition-colors">
                                        Не явился
                                    </button>
                                </form>
                                @endif

                                @if($booking->status->isCancellable())
                                <form action="{{ route('trainer.bookings.cancel', $booking) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('Отменить запись?')"
                                            class="px-3 py-1 bg-red-900/30 hover:bg-red-900/60 text-red-400 rounded-lg text-xs font-medium transition-colors">
                                        Отменить
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Past --}}
                @if($past->isNotEmpty())
                <h2 class="text-base font-semibold text-slate-400 uppercase tracking-wider mb-3">История</h2>
                <div class="space-y-2">
                    @foreach($past as $booking)
                    <div class="bg-slate-900/60 rounded-xl px-6 py-4 flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="font-medium text-slate-300">{{ $booking->user->name }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">
                                {{ $booking->scheduled_at->format('d.m.Y H:i') }}
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @switch($booking->status->value)
                                @case('completed') bg-slate-700 text-slate-400 @break
                                @case('cancelled') bg-red-900/30 text-red-400 @break
                                @case('no_show') bg-red-900/30 text-red-400 @break
                                @default bg-slate-700 text-slate-400
                            @endswitch">
                            {{ $booking->status->label() }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @endif

                @if($upcoming->isEmpty() && $past->isEmpty())
                <div class="bg-slate-900 rounded-2xl p-12 text-center text-slate-500">
                    Записей пока нет
                </div>
                @endif

                @endif
            </main>
        </div>
    </div>
</div>
</x-app-layout>
