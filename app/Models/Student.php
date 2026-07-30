<?php

namespace App\Models;

use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    /** @use HasFactory<StudentFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = ['course_id', 'name', 'registration_number', 'roll_number', 'father_name', 'mother_name', 'phone', 'email', 'gender', 'date_of_birth', 'address', 'district', 'upazila', 'passport_nid_number', 'education_qualification', 'duration', 'session', 'image_path', 'admitted_at', 'expire_date', 'result_status', 'grade', 'score'];

    protected function casts(): array
    {
        return ['admitted_at' => 'date', 'date_of_birth' => 'date', 'expire_date' => 'date', 'score' => 'decimal:2'];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(StudentResult::class);
    }
}
