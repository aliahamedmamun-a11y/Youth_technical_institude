<?php

use App\Enums\UserRole;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

function fakeTeacherPortraitWithBackground(string $name, int $red, int $green, int $blue): UploadedFile
{
    $upload = UploadedFile::fake()->image($name, 300, 400);
    $image = imagecreatetruecolor(300, 400);
    $background = imagecolorallocate($image, $red, $green, $blue);
    imagefill($image, 0, 0, $background);
    imagepng($image, $upload->getPathname());
    imagedestroy($image);

    return $upload;
}

test('super admins can manage teachers', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $data = ['name' => 'Farhana Akter', 'employee_number' => 'T-1001', 'email' => 'farhana@example.com', 'phone' => '01700000000', 'designation' => 'Senior Instructor', 'department' => 'Computer', 'description' => 'Specialist in practical computer training.', 'is_active' => '1'];
    $this->actingAs($superAdmin)->post(route('super-admin.teachers.store'), $data)->assertRedirect(route('super-admin.teachers.index'));
    $teacher = Teacher::query()->firstOrFail();
    $this->actingAs($superAdmin)->put(route('super-admin.teachers.update', $teacher), [...$data, 'designation' => 'Head Instructor', 'is_active' => '0'])->assertRedirect(route('super-admin.teachers.index'));
    expect($teacher->refresh())->designation->toBe('Head Instructor')->description->toBe('Specialist in practical computer training.')->is_active->toBeFalse();
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
        'name' => 'Nadia Islam', 'employee_number' => 'T-2001', 'phone' => '01700000000', 'designation' => 'Instructor', 'is_active' => '1', 'image' => fakeTeacherPortraitWithBackground('nadia.png', 255, 255, 255),
    ])->assertRedirect(route('super-admin.teachers.index'));

    $teacher = Teacher::query()->firstOrFail();
    Storage::disk('public')->assertExists($teacher->image_path);
});

test('new and replacement teacher photos require a white background', function () {
    Storage::fake('public');
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();
    $teacherData = ['name' => 'Nadia Islam', 'employee_number' => 'T-2001', 'phone' => '01700000000', 'designation' => 'Instructor', 'is_active' => '1'];

    $this->actingAs($superAdmin)->post(route('super-admin.teachers.store'), [
        ...$teacherData,
        'image' => fakeTeacherPortraitWithBackground('blue-background.png', 35, 153, 232),
    ])->assertSessionHasErrors('image');

    expect(Teacher::query()->count())->toBe(0);

    $teacher = Teacher::factory()->create(['image_path' => null]);

    $this->actingAs($superAdmin)->put(route('super-admin.teachers.update', $teacher), [
        ...$teacherData,
        'employee_number' => $teacher->employee_number,
        'image' => fakeTeacherPortraitWithBackground('replacement-blue-background.png', 35, 153, 232),
    ])->assertSessionHasErrors('image');

    expect($teacher->refresh()->image_path)->toBeNull();
});
