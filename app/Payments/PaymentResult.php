<?php

namespace App\Payments;

use App\Enums\PaymentStatus;

readonly class PaymentResult
{
    public function __construct(
        public string $providerPaymentId,
        public PaymentStatus $status,
        public ?array $raw = null,
    ) {}

    public function succeeded(): bool
    {
        return $this->status === PaymentStatus::Succeeded;
    }
}
