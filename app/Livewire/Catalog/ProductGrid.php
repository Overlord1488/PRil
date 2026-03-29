<?php

namespace App\Livewire\Catalog;

use App\Enums\ProductType;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductGrid extends Component
{
    use WithPagination;

    #[Url]
    public string $type = '';

    #[Url]
    public string $category = '';

    #[Url]
    public string $sort = 'newest';

    #[Url]
    public int $priceMin = 0;

    #[Url]
    public int $priceMax = 0;

    public function updatingType(): void
    {
        $this->resetPage();
    }

    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    public function updatingSort(): void
    {
        $this->resetPage();
    }

    public function updatingPriceMin(): void
    {
        $this->resetPage();
    }

    public function updatingPriceMax(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $query = Product::query()->published()->with(['category', 'images']);

        if ($this->type) {
            $query->ofType($this->type);
        }

        if ($this->category) {
            $cat = Category::where('slug', $this->category)->first();
            if ($cat) {
                $ids = $cat->children()->pluck('id')->push($cat->id);
                $query->whereIn('category_id', $ids);
            }
        }

        if ($this->priceMin > 0) {
            $query->where('price', '>=', $this->priceMin);
        }

        if ($this->priceMax > 0) {
            $query->where('price', '<=', $this->priceMax);
        }

        match ($this->sort) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'popular' => $query->orderBy('sort_order'),
            default => $query->orderByDesc('created_at'),
        };

        return view('livewire.catalog.product-grid', [
            'products' => $query->paginate(12),
            'categories' => Category::active()->roots()->with('children')->orderBy('sort_order')->get(),
            'types' => ProductType::cases(),
        ]);
    }
}
