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
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('academic structure seeding is complete and idempotent', function () {
    $this->seed(AcademicDataSeeder::class);
    $this->seed(AcademicStructureSeeder::class);

    expect(Course::query()->count())->toBe(3)
        ->and(Semester::query()->count())->toBe(6)
        ->and(Subject::query()->count())->toBe(24);

    $semester = Semester::query()->where('name', 'First Semester')->firstOrFail();
    expect($semester->subjects()->pluck('sort_order')->all())->toBe([0, 1, 2, 3])
        ->and($semester->subjects()->pluck('code')->unique()->count())->toBe(4);

    $this->seed(AcademicDataSeeder::class);
    $this->seed(AcademicStructureSeeder::class);

    expect(Course::query()->count())->toBe(3)
        ->and(Semester::query()->count())->toBe(6)
        ->and(Subject::query()->count())->toBe(24);
});

test('sample result seeding snapshots the configured semester subjects', function () {
    $this->seed(AcademicDataSeeder::class);
    $this->seed(AcademicStructureSeeder::class);
    $this->seed(StudentResultSeeder::class);

    $student = Student::query()->firstOrFail();
    $result = StudentResult::query()->whereBelongsTo($student)->with(['semesterDefinition', 'subjects'])->firstOrFail();

    expect($result->semesterDefinition->name)->toBe('First Semester')
        ->and($result->subjects)->toHaveCount(4)
        ->and($result->subjects->pluck('code')->all())->toBe($result->semesterDefinition->subjects()->pluck('code')->all())
        ->and((float) $result->total_credit)->toBe(14.0);
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
