<?php

namespace App\Models;

use Database\Factories\InstituteProfileFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InstituteProfile extends Model
{
    /** @use HasFactory<InstituteProfileFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = ['slug', 'about_heading', 'summary', 'content', 'principal_name', 'principal_title', 'principal_image_path', 'image_path', 'sort_order', 'is_active', 'is_published'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'is_published' => 'boolean'];
    }

    protected static function booted(): void
    {
        static::saving(function (InstituteProfile $profile): void {
            if ($profile->isDirty('about_heading') || blank($profile->slug)) {
                $baseSlug = Str::slug($profile->about_heading);
                $slug = $baseSlug;
                $suffix = 2;

                while (static::query()->where('slug', $slug)->whereKeyNot($profile->getKey())->exists()) {
                    $slug = $baseSlug.'-'.$suffix++;
                }

                $profile->slug = $slug;
            }
        });
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_active', true)->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->latest();
    }
}
