<?php

use App\Enums\UserRole;
use App\Models\HomepageItem;
use App\Models\HomepageSection;
use App\Models\User;
use Database\Seeders\HomepageItemSeeder;
use Database\Seeders\HomepageSectionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed([HomepageSectionSeeder::class, HomepageItemSeeder::class]);
});

test('homepage renders seeded section content', function (): void {
    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Government Approved')
        ->assertSee('20,000+')
        ->assertSee('Smart Classroom');
});

test('super admin can manage homepage items', function (): void {
    $admin = User::factory()->role(UserRole::SuperAdmin)->create();
    $section = HomepageSection::query()->where('key', 'trust')->firstOrFail();

    $this->actingAs($admin)
        ->get(route('super-admin.homepage.items.index', $section->key))
        ->assertSuccessful()
        ->assertSee('Trust Indicators')
        ->assertSee('Hero Slides')
        ->assertSee('Achievement Statistics')
        ->assertSee('Branch Promotion')
        ->assertSee('Institute Gallery')
        ->assertSee('Student Testimonials')
        ->assertSee('Contact Information')
        ->assertSee('Footer Settings');

    $this->actingAs($admin)
        ->post(route('super-admin.homepage.items.store'), [
            'section' => $section->key,
            'stable_key' => 'test-item',
            'title' => 'Test indicator',
            'body' => 'Test description',
            'sort_order' => 99,
            'is_published' => '1',
        ])
        ->assertRedirect(route('super-admin.homepage.items.index', $section->key));

    expect(HomepageItem::query()->where('stable_key', 'test-item')->exists())->toBeTrue();
});

test('non super admin users cannot manage homepage items', function (): void {
    $user = User::factory()->role(UserRole::Branch)->create();

    $this->actingAs($user)
        ->get(route('super-admin.homepage.items.index', 'hero'))
        ->assertForbidden();
});

test('homepage seeders are idempotent', function (): void {
    $this->seed([HomepageSectionSeeder::class, HomepageItemSeeder::class]);

    expect(HomepageSection::query()->where('key', 'hero')->count())->toBe(1)
        ->and(HomepageItem::query()->where('stable_key', 'hero-lab')->count())->toBe(1);
});
