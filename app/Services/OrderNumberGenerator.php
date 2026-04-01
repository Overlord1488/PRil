<?php

namespace App\Services;

use App\Models\Order;

class OrderNumberGenerator
{
    public function generate(): string
    {
        $prefix = 'ORD-'.now()->format('Ym').'-';

        $last = Order::where('number', 'like', $prefix.'%')
            ->orderByDesc('number')
            ->value('number');

        $seq = $last ? ((int) substr($last, -5)) + 1 : 1;

        return $prefix.str_pad((string) $seq, 5, '0', STR_PAD_LEFT);
    }
}
