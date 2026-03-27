<?php

return [
    'shipping' => [
        'flat_rate' => (float) env('SHOP_SHIPPING_FLAT_RATE', 400),
        'free_threshold' => null,
    ],
    'downloads' => [
        'max_per_file' => (int) env('DOWNLOAD_MAX_PER_FILE', 5),
        'expires_days' => (int) env('DOWNLOAD_EXPIRES_DAYS', 30),
    ],
    'bookings' => [
        'payment_timeout_minutes' => (int) env('BOOKING_PAYMENT_TIMEOUT_MINUTES', 15),
        'min_hours_before' => (int) env('BOOKING_MIN_HOURS_BEFORE', 2),
        'cancel_hours_before' => (int) env('BOOKING_CANCEL_HOURS_BEFORE', 24),
    ],
];
