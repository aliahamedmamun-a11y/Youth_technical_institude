<?php

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('public visitors can access student registration', function () {
    Course::factory()->create();

    $this->get(route('student-registrations.create'))
        ->assertSuccessful()
        ->assertSee('Student registration')
        ->assertSee(route('student-registrations.store'));

    $this->get(route('home'))->assertSuccessful()->assertSee(route('student-registrations.create'));
});

test('super admins can add and update students', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $course = Course::factory()->create();

    $this->actingAs($superAdmin)->post(route('super-admin.students.store'), [
        'course_id' => $course->id, 'name' => 'Ayesha Rahman', 'father_name' => 'Abdul Rahman', 'mother_name' => 'Salma Begum', 'address' => 'Batiaghata, Khulna', 'district' => 'Khulna', 'upazila' => 'Batiaghata', 'date_of_birth' => '2005-06-14', 'passport_nid_number' => 'NID-123', 'phone' => '01700000000', 'gender' => 'Female', 'education_qualification' => 'HSC', 'duration' => '6 Months', 'session' => '2026', 'admitted_at' => '2026-01-01', 'expire_date' => '2026-06-30', 'image' => UploadedFile::fake()->image('ayesha.png'),
    ])->assertRedirect(route('super-admin.students.index'));

    $student = Student::query()->firstOrFail();
    expect($student)->name->toBe('Ayesha Rahman');

    $this->actingAs($superAdmin)->put(route('super-admin.students.update', $student), [
        'course_id' => $course->id, 'name' => 'Ayesha Rahman', 'father_name' => 'Abdul Rahman', 'mother_name' => 'Salma Begum', 'address' => 'Dumuria, Khulna', 'district' => 'Khulna', 'upazila' => 'Dumuria', 'date_of_birth' => '2005-06-14', 'passport_nid_number' => 'NID-123', 'phone' => '01700000000', 'gender' => 'Female', 'education_qualification' => 'HSC', 'duration' => '6 Months', 'session' => '2026', 'admitted_at' => '2026-01-01', 'expire_date' => '2026-07-01',
    ])->assertRedirect(route('super-admin.students.show', $student));

    expect($student->refresh())->upazila->toBe('Dumuria')->expire_date->format('Y-m-d')->toBe('2026-07-01');
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
        'course_id' => $course->id, 'name' => 'Mim Akter', 'father_name' => 'Abdul Karim', 'mother_name' => 'Rokeya Begum', 'address' => 'Savar, Dhaka', 'district' => 'Dhaka', 'upazila' => 'Savar', 'date_of_birth' => '2006-01-01', 'passport_nid_number' => 'NID-900', 'phone' => '01700000000', 'gender' => 'Female', 'education_qualification' => 'SSC', 'duration' => '6 Months', 'session' => '2026', 'admitted_at' => '2026-01-01', 'expire_date' => '2026-06-30', 'image' => UploadedFile::fake()->image('mim.png'),
    ])->assertRedirect(route('super-admin.students.index'));

    $student = Student::query()->firstOrFail();
    Storage::disk('public')->assertExists($student->image_path);
});
