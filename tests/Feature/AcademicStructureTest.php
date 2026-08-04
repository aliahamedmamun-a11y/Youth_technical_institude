<?php

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentResult;
use App\Models\Subject;
use App\Models\User;
use Database\Seeders\AcademicDataSeeder;
use Database\Seeders\AcademicStructureSeeder;
use Database\Seeders\StudentResultSeeder;
use Database\Seeders\StudentSemesterEnrollmentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('academic structure seeding is complete and idempotent', function () {
    $this->seed(AcademicDataSeeder::class);
    $this->seed(AcademicStructureSeeder::class);

    expect(Course::query()->count())->toBe(3)
        ->and(Semester::query()->count())->toBe(24)
        ->and(Subject::query()->count())->toBe(120)
        ->and(Semester::query()->withCount('subjects')->get()->every(fn (Semester $semester): bool => $semester->subjects_count >= 5))->toBeTrue();

    $semester = Semester::query()->where('name', 'First Semester')->firstOrFail();
    expect($semester->subjects()->pluck('sort_order')->all())->toBe([0, 1, 2, 3, 4])
        ->and($semester->subjects()->pluck('code')->unique()->count())->toBe(5);

    $this->seed(AcademicDataSeeder::class);
    $this->seed(AcademicStructureSeeder::class);

    expect(Course::query()->count())->toBe(3)
        ->and(Semester::query()->count())->toBe(24)
        ->and(Subject::query()->count())->toBe(120);
});

test('student semester enrollment seeding assigns every semester subject idempotently', function () {
    $this->seed(AcademicDataSeeder::class);
    $this->seed(AcademicStructureSeeder::class);
    $this->seed(StudentSemesterEnrollmentSeeder::class);
    $this->seed(StudentSemesterEnrollmentSeeder::class);

    $students = Student::query()->with('course.semesters', 'semesterEnrollments.subjects')->get();

    foreach ($students as $student) {
        expect($student->semesterEnrollments)->toHaveCount($student->course->semesters->count());

        foreach ($student->semesterEnrollments as $enrollment) {
            expect($enrollment->subjects)->toHaveCount($enrollment->semester()->with('subjects')->first()->subjects->count());
            expect($enrollment->subjects)->toHaveCount(5);
        }
    }
});

test('sample result seeding snapshots the configured semester subjects', function () {
    $this->seed(AcademicDataSeeder::class);
    $this->seed(AcademicStructureSeeder::class);
    $this->seed(StudentResultSeeder::class);

    expect(StudentResult::query()->count())->toBe(24);

    foreach (Student::query()->with('course')->get() as $student) {
        $result = StudentResult::query()->whereBelongsTo($student)->where('semester', 'First Semester')->with(['semesterDefinition', 'subjects'])->firstOrFail();

        expect($result->semesterDefinition->name)->toBe('First Semester')
            ->and($result->subjects)->toHaveCount(5)
            ->and($result->subjects->pluck('code')->all())->toBe($result->semesterDefinition->subjects()->pluck('code')->all())
            ->and((float) $result->total_credit)->toBe(17.0)
            ->and($result->isPublished())->toBeTrue()
            ->and($result->subjects->every(fn ($subject): bool => $subject->marks !== null && $subject->grade !== null && $subject->grade_point !== null && $subject->marks >= 0 && $subject->marks <= 100))->toBeTrue();
    }
});

test('super admins can manage course semesters and subjects', function () {
    $admin = User::factory()->role(UserRole::SuperAdmin)->create();
    $course = Course::factory()->create();

    $this->actingAs($admin)->get(route('super-admin.semester-setup.index'))->assertSuccessful()->assertSee('Semester Setup')->assertSee('Manage semesters');

    $this->actingAs($admin)->post(route('super-admin.courses.semesters.store', $course), [
        'course_id' => $course->id,
        'name' => 'First Year First Semester',
        'sort_order' => 1,
        'is_active' => 1,
    ])->assertRedirect();

    $semester = Semester::query()->firstOrFail();
    $this->actingAs($admin)->post(route('super-admin.semesters.subjects.store', $semester), [
        'semester_id' => $semester->id,
        'code' => '1582',
        'title' => 'History of the Emergence of Independent Bangladesh',
        'credit' => 4,
        'sort_order' => 1,
        'is_active' => 1,
    ])->assertRedirect();

    $this->assertModelExists($semester);
    $this->assertModelExists(Subject::query()->firstOrFail());
    $this->actingAs($admin)->post(route('super-admin.semesters.subjects.store', $semester), [
        'semester_id' => $semester->id,
        'code' => '1582',
        'title' => 'Duplicate',
        'credit' => 4,
        'sort_order' => 2,
    ])->assertSessionHasErrors('code');
});

test('results use the selected course semester and preserve subject snapshots', function () {
    $admin = User::factory()->role(UserRole::SuperAdmin)->create();
    $course = Course::factory()->create();
    $semester = Semester::factory()->for($course)->create(['name' => 'Fourth Year']);
    $subject = Subject::factory()->for($semester)->create(['code' => '1990', 'title' => 'Viva-Voce + Term Paper', 'credit' => 4]);
    $student = Student::factory()->for($course)->create();

    $this->actingAs($admin)->get(route('super-admin.students.results.create', $student))->assertSuccessful()->assertSee('Fourth Year')->assertSee('Viva-Voce + Term Paper');

    $this->actingAs($admin)->post(route('super-admin.students.results.store'), [
        'student_id' => $student->id,
        'semester_id' => $semester->id,
        'session' => '2026',
        'status' => 'published',
        'subjects' => [['code' => $subject->code, 'title' => $subject->title, 'credit' => 4, 'marks' => 90, 'grade' => 'A+', 'grade_point' => 4]],
    ])->assertRedirect();

    $result = StudentResult::query()->with('subjects')->firstOrFail();
    expect($result->semester_id)->toBe($semester->id)->and($result->subjects->first()->title)->toBe('Viva-Voce + Term Paper');

    $subject->update(['title' => 'Changed curriculum title']);
    expect($result->refresh()->subjects->first()->title)->toBe('Viva-Voce + Term Paper');
});
