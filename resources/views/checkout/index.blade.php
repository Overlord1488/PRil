@extends('layouts.app')

@section('title', __('Оформление заказа'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-2xl font-bold text-white mb-8">{{ __('Оформление заказа') }}</h1>
    <livewire:checkout.checkout-form />
</div>
@endsection
