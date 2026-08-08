<?php

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\Student;
use App\Models\StudentResult;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('public visitors can access student registration', function () {
    Course::factory()->create();

    $this->get(route('student-registrations.create'))
        ->assertSuccessful()
        ->assertSee('Student Registration')
        ->assertSee('Personal Information')
        ->assertSee('Address Information')
        ->assertSee('Academic Information')
        ->assertSee('Photo Upload')
        ->assertSee('Important Notes')
        ->assertSee('APPLICATION SUBMIT')
        ->assertSee('RESET FORM')
        ->assertSee('declaration')
        ->assertSee(route('student-registrations.store'));

    $this->get(route('home'))->assertSuccessful()->assertSee(route('student-registrations.create'));
});

test('public applicants must accept the declaration and can submit a registration', function () {
    Storage::fake('public');
    $course = Course::factory()->create();
    $payload = [
        'course_id' => $course->id, 'name' => 'Nusrat Jahan', 'father_name' => 'Abdul Karim', 'mother_name' => 'Rokeya Begum', 'address' => 'Savar, Dhaka', 'district' => 'Dhaka', 'upazila' => 'Savar', 'date_of_birth' => '2005-06-14', 'passport_nid_number' => 'NID-12345', 'phone' => '01700000000', 'gender' => 'Female', 'education_qualification' => 'HSC', 'duration' => '6 Months', 'session' => '2026', 'admitted_at' => '2026-01-01', 'expire_date' => '2026-06-30', 'image' => UploadedFile::fake()->image('nusrat.png'),
    ];

    $this->post(route('student-registrations.store'), $payload)
        ->assertSessionHasErrors('declaration');

    $this->post(route('student-registrations.store'), [...$payload, 'declaration' => '1', 'image' => UploadedFile::fake()->image('nusrat.png')])
        ->assertRedirect(route('student-registrations.create'));

    $student = Student::query()->where('name', 'Nusrat Jahan')->firstOrFail();
    expect($student->result_status)->toBe('Pending')->and($student->registration_number)->toStartWith('BNYTI-');
    Storage::disk('public')->assertExists($student->image_path);
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

test('super admins can print certificates with the latest published result', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $course = Course::factory()->create(['name' => 'Web Design and Development']);
    $student = Student::factory()->for($course)->create([
        'name' => 'Ayesha Rahman',
        'registration_number' => 'BNYTI-2026-001',
        'roll_number' => '101',
        'session' => 'Student Session',
        'father_name' => 'Abdul Rahman',
        'mother_name' => 'Salma Begum',
    ]);

    StudentResult::factory()->for($student)->create([
        'semester' => 'First Semester',
        'session' => '2025-2026',
        'gpa' => 3.00,
        'total_credit' => 10,
        'published_at' => '2026-07-15 10:00:00',
    ]);
    $latestResult = StudentResult::factory()->for($student)->create([
        'semester' => 'Final Semester',
        'session' => '2026-2027',
        'gpa' => 4.00,
        'total_credit' => 10,
        'published_at' => '2026-07-15 10:00:00',
    ]);

    $this->actingAs($superAdmin)
        ->get(route('super-admin.students.documents.show', [$student, 'certificate']))
        ->assertSuccessful()
        ->assertSeeText(sprintf('CERT-%06d', $latestResult->id))
        ->assertSeeText('BNYTI-2026-001')
        ->assertSeeText('2026-2027')
        ->assertSeeText('Ayesha Rahman')
        ->assertSeeText('Abdul Rahman')
        ->assertSeeText('Salma Begum')
        ->assertSeeText('Web Design and Development')
        ->assertSeeText('101')
        ->assertSeeText('Final Semester')
        ->assertSeeText('July 2026')
        ->assertSeeText('3.50')
        ->assertSeeText('15/07/2026')
        ->assertSee(asset('images/certificate-template.png'));
});

test('certificates safely display missing result information', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $student = Student::factory()->create([
        'registration_number' => null,
        'roll_number' => null,
        'session' => null,
        'father_name' => null,
        'mother_name' => null,
    ]);

    $this->actingAs($superAdmin)
        ->get(route('super-admin.students.documents.show', [$student, 'certificate']))
        ->assertSuccessful()
        ->assertSeeText('—')
        ->assertDontSeeText(now()->format('d/m/Y'));
});

test('super admins can print admit cards with student information', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $course = Course::factory()->create(['name' => 'Computer Office Application']);
    $student = Student::factory()->for($course)->create([
        'name' => 'Ayesha Rahman',
        'registration_number' => 'BNYTI-2026-001',
        'roll_number' => '101',
        'session' => '2026',
        'duration' => '6 Months',
        'father_name' => 'Abdul Rahman',
        'mother_name' => 'Salma Begum',
    ]);

    $this->actingAs($superAdmin)
        ->get(route('super-admin.students.documents.show', [$student, 'admit-card']))
        ->assertSuccessful()
        ->assertSeeText('Ayesha Rahman')
        ->assertSeeText('BNYTI-2026-001')
        ->assertSeeText('101')
        ->assertSeeText('Computer Office Application')
        ->assertSeeText('2026')
        ->assertSeeText('6 Months')
        ->assertSeeText('Abdul Rahman')
        ->assertSeeText('Salma Begum')
        ->assertSee(asset('images/admit-card-template.png'));
});

test('admit cards safely display missing optional student information', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $student = Student::factory()->create([
        'roll_number' => null,
        'session' => null,
        'duration' => null,
        'father_name' => null,
        'mother_name' => null,
        'image_path' => null,
    ]);

    $this->actingAs($superAdmin)
        ->get(route('super-admin.students.documents.show', [$student, 'admit-card']))
        ->assertSuccessful()
        ->assertSeeText('—')
        ->assertSeeText('No photo');
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
