<?php

use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the homepage presents the institute and its primary sections', function () {
    $teacher = Teacher::factory()->create([
        'name' => 'Engr. Md. Rasel',
        'designation' => 'Head of Electrical Department',
        'department' => 'Electrical Technology',
    ]);

    $response = $this->get('/');

    $response
        ->assertSuccessful()
        ->assertSee('Bangladesh National Youth Technical Institute')
        ->assertSee('images/bnyti-hero-premium-1.png', false)
        ->assertSee('images/bnyti-hero-premium-2.png', false)
        ->assertSee('images/bnyti-hero-premium-3.png', false)
        ->assertSee('data-hero-carousel', false)
        ->assertSee('Practical skills for a')
        ->assertSee('Our Expert Teachers')
        ->assertSee($teacher->name)
        ->assertSee(route('teachers.show', $teacher), false)
        ->assertSee('Popular Courses')
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
