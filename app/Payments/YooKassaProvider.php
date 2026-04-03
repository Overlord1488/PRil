<?php

namespace App\Payments;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use YooKassa\Client;

class YooKassaProvider implements PaymentProvider
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client;
        $this->client->setAuth(
            config('payments.providers.yookassa.shop_id'),
            config('payments.providers.yookassa.secret_key'),
        );
    }

    public function create(Order $order, string $returnUrl): RedirectInfo
    {
        $response = $this->client->createPayment([
            'amount' => [
                'value' => number_format((float) $order->total, 2, '.', ''),
                'currency' => 'RUB',
            ],
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => $returnUrl,
            ],
            'capture' => true,
            'description' => 'Заказ '.$order->number,
            'metadata' => ['order_id' => $order->id],
        ], uniqid('', true));

        return new RedirectInfo(
            paymentId: $response->getId(),
            confirmationUrl: $response->getConfirmation()->getConfirmationUrl(),
        );
    }

    public function handleWebhook(Request $request): PaymentResult
    {
        $body = json_decode($request->getContent(), true);
        $object = $body['object'] ?? [];

        $status = match ($object['status'] ?? '') {
            'succeeded' => PaymentStatus::Succeeded,
            'canceled' => PaymentStatus::Cancelled,
            default => PaymentStatus::Pending,
        };

        return new PaymentResult(
            providerPaymentId: $object['id'] ?? '',
            status: $status,
            raw: $body,
        );
    }

    public function refund(Payment $payment, float $amount): bool
    {
        $this->client->createRefund([
            'payment_id' => $payment->provider_payment_id,
            'amount' => [
                'value' => number_format($amount, 2, '.', ''),
                'currency' => 'RUB',
            ],
        ], uniqid('', true));

        return true;
    }
}
