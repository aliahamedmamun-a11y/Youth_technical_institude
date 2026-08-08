<?php

use App\Enums\UserRole;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('published notices appear in the homepage ticker while drafts stay hidden', function () {
    $latest = Notice::factory()->create(['title' => 'Latest notice', 'message' => 'Latest message.', 'published_at' => now()]);
    Notice::factory()->create(['title' => 'Draft notice', 'is_published' => false, 'published_at' => null]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee($latest->title)
        ->assertSee($latest->message)
        ->assertDontSee('Draft notice')
        ->assertSee('id="notice-bar"', false);
});

test('super admins can manage notices separately from news', function () {
    $admin = User::factory()->role(UserRole::SuperAdmin)->create();

    $this->actingAs($admin)
        ->get(route('super-admin.notices.index'))
        ->assertSuccessful()
        ->assertSee('Notice Management');

    $this->actingAs($admin)->post(route('super-admin.notices.store'), [
        'title' => 'Admission notice',
        'message' => 'Applications are open.',
        'is_published' => 1,
    ])->assertRedirect(route('super-admin.notices.index'));

    expect(Notice::query()->where('title', 'Admission notice')->firstOrFail()->is_published)->toBeTrue();
});

test('non-super-admins cannot manage notices', function () {
    $user = User::factory()->role(UserRole::Branch)->create();

    $this->actingAs($user)->get(route('super-admin.notices.index'))->assertForbidden();
});

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
