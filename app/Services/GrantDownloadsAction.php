<?php

namespace App\Services;

use App\Models\Download;
use App\Models\Order;

class GrantDownloadsAction
{
    public function execute(Order $order): void
    {
        $order->load('items.product.files');

        $maxDownloads = (int) config('shop.downloads.max_per_file', 5);
        $expiresDays = (int) config('shop.downloads.expires_days', 30);
        $expiresAt = now()->addDays($expiresDays);

        foreach ($order->items as $item) {
            if (! $item->product?->isDigital()) {
                continue;
            }

            foreach ($item->product->files as $file) {
                Download::firstOrCreate(
                    [
                        'user_id' => $order->user_id,
                        'order_item_id' => $item->id,
                        'product_file_id' => $file->id,
                    ],
                    [
                        'downloads_count' => 0,
                        'max_downloads' => $maxDownloads,
                        'expires_at' => $expiresAt,
                    ]
                );
            }
        }
    }
}
