<x-app-layout>
<div class="bg-zinc-950 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            @include('account._sidebar')

            <main class="flex-1 min-w-0">
                @if(session('success'))
                <div class="mb-6 flex items-center gap-3 px-5 py-4 bg-green-900/30 border border-green-700/40 rounded-xl text-sm text-green-300">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 flex items-center gap-3 px-5 py-4 bg-red-900/30 border border-red-700/40 rounded-xl text-sm text-red-300">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
                @endif

                <div class="flex items-center gap-3 mb-6">
                    <a href="{{ route('account.orders.index') }}"
                       class="text-slate-400 hover:text-slate-100 transition-colors text-sm">← Все заказы</a>
                    <span class="text-slate-600">/</span>
                    <h1 class="text-2xl font-bold text-slate-100">{{ $order->number }}</h1>
                </div>

                <div class="bg-slate-900 rounded-2xl overflow-hidden mb-6">
                    {{-- Header --}}
                    <div class="px-6 py-5 border-b border-slate-800 flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-sm text-slate-400">Оформлен {{ $order->created_at->format('d.m.Y в H:i') }}</p>
                            @if($order->shipping_name)
                            <p class="text-sm text-slate-400 mt-0.5">{{ $order->shipping_name }}</p>
                            @endif
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
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

                    {{-- Items --}}
                    <div class="divide-y divide-slate-800">
                        @foreach($order->items as $item)
                        <div class="px-6 py-4 flex items-center justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-slate-100 font-medium truncate">{{ $item->product_name }}</p>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $item->qty }} × {{ number_format($item->unit_price, 0, '.', ' ') }} ₽</p>
                            </div>
                            <p class="text-slate-100 font-semibold flex-shrink-0">
                                {{ number_format($item->total_price, 0, '.', ' ') }} ₽
                            </p>
                        </div>
                        @endforeach
                    </div>

                    {{-- Totals --}}
                    <div class="px-6 py-5 border-t border-slate-800 space-y-2">
                        <div class="flex justify-between text-sm text-slate-400">
                            <span>Товары</span>
                            <span>{{ number_format($order->subtotal, 0, '.', ' ') }} ₽</span>
                        </div>
                        @if($order->shipping > 0)
                        <div class="flex justify-between text-sm text-slate-400">
                            <span>Доставка</span>
                            <span>{{ number_format($order->shipping, 0, '.', ' ') }} ₽</span>
                        </div>
                        @endif
                        <div class="flex justify-between text-slate-100 font-semibold pt-2 border-t border-slate-800">
                            <span>Итого</span>
                            <span>{{ number_format($order->total, 0, '.', ' ') }} ₽</span>
                        </div>
                    </div>
                </div>

                @if($order->status === \App\Enums\OrderStatus::PendingPayment)
                <div class="bg-slate-900 rounded-2xl px-6 py-5 mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <p class="text-slate-100 font-semibold">Заказ ожидает оплаты</p>
                        <p class="text-sm text-slate-400 mt-0.5">Оплатите заказ, чтобы мы начали его обработку.</p>
                    </div>
                    <a href="{{ route('checkout.pay', $order) }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-xl transition-colors whitespace-nowrap flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Оплатить заказ
                    </a>
                </div>
                @endif

                @if($order->has_digital)
                <div class="bg-blue-900/20 border border-blue-800/40 rounded-xl px-5 py-4 text-sm text-blue-300">
                    Цифровые товары из этого заказа доступны в
                    <a href="{{ route('account.downloads.index') }}" class="underline hover:text-blue-200">разделе загрузок</a>.
                </div>
                @endif
            </main>
        </div>
    </div>
</div>
</x-app-layout>
