<?php

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('super admins can add and update students', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $course = Course::factory()->create();

    $this->actingAs($superAdmin)->post(route('super-admin.students.store'), [
        'course_id' => $course->id, 'name' => 'Ayesha Rahman', 'registration_number' => 'BNYTI-2026-001', 'phone' => '01700000000', 'admitted_at' => '2026-01-01', 'result_status' => 'Pending',
    ])->assertRedirect(route('super-admin.students.index'));

    $student = Student::query()->firstOrFail();
    expect($student)->name->toBe('Ayesha Rahman');

    $this->actingAs($superAdmin)->put(route('super-admin.students.update', $student), [
        'course_id' => $course->id, 'name' => 'Ayesha Rahman', 'registration_number' => 'BNYTI-2026-001', 'phone' => '01700000000', 'admitted_at' => '2026-01-01', 'result_status' => 'Passed', 'grade' => 'A+', 'score' => 90,
    ])->assertRedirect(route('super-admin.students.show', $student));

    expect($student->refresh())->result_status->toBe('Passed')->grade->toBe('A+');
});

test('super admins can access student documents', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $student = Student::factory()->create();

    $this->actingAs($superAdmin)->get(route('super-admin.students.documents.show', [$student, 'certificate']))
        ->assertSuccessful()->assertSee('Certificate')->assertSee($student->name);
});

test('non-super-admins cannot access student management', function () {
    $branchUser = User::factory()->role(UserRole::Branch)->create();

    $this->actingAs($branchUser)->get(route('super-admin.students.index'))->assertForbidden();
});

test('super admins can upload a student photo', function () {
    Storage::fake('public');
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $course = Course::factory()->create();

    $this->actingAs($superAdmin)->post(route('super-admin.students.store'), [
        'course_id' => $course->id, 'name' => 'Mim Akter', 'registration_number' => 'BNYTI-2026-900', 'phone' => '01700000000', 'admitted_at' => '2026-01-01', 'result_status' => 'Pending', 'image' => UploadedFile::fake()->image('mim.png'),
    ])->assertRedirect(route('super-admin.students.index'));

    $student = Student::query()->firstOrFail();
    Storage::disk('public')->assertExists($student->image_path);
});
