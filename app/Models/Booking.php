<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'trainer_id', 'training_direction_id',
        'scheduled_at', 'duration_minutes', 'status', 'notes', 'price',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'status' => BookingStatus::class,
            'price' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }

    public function direction(): BelongsTo
    {
        return $this->belongsTo(TrainingDirection::class, 'training_direction_id');
    }

    public function scopeUpcoming(Builder $query): void
    {
        $query->where('scheduled_at', '>=', now())
            ->whereNotIn('status', [BookingStatus::Cancelled->value]);
    }

    public function scopeForUser(Builder $query, int $userId): void
    {
        $query->where('user_id', $userId);
    }
}
