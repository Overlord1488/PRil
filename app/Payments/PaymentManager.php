<?php

namespace App\Payments;

use InvalidArgumentException;

class PaymentManager
{
    public function driver(?string $driver = null): PaymentProvider
    {
        $driver ??= config('payments.default', 'stub');

        return match ($driver) {
            'stub' => new StubProvider,
            'yookassa' => new YooKassaProvider,
            default => throw new InvalidArgumentException("Unknown payment driver: {$driver}"),
        };
    }
}
