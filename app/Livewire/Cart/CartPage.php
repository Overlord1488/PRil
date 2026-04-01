<?php

namespace App\Livewire\Cart;

use App\Services\CartManager;
use App\Services\ShippingCalculator;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CartPage extends Component
{
    public function update(int $itemId, int $qty): void
    {
        app(CartManager::class)->update($itemId, $qty);
    }

    public function remove(int $itemId): void
    {
        app(CartManager::class)->remove($itemId);
    }

    public function render(): View
    {
        $cart = app(CartManager::class)->current();
        $cart->load('items.product');
        $shipping = app(ShippingCalculator::class)->calculate($cart);

        return view('livewire.cart.cart-page', [
            'cart' => $cart,
            'shipping' => $shipping,
        ]);
    }
}
