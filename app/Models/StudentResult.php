<?php

namespace App\Models;

use Database\Factories\StudentResultFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentResult extends Model
{
    /** @use HasFactory<StudentResultFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = ['student_id', 'semester', 'session', 'status', 'verification_token', 'total_credit', 'credit_earned', 'gpa', 'overall_grade', 'published_at'];

    protected function casts(): array
    {
        return ['total_credit' => 'decimal:2', 'credit_earned' => 'decimal:2', 'gpa' => 'decimal:2', 'published_at' => 'datetime'];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(StudentResultSubject::class)->orderBy('sort_order');
    }

    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->published_at !== null;
    }
}
