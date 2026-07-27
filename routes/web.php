<?php

use App\Enums\UserRole;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BranchApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperAdmin\BranchApplicationController as SuperAdminBranchApplicationController;
use App\Http\Controllers\SuperAdmin\CourseController;
use App\Http\Controllers\SuperAdmin\StudentController;
use App\Http\Controllers\SuperAdmin\StudentDocumentController;
use App\Http\Controllers\SuperAdmin\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/branch-application', [BranchApplicationController::class, 'create'])->name('branch-applications.create');
Route::post('/branch-application', [BranchApplicationController::class, 'store'])->name('branch-applications.store');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/super-admin', [DashboardController::class, 'superAdmin'])
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->name('dashboards.super-admin');

    Route::resource('/super-admin/courses', CourseController::class)
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->names('super-admin.courses');

    Route::resource('/super-admin/students', StudentController::class)
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->names('super-admin.students');

    Route::resource('/super-admin/teachers', TeacherController::class)
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->names('super-admin.teachers');

    Route::get('/super-admin/branch-applications', [SuperAdminBranchApplicationController::class, 'index'])->middleware('role:'.UserRole::SuperAdmin->value)->name('super-admin.branch-applications.index');
    Route::get('/super-admin/branch-applications/{branchApplication}', [SuperAdminBranchApplicationController::class, 'show'])->middleware('role:'.UserRole::SuperAdmin->value)->name('super-admin.branch-applications.show');
    Route::patch('/super-admin/branch-applications/{branchApplication}', [SuperAdminBranchApplicationController::class, 'update'])->middleware('role:'.UserRole::SuperAdmin->value)->name('super-admin.branch-applications.update');

    Route::get('/super-admin/students/{student}/{document}', [StudentDocumentController::class, 'show'])
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->whereIn('document', ['admit-card', 'registration-card', 'student-id', 'certificate', 'testimonial', 'transcript', 'forwarding-letter', 'results'])
        ->name('super-admin.students.documents.show');

    Route::get('/dashboard/branch', [DashboardController::class, 'branch'])
        ->middleware('role:'.UserRole::Branch->value)
        ->name('dashboards.branch');

    Route::get('/dashboard/editor', [DashboardController::class, 'editor'])
        ->middleware('role:'.UserRole::Editor->value)
        ->name('dashboards.editor');

    Route::get('/dashboard/student', [DashboardController::class, 'student'])
        ->middleware('role:'.UserRole::Student->value)
        ->name('dashboards.student');
});
