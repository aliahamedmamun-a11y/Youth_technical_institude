<?php

use App\Models\InstituteProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('published about entries show their complete content on the homepage and resolve by slug', function () {
    $about = InstituteProfile::factory()->create([
        'about_heading' => 'Industry-ready education',
        'summary' => 'Skills that connect learners to opportunity.',
        'content' => 'A complete story about industry-ready education.',
        'is_published' => true,
        'is_active' => true,
    ]);
    InstituteProfile::factory()->create(['about_heading' => 'A second About story']);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee($about->about_heading)
        ->assertSee($about->content)
        ->assertDontSee(route('about.show', $about), false)
        ->assertDontSeeText('Read more')
        ->assertSee('data-about-layout="profile"', false)
        ->assertSee('data-about-size="compact"', false)
        ->assertSee('aria-label="About Us"', false)
        ->assertSee('data-about-heading', false)
        ->assertSee('data-about-interval="10000"', false)
        ->assertSee('data-about-next', false);

    $this->get(route('about.show', $about))
        ->assertSuccessful()
        ->assertSee($about->content);
});

test('unpublished about entries are hidden from public pages', function () {
    $about = InstituteProfile::factory()->create([
        'about_heading' => 'Private draft about entry',
        'is_published' => false,
    ]);

    $this->get(route('home'))->assertSuccessful()->assertDontSee($about->about_heading);
    $this->get(route('about.show', $about))->assertNotFound();
    $this->get('/about/not-a-real-entry')->assertNotFound();
});

test('duplicate about headings receive unique slugs', function () {
    $first = InstituteProfile::factory()->create(['about_heading' => 'Our Mission']);
    $second = InstituteProfile::factory()->create(['about_heading' => 'Our Mission']);

    expect($first->slug)->toBe('our-mission')->and($second->slug)->toBe('our-mission-2');
});
