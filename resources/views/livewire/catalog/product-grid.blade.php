<div class="flex flex-col lg:flex-row gap-8">

    {{-- Sidebar Filters --}}
    <aside class="lg:w-60 shrink-0">
        <div class="bg-slate-900 rounded-2xl p-5 space-y-6 sticky top-6">

            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Тип</p>
                <div class="space-y-1.5">
                    <label class="flex items-center gap-2.5 cursor-pointer group">
                        <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-colors
                            {{ $type === '' ? 'border-blue-500 bg-blue-500' : 'border-slate-600 group-hover:border-slate-400' }}">
                            @if($type === '') <div class="w-1.5 h-1.5 rounded-full bg-white"></div> @endif
                        </div>
                        <input type="radio" wire:model.live="type" value="" class="sr-only">
                        <span class="text-sm {{ $type === '' ? 'text-slate-100' : 'text-slate-400 group-hover:text-slate-200' }} transition-colors">Все</span>
                    </label>
                    @foreach($types as $t)
                    <label class="flex items-center gap-2.5 cursor-pointer group">
                        <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-colors
                            {{ $type === $t->value ? 'border-blue-500 bg-blue-500' : 'border-slate-600 group-hover:border-slate-400' }}">
                            @if($type === $t->value) <div class="w-1.5 h-1.5 rounded-full bg-white"></div> @endif
                        </div>
                        <input type="radio" wire:model.live="type" value="{{ $t->value }}" class="sr-only">
                        <span class="text-sm {{ $type === $t->value ? 'text-slate-100' : 'text-slate-400 group-hover:text-slate-200' }} transition-colors">{{ $t->label() }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            @if($categories->isNotEmpty())
            <div class="border-t border-slate-800 pt-5">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Категория</p>
                <div class="space-y-1.5">
                    <label class="flex items-center gap-2.5 cursor-pointer group">
                        <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-colors
                            {{ $category === '' ? 'border-blue-500 bg-blue-500' : 'border-slate-600 group-hover:border-slate-400' }}">
                            @if($category === '') <div class="w-1.5 h-1.5 rounded-full bg-white"></div> @endif
                        </div>
                        <input type="radio" wire:model.live="category" value="" class="sr-only">
                        <span class="text-sm {{ $category === '' ? 'text-slate-100' : 'text-slate-400 group-hover:text-slate-200' }} transition-colors">Все</span>
                    </label>
                    @foreach($categories as $cat)
                    <label class="flex items-center gap-2.5 cursor-pointer group">
                        <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center transition-colors
                            {{ $category === $cat->slug ? 'border-blue-500 bg-blue-500' : 'border-slate-600 group-hover:border-slate-400' }}">
                            @if($category === $cat->slug) <div class="w-1.5 h-1.5 rounded-full bg-white"></div> @endif
                        </div>
                        <input type="radio" wire:model.live="category" value="{{ $cat->slug }}" class="sr-only">
                        <span class="text-sm {{ $category === $cat->slug ? 'text-slate-100' : 'text-slate-400 group-hover:text-slate-200' }} transition-colors">{{ $cat->name }}</span>
                    </label>
                    @foreach($cat->children as $child)
                    <label class="flex items-center gap-2.5 cursor-pointer group pl-4">
                        <div class="w-3.5 h-3.5 rounded-full border-2 flex items-center justify-center transition-colors
                            {{ $category === $child->slug ? 'border-blue-500 bg-blue-500' : 'border-slate-600 group-hover:border-slate-400' }}">
                            @if($category === $child->slug) <div class="w-1 h-1 rounded-full bg-white"></div> @endif
                        </div>
                        <input type="radio" wire:model.live="category" value="{{ $child->slug }}" class="sr-only">
                        <span class="text-xs {{ $category === $child->slug ? 'text-slate-100' : 'text-slate-500 group-hover:text-slate-300' }} transition-colors">{{ $child->name }}</span>
                    </label>
                    @endforeach
                    @endforeach
                </div>
            </div>
            @endif

            <div class="border-t border-slate-800 pt-5">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Цена, ₽</p>
                <div class="flex gap-2">
                    <input type="number" wire:model.lazy="priceMin" placeholder="от"
                           class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-200 focus:outline-none focus:ring-1 focus:ring-blue-700 focus:border-blue-700 transition-colors">
                    <input type="number" wire:model.lazy="priceMax" placeholder="до"
                           class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-200 focus:outline-none focus:ring-1 focus:ring-blue-700 focus:border-blue-700 transition-colors">
                </div>
            </div>

            @if($type || $category || $priceMin || $priceMax)
            <button wire:click="$set('type',''); $set('category',''); $set('priceMin',0); $set('priceMax',0)"
                    class="w-full py-2 text-xs text-slate-400 hover:text-red-400 transition-colors">
                Сбросить фильтры
            </button>
            @endif
        </div>
    </aside>

    {{-- Product Grid --}}
    <div class="flex-1 min-w-0">
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm text-slate-400">
                Найдено: <span class="text-slate-200 font-medium">{{ $products->total() }}</span>
            </p>
            <select wire:model.live="sort"
                    class="bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-700 transition-colors">
                <option value="newest">Новинки</option>
                <option value="popular">Популярные</option>
                <option value="price_asc">Цена: по возрастанию</option>
                <option value="price_desc">Цена: по убыванию</option>
            </select>
        </div>

        @if($products->isEmpty())
        <div class="text-center py-24 text-slate-500">
            <svg class="w-12 h-12 mx-auto mb-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-lg font-medium text-slate-600">Товары не найдены</p>
            <p class="text-sm mt-1">Попробуйте изменить фильтры</p>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
            @foreach($products as $product)
            <a href="{{ route('products.show', $product->slug) }}"
               class="group bg-slate-900 rounded-2xl overflow-hidden hover:ring-1 hover:ring-blue-700 transition-all flex flex-col">
                <div class="aspect-video bg-slate-800 overflow-hidden relative">
                    @if($product->cover_path)
                    <img src="{{ asset('storage/'.$product->cover_path) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                    <div class="w-full h-full flex flex-col items-center justify-center gap-2 bg-gradient-to-br from-slate-800 to-slate-900">
                        @if($product->isDigital())
                        <svg class="w-10 h-10 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        @else
                        <svg class="w-10 h-10 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        @endif
                    </div>
                    @endif
                    <div class="absolute top-2 left-2">
                        <span class="px-2 py-0.5 bg-blue-900/80 text-blue-300 text-xs font-medium rounded-lg backdrop-blur-sm">
                            {{ $product->type->label() }}
                        </span>
                    </div>
                </div>
                <div class="p-4 flex flex-col flex-1">
                    <h3 class="text-sm font-semibold text-slate-100 group-hover:text-white mb-1 line-clamp-2 flex-1">{{ $product->name }}</h3>
                    @if($product->description)
                    <p class="text-xs text-slate-500 line-clamp-2 mb-3">{{ $product->description }}</p>
                    @endif
                    <p class="text-base font-bold text-white mt-auto">{{ number_format($product->price, 0, '.', ' ') }} ₽</p>
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
