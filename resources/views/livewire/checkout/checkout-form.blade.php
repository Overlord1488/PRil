<div>
    <form wire:submit="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Form fields --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-slate-900 rounded-xl p-6">
                <h3 class="text-base font-semibold text-white mb-4">{{ __('Контактные данные') }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-slate-300 mb-1">{{ __('Имя') }} *</label>
                        <input wire:model="name" type="text"
                               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror">
                        @error('name') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm text-slate-300 mb-1">{{ __('Телефон') }} *</label>
                        <input wire:model="phone" type="tel"
                               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 @error('phone') border-red-500 @enderror">
                        @error('phone') <p class="text-xs text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            @if($hasPhysical)
            <div class="bg-slate-900 rounded-xl p-6">
                <h3 class="text-base font-semibold text-white mb-4">{{ __('Адрес доставки') }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-slate-300 mb-1">{{ __('Город') }}</label>
                        <input wire:model="city" type="text"
                               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm text-slate-300 mb-1">{{ __('Индекс') }}</label>
                        <input wire:model="zip" type="text"
                               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm text-slate-300 mb-1">{{ __('Адрес') }}</label>
                        <input wire:model="address" type="text"
                               class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500">
                    </div>
                </div>
            </div>
            @endif

            <div class="bg-slate-900 rounded-xl p-6">
                <label class="block text-sm text-slate-300 mb-1">{{ __('Комментарий к заказу') }}</label>
                <textarea wire:model="comment" rows="3"
                          class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 resize-none"></textarea>
            </div>
        </div>

        {{-- Order summary --}}
        <div class="bg-slate-900 rounded-xl p-6 h-fit">
            <h3 class="text-base font-semibold text-white mb-4">{{ __('Ваш заказ') }}</h3>
            <div class="space-y-3 mb-4">
                @foreach($cart->items as $item)
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-300 truncate mr-2">{{ $item->product?->name }}</span>
                        <span class="text-slate-200 shrink-0">{{ number_format($item->lineTotal(), 0, '.', ' ') }} ₽</span>
                    </div>
                @endforeach
            </div>
            <div class="border-t border-slate-700 pt-3 space-y-2 text-sm">
                @if($shipping > 0)
                    <div class="flex justify-between text-slate-400">
                        <span>{{ __('Доставка') }}</span>
                        <span>{{ number_format($shipping, 0, '.', ' ') }} ₽</span>
                    </div>
                @endif
                <div class="flex justify-between font-bold text-white text-base pt-1">
                    <span>{{ __('К оплате') }}</span>
                    <span>{{ number_format($cart->total() + $shipping, 0, '.', ' ') }} ₽</span>
                </div>
            </div>
            <button type="submit"
                    class="mt-6 w-full px-6 py-3 bg-blue-900 hover:bg-blue-800 text-white font-medium rounded-lg transition-colors">
                <span wire:loading.remove>{{ __('Перейти к оплате') }}</span>
                <span wire:loading>{{ __('Оформление...') }}</span>
            </button>
        </div>
    </form>
</div>
