<?php

namespace App\Http\Controllers\Checkout;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Notifications\OrderPaidNotification;
use App\Payments\PaymentManager;
use App\Services\GrantDownloadsAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentManager $paymentManager,
        private readonly GrantDownloadsAction $grantDownloads,
    ) {}

    public function pay(Order $order): RedirectResponse
    {
        $this->authorize('view', $order);

        if ($order->status !== OrderStatus::PendingPayment) {
            return redirect()->route('checkout.success', $order);
        }

        $returnUrl = route('checkout.success', $order);

        $driver = app(PaymentManager::class)->driver();
        $info = $driver->create($order, $returnUrl);

        Payment::create([
            'order_id' => $order->id,
            'provider' => config('payments.default', 'stub'),
            'provider_payment_id' => $info->paymentId,
            'status' => PaymentStatus::Pending,
            'amount' => $order->total,
            'return_url' => $returnUrl,
            'confirmation_url' => $info->confirmationUrl,
        ]);

        return redirect()->away($info->confirmationUrl);
    }

    public function success(Order $order): RedirectResponse
    {
        $this->authorize('view', $order);

        if ($order->status === OrderStatus::PendingPayment) {
            $this->markPaid($order);
        }

        return redirect()->route('account.orders.show', $order)
            ->with('success', __('Заказ оплачен! Спасибо.'));
    }

    public function failure(Order $order): RedirectResponse
    {
        $this->authorize('view', $order);

        return redirect()->route('checkout.pay.form', $order)
            ->withErrors(__('Оплата не прошла. Попробуйте ещё раз.'));
    }

    private function markPaid(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $order->update([
                'status' => OrderStatus::Paid,
            ]);

            Payment::where('order_id', $order->id)
                ->where('status', PaymentStatus::Pending)
                ->update(['status' => PaymentStatus::Succeeded, 'paid_at' => now()]);

            $this->grantDownloads->execute($order);

            $order->user->notify(new OrderPaidNotification($order));
        });
    }
}
