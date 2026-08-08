<?php

namespace App\Models;

use Database\Factories\HomepageSectionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HomepageSection extends Model
{
    /** @use HasFactory<HomepageSectionFactory> */
    use HasFactory;

    protected $fillable = ['key', 'label', 'sort_order', 'is_visible', 'settings'];

    protected function casts(): array
    {
        return ['is_visible' => 'boolean', 'settings' => 'array'];
    }

    public function items(): HasMany
    {
        return $this->hasMany(HomepageItem::class)->orderBy('sort_order');
    }

    public function scopeVisible(Builder $query): void
    {
        $query->where('is_visible', true)->orderBy('sort_order');
    }
}
