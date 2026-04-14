<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Trainer extends Model
{
    protected $fillable = [
        'user_id', 'slug', 'display_name', 'photo_path',
        'bio', 'experience_years', 'rating', 'reviews_count',
        'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function directions(): BelongsToMany
    {
        return $this->belongsToMany(TrainingDirection::class, 'direction_trainer', 'trainer_id', 'training_direction_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(TrainerSchedule::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }
}
