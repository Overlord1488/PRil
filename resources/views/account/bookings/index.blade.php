<x-app-layout>
<div class="bg-zinc-950 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-8">
            @include('account._sidebar')

            <main class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold text-slate-100 mb-6">Мои записи</h1>

                @if(session('success'))
                <div class="mb-6 rounded-xl bg-green-900/30 border border-green-700/40 px-5 py-4 text-green-400 text-sm">
                    {{ session('success') }}
                </div>
                @endif

                {{-- Upcoming --}}
                @if($upcoming->isNotEmpty())
                <h2 class="text-base font-semibold text-slate-400 uppercase tracking-wider mb-3">Предстоящие</h2>
                <div class="space-y-3 mb-8">
                    @foreach($upcoming as $booking)
                    <div class="bg-slate-900 rounded-xl px-6 py-5">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <a href="{{ route('trainers.show', $booking->trainer->slug) }}"
                                   class="font-semibold text-slate-100 hover:text-blue-400 transition-colors">
                                    {{ $booking->trainer->display_name }}
                                </a>
                                @if($booking->direction)
                                <span class="ml-2 px-2 py-0.5 bg-blue-900/30 text-blue-400 rounded text-xs">
                                    {{ $booking->direction->name }}
                                </span>
                                @endif
                                <p class="text-sm text-slate-400 mt-1">
                                    {{ $booking->scheduled_at->isoFormat('dddd, D MMMM YYYY') }}
                                    в {{ $booking->scheduled_at->format('H:i') }}
                                    · {{ $booking->duration_minutes }} мин
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @switch($booking->status->value)
                                        @case('pending') bg-yellow-900/40 text-yellow-400 @break
                                        @case('confirmed') bg-green-900/40 text-green-400 @break
                                        @default bg-slate-700 text-slate-400
                                    @endswitch">
                                    {{ $booking->status->label() }}
                                </span>
                                @if($booking->status->isCancellable())
                                <form action="{{ route('account.bookings.cancel', $booking) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('Отменить запись?')"
                                            class="text-xs text-slate-500 hover:text-red-400 transition-colors">
                                        Отменить
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                        @if($booking->notes)
                        <p class="text-xs text-slate-500 mt-3 border-t border-slate-800 pt-3">
                            {{ $booking->notes }}
                        </p>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Past --}}
                @if($past->isNotEmpty())
                <h2 class="text-base font-semibold text-slate-400 uppercase tracking-wider mb-3">История</h2>
                <div class="space-y-3">
                    @foreach($past as $booking)
                    <div class="bg-slate-900/60 rounded-xl px-6 py-4 flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="font-medium text-slate-300">{{ $booking->trainer->display_name }}</p>
                            <p class="text-sm text-slate-500 mt-0.5">
                                {{ $booking->scheduled_at->format('d.m.Y H:i') }}
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @switch($booking->status->value)
                                @case('completed') bg-slate-700 text-slate-400 @break
                                @case('cancelled') bg-red-900/30 text-red-400 @break
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
                    У вас нет записей к тренерам.
                    <a href="{{ route('trainers.index') }}" class="text-blue-400 hover:underline ml-1">Найти тренера →</a>
                </div>
                @endif
            </main>
        </div>
    </div>
</div>
</x-app-layout>
