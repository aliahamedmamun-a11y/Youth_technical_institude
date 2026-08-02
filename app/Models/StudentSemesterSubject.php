<?php

namespace App\Models;

use Database\Factories\StudentSemesterSubjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentSemesterSubject extends Model
{
    /** @use HasFactory<StudentSemesterSubjectFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = ['student_semester_enrollment_id', 'subject_id', 'code', 'title', 'credit', 'sort_order'];

    protected function casts(): array
    {
        return ['credit' => 'decimal:2'];
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(StudentSemesterEnrollment::class, 'student_semester_enrollment_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
