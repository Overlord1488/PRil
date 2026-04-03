<?php

namespace App\Payments;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

interface PaymentProvider
{
    public function create(Order $order, string $returnUrl): RedirectInfo;

    public function handleWebhook(Request $request): PaymentResult;

    public function refund(Payment $payment, float $amount): bool;
}
