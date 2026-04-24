<?php

namespace App\Models;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'category_id',
        'description',
        'body',
        'price',
        'cover_path',
        'is_published',
        'in_stock',
        'stock_qty',
        'weight_kg',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'type' => ProductType::class,
            'price' => 'decimal:2',
            'is_published' => 'boolean',
            'in_stock' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function files(): HasMany
    {
        return $this->hasMany(ProductFile::class)->orderBy('sort_order');
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }

    public function scopeOfType(Builder $query, ProductType|string $type): void
    {
        $query->where('type', $type instanceof ProductType ? $type->value : $type);
    }

    public function scopeInCategory(Builder $query, int $categoryId): void
    {
        $query->where('category_id', $categoryId);
    }

    public function getCoverUrlAttribute(): ?string
    {
        if (!$this->cover_path) return null;
        return str_starts_with($this->cover_path, 'http')
            ? $this->cover_path
            : Storage::url($this->cover_path);
    }

    public function isDigital(): bool
    {
        return $this->type->isDigital();
    }
}
