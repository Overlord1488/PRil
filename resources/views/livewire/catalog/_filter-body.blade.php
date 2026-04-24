{{-- Type --}}
<div>
    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Тип</p>
    <div class="flex flex-wrap gap-2">
        <button wire:click="$set('type', '')"
                class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors
                    {{ $type === '' ? 'bg-blue-700 text-white' : 'bg-slate-800 text-slate-400 hover:text-slate-100' }}">
            Все
        </button>
        @foreach($types as $t)
        <button wire:click="$set('type', '{{ $t->value }}')"
                class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors
                    {{ $type === $t->value ? 'bg-blue-700 text-white' : 'bg-slate-800 text-slate-400 hover:text-slate-100' }}">
            {{ $t->label() }}
        </button>
        @endforeach
    </div>
</div>

{{-- Category --}}
@if($categories->isNotEmpty())
<div class="border-t border-slate-800 pt-5">
    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Категория</p>
    <div class="space-y-1">
        <button wire:click="$set('category', '')"
                class="w-full text-left px-3 py-2 rounded-lg text-sm transition-colors
                    {{ $category === '' ? 'bg-slate-800 text-slate-100 font-medium' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/50' }}">
            Все категории
        </button>
        @foreach($categories as $cat)
        <button wire:click="$set('category', '{{ $cat->slug }}')"
                class="w-full text-left px-3 py-2 rounded-lg text-sm transition-colors
                    {{ $category === $cat->slug ? 'bg-slate-800 text-slate-100 font-medium' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/50' }}">
            {{ $cat->name }}
        </button>
        @foreach($cat->children as $child)
        <button wire:click="$set('category', '{{ $child->slug }}')"
                class="w-full text-left pl-7 pr-3 py-1.5 rounded-lg text-xs transition-colors
                    {{ $category === $child->slug ? 'bg-slate-800 text-slate-100 font-medium' : 'text-slate-500 hover:text-slate-200 hover:bg-slate-800/50' }}">
            {{ $child->name }}
        </button>
        @endforeach
        @endforeach
    </div>
</div>
@endif

{{-- Price --}}
<div class="border-t border-slate-800 pt-5">
    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Цена, ₽</p>
    <div class="flex gap-2">
        <input type="number" wire:model.lazy="priceMin" placeholder="от" min="0"
               class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:ring-1 focus:ring-blue-700 focus:border-blue-700 transition-colors">
        <input type="number" wire:model.lazy="priceMax" placeholder="до" min="0"
               class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:ring-1 focus:ring-blue-700 focus:border-blue-700 transition-colors">
    </div>
</div>
