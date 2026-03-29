<div class="flex flex-col lg:flex-row gap-8">
    {{-- Sidebar Filters --}}
    <aside class="lg:w-64 shrink-0">
        <div class="bg-slate-900 rounded-xl p-5 space-y-6">
            <div>
                <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-3">{{ __('Тип') }}</h3>
                <div class="space-y-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model.live="type" value="" class="text-blue-500">
                        <span class="text-sm text-slate-300">{{ __('Все') }}</span>
                    </label>
                    @foreach($types as $t)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" wire:model.live="type" value="{{ $t->value }}" class="text-blue-500">
                            <span class="text-sm text-slate-300">{{ $t->label() }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-3">{{ __('Категория') }}</h3>
                <div class="space-y-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model.live="category" value="" class="text-blue-500">
                        <span class="text-sm text-slate-300">{{ __('Все') }}</span>
                    </label>
                    @foreach($categories as $cat)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" wire:model.live="category" value="{{ $cat->slug }}" class="text-blue-500">
                            <span class="text-sm text-slate-300">{{ $cat->name }}</span>
                        </label>
                        @foreach($cat->children as $child)
                            <label class="flex items-center gap-2 cursor-pointer pl-4">
                                <input type="radio" wire:model.live="category" value="{{ $child->slug }}" class="text-blue-500">
                                <span class="text-sm text-slate-400">{{ $child->name }}</span>
                            </label>
                        @endforeach
                    @endforeach
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-3">{{ __('Цена, ₽') }}</h3>
                <div class="flex gap-2">
                    <input type="number" wire:model.lazy="priceMin" placeholder="{{ __('от') }}"
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500">
                    <input type="number" wire:model.lazy="priceMax" placeholder="{{ __('до') }}"
                        class="w-full bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500">
                </div>
            </div>
        </div>
    </aside>

    {{-- Product Grid --}}
    <div class="flex-1">
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-slate-400">
                {{ __('Найдено: ') }}<span class="text-slate-200 font-medium">{{ $products->total() }}</span>
            </p>
            <select wire:model.live="sort" class="bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500">
                <option value="newest">{{ __('Новинки') }}</option>
                <option value="popular">{{ __('Популярные') }}</option>
                <option value="price_asc">{{ __('Цена: по возрастанию') }}</option>
                <option value="price_desc">{{ __('Цена: по убыванию') }}</option>
            </select>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-20 text-slate-500">
                <p class="text-lg">{{ __('Товары не найдены') }}</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product->slug) }}"
                       class="group bg-slate-900 rounded-xl overflow-hidden hover:ring-1 hover:ring-blue-700 transition-all">
                        <div class="aspect-video bg-slate-800 overflow-hidden">
                            @if($product->cover_path)
                                <img src="{{ asset('storage/'.$product->cover_path) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <span class="text-4xl text-slate-700">
                                        @if($product->isDigital()) 📄 @else 📦 @endif
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <span class="inline-block text-xs text-blue-400 font-medium mb-1">{{ $product->type->label() }}</span>
                            <h3 class="text-sm font-semibold text-slate-100 group-hover:text-white mb-2 line-clamp-2">{{ $product->name }}</h3>
                            @if($product->description)
                                <p class="text-xs text-slate-400 line-clamp-2 mb-3">{{ $product->description }}</p>
                            @endif
                            <p class="text-base font-bold text-white">{{ number_format($product->price, 0, '.', ' ') }} ₽</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
