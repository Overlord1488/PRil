<?php

namespace App\Payments;

readonly class RedirectInfo
{
    public function __construct(
        public string $paymentId,
        public string $confirmationUrl,
    ) {}
}
