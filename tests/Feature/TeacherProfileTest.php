<?php

use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('active teachers have public profile pages', function () {
    $teacher = Teacher::factory()->create([
        'name' => 'Farhana Akter',
        'description' => 'Specialist in practical computer training.',
        'qualification' => 'BSc in Computer Science',
        'department' => 'Computer Technology',
    ]);

    $this->get(route('teachers.show', $teacher))
        ->assertSuccessful()
        ->assertSee($teacher->name)
        ->assertSee($teacher->description)
        ->assertSee($teacher->qualification);
});

test('inactive teachers are not publicly visible', function () {
    $teacher = Teacher::factory()->create(['is_active' => false]);

    $this->get(route('teachers.show', $teacher))->assertNotFound();
});
