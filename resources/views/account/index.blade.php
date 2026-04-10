<x-app-layout>
<div class="bg-zinc-950 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-8">
            @include('account._sidebar')

            <main class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold text-slate-100 mb-6">Обзор</h1>

                @if(session('success'))
                <div class="mb-6 rounded-xl bg-green-900/30 border border-green-700/40 px-5 py-4 text-green-400 text-sm">
                    {{ session('success') }}
                </div>
                @endif

                {{-- Stats row --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                    <a href="{{ route('account.orders.index') }}"
                       class="bg-slate-900 rounded-2xl p-5 hover:ring-1 hover:ring-blue-900 transition-all group">
                        <p class="text-xs text-slate-500 uppercase tracking-wider mb-2">Заказов</p>
                        <p class="text-3xl font-bold text-slate-100">{{ $recentOrders->count() }}</p>
                        <p class="text-xs text-blue-400 mt-1 group-hover:underline">Все заказы →</p>
                    </a>
                    <a href="{{ route('account.bookings.index') }}"
                       class="bg-slate-900 rounded-2xl p-5 hover:ring-1 hover:ring-blue-900 transition-all group">
                        <p class="text-xs text-slate-500 uppercase tracking-wider mb-2">Предстоящих записей</p>
                        <p class="text-3xl font-bold text-slate-100">{{ $upcomingBookings->count() }}</p>
                        <p class="text-xs text-blue-400 mt-1 group-hover:underline">Все записи →</p>
                    </a>
                    <a href="{{ route('account.downloads.index') }}"
                       class="bg-slate-900 rounded-2xl p-5 hover:ring-1 hover:ring-blue-900 transition-all group">
                        <p class="text-xs text-slate-500 uppercase tracking-wider mb-2">Доступных загрузок</p>
                        <p class="text-3xl font-bold text-slate-100">{{ $downloadsCount }}</p>
                        <p class="text-xs text-blue-400 mt-1 group-hover:underline">К загрузкам →</p>
                    </a>
                </div>

                {{-- Upcoming bookings --}}
                @if($upcomingBookings->isNotEmpty())
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-slate-100 mb-4">Предстоящие записи</h2>
                    <div class="space-y-3">
                        @foreach($upcomingBookings as $booking)
                        <div class="bg-slate-900 rounded-xl px-5 py-4 flex items-center justify-between">
                            <div>
                                <p class="text-slate-100 font-medium">{{ $booking->trainer->display_name }}</p>
                                <p class="text-sm text-slate-400">
                                    {{ $booking->scheduled_at->isoFormat('D MMMM, H:mm') }}
                                </p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @switch($booking->status->value)
                                    @case('pending') bg-yellow-900/40 text-yellow-400 @break
                                    @case('confirmed') bg-green-900/40 text-green-400 @break
                                @endswitch">
                                {{ $booking->status->label() }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Recent orders --}}
                @if($recentOrders->isNotEmpty())
                <div>
                    <h2 class="text-lg font-semibold text-slate-100 mb-4">Последние заказы</h2>
                    <div class="space-y-3">
                        @foreach($recentOrders as $order)
                        <a href="{{ route('account.orders.show', $order) }}"
                           class="bg-slate-900 rounded-xl px-5 py-4 flex items-center justify-between hover:ring-1 hover:ring-blue-900 transition-all">
                            <div>
                                <p class="text-slate-100 font-medium">{{ $order->number }}</p>
                                <p class="text-sm text-slate-400">
                                    {{ $order->created_at->format('d.m.Y') }} · {{ $order->items->count() }} поз.
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-slate-100 font-semibold">{{ number_format($order->total, 0, '.', ' ') }} ₽</p>
                                <span class="text-xs text-slate-400">{{ $order->status->label() }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($recentOrders->isEmpty() && $upcomingBookings->isEmpty())
                <div class="bg-slate-900 rounded-2xl p-12 text-center text-slate-500">
                    Здесь пока ничего нет. Начните с&nbsp;
                    <a href="{{ route('trainers.index') }}" class="text-blue-400 hover:underline">выбора тренера</a>
                    &nbsp;или&nbsp;
                    <a href="{{ route('catalog.index') }}" class="text-blue-400 hover:underline">каталога</a>.
                </div>
                @endif
            </main>
        </div>
    </div>
</div>
</x-app-layout>
