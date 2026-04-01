@extends('layouts.app')

@section('title', __('Заказ оплачен'))

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <div class="bg-slate-900 rounded-xl p-10">
        <div class="text-5xl mb-4">✅</div>
        <h1 class="text-2xl font-bold text-white mb-2">{{ __('Заказ оплачен!') }}</h1>
        <p class="text-slate-400 mb-2">{{ __('Номер заказа') }}: <span class="text-white font-mono">{{ $order->number }}</span></p>
        <p class="text-slate-400 mb-8">{{ __('Сумма') }}: <span class="text-white font-bold">{{ number_format($order->total, 0, '.', ' ') }} ₽</span></p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('account.orders.show', $order) }}"
               class="px-6 py-3 bg-blue-900 hover:bg-blue-800 text-white rounded-lg transition-colors">
                {{ __('Мои заказы') }}
            </a>
            <a href="{{ route('catalog.index') }}"
               class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-white rounded-lg transition-colors">
                {{ __('Продолжить покупки') }}
            </a>
        </div>
    </div>
</div>
@endsection
