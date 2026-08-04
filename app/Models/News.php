<?php

namespace App\Models;

use Database\Factories\NewsFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class News extends Model
{
    /** @use HasFactory<NewsFactory> */
    use HasFactory;

    protected $fillable = ['created_by', 'title', 'slug', 'excerpt', 'content', 'image_path', 'published_at', 'is_published'];

    protected function casts(): array
    {
        return ['published_at' => 'datetime', 'is_published' => 'boolean'];
    }

    protected static function booted(): void
    {
        static::creating(function (News $news): void {
            $news->slug ??= Str::slug($news->title);
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true)->whereNotNull('published_at');
    }
}
