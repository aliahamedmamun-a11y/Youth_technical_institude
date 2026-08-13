<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('super admin dashboard loads without browser errors', function () {
    User::factory()->role(UserRole::SuperAdmin)->create([
        'email' => 'admin-browser@example.com',
        'password' => 'password',
    ]);

    $page = visit('/login');

    $page->fill('email', 'admin-browser@example.com')
        ->fill('password', 'password')
        ->click('Sign in')
        ->assertSee('Administration Overview')
        ->assertSee('People & Branches')
        ->assertNoJavaScriptErrors()
        ->assertNoConsoleLogs();
});

test('mobile navigation exposes the management groups', function () {
    User::factory()->role(UserRole::SuperAdmin)->create([
        'email' => 'mobile-admin@example.com',
        'password' => 'password',
    ]);

    $page = visit('/login')->on()->mobile();

    $page->fill('email', 'mobile-admin@example.com')
        ->fill('password', 'password')
        ->click('Sign in')
        ->click('Open navigation')
        ->assertSee('Academic Management')
        ->assertSee('Website Content')
        ->assertNoJavaScriptErrors();
});
