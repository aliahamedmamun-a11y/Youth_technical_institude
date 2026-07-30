<?php

namespace App\Models;

use Database\Factories\StudentResultSubjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentResultSubject extends Model
{
    /** @use HasFactory<StudentResultSubjectFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = ['student_result_id', 'code', 'title', 'credit', 'marks', 'grade', 'grade_point', 'sort_order'];

    protected function casts(): array
    {
        return ['credit' => 'decimal:2', 'marks' => 'decimal:2', 'grade_point' => 'decimal:2'];
    }

    public function result(): BelongsTo
    {
        return $this->belongsTo(StudentResult::class, 'student_result_id');
    }
}
