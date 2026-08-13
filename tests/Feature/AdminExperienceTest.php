<?php

use App\Enums\UserRole;
use App\Models\News;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('content filters preserve clear status choices and responsive cards', function () {
    $admin = User::factory()->role(UserRole::SuperAdmin)->create();
    News::factory()->create(['title' => 'Published update', 'is_published' => true]);
    News::factory()->create(['title' => 'Draft update', 'is_published' => false]);

    $this->actingAs($admin)
        ->get(route('super-admin.news.index', ['search' => 'Published', 'status' => 'published']))
        ->assertSuccessful()
        ->assertSee('Published update')
        ->assertDontSee('Draft update')
        ->assertSee('admin-record-grid', false)
        ->assertSee('Clear filters');
});

test('destructive admin actions expose the accessible confirmation dialog', function () {
    $admin = User::factory()->role(UserRole::SuperAdmin)->create();
    $notice = Notice::factory()->create();

    $this->actingAs($admin)
        ->get(route('super-admin.notices.index'))
        ->assertSuccessful()
        ->assertSee($notice->title)
        ->assertSee('data-admin-confirm-dialog', false)
        ->assertSee('data-confirm="Delete this notice?', false)
        ->assertSee('No, go back');
});

test('admin forms include validation summary and unsaved change support', function () {
    $admin = User::factory()->role(UserRole::SuperAdmin)->create();

    $this->actingAs($admin)
        ->from(route('super-admin.notices.create'))
        ->post(route('super-admin.notices.store'), [])
        ->assertRedirect(route('super-admin.notices.create'));

    $this->actingAs($admin)
        ->get(route('super-admin.notices.create'))
        ->assertSuccessful()
        ->assertSee('Please correct the following:')
        ->assertSee('data-admin-workspace', false);
});
