<?php

use App\Enums\UserRole;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('super admins can manage teachers', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $data = ['name' => 'Farhana Akter', 'employee_number' => 'T-1001', 'email' => 'farhana@example.com', 'phone' => '01700000000', 'designation' => 'Senior Instructor', 'department' => 'Computer', 'is_active' => '1'];
    $this->actingAs($superAdmin)->post(route('super-admin.teachers.store'), $data)->assertRedirect(route('super-admin.teachers.index'));
    $teacher = Teacher::query()->firstOrFail();
    $this->actingAs($superAdmin)->put(route('super-admin.teachers.update', $teacher), [...$data, 'designation' => 'Head Instructor', 'is_active' => '0'])->assertRedirect(route('super-admin.teachers.index'));
    expect($teacher->refresh())->designation->toBe('Head Instructor')->is_active->toBeFalse();
    $this->actingAs($superAdmin)->delete(route('super-admin.teachers.destroy', $teacher))->assertRedirect(route('super-admin.teachers.index'));
    $this->assertModelMissing($teacher);
});

test('non-super-admins cannot access teachers', function () {
    $branchUser = User::factory()->role(UserRole::Branch)->create();
    $this->actingAs($branchUser)->get(route('super-admin.teachers.index'))->assertForbidden();
});

test('super admins can upload a teacher photo', function () {
    Storage::fake('public');
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();

    $this->actingAs($superAdmin)->post(route('super-admin.teachers.store'), [
        'name' => 'Nadia Islam', 'employee_number' => 'T-2001', 'phone' => '01700000000', 'designation' => 'Instructor', 'is_active' => '1', 'image' => UploadedFile::fake()->image('nadia.png'),
    ])->assertRedirect(route('super-admin.teachers.index'));

    $teacher = Teacher::query()->firstOrFail();
    Storage::disk('public')->assertExists($teacher->image_path);
});
