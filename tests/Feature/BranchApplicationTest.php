<?php

use App\Enums\BranchApplicationStatus;
use App\Enums\UserRole;
use App\Models\BranchApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests can submit a branch application', function () {
    $this->post(route('branch-applications.store'), ['proposed_branch_name' => 'BNYTI Khulna Branch', 'applicant_name' => 'Rafiul Islam', 'email' => 'rafiul@example.com', 'phone' => '01740000000', 'district' => 'Khulna', 'address' => 'Sonadanga, Khulna'])
        ->assertRedirect(route('branch-applications.create'));

    expect(BranchApplication::query()->firstOrFail()->status)->toBe(BranchApplicationStatus::Pending);
});

test('super admins can approve branch applications', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $application = BranchApplication::factory()->create();

    $this->actingAs($superAdmin)->patch(route('super-admin.branch-applications.update', $application), ['status' => 'approved'])
        ->assertRedirect(route('super-admin.branch-applications.show', $application));

    $application->refresh();

    expect($application->status)->toBe(BranchApplicationStatus::Approved);
    expect($application->reviewed_at)->not->toBeNull();
});

test('non-super-admins cannot review branch applications', function () {
    $branchUser = User::factory()->role(UserRole::Branch)->create();
    $application = BranchApplication::factory()->create();

    $this->actingAs($branchUser)->get(route('super-admin.branch-applications.index'))->assertForbidden();
});

test('super admins can view branch application details', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $application = BranchApplication::factory()->create();

    $this->actingAs($superAdmin)
        ->get(route('super-admin.branch-applications.show', $application))
        ->assertSuccessful()
        ->assertSee($application->proposed_branch_name);
});
