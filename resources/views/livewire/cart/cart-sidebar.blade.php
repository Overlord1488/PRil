<div x-data="{ open: @entangle('open') }">
    {{-- Trigger button --}}
    <button wire:click="toggle" class="relative text-slate-300 hover:text-white transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m12-9l2 9M9 22h.01M15 22h.01"/>
        </svg>
        @if($cart->totalQty() > 0)
            <span class="absolute -top-2 -right-2 bg-blue-600 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                {{ $cart->totalQty() }}
            </span>
        @endif
    </button>

    {{-- Backdrop --}}
    <div x-show="open" x-transition.opacity @click="open=false"
         class="fixed inset-0 bg-black/60 z-40"></div>

    {{-- Sidebar --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed top-0 right-0 h-full w-96 max-w-full bg-slate-900 border-l border-slate-800 z-50 flex flex-col">

        <div class="flex items-center justify-between p-5 border-b border-slate-800">
            <h2 class="text-lg font-semibold text-white">{{ __('Корзина') }}</h2>
            <button wire:click="toggle" class="text-slate-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-5 space-y-4">
            @forelse($cart->items as $item)
                <div class="flex items-start gap-3">
                    <div class="w-14 h-14 rounded-lg bg-slate-800 shrink-0 overflow-hidden">
                        @if($item->product?->cover_path)
                            <img src="{{ asset('storage/'.$item->product->cover_path) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-2xl">
                                @if($item->product?->isDigital()) 📄 @else 📦 @endif
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-slate-200 truncate">{{ $item->product?->name ?? __('Товар удалён') }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ number_format($item->price_snapshot, 0, '.', ' ') }} ₽</p>
                        <div class="flex items-center gap-2 mt-2">
                            <button wire:click="update({{ $item->id }}, {{ $item->qty - 1 }})"
                                    class="w-6 h-6 rounded bg-slate-700 hover:bg-slate-600 text-white text-sm flex items-center justify-center">−</button>
                            <span class="text-sm text-white min-w-[1.5rem] text-center">{{ $item->qty }}</span>
                            <button wire:click="update({{ $item->id }}, {{ $item->qty + 1 }})"
                                    class="w-6 h-6 rounded bg-slate-700 hover:bg-slate-600 text-white text-sm flex items-center justify-center">+</button>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-sm font-semibold text-white">{{ number_format($item->lineTotal(), 0, '.', ' ') }} ₽</p>
                        <button wire:click="remove({{ $item->id }})" class="text-xs text-slate-500 hover:text-red-400 mt-1">{{ __('Удалить') }}</button>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-slate-500">
                    <p>{{ __('Корзина пуста') }}</p>
                </div>
            @endforelse
        </div>

        @if($cart->items->isNotEmpty())
            <div class="p-5 border-t border-slate-800">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-slate-300">{{ __('Итого') }}</span>
                    <span class="text-xl font-bold text-white">{{ number_format($cart->total(), 0, '.', ' ') }} ₽</span>
                </div>
                <a href="{{ route('cart.index') }}"
                   class="block w-full text-center px-6 py-3 bg-blue-900 hover:bg-blue-800 text-white font-medium rounded-lg transition-colors"
                   wire:navigate>
                    {{ __('Оформить заказ') }}
                </a>
            </div>
        @endif
    </div>
</div>
