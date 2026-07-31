<?php

use App\Enums\UserRole;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('super admins can manage courses', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();

    $this->actingAs($superAdmin)
        ->post(route('super-admin.courses.store'), [
            'name' => 'Computer Office Applications',
            'duration' => '6 Months',
            'description' => 'Practical office application training.',
            'is_active' => '1',
        ])
        ->assertRedirect(route('super-admin.courses.index'));

    $course = Course::query()->firstOrFail();

    expect($course)
        ->name->toBe('Computer Office Applications')
        ->is_active->toBeTrue();

    $this->actingAs($superAdmin)
        ->put(route('super-admin.courses.update', $course), [
            'name' => 'Advanced Computer Office Applications',
            'duration' => '1 Year',
            'description' => 'Advanced practical office application training.',
            'is_active' => '0',
        ])
        ->assertRedirect(route('super-admin.courses.index'));

    expect($course->refresh())
        ->name->toBe('Advanced Computer Office Applications')
        ->duration->toBe('1 Year')
        ->is_active->toBeFalse();

    $this->actingAs($superAdmin)
        ->delete(route('super-admin.courses.destroy', $course))
        ->assertRedirect(route('super-admin.courses.index'));

    $this->assertModelMissing($course);
});

test('non-super-admin users cannot access course management', function () {
    $course = Course::factory()->create();
    $branchUser = User::factory()->role(UserRole::Branch)->create();

    $this->actingAs($branchUser)
        ->get(route('super-admin.courses.index'))
        ->assertForbidden();

    $this->actingAs($branchUser)
        ->get(route('super-admin.courses.edit', $course))
        ->assertForbidden();
});

test('departments do not require a department code', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();

    $this->actingAs($superAdmin)
        ->post(route('super-admin.courses.store'), [
            'name' => 'Another Department',
            'duration' => '3 Months',
            'is_active' => '1',
        ])
        ->assertRedirect(route('super-admin.courses.index'));

    expect(Course::query()->where('name', 'Another Department')->exists())->toBeTrue();
});

test('super admins can upload a course image', function () {
    Storage::fake('public');
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();

    $this->actingAs($superAdmin)
        ->post(route('super-admin.courses.store'), [
            'name' => 'Web Design',
            'duration' => '6 Months',
            'is_active' => '1',
            'image' => UploadedFile::fake()->image('web-design.png'),
        ])
        ->assertRedirect(route('super-admin.courses.index'));

    $course = Course::query()->firstOrFail();

    expect($course->image_path)->not->toBeNull();
    Storage::disk('public')->assertExists($course->image_path);
});
