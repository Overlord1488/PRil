@extends('layouts.app')

@section('title', __('Ошибка оплаты'))

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <div class="bg-slate-900 rounded-xl p-10">
        <div class="text-5xl mb-4">❌</div>
        <h1 class="text-2xl font-bold text-white mb-2">{{ __('Ошибка оплаты') }}</h1>
        <p class="text-slate-400 mb-8">{{ __('Не удалось провести оплату заказа') }} {{ $order->number }}.</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('checkout.pay', $order) }}"
               class="px-6 py-3 bg-blue-900 hover:bg-blue-800 text-white rounded-lg transition-colors">
                {{ __('Попробовать ещё раз') }}
            </a>
            <a href="{{ route('cart.index') }}"
               class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white rounded-lg transition-colors">
                {{ __('Вернуться в корзину') }}
            </a>
        </div>
    </div>
</div>
@endsection
