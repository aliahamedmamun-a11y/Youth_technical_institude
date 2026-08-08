<?php

namespace App\Models;

use Database\Factories\HomepageItemFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomepageItem extends Model
{
    /** @use HasFactory<HomepageItemFactory> */
    use HasFactory;

    protected $fillable = ['homepage_section_id', 'stable_key', 'title', 'subtitle', 'body', 'image_path', 'icon', 'link_label', 'link_url', 'metadata', 'sort_order', 'is_published'];

    protected function casts(): array
    {
        return ['metadata' => 'array', 'is_published' => 'boolean'];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(HomepageSection::class, 'homepage_section_id');
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true)->orderBy('sort_order');
    }
}
