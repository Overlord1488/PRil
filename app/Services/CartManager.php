<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartManager
{
    public function current(): Cart
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }

        $sessionId = Session::getId();

        return Cart::firstOrCreate(['session_id' => $sessionId, 'user_id' => null]);
    }

    public function add(Product $product, int $qty = 1): CartItem
    {
        $cart = $this->current();

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->increment('qty', $qty);

            return $item;
        }

        return $cart->items()->create([
            'product_id' => $product->id,
            'qty' => $qty,
            'price_snapshot' => $product->price,
        ]);
    }

    public function update(int $cartItemId, int $qty): void
    {
        $cart = $this->current();

        if ($qty <= 0) {
            $cart->items()->where('id', $cartItemId)->delete();

            return;
        }

        $cart->items()->where('id', $cartItemId)->update(['qty' => $qty]);
    }

    public function remove(int $cartItemId): void
    {
        $this->current()->items()->where('id', $cartItemId)->delete();
    }

    public function clear(): void
    {
        $this->current()->items()->delete();
    }

    public function mergeGuestCart(string $sessionId): void
    {
        $guest = Cart::where('session_id', $sessionId)->where('user_id', null)->first();

        if (! $guest) {
            return;
        }

        $userCart = $this->current();

        foreach ($guest->items as $guestItem) {
            $existing = $userCart->items()->where('product_id', $guestItem->product_id)->first();

            if ($existing) {
                $existing->increment('qty', $guestItem->qty);
            } else {
                $userCart->items()->create([
                    'product_id' => $guestItem->product_id,
                    'qty' => $guestItem->qty,
                    'price_snapshot' => $guestItem->price_snapshot,
                ]);
            }
        }

        $guest->delete();
    }
}
