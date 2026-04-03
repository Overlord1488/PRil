<?php

namespace App\Http\Controllers\Webhooks;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Notifications\OrderPaidNotification;
use App\Payments\PaymentManager;
use App\Services\GrantDownloadsAction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class YooKassaWebhookController extends Controller
{
    public function __construct(
        private readonly PaymentManager $paymentManager,
        private readonly GrantDownloadsAction $grantDownloads,
    ) {}

    public function __invoke(Request $request): Response
    {
        $result = $this->paymentManager->driver('yookassa')->handleWebhook($request);

        if (! $result->providerPaymentId) {
            return response()->noContent();
        }

        $payment = Payment::where('provider_payment_id', $result->providerPaymentId)->first();

        if (! $payment || $payment->status === PaymentStatus::Succeeded) {
            return response()->noContent();
        }

        DB::transaction(function () use ($payment, $result) {
            $payment->update([
                'status' => $result->status,
                'raw_response' => $result->raw,
                'paid_at' => $result->succeeded() ? now() : null,
            ]);

            if ($result->succeeded()) {
                $order = $payment->order;
                $order->update(['status' => OrderStatus::Paid]);
                $this->grantDownloads->execute($order);
                $order->user->notify(new OrderPaidNotification($order));
            }
        });

        return response()->noContent();
    }
}
