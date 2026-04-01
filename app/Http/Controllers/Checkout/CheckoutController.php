<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View
    {
        return view('checkout.index');
    }

    public function pay(Order $order): View
    {
        $this->authorize('view', $order);

        return view('checkout.pay', compact('order'));
    }

    public function success(Order $order): View
    {
        $this->authorize('view', $order);

        return view('checkout.success', compact('order'));
    }

    public function failure(Order $order): View
    {
        $this->authorize('view', $order);

        return view('checkout.failure', compact('order'));
    }
}
