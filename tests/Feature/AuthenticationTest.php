<?php

use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\RoleUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests can see the login page', function () {
    $this->get('/login')
        ->assertSuccessful()
        ->assertSee('Sign in')
        ->assertSee('STAFF ACCESS');
});

test('users are redirected to their role dashboard after login', function (UserRole $role, string $routeName) {
    $user = User::factory()->role($role)->create([
        'email' => 'person@example.com',
        'password' => 'password',
    ]);

    $this->post('/login', [
        'email' => 'person@example.com',
        'password' => 'password',
    ])
        ->assertRedirect(route($routeName, absolute: false));

    $this->assertAuthenticatedAs($user);
})->with([
    'super admin' => [UserRole::SuperAdmin, 'dashboards.super-admin'],
    'branch' => [UserRole::Branch, 'dashboards.branch'],
    'editor' => [UserRole::Editor, 'dashboards.editor'],
    'student' => [UserRole::Student, 'dashboards.student'],
]);

test('users cannot access another role dashboard', function () {
    $user = User::factory()->role(UserRole::Branch)->create();

    $this->actingAs($user)
        ->get('/dashboard/editor')
        ->assertForbidden();
});

test('dashboard redirects authenticated users to their own dashboard', function () {
    $user = User::factory()->role(UserRole::Editor)->create();

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertRedirect(route('dashboards.editor', absolute: false));
});

test('branch dashboard displays a secure logout form', function () {
    $user = User::factory()->role(UserRole::Branch)->create();

    $this->actingAs($user)
        ->get(route('dashboards.branch'))
        ->assertSuccessful()
        ->assertSee('action="'.route('logout').'"', false)
        ->assertSee('method="POST"', false)
        ->assertSee('name="_token"', false)
        ->assertSee('Log out of the branch dashboard', false)
        ->assertSee('BRANCH MANAGEMENT SYSTEM')
        ->assertSee('ADMISSION')
        ->assertSee('CERTIFICATES')
        ->assertSee('NEWS &amp; NOTICE', false)
        ->assertSee('Apply Now')
        ->assertSee('Student Registration')
        ->assertSee('Branch Registration')
        ->assertSee('branch-dashboard-mobile-menu', false);
});

test('users can log out from the branch dashboard', function () {
    $user = User::factory()->role(UserRole::Branch)->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect(route('login', absolute: false));

    $this->assertGuest();
});

test('super admin dashboard shows academic management navigation', function () {
    $superAdmin = User::factory()->role(UserRole::SuperAdmin)->create();

    $this->actingAs($superAdmin)
        ->get(route('dashboards.super-admin'))
        ->assertSuccessful()
        ->assertSee('Course Management')
        ->assertSee('Student Management')
        ->assertSee('Teacher Management');
});

test('role user seeder creates one user for every dashboard role', function () {
    $this->seed(RoleUserSeeder::class);

    expect(User::query()->count())->toBe(4);

    foreach (UserRole::cases() as $role) {
        expect(User::query()->where('role', $role->value)->exists())->toBeTrue();
    }
});
