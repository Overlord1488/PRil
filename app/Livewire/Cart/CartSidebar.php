<?php

namespace App\Livewire\Cart;

use App\Models\Product;
use App\Services\CartManager;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class CartSidebar extends Component
{
    public bool $open = false;

    public function toggle(): void
    {
        $this->open = ! $this->open;
    }

    #[On('add-to-cart')]
    public function add(int $productId, int $qty = 1): void
    {
        $product = Product::find($productId);
        if (! $product) {
            return;
        }

        app(CartManager::class)->add($product, $qty);
        $this->open = true;
        $this->dispatch('cart-updated');
    }

    public function update(int $itemId, int $qty): void
    {
        app(CartManager::class)->update($itemId, $qty);
        $this->dispatch('cart-updated');
    }

    public function remove(int $itemId): void
    {
        app(CartManager::class)->remove($itemId);
        $this->dispatch('cart-updated');
    }

    #[On('cart-updated')]
    public function refresh(): void {}

    public function render(): View
    {
        $cart = app(CartManager::class)->current();
        $cart->load('items.product');

        return view('livewire.cart.cart-sidebar', ['cart' => $cart]);
    }
}
