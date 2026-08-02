<?php

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentResult;
use App\Models\StudentSemesterEnrollment;
use App\Models\User;
use App\Services\ResultGradingService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function enrollmentSetup(): array
{
    $course = Course::factory()->create();
    $otherCourse = Course::factory()->create();
    $student = Student::factory()->for($course)->create();
    $semester = Semester::factory()->for($course)->create();
    $otherSemester = Semester::factory()->for($otherCourse)->create();
    $otherSubject = $otherSemester->subjects()->create(['code' => '201', 'title' => 'Other Department Subject', 'credit' => 3, 'sort_order' => 0, 'is_active' => true]);
    $subjects = collect($semester->subjects()->createMany([
        ['code' => '101', 'title' => 'Fundamentals', 'credit' => 3, 'sort_order' => 0, 'is_active' => true],
        ['code' => '102', 'title' => 'Applications', 'credit' => 4, 'sort_order' => 1, 'is_active' => true],
    ]));

    return compact('course', 'otherCourse', 'student', 'semester', 'otherSemester', 'otherSubject', 'subjects');
}

test('admin can assign only a semester from the student department and select subjects', function () {
    $admin = User::factory()->role(UserRole::SuperAdmin)->create();
    $data = enrollmentSetup();

    $this->actingAs($admin)->post(route('super-admin.students.semester-enrollments.store', $data['student']), [
        'semester_id' => $data['otherSemester']->id,
        'subjects' => [$data['otherSubject']->id],
    ])->assertNotFound();

    $this->actingAs($admin)->post(route('super-admin.students.semester-enrollments.store', $data['student']), [
        'semester_id' => $data['semester']->id,
        'subjects' => [$data['subjects'][0]->id],
    ])->assertRedirect();

    $enrollment = StudentSemesterEnrollment::query()->firstOrFail();
    expect($enrollment->subjects)->toHaveCount(1)
        ->and($enrollment->subjects->first()->code)->toBe('101');

    $this->actingAs($admin)->post(route('super-admin.students.semester-enrollments.store', $data['student']), [
        'semester_id' => $data['semester']->id,
        'subjects' => [$data['subjects'][0]->id],
    ])->assertSessionHasErrors('semester_id');
});

test('marks are graded at every boundary and the weighted semester gpa is calculated', function () {
    $admin = User::factory()->role(UserRole::SuperAdmin)->create();
    $data = enrollmentSetup();
    $enrollment = StudentSemesterEnrollment::factory()->for($data['student'])->for($data['semester'])->create();
    $enrollment->subjects()->createMany($data['subjects']->map(fn ($subject): array => [
        'subject_id' => $subject->id,
        'code' => $subject->code,
        'title' => $subject->title,
        'credit' => $subject->credit,
        'sort_order' => $subject->sort_order,
    ])->all());

    $response = $this->actingAs($admin)->post(route('super-admin.enrollments.results.store', $enrollment), [
        'session' => '2026',
        'status' => 'published',
        'subjects' => [
            ['id' => $enrollment->subjects[0]->id, 'marks' => 80],
            ['id' => $enrollment->subjects[1]->id, 'marks' => 75],
        ],
    ]);

    $response->assertRedirect();
    $result = StudentResult::query()->with('subjects')->firstOrFail();
    expect($result->subjects->pluck('grade')->all())->toBe(['A+', 'A'])
        ->and($result->subjects->pluck('grade_point')->map(fn ($point): float => (float) $point)->all())->toBe([4.0, 3.75])
        ->and((float) $result->gpa)->toBe(3.86)
        ->and((float) $result->total_credit)->toBe(7.0)
        ->and((float) $result->credit_earned)->toBe(7.0);
});

test('invalid marks are rejected and incomplete published results are blocked', function () {
    $admin = User::factory()->role(UserRole::SuperAdmin)->create();
    $data = enrollmentSetup();
    $enrollment = StudentSemesterEnrollment::factory()->for($data['student'])->for($data['semester'])->create();
    $enrollment->subjects()->createMany($data['subjects']->map(fn ($subject): array => [
        'subject_id' => $subject->id, 'code' => $subject->code, 'title' => $subject->title, 'credit' => $subject->credit, 'sort_order' => $subject->sort_order,
    ])->all());

    $this->actingAs($admin)->post(route('super-admin.enrollments.results.store', $enrollment), [
        'session' => '2026', 'status' => 'published', 'subjects' => [['id' => $enrollment->subjects[0]->id, 'marks' => 101]],
    ])->assertSessionHasErrors('subjects.0.marks');

    $this->actingAs($admin)->post(route('super-admin.enrollments.results.store', $enrollment), [
        'session' => '2026', 'status' => 'published', 'subjects' => [['id' => $enrollment->subjects[0]->id, 'marks' => 80], ['id' => $enrollment->subjects[1]->id]],
    ])->assertSessionHasErrors('subjects');
});

test('cumulative cgpa uses published results weighted by credits', function () {
    $data = enrollmentSetup();
    $student = $data['student'];
    $first = StudentResult::factory()->for($student)->create(['status' => 'published', 'total_credit' => 3, 'gpa' => 4]);
    StudentResult::factory()->for($student)->create(['status' => 'published', 'total_credit' => 5, 'gpa' => 3]);
    StudentResult::factory()->for($student)->create(['status' => 'draft', 'total_credit' => 10, 'gpa' => 1]);

    expect(app(ResultGradingService::class)->cumulativeGpa($student))->toBe(3.38);
});

test('non-admins cannot assign semesters', function () {
    $data = enrollmentSetup();
    $user = User::factory()->role(UserRole::Editor)->create();

    $this->actingAs($user)->get(route('super-admin.students.semester-enrollments.index', $data['student']))->assertForbidden();
});
