<?php

use App\Enums\BranchApplicationStatus;
use App\Enums\UserRole;
use App\Models\BranchApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('people can submit a complete branch registration', function () {
    Storage::fake('public');

    $this->post(route('branch-applications.store'), ['director_name' => 'Rafiul Islam', 'father_name' => 'Abdul Islam', 'mother_name' => 'Salma Islam', 'institute_name' => 'BNYTI Khulna', 'full_address' => 'Batiaghata, Khulna', 'district' => 'Khulna', 'upazila' => 'Batiaghata', 'post_office' => 'Khulna GPO', 'email' => 'rafiul@example.com', 'sex' => 'Male', 'username' => 'rafiul_branch', 'password' => 'password123', 'password_confirmation' => 'password123', 'mobile_number' => '01740000000', 'director_signature' => UploadedFile::fake()->image('signature.png'), 'nid_photo' => UploadedFile::fake()->image('nid.png'), 'director_photo' => UploadedFile::fake()->image('director.png')])->assertRedirect(route('branch-applications.create'));

    $application = BranchApplication::query()->firstOrFail();
    expect($application->status)->toBe(BranchApplicationStatus::Pending);
    Storage::disk('public')->assertExists($application->director_photo_path);
});

test('public visitors can access the branded branch registration form', function () {
    $this->get(route('branch-applications.create'))
        ->assertSuccessful()
        ->assertSee('Branch Registration')
        ->assertSee('Director Information')
        ->assertSee('Institute Information')
        ->assertSee('Address Information')
        ->assertSee('Login Credentials')
        ->assertSee('Required Documents')
        ->assertSee('Important Notes')
        ->assertSee('APPLICATION SUBMIT')
        ->assertSee('RESET FORM')
        ->assertSee('Student Registration')
        ->assertSee('Results')
        ->assertSee('Apply Now');
});

test('super admins can approve branch registrations', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $application = BranchApplication::factory()->create();

    $this->actingAs($superAdmin)->patch(route('super-admin.branch-applications.update', $application), ['status' => 'approved'])->assertRedirect(route('super-admin.branch-applications.show', $application));
    expect($application->refresh()->status)->toBe(BranchApplicationStatus::Approved);
    expect($application->password)->toBeNull();
    $branchUser = User::query()->where('email', $application->email)->firstOrFail();
    expect($branchUser->role)->toBe(UserRole::Branch)
        ->and($branchUser->name)->toBe($application->director_name);

    Auth::logout();
    $this->post(route('login'), ['email' => $application->email, 'password' => 'password'])->assertRedirect(route('dashboards.branch', absolute: false));
});

test('approval is blocked when the application email already has an account', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $existingUser = User::factory()->create();
    $application = BranchApplication::factory()->create(['email' => $existingUser->email]);

    $this->actingAs($superAdmin)
        ->patch(route('super-admin.branch-applications.update', $application), ['status' => 'approved'])
        ->assertSessionHasErrors('email');

    expect($application->refresh()->status)->toBe(BranchApplicationStatus::Pending);
});

test('already reviewed applications cannot be approved again', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $application = BranchApplication::factory()->approved()->create();

    $this->actingAs($superAdmin)
        ->patch(route('super-admin.branch-applications.update', $application), ['status' => 'approved'])
        ->assertSessionHasErrors('status');

    expect(User::query()->where('email', $application->email)->exists())->toBeFalse();
});

test('rejection does not create a branch account', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $application = BranchApplication::factory()->create();

    $this->actingAs($superAdmin)
        ->patch(route('super-admin.branch-applications.update', $application), ['status' => 'rejected', 'rejection_reason' => 'Documents require review.'])
        ->assertRedirect(route('super-admin.branch-applications.show', $application));

    expect($application->refresh()->status)->toBe(BranchApplicationStatus::Rejected)
        ->and(User::query()->where('email', $application->email)->exists())->toBeFalse();
});

test('non-super-admins cannot review branch registrations', function () {
    $branchUser = User::factory()->role(UserRole::Branch)->create();
    $application = BranchApplication::factory()->create();
    $this->actingAs($branchUser)->get(route('super-admin.branch-applications.index'))->assertForbidden();
});
