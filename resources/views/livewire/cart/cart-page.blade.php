<div>
    @if($cart->items->isEmpty())
        <div class="text-center py-20">
            <p class="text-slate-400 text-lg mb-6">{{ __('Ваша корзина пуста') }}</p>
            <a href="{{ route('catalog.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-900 hover:bg-blue-800 text-white rounded-lg transition-colors">
                {{ __('Перейти в каталог') }}
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart->items as $item)
                    <div class="flex items-start gap-4 bg-slate-900 rounded-xl p-4">
                        <div class="w-20 h-20 rounded-lg bg-slate-800 shrink-0 overflow-hidden">
                            @if($item->product?->cover_url)
                                <img src="{{ $item->product->cover_url }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    @if($item->product?->isDigital())
                                    <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    @else
                                    <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-white">{{ $item->product?->name ?? __('Товар удалён') }}</p>
                            <p class="text-sm text-slate-400 mt-0.5">{{ $item->product?->type->label() }}</p>
                            <p class="text-sm text-slate-300 mt-1">{{ number_format($item->price_snapshot, 0, '.', ' ') }} ₽ × {{ $item->qty }}</p>
                            <div class="flex items-center gap-2 mt-3">
                                <button wire:click="update({{ $item->id }}, {{ $item->qty - 1 }})"
                                        class="w-8 h-8 rounded bg-slate-700 hover:bg-slate-600 text-white flex items-center justify-center">−</button>
                                <span class="text-white min-w-[2rem] text-center font-medium">{{ $item->qty }}</span>
                                <button wire:click="update({{ $item->id }}, {{ $item->qty + 1 }})"
                                        class="w-8 h-8 rounded bg-slate-700 hover:bg-slate-600 text-white flex items-center justify-center">+</button>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <p class="text-lg font-bold text-white">{{ number_format($item->lineTotal(), 0, '.', ' ') }} ₽</p>
                            <button wire:click="remove({{ $item->id }})" class="text-xs text-slate-500 hover:text-red-400 mt-2">{{ __('Удалить') }}</button>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Summary --}}
            <div class="bg-slate-900 rounded-xl p-6 h-fit">
                <h3 class="text-lg font-semibold text-white mb-4">{{ __('Итого') }}</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-slate-300">
                        <span>{{ __('Товары') }}</span>
                        <span>{{ number_format($cart->total(), 0, '.', ' ') }} ₽</span>
                    </div>
                    <div class="flex justify-between text-slate-300">
                        <span>{{ __('Доставка') }}</span>
                        <span>@if($shipping > 0) {{ number_format($shipping, 0, '.', ' ') }} ₽ @else {{ __('Бесплатно') }} @endif</span>
                    </div>
                    <div class="border-t border-slate-700 pt-3 flex justify-between font-bold text-white text-base">
                        <span>{{ __('К оплате') }}</span>
                        <span>{{ number_format($cart->total() + $shipping, 0, '.', ' ') }} ₽</span>
                    </div>
                </div>
                <a href="{{ route('checkout.index') }}"
                   class="block mt-6 w-full text-center px-6 py-3 bg-blue-900 hover:bg-blue-800 text-white font-medium rounded-lg transition-colors"
                   wire:navigate>
                    {{ __('Перейти к оформлению') }}
                </a>
            </div>
        </div>
    @endif
</div>
