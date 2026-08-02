<?php

namespace App\Models;

use Database\Factories\StudentSemesterEnrollmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentSemesterEnrollment extends Model
{
    /** @use HasFactory<StudentSemesterEnrollmentFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = ['student_id', 'semester_id', 'status', 'assigned_at'];

    protected function casts(): array
    {
        return ['assigned_at' => 'datetime'];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(StudentSemesterSubject::class)->orderBy('sort_order');
    }

    public function results(): HasMany
    {
        return $this->hasMany(StudentResult::class);
    }
}
