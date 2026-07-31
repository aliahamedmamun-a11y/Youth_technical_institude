<?php

namespace App\Models;

use Database\Factories\SubjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    /** @use HasFactory<SubjectFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = ['semester_id', 'code', 'title', 'credit', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['credit' => 'decimal:2', 'is_active' => 'boolean'];
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }
}
