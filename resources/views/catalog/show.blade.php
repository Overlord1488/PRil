@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
    <nav class="text-sm text-slate-400 mb-6">
        <a href="{{ route('catalog.index') }}" class="hover:text-white">{{ __('Каталог') }}</a>
        @if($product->category)
            <span class="mx-2">/</span>
            <a href="{{ route('catalog.category', $product->category->slug) }}" class="hover:text-white">{{ $product->category->name }}</a>
        @endif
        <span class="mx-2">/</span>
        <span class="text-slate-300">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-12">
        {{-- Gallery --}}
        <div>
            @if($product->cover_url)
                <div class="aspect-video bg-slate-900 rounded-xl overflow-hidden mb-4">
                    <img src="{{ $product->cover_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="aspect-video bg-slate-900 rounded-xl flex items-center justify-center mb-4">
                    @if($product->isDigital())
                    <svg class="w-16 h-16 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    @else
                    <svg class="w-16 h-16 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    @endif
                </div>
            @endif
            @if($product->images->isNotEmpty())
                <div class="flex gap-2 flex-wrap">
                    @foreach($product->images as $img)
                        <div class="w-20 h-20 rounded-lg overflow-hidden bg-slate-900">
                            <img src="{{ asset('storage/'.$img->path) }}" alt="{{ $img->alt }}" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Info --}}
        <div>
            <span class="inline-block text-xs text-blue-400 font-medium mb-2">{{ $product->type->label() }}</span>
            <h1 class="text-2xl font-bold text-white mb-4">{{ $product->name }}</h1>

            @if($product->description)
                <p class="text-slate-300 mb-6">{{ $product->description }}</p>
            @endif

            <div class="text-3xl font-bold text-white mb-6">{{ number_format($product->price, 0, '.', ' ') }} ₽</div>

            @if(!$product->isDigital() && $product->in_stock)
                <p class="text-sm text-green-400 mb-4">{{ __('В наличии') }}@if($product->stock_qty): {{ $product->stock_qty }} {{ __('шт.') }}@endif</p>
            @elseif(!$product->in_stock)
                <p class="text-sm text-red-400 mb-4">{{ __('Нет в наличии') }}</p>
            @endif

            <button type="button"
                    onclick="Livewire.dispatch('add-to-cart', { productId: {{ $product->id }} })"
                    class="w-full sm:w-auto px-8 py-3 bg-blue-900 hover:bg-blue-800 text-white font-semibold rounded-xl transition-colors">
                {{ __('Добавить в корзину') }}
            </button>
        </div>
    </div>

    @if($product->body)
        <div class="mt-12 bg-slate-900 rounded-xl p-8">
            <h2 class="text-lg font-semibold text-white mb-4">{{ __('Описание') }}</h2>
            <div class="prose prose-invert max-w-none text-slate-300">{!! $product->body !!}</div>
        </div>
    @endif
</div>
@endsection
