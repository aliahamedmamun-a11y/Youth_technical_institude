<?php

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\Student;
use App\Models\StudentResult;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function resultSubjects(): array
{
    return [
        ['code' => '101', 'title' => 'Principles of Management', 'credit' => 4, 'marks' => 72, 'grade' => 'B', 'grade_point' => 3],
        ['code' => '102', 'title' => 'Business Communication', 'credit' => 3, 'marks' => 86, 'grade' => 'A+', 'grade_point' => 4],
    ];
}

test('super admins can create and calculate a student result', function () {
    $admin = User::factory()->role(UserRole::SuperAdmin)->create();
    $course = Course::factory()->create();
    $student = Student::factory()->create(['course_id' => $course->id]);

    $this->actingAs($admin)->post(route('super-admin.students.results.store'), [
        'student_id' => $student->id,
        'semester' => 'First Year First Semester',
        'session' => '2026',
        'status' => 'published',
        'subjects' => resultSubjects(),
    ])->assertRedirect(route('super-admin.students.results.index', $student));

    $result = StudentResult::query()->with('subjects')->firstOrFail();
    expect($result->total_credit)->toBe('7.00')
        ->and($result->credit_earned)->toBe('7.00')
        ->and($result->gpa)->toBe('3.43')
        ->and($result->overall_grade)->toBe('B+')
        ->and($result->isPublished())->toBeTrue()
        ->and($result->subjects)->toHaveCount(2);

    $this->actingAs($admin)->get(route('super-admin.results.show', $result))->assertSuccessful()->assertSee('RESULT SHEET')->assertSee('Print result');

    $this->actingAs($admin)->put(route('super-admin.results.update', $result), [
        'semester' => 'First Year First Semester',
        'session' => '2026',
        'status' => 'draft',
        'subjects' => resultSubjects(),
    ])->assertRedirect(route('super-admin.students.results.index', $student));

    expect($result->refresh()->status)->toBe('draft');

    $this->actingAs($admin)->delete(route('super-admin.results.destroy', $result))->assertRedirect(route('super-admin.students.results.index', $student));
    expect(StudentResult::query()->whereKey($result->id)->exists())->toBeFalse();
});

test('public users can find and verify only published results', function () {
    $student = Student::factory()->create();
    $published = StudentResult::factory()->for($student)->create(['status' => 'published', 'published_at' => now()]);
    StudentResult::factory()->for($student)->create(['status' => 'draft', 'published_at' => null]);

    $this->get(route('results.index', ['roll_number' => $student->roll_number]))
        ->assertRedirect(route('results.show', $published->verification_token));

    $this->get(route('results.show', $published->verification_token))
        ->assertSuccessful()
        ->assertSee('RESULT SHEET')
        ->assertSee($student->name)
        ->assertSee('SCAN TO VERIFY');

    $this->get(route('results.show', 'invalid-token'))->assertNotFound();
});

test('the public result portal uses roll number lookup and rejects unmatched searches', function () {
    $student = Student::factory()->create(['roll_number' => '412005']);

    $this->get(route('results.index'))
        ->assertSuccessful()
        ->assertSee('STUDENT')
        ->assertSee('RESULT')
        ->assertSee('PORTAL')
        ->assertSee('Enter Your Roll Number')
        ->assertSee('FAST &amp; EASY', false)
        ->assertSee('TRUSTED INSTITUTE');

    $this->get(route('results.index', ['roll_number' => '999999']))
        ->assertSuccessful()
        ->assertSee('No published result was found for this Roll Number.');

    $this->get(route('results.index', ['roll_number' => '']))
        ->assertSessionHasErrors('roll_number');
});

test('student roll numbers are unique when managed by administrators', function () {
    $admin = User::factory()->role(UserRole::SuperAdmin)->create();
    $existing = Student::factory()->create(['roll_number' => '412005']);
    $duplicate = Student::factory()->make(['roll_number' => $existing->roll_number]);

    $this->actingAs($admin)
        ->put(route('super-admin.students.update', $existing), [
            ...$duplicate->only(['course_id', 'name', 'father_name', 'mother_name', 'address', 'district', 'upazila', 'date_of_birth', 'passport_nid_number', 'phone', 'gender', 'education_qualification', 'duration', 'session', 'admitted_at', 'expire_date']),
            'roll_number' => '412006',
        ]);

    expect($existing->refresh()->roll_number)->toBe('412006');
});

test('non-super-admins cannot manage student results', function () {
    $branchUser = User::factory()->role(UserRole::Branch)->create();
    $student = Student::factory()->create();

    $this->actingAs($branchUser)->get(route('super-admin.students.results.index', $student))->assertForbidden();
});
