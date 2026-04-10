<x-app-layout>
<div class="bg-zinc-950 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-8">
            @include('account._sidebar')

            <main class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold text-slate-100 mb-6">Мои заказы</h1>

                @forelse($orders as $order)
                <a href="{{ route('account.orders.show', $order) }}"
                   class="block bg-slate-900 rounded-xl mb-3 px-6 py-5 hover:ring-1 hover:ring-blue-900 transition-all">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="font-semibold text-slate-100">{{ $order->number }}</p>
                            <p class="text-sm text-slate-400 mt-0.5">
                                {{ $order->created_at->format('d.m.Y') }}
                            </p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="font-semibold text-slate-100">{{ number_format($order->total, 0, '.', ' ') }} ₽</p>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded text-xs font-medium
                                @switch($order->status->value)
                                    @case('pending_payment') bg-yellow-900/40 text-yellow-400 @break
                                    @case('paid') bg-blue-900/40 text-blue-400 @break
                                    @case('processing') bg-blue-900/40 text-blue-400 @break
                                    @case('shipped') bg-purple-900/40 text-purple-400 @break
                                    @case('delivered') bg-green-900/40 text-green-400 @break
                                    @case('cancelled') bg-red-900/40 text-red-400 @break
                                    @default bg-slate-700 text-slate-400
                                @endswitch">
                                {{ $order->status->label() }}
                            </span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="bg-slate-900 rounded-2xl p-12 text-center text-slate-500">
                    У вас ещё нет заказов.
                    <a href="{{ route('catalog.index') }}" class="text-blue-400 hover:underline ml-1">В каталог →</a>
                </div>
                @endforelse

                <div class="mt-4">{{ $orders->links() }}</div>
            </main>
        </div>
    </div>
</div>
</x-app-layout>
