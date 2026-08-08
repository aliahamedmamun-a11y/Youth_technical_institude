<?php

use App\Models\Course;
use App\Models\InstituteProfile;
use App\Models\News;
use App\Models\Teacher;
use Database\Seeders\HomepageItemSeeder;
use Database\Seeders\HomepageSectionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed([HomepageSectionSeeder::class, HomepageItemSeeder::class]);
});

test('the homepage presents the institute and its primary sections', function () {
    $teacher = Teacher::factory()->create([
        'name' => 'Engr. Md. Rasel',
        'designation' => 'Head of Electrical Department',
        'department' => 'Electrical Technology',
    ]);
    $course = Course::factory()->create([
        'name' => 'Advanced Web Engineering',
        'description' => 'Project-based web development training.',
    ]);
    $profile = InstituteProfile::factory()->create([
        'about_heading' => 'Learning for a changing world.',
        'content' => "A dynamic institute profile paragraph.\n\nA second profile paragraph.",
        'principal_name' => 'Dr. Dynamic Principal',
    ]);

    $response = $this->get('/');

    $response
        ->assertSuccessful()
        ->assertSee('Bangladesh National Youth Technical Institute')
        ->assertSee('images/bnyti-hero-premium-1.png', false)
        ->assertSee('images/bnyti-hero-premium-2.png', false)
        ->assertSee('images/bnyti-hero-premium-3.png', false)
        ->assertSee('data-hero-carousel', false)
        ->assertSee('id="notice-bar"', false)
        ->assertSee('NOTICE')
        ->assertSee('Admission for the July 2026 session is now open')
        ->assertSee('Practical skills for a')
        ->assertSee('Our Expert Teachers')
        ->assertSee($teacher->name)
        ->assertSee(route('teachers.show', $teacher), false)
        ->assertSee('Popular Courses')
        ->assertSee($course->name)
        ->assertSee($course->description)
        ->assertSee($profile->about_heading)
        ->assertSee($profile->principal_name)
        ->assertSee('A dynamic institute profile paragraph.')
        ->assertSee('id="branch-application-promo"', false)
        ->assertSee('id="latest-news-contact"', false)
        ->assertDontSee('25,000+')
        ->assertDontSee('STUDENT SERVICES')
        ->assertDontSee('NATIONWIDE NETWORK')
        ->assertDontSee('Learn the skills employers actually need.')
        ->assertSee('data-theme-toggle', false)
        ->assertSee('data-locale-toggle', false)
        ->assertSee('id="mobile-menu"', false);
});

test('the notice ticker shows only published news in publication order', function () {
    $old = News::factory()->create([
        'title' => 'Older published notice',
        'excerpt' => 'Older notice details.',
        'is_published' => true,
        'published_at' => now()->subDay(),
    ]);
    $latest = News::factory()->create([
        'title' => 'Latest published notice',
        'excerpt' => 'Latest notice details.',
        'is_published' => true,
        'published_at' => now(),
    ]);
    $draft = News::factory()->create([
        'title' => 'Private draft notice',
        'is_published' => false,
        'published_at' => null,
    ]);

    $response = $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee($latest->title)
        ->assertSee(route('news.show', $latest), false)
        ->assertSee($old->title)
        ->assertDontSee($draft->title);

    expect($response->getContent())->toContain($latest->title)
        ->and($response->getContent())->toContain($old->title)
        ->and(strpos($response->getContent(), $latest->title))
        ->toBeLessThan(strpos($response->getContent(), $old->title));
});
