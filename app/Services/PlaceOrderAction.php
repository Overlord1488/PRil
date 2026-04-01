<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PlaceOrderAction
{
    public function __construct(
        private readonly OrderNumberGenerator $numberGenerator,
        private readonly ShippingCalculator $shippingCalculator,
    ) {}

    public function execute(Cart $cart, User $user, array $shippingData = []): Order
    {
        return DB::transaction(function () use ($cart, $user, $shippingData) {
            $cart->load('items.product');

            $subtotal = $cart->total();
            $shipping = $this->shippingCalculator->calculate($cart);
            $hasDigital = $this->shippingCalculator->hasDigital($cart);
            $hasPhysical = $this->shippingCalculator->hasPhysical($cart);

            $order = Order::create([
                'number' => $this->numberGenerator->generate(),
                'user_id' => $user->id,
                'status' => 'pending_payment',
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $subtotal + $shipping,
                'has_digital' => $hasDigital,
                'has_physical' => $hasPhysical,
                'shipping_name' => $shippingData['name'] ?? null,
                'shipping_phone' => $shippingData['phone'] ?? null,
                'shipping_city' => $shippingData['city'] ?? null,
                'shipping_address' => $shippingData['address'] ?? null,
                'shipping_zip' => $shippingData['zip'] ?? null,
                'comment' => $shippingData['comment'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product?->name ?? 'Товар удалён',
                    'product_type' => $item->product?->type->value ?? 'digital',
                    'qty' => $item->qty,
                    'unit_price' => $item->price_snapshot,
                    'total_price' => $item->price_snapshot * $item->qty,
                ]);
            }

            $cart->items()->delete();

            return $order;
        });
    }
}
