<?php

use App\Enums\UserRole;
use App\Models\InstituteProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('super admins can manage about entries', function () {
    $admin = User::factory()->role(UserRole::SuperAdmin)->create();
    InstituteProfile::factory()->create();

    $this->actingAs($admin)
        ->get(route('super-admin.about.index'))
        ->assertSuccessful()
        ->assertSee('About Us Management');

    $this->actingAs($admin)
        ->put(route('super-admin.about.update', InstituteProfile::query()->first()), [
            'about_heading' => 'Skills for tomorrow.',
            'summary' => 'A short About summary.',
            'content' => "First paragraph.\n\nSecond paragraph.",
            'principal_name' => 'Dr. Ayesha Karim',
            'principal_title' => 'Principal',
            'sort_order' => 1,
            'is_active' => '1',
            'is_published' => '1',
        ])
        ->assertRedirect();

    expect(InstituteProfile::query()->first())
        ->about_heading->toBe('Skills for tomorrow.')
        ->principal_name->toBe('Dr. Ayesha Karim');
});

test('non-super-admins cannot manage the institute profile', function () {
    $user = User::factory()->role(UserRole::Branch)->create();

    $this->actingAs($user)->get(route('super-admin.about.index'))->assertForbidden();
});

test('super admins can create, publish, and delete about entries', function () {
    $admin = User::factory()->role(UserRole::SuperAdmin)->create();
    $payload = [
        'about_heading' => 'Hands-on learning for every learner',
        'summary' => 'A practical education story.',
        'content' => 'Full About content.',
        'principal_name' => '',
        'principal_title' => '',
        'sort_order' => 2,
        'is_published' => '0',
    ];

    $this->actingAs($admin)->post(route('super-admin.about.store'), $payload)->assertRedirect(route('super-admin.about.index'));
    $about = InstituteProfile::query()->where('about_heading', $payload['about_heading'])->firstOrFail();

    expect($about->slug)->toBe('hands-on-learning-for-every-learner');
    expect($about->is_published)->toBeFalse();

    $this->actingAs($admin)->patch(route('super-admin.about.publish', $about))->assertRedirect();
    expect($about->refresh()->is_published)->toBeTrue();

    $this->actingAs($admin)->delete(route('super-admin.about.destroy', $about))->assertRedirect();
    $this->assertModelMissing($about);
});

test('super admins can upload and replace about images safely', function () {
    Storage::fake('public');
    $admin = User::factory()->role(UserRole::SuperAdmin)->create();
    $about = InstituteProfile::factory()->create();
    $firstImage = UploadedFile::fake()->image('first.jpg');

    $this->actingAs($admin)->put(route('super-admin.about.update', $about), [
        'about_heading' => $about->about_heading,
        'summary' => $about->summary,
        'content' => $about->content,
        'sort_order' => $about->sort_order,
        'is_published' => '1',
        'image' => $firstImage,
    ])->assertRedirect();

    $firstPath = $about->refresh()->image_path;
    Storage::disk('public')->assertExists($firstPath);

    $this->actingAs($admin)->put(route('super-admin.about.update', $about), [
        'about_heading' => $about->about_heading,
        'summary' => $about->summary,
        'content' => $about->content,
        'sort_order' => $about->sort_order,
        'is_published' => '1',
        'image' => UploadedFile::fake()->image('replacement.png'),
    ])->assertRedirect();

    Storage::disk('public')->assertMissing($firstPath);
    Storage::disk('public')->assertExists($about->refresh()->image_path);
});
