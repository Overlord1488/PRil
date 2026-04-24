<div x-data="{ filtersOpen: false }">

    {{-- Mobile top bar --}}
    <div class="flex items-center gap-3 mb-5 lg:hidden">
        <button @click="filtersOpen = true"
                class="flex items-center gap-2 px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-sm text-slate-300 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
            </svg>
            Фильтры
            @php $activeCount = (int)($type !== '') + (int)($category !== '') + (int)($priceMin > 0) + (int)($priceMax > 0); @endphp
            @if($activeCount > 0)
            <span class="w-5 h-5 bg-blue-600 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ $activeCount }}</span>
            @endif
        </button>
        <div class="flex-1"></div>
        <select wire:model.live="sort"
                class="bg-slate-900 border border-slate-700 rounded-xl px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-700 transition-colors">
            <option value="newest">Новинки</option>
            <option value="popular">Популярные</option>
            <option value="price_asc">Цена ↑</option>
            <option value="price_desc">Цена ↓</option>
        </select>
    </div>

    {{-- Mobile filter drawer --}}
    <div x-show="filtersOpen" x-cloak class="fixed inset-0 z-50 lg:hidden">
        {{-- Backdrop --}}
        <div @click="filtersOpen = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 bg-black/70"></div>

        {{-- Drawer --}}
        <div x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full"
             class="absolute bottom-0 left-0 right-0 bg-slate-900 rounded-t-2xl max-h-[85vh] flex flex-col">

            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-800 flex-shrink-0">
                <span class="text-base font-semibold text-white">Фильтры</span>
                <button @click="filtersOpen = false" class="text-slate-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="overflow-y-auto flex-1 px-5 py-4 space-y-6">
                @include('livewire.catalog._filter-body')
            </div>

            <div class="px-5 py-4 border-t border-slate-800 flex gap-3 flex-shrink-0">
                @if($type || $category || $priceMin || $priceMax)
                <button wire:click="resetFilters" @click="filtersOpen = false"
                        class="flex-1 py-3 text-sm text-slate-400 hover:text-white border border-slate-700 rounded-xl transition-colors">
                    Сбросить
                </button>
                @endif
                <button @click="filtersOpen = false"
                        class="flex-1 py-3 text-sm text-white bg-blue-700 hover:bg-blue-600 rounded-xl transition-colors font-medium">
                    Применить
                </button>
            </div>
        </div>
    </div>

    {{-- Desktop layout --}}
    <div class="flex gap-8">

        {{-- Desktop sidebar --}}
        <aside class="hidden lg:block w-56 shrink-0">
            <div class="bg-slate-900 rounded-2xl p-5 space-y-6 sticky top-6">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest">Фильтры</p>
                @include('livewire.catalog._filter-body')
                @if($type || $category || $priceMin || $priceMax)
                <button wire:click="resetFilters"
                        class="w-full py-2 text-xs text-slate-500 hover:text-red-400 transition-colors flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Сбросить фильтры
                </button>
                @endif
            </div>
        </aside>

        {{-- Products --}}
        <div class="flex-1 min-w-0">

            {{-- Desktop top bar --}}
            <div class="hidden lg:flex items-center justify-between mb-6">
                <p class="text-sm text-slate-400">
                    Найдено: <span class="text-slate-100 font-semibold">{{ $products->total() }}</span>
                </p>
                <select wire:model.live="sort"
                        class="bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-700 transition-colors">
                    <option value="newest">Новинки</option>
                    <option value="popular">Популярные</option>
                    <option value="price_asc">Цена: по возрастанию</option>
                    <option value="price_desc">Цена: по убыванию</option>
                </select>
            </div>

            {{-- Mobile result count --}}
            <p class="text-sm text-slate-400 mb-4 lg:hidden">
                Найдено: <span class="text-slate-100 font-semibold">{{ $products->total() }}</span>
            </p>

            {{-- Active filters chips --}}
            @if($type || $category || $priceMin || $priceMax)
            <div class="flex flex-wrap gap-2 mb-5">
                @if($type)
                <button wire:click="$set('type','')"
                        class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-900/50 text-blue-300 text-xs rounded-full hover:bg-red-900/40 hover:text-red-300 transition-colors">
                    {{ collect($types)->firstWhere('value', $type)?->label() }}
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                @endif
                @if($category)
                <button wire:click="$set('category','')"
                        class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-900/50 text-blue-300 text-xs rounded-full hover:bg-red-900/40 hover:text-red-300 transition-colors">
                    {{ $categories->flatMap(fn($c) => $c->children->push($c))->firstWhere('slug', $category)?->name }}
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                @endif
                @if($priceMin > 0)
                <button wire:click="$set('priceMin', 0)"
                        class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-900/50 text-blue-300 text-xs rounded-full hover:bg-red-900/40 hover:text-red-300 transition-colors">
                    от {{ number_format($priceMin, 0, '.', ' ') }} ₽
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                @endif
                @if($priceMax > 0)
                <button wire:click="$set('priceMax', 0)"
                        class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-900/50 text-blue-300 text-xs rounded-full hover:bg-red-900/40 hover:text-red-300 transition-colors">
                    до {{ number_format($priceMax, 0, '.', ' ') }} ₽
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                @endif
            </div>
            @endif

            @if($products->isEmpty())
            <div class="text-center py-24 text-slate-500">
                <svg class="w-12 h-12 mx-auto mb-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p class="text-lg font-medium text-slate-600">Товары не найдены</p>
                <p class="text-sm mt-1 mb-5">Попробуйте изменить фильтры</p>
                <button wire:click="resetFilters" class="text-sm text-blue-400 hover:text-blue-300 transition-colors">
                    Сбросить все фильтры
                </button>
            </div>
            @else
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-4">
                @foreach($products as $product)
                <a href="{{ route('products.show', $product->slug) }}"
                   class="group bg-slate-900 rounded-2xl overflow-hidden hover:ring-1 hover:ring-blue-700 transition-all flex flex-col">
                    <div class="aspect-video bg-slate-800 overflow-hidden relative">
                        @if($product->cover_url)
                        <img src="{{ $product->cover_url }}"
                             alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900">
                            @if($product->isDigital())
                            <svg class="w-10 h-10 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            @else
                            <svg class="w-10 h-10 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            @endif
                        </div>
                        @endif
                        <div class="absolute top-2 left-2">
                            <span class="px-2 py-0.5 bg-slate-900/80 text-blue-300 text-xs font-medium rounded-lg backdrop-blur-sm">
                                {{ $product->type->label() }}
                            </span>
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="text-sm font-semibold text-slate-100 group-hover:text-white mb-1 line-clamp-2 flex-1 leading-snug">{{ $product->name }}</h3>
                        @if($product->description)
                        <p class="text-xs text-slate-500 line-clamp-2 mb-3 leading-relaxed">{{ $product->description }}</p>
                        @endif
                        <p class="text-base font-bold text-white mt-auto">{{ number_format($product->price, 0, '.', ' ') }} ₽</p>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="mt-8">{{ $products->links() }}</div>
            @endif
        </div>
    </div>
</div>
