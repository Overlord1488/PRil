<?php

namespace App\Payments;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StubProvider implements PaymentProvider
{
    public function create(Order $order, string $returnUrl): RedirectInfo
    {
        $fakeId = 'stub_'.Str::uuid();

        return new RedirectInfo(
            paymentId: $fakeId,
            confirmationUrl: $returnUrl.'?stub_paid=1',
        );
    }

    public function handleWebhook(Request $request): PaymentResult
    {
        return new PaymentResult(
            providerPaymentId: $request->input('payment_id', 'stub_unknown'),
            status: PaymentStatus::Succeeded,
        );
    }

    public function refund(Payment $payment, float $amount): bool
    {
        return true;
    }
}
