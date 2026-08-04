<?php

use App\Enums\UserRole;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('public users can browse only published news', function () {
    $published = News::factory()->create(['title' => 'Published update', 'is_published' => true, 'published_at' => now()]);
    $draft = News::factory()->create(['title' => 'Private draft', 'is_published' => false, 'published_at' => null]);

    $this->get(route('news.index'))->assertSuccessful()->assertSee($published->title)->assertDontSee($draft->title);
    $this->get(route('news.show', $published))->assertSuccessful()->assertSee($published->content);
    $this->get(route('news.show', $draft))->assertNotFound();
});

test('super admins can create and delete news', function () {
    $admin = User::factory()->role(UserRole::SuperAdmin)->create();

    $this->actingAs($admin)->post(route('super-admin.news.store'), [
        'title' => 'Admission update',
        'excerpt' => 'Important update',
        'content' => 'Admissions are open.',
        'is_published' => 1,
    ])->assertRedirect(route('super-admin.news.index'));

    $news = News::query()->firstOrFail();
    expect($news->slug)->toBe('admission-update')->and($news->is_published)->toBeTrue();

    $this->actingAs($admin)->delete(route('super-admin.news.destroy', $news))->assertRedirect();
    expect(News::query()->whereKey($news->id)->exists())->toBeFalse();
});

test('non-super-admins cannot manage news', function () {
    $user = User::factory()->role(UserRole::Branch)->create();

    $this->actingAs($user)->get(route('super-admin.news.index'))->assertForbidden();
});
