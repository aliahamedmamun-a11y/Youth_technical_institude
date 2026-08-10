<?php

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentResult;
use App\Models\StudentResultSubject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
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

test('super admins can print testimonials with the latest published result', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $course = Course::factory()->create(['name' => 'Web Design and Development']);
    $student = Student::factory()->for($course)->create([
        'name' => 'Ayesha Rahman',
        'registration_number' => 'BNYTI-2026-001',
        'roll_number' => '101',
        'session' => 'Student Session',
        'father_name' => 'Abdul Rahman',
    ]);

    StudentResult::factory()->for($student)->create([
        'gpa' => 3.00,
        'total_credit' => 10,
        'published_at' => '2026-01-15 10:00:00',
    ]);
    $latestResult = StudentResult::factory()->for($student)->create([
        'session' => '2026-2027',
        'overall_grade' => 'A+',
        'gpa' => 4.00,
        'total_credit' => 10,
        'published_at' => '2026-07-15 10:00:00',
    ]);

    $this->actingAs($superAdmin)
        ->get(route('super-admin.students.documents.show', [$student, 'testimonial']))
        ->assertSuccessful()
        ->assertSee(asset('images/testimonial-template.png'))
        ->assertSeeText(sprintf('TEST-%06d', $latestResult->id))
        ->assertSeeText('Ayesha Rahman')
        ->assertSeeText('Abdul Rahman')
        ->assertSeeText('Web Design and Development')
        ->assertSeeText('A+')
        ->assertSeeText('3.50')
        ->assertSeeText('101')
        ->assertSeeText('BNYTI-2026-001')
        ->assertSeeText('2026-2027')
        ->assertSeeText('15/07/2026');
});

test('testimonials safely display missing result information', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $student = Student::factory()->create([
        'registration_number' => null,
        'roll_number' => null,
        'session' => null,
        'father_name' => null,
        'grade' => null,
    ]);

    $this->actingAs($superAdmin)
        ->get(route('super-admin.students.documents.show', [$student, 'testimonial']))
        ->assertSuccessful()
        ->assertSeeText('—')
        ->assertDontSeeText(now()->format('d/m/Y'));
});

test('certificate dynamic values use the dedicated Shelley font', function () {
    $certificateStyles = file_get_contents(resource_path('css/certificate.css'));

    expect(resource_path('css/fonts/certificate-shelle.ttf'))
        ->toBeFile()
        ->and($certificateStyles)
        ->toContain("font-family: 'Certificate Shelley';")
        ->toContain("font-family: 'Certificate Shelley', Georgia, 'Times New Roman', serif;")
        ->and(file_get_contents(resource_path('css/admit-card.css')))
        ->not->toContain('Certificate Shelley')
        ->and(file_get_contents(resource_path('css/registration-card.css')))
        ->not->toContain('Certificate Shelley');
});

test('documents use their dedicated dynamic value fonts', function () {
    $applicationStyles = file_get_contents(resource_path('css/app.css'));
    $admitCardStyles = file_get_contents(resource_path('css/admit-card.css'));
    $registrationCardStyles = file_get_contents(resource_path('css/registration-card.css'));
    $studentDocumentView = file_get_contents(resource_path('views/super-admin/students/document.blade.php'));

    expect(resource_path('css/fonts/document-monotype-corsiva-bold-italic.ttf'))
        ->toBeFile()
        ->and($applicationStyles)
        ->toContain("font-family: 'Document Corsiva';")
        ->toContain('.document-dynamic-value')
        ->and($admitCardStyles)
        ->toContain("font-family: Georgia, 'Times New Roman', serif;")
        ->not->toContain('Document Corsiva')
        ->and($registrationCardStyles)
        ->toContain("font-family: Georgia, 'Times New Roman', serif;")
        ->not->toContain('Document Corsiva')
        ->and($studentDocumentView)
        ->toContain('document-dynamic-value')
        ->and(file_get_contents(resource_path('css/certificate.css')))
        ->not->toContain('Document Corsiva')
        ->and(file_get_contents(resource_path('views/components/certificate.blade.php')))
        ->not->toContain('document-dynamic-value');
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

test('super admins can print a verified academic transcript with published results in semester order', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $course = Course::factory()->create(['name' => 'Computer Science and Technology']);
    $student = Student::factory()->for($course)->create([
        'name' => 'Ayesha Rahman',
        'registration_number' => 'BNYTI-2026-001',
        'roll_number' => '101',
    ]);
    $firstSemester = Semester::factory()->for($course)->create(['name' => 'First Semester', 'sort_order' => 1]);
    $secondSemester = Semester::factory()->for($course)->create(['name' => 'Second Semester', 'sort_order' => 2]);

    $secondResult = StudentResult::factory()->for($student)->create([
        'semester_id' => $secondSemester->id,
        'semester' => 'Second Semester',
        'session' => '2026-2027',
        'verification_token' => 'LATEST-VERIFY-TOKEN',
        'total_credit' => 3,
        'credit_earned' => 3,
        'gpa' => 4,
        'published_at' => '2026-07-15 10:00:00',
    ]);
    StudentResultSubject::factory()->for($secondResult, 'result')->create([
        'code' => 'CST-202',
        'title' => 'Database Management',
        'credit' => 3,
        'marks' => 88,
        'grade' => 'A+',
        'grade_point' => 4,
    ]);

    $firstResult = StudentResult::factory()->for($student)->create([
        'semester_id' => $firstSemester->id,
        'semester' => 'First Semester',
        'session' => '2025-2026',
        'verification_token' => 'FIRST-VERIFY-TOKEN',
        'total_credit' => 3,
        'credit_earned' => 3,
        'gpa' => 3,
        'published_at' => '2026-01-15 10:00:00',
    ]);
    StudentResultSubject::factory()->for($firstResult, 'result')->create([
        'code' => 'CST-101',
        'title' => 'Computer Fundamentals',
        'credit' => 3,
        'marks' => 72,
        'grade' => 'A-',
        'grade_point' => 3.5,
    ]);

    $draftResult = StudentResult::factory()->for($student)->create([
        'semester' => 'Draft Semester',
        'status' => 'draft',
        'published_at' => null,
    ]);
    StudentResultSubject::factory()->for($draftResult, 'result')->create(['title' => 'Unpublished Subject']);

    $this->actingAs($superAdmin)
        ->get(route('super-admin.students.documents.show', [$student, 'transcript']))
        ->assertSuccessful()
        ->assertSee(asset('images/academic-transcript-template.png'))
        ->assertSeeText('Ayesha Rahman')
        ->assertSeeText('BNYTI-2026-001')
        ->assertSeeText('Computer Science and Technology')
        ->assertSeeTextInOrder(['First Semester', 'Second Semester'])
        ->assertSeeText('Computer Fundamentals')
        ->assertSeeText('Database Management')
        ->assertSeeText('Marks')
        ->assertSeeText('Grade Point')
        ->assertSeeText('Total Credits')
        ->assertSeeText('Credits Earned')
        ->assertSeeText('CGPA')
        ->assertSeeText('3.50')
        ->assertSeeText('LATEST-VERIFY-TOKEN')
        ->assertSee(route('results.show', 'LATEST-VERIFY-TOKEN'))
        ->assertSee('data:image/png;base64,', false)
        ->assertDontSeeText('Draft Semester')
        ->assertDontSeeText('Unpublished Subject');
});

test('academic transcripts paginate semesters after twelve subjects', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $course = Course::factory()->create();
    $student = Student::factory()->for($course)->create();
    $semester = Semester::factory()->for($course)->create(['name' => 'First Semester', 'sort_order' => 1]);
    $result = StudentResult::factory()->for($student)->create([
        'semester_id' => $semester->id,
        'semester' => 'First Semester',
        'total_credit' => 39,
        'credit_earned' => 39,
    ]);

    foreach (range(1, 13) as $subjectNumber) {
        StudentResultSubject::factory()->for($result, 'result')->create([
            'code' => sprintf('CST-%03d', $subjectNumber),
            'title' => sprintf('Transcript Subject %02d', $subjectNumber),
            'sort_order' => $subjectNumber,
        ]);
    }

    $response = $this->actingAs($superAdmin)
        ->get(route('super-admin.students.documents.show', [$student, 'transcript']))
        ->assertSuccessful()
        ->assertSeeText('Page 1 of 2')
        ->assertSeeText('Page 2 of 2')
        ->assertSeeText('Continuation')
        ->assertSeeText('Transcript Subject 13');

    expect(substr_count($response->getContent(), 'data-transcript-page'))->toBe(2);
});

test('academic transcripts safely display students without published results', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $student = Student::factory()->create(['name' => 'Nusrat Jahan']);

    StudentResult::factory()->for($student)->create([
        'status' => 'draft',
        'published_at' => null,
        'verification_token' => 'DRAFT-VERIFY-TOKEN',
    ]);

    $this->actingAs($superAdmin)
        ->get(route('super-admin.students.documents.show', [$student, 'transcript']))
        ->assertSuccessful()
        ->assertSeeText('Nusrat Jahan')
        ->assertSeeText('No published results available')
        ->assertDontSeeText('DRAFT-VERIFY-TOKEN')
        ->assertDontSee('data:image/png;base64,', false);
});

test('super admins can print admit cards with student information', function () {
    $this->travelTo(Carbon::parse('2026-08-01 10:00:00'));

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
        'date_of_birth' => '2005-06-14',
        'gender' => 'Female',
        'image_path' => 'students/ayesha.png',
    ]);

    $this->actingAs($superAdmin)
        ->get(route('super-admin.students.documents.show', [$student, 'admit-card']))
        ->assertSuccessful()
        ->assertSeeText(sprintf('STU-%06d', $student->id))
        ->assertSeeText('BR-5667655')
        ->assertSeeText('Titas Technical Training Center')
        ->assertSeeText('Ayesha Rahman')
        ->assertSeeText('Abdul Rahman')
        ->assertSeeText('Salma Begum')
        ->assertSeeText('14 Jun 2005')
        ->assertSeeText('2026')
        ->assertSeeText('Computer Office Application')
        ->assertSeeText('101')
        ->assertSeeText('BNYTI-2026-001')
        ->assertSeeText('Female')
        ->assertSeeText('Regular')
        ->assertSeeText('1 Aug 2026')
        ->assertSee(asset('storage/students/ayesha.png'))
        ->assertSee(route('home'))
        ->assertSee('data:image/png;base64,', false)
        ->assertSeeText('Scan to Verify')
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
        'date_of_birth' => null,
        'gender' => null,
        'image_path' => null,
    ]);

    $this->actingAs($superAdmin)
        ->get(route('super-admin.students.documents.show', [$student, 'admit-card']))
        ->assertSuccessful()
        ->assertSeeText('—')
        ->assertSeeText('No photo');
});

test('super admins can print registration cards with student information', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $course = Course::factory()->create(['name' => 'Computer Office Application']);
    $student = Student::factory()->for($course)->create([
        'name' => 'Ayesha Rahman',
        'registration_number' => 'BNYTI-2026-001',
        'session' => '2026',
        'duration' => '6 Months',
        'father_name' => 'Abdul Rahman',
        'mother_name' => 'Salma Begum',
        'date_of_birth' => '2005-06-14',
        'gender' => 'Female',
        'admitted_at' => '2026-01-05',
        'expire_date' => '2026-07-05',
        'phone' => '01720000001',
        'email' => 'ayesha@example.test',
        'district' => 'Dhaka',
        'upazila' => 'Mirpur',
        'education_qualification' => 'HSC',
        'passport_nid_number' => 'NID-123456',
        'address' => 'Mirpur, Dhaka',
        'image_path' => 'students/ayesha.png',
    ]);

    $this->actingAs($superAdmin)
        ->get(route('super-admin.students.documents.show', [$student, 'registration-card']))
        ->assertSuccessful()
        ->assertSeeText(sprintf('STU-%06d', $student->id))
        ->assertSeeText('BR-5667655')
        ->assertSeeText('Titas Technical Training Center')
        ->assertSeeText('Ayesha Rahman')
        ->assertSeeText('BNYTI-2026-001')
        ->assertSeeText('Computer Office Application')
        ->assertSeeText('2026')
        ->assertSeeText('6 Months')
        ->assertSeeText('Abdul Rahman')
        ->assertSeeText('Salma Begum')
        ->assertSeeText('14 Jun 2005')
        ->assertSeeText('Female')
        ->assertSeeText('Dhaka')
        ->assertSeeText('Mirpur')
        ->assertDontSeeText('05 Jan 2026')
        ->assertDontSeeText('05 Jul 2026')
        ->assertDontSeeText('01720000001')
        ->assertDontSeeText('ayesha@example.test')
        ->assertDontSeeText('HSC')
        ->assertDontSeeText('NID-123456')
        ->assertDontSeeText('Mirpur, Dhaka')
        ->assertSee(asset('storage/students/ayesha.png'))
        ->assertSee(route('home'))
        ->assertSee('data:image/png;base64,', false)
        ->assertSeeText('Scan to Verify')
        ->assertSee(asset('images/registration-card-template.png'));
});

test('registration cards safely display missing optional student information', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $student = Student::factory()->create([
        'registration_number' => null,
        'roll_number' => null,
        'session' => null,
        'duration' => null,
        'father_name' => null,
        'mother_name' => null,
        'date_of_birth' => null,
        'gender' => null,
        'expire_date' => null,
        'email' => null,
        'district' => null,
        'upazila' => null,
        'education_qualification' => null,
        'passport_nid_number' => null,
        'address' => null,
        'image_path' => null,
    ]);

    $this->actingAs($superAdmin)
        ->get(route('super-admin.students.documents.show', [$student, 'registration-card']))
        ->assertSuccessful()
        ->assertSeeText('—')
        ->assertSeeText('No photo')
        ->assertDontSeeText(now()->format('d M Y'));
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
