<?php

return [
    'default' => env('PAYMENT_PROVIDER', 'stub'),
    'providers' => [
        'stub' => [
            'driver' => 'stub',
        ],
        'yookassa' => [
            'driver' => 'yookassa',
            'shop_id' => env('YOOKASSA_SHOP_ID'),
            'secret_key' => env('YOOKASSA_SECRET_KEY'),
            'return_url' => env('YOOKASSA_RETURN_URL'),
        ],
    ],
];
