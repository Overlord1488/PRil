@extends('layouts.app')

@section('title', __('Оплата заказа') . ' ' . $order->number)

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    {{-- Flash errors --}}
    @if($errors->any())
        <div class="mb-6 bg-red-900/30 border border-red-700 rounded-xl px-5 py-4 text-red-300 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="bg-slate-900 rounded-2xl overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-slate-800">
            <p class="text-xs text-slate-500 mb-1">{{ __('Заказ') }} {{ $order->number }}</p>
            <h1 class="text-xl font-bold text-white">{{ __('Подтверждение оплаты') }}</h1>
        </div>

        {{-- Items --}}
        <div class="px-6 py-5 border-b border-slate-800 space-y-3">
            @foreach($order->items as $item)
                <div class="flex justify-between items-start gap-4 text-sm">
                    <div class="text-slate-300 leading-snug">
                        {{ $item->product_name }}
                        @if($item->qty > 1)
                            <span class="text-slate-500 ml-1">× {{ $item->qty }}</span>
                        @endif
                    </div>
                    <span class="text-slate-200 shrink-0">{{ number_format($item->total_price, 0, '.', ' ') }} ₽</span>
                </div>
            @endforeach
        </div>

        {{-- Totals --}}
        <div class="px-6 py-4 border-b border-slate-800 space-y-2 text-sm">
            @if($order->shipping > 0)
                <div class="flex justify-between text-slate-400">
                    <span>{{ __('Доставка') }}</span>
                    <span>{{ number_format($order->shipping, 0, '.', ' ') }} ₽</span>
                </div>
            @endif
            <div class="flex justify-between font-bold text-white text-lg pt-1">
                <span>{{ __('К оплате') }}</span>
                <span>{{ number_format($order->total, 0, '.', ' ') }} ₽</span>
            </div>
        </div>

        {{-- Contact info --}}
        @if($order->shipping_name || $order->shipping_phone)
        <div class="px-6 py-4 border-b border-slate-800 text-sm text-slate-400 space-y-1">
            @if($order->shipping_name)
                <div>{{ $order->shipping_name }}</div>
            @endif
            @if($order->shipping_phone)
                <div>{{ $order->shipping_phone }}</div>
            @endif
            @if($order->shipping_city || $order->shipping_address)
                <div>{{ implode(', ', array_filter([$order->shipping_city, $order->shipping_address, $order->shipping_zip])) }}</div>
            @endif
        </div>
        @endif

        {{-- Pay action --}}
        <div class="px-6 py-6 flex flex-col items-center gap-4">
            <a href="{{ route('checkout.pay', $order) }}"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-10 py-3.5 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-xl transition-colors text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                {{ __('Оплатить') }} {{ number_format($order->total, 0, '.', ' ') }} ₽
            </a>

            {{-- Security note --}}
            <div class="flex items-center gap-1.5 text-xs text-slate-500">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                {{ __('Безопасная оплата') }}
            </div>

            <a href="{{ route('account.orders.show', $order) }}"
               class="text-sm text-slate-500 hover:text-slate-300 transition-colors">
                ← {{ __('Вернуться к заказу') }}
            </a>
        </div>
    </div>
</div>
@endsection
