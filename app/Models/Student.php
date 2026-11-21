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
    protected $fillable = [
        'branch_id',
        'course_id',
        'name',
        'registration_number',
        'roll_number',
        'certificate_serial',
        'father_name',
        'mother_name',
        'phone',
        'email',
        'gender',
        'religion',
        'date_of_birth',
        'address',
        'district',
        'upazila',
        'passport_nid_number',
        'education_qualification',
        'duration',

        'start_month',
        'end_month',
        'start_year',
        'end_year',

        'session',
        'image_path',
        'admitted_at',
        'expire_date',
        'director_name',
        'institute_name',
        'full_marks',
        'written_marks',
        'viva_marks',
        'practical_marks',
        'cgpa',
        'publication_date',
        'examination_month',
        'result_status',
        'grade',
        'score',
    ];

    protected function casts(): array
    {
        return [
            'admitted_at' => 'date',
            'date_of_birth' => 'date',
            'expire_date' => 'date',
            'score' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Student $student): void {
            if (empty($student->registration_number) || str_contains((string) $student->registration_number, '202611')) {
                do {
                    $reg = (string) random_int(10000000, 99999999);
                } while (static::query()->where('registration_number', $reg)->exists());
                $student->registration_number = $reg;
            }

            if (empty($student->roll_number)) {
                do {
                    $roll = (string) random_int(100000, 999999);
                } while (static::query()->where('roll_number', $roll)->exists());
                $student->roll_number = $roll;
            }
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(StudentResult::class);
    }

    public function semesterEnrollments(): HasMany
    {
        return $this->hasMany(StudentSemesterEnrollment::class);
    }
}
