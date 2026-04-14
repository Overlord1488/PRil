<?php

namespace App\Services;

use App\Models\Review;
use App\Models\Trainer;

class RecalculateRatingAction
{
    public function execute(Trainer $trainer): void
    {
        $stats = Review::where('reviewable_type', Trainer::class)
            ->where('reviewable_id', $trainer->id)
            ->where('is_approved', true)
            ->selectRaw('COUNT(*) as cnt, AVG(rating) as avg_rating')
            ->first();

        $trainer->update([
            'rating' => round((float) ($stats->avg_rating ?? 0), 2),
            'reviews_count' => (int) ($stats->cnt ?? 0),
        ]);
    }
}
