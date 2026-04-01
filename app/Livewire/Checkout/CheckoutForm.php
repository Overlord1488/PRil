<?php

namespace App\Livewire\Checkout;

use App\Services\CartManager;
use App\Services\PlaceOrderAction;
use App\Services\ShippingCalculator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CheckoutForm extends Component
{
    #[Validate('required|string|max:200')]
    public string $name = '';

    #[Validate('required|string|max:32')]
    public string $phone = '';

    #[Validate('nullable|string|max:120')]
    public string $city = '';

    #[Validate('nullable|string|max:500')]
    public string $address = '';

    #[Validate('nullable|string|max:20')]
    public string $zip = '';

    #[Validate('nullable|string|max:1000')]
    public string $comment = '';

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->phone = $user->phone ?? '';
    }

    public function submit(): void
    {
        $this->validate();

        $cart = app(CartManager::class)->current();
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            $this->addError('name', __('Корзина пуста'));

            return;
        }

        $order = app(PlaceOrderAction::class)->execute(
            $cart,
            Auth::user(),
            [
                'name' => $this->name,
                'phone' => $this->phone,
                'city' => $this->city ?: null,
                'address' => $this->address ?: null,
                'zip' => $this->zip ?: null,
                'comment' => $this->comment ?: null,
            ]
        );

        $this->redirect(route('checkout.pay', $order), navigate: true);
    }

    public function render(): View
    {
        $cart = app(CartManager::class)->current();
        $cart->load('items.product');

        $shipping = app(ShippingCalculator::class)->calculate($cart);
        $hasPhysical = app(ShippingCalculator::class)->hasPhysical($cart);

        return view('livewire.checkout.checkout-form', [
            'cart' => $cart,
            'shipping' => $shipping,
            'hasPhysical' => $hasPhysical,
        ]);
    }
}
