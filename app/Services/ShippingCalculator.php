<?php

namespace App\Services;

use App\Models\Cart;

class ShippingCalculator
{
    public function calculate(Cart $cart): float
    {
        $hasPhysical = $cart->items->contains(
            fn ($item) => $item->product && ! $item->product->isDigital()
        );

        if (! $hasPhysical) {
            return 0.0;
        }

        $threshold = config('shop.shipping.free_threshold');

        if ($threshold && $cart->total() >= $threshold) {
            return 0.0;
        }

        return (float) config('shop.shipping.flat_rate', 400);
    }

    public function hasPhysical(Cart $cart): bool
    {
        return $cart->items->contains(fn ($item) => $item->product && ! $item->product->isDigital());
    }

    public function hasDigital(Cart $cart): bool
    {
        return $cart->items->contains(fn ($item) => $item->product && $item->product->isDigital());
    }
}
