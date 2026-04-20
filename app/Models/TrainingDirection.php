<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class TrainingDirection extends Model
{
    protected $fillable = [
        'name', 'slug', 'icon', 'description', 'body',
        'cover_path', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function trainers(): BelongsToMany
    {
        return $this->belongsToMany(Trainer::class, 'direction_trainer', 'training_direction_id', 'trainer_id');
    }

    public function getCoverUrlAttribute(): ?string
    {
        if (! $this->cover_path) {
            return null;
        }

        return str_starts_with($this->cover_path, 'http')
            ? $this->cover_path
            : Storage::url($this->cover_path);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }
}
