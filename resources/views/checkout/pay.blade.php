@extends('layouts.app')

@section('title', __('Оплата заказа') . ' ' . $order->number)

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <div class="bg-slate-900 rounded-xl p-10">
        <h1 class="text-xl font-bold text-white mb-2">{{ __('Заказ') }} {{ $order->number }}</h1>
        <p class="text-slate-400 mb-8">{{ __('Сумма к оплате') }}: <span class="text-white font-bold">{{ number_format($order->total, 0, '.', ' ') }} ₽</span></p>
        <p class="text-slate-500 text-sm mb-6">{{ __('Здесь будет платёжная форма ЮKassa') }}</p>
        <a href="{{ route('checkout.pay', $order) }}"
           class="inline-flex items-center px-8 py-3 bg-blue-900 hover:bg-blue-800 text-white rounded-lg transition-colors">
            {{ __('Перейти к оплате') }}
        </a>
    </div>
</div>
@endsection
