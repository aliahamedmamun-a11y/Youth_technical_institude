<?php

use App\Enums\UserRole;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BranchApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PublicResultController;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\SuperAdmin\BranchApplicationController as SuperAdminBranchApplicationController;
use App\Http\Controllers\SuperAdmin\CourseController;
use App\Http\Controllers\SuperAdmin\HomepageContentController;
use App\Http\Controllers\SuperAdmin\InstituteProfileController;
use App\Http\Controllers\SuperAdmin\NewsController as SuperAdminNewsController;
use App\Http\Controllers\SuperAdmin\NoticeController;
use App\Http\Controllers\SuperAdmin\SemesterController;
use App\Http\Controllers\SuperAdmin\SemesterSetupController;
use App\Http\Controllers\SuperAdmin\StudentController;
use App\Http\Controllers\SuperAdmin\StudentDocumentController;
use App\Http\Controllers\SuperAdmin\StudentResultController;
use App\Http\Controllers\SuperAdmin\StudentSemesterEnrollmentController;
use App\Http\Controllers\SuperAdmin\SubjectController;
use App\Http\Controllers\SuperAdmin\TeacherController;
use App\Http\Controllers\TeacherController as PublicTeacherController;
use App\Models\Course;
use App\Models\HomepageSection;
use App\Models\InstituteProfile;
use App\Models\News;
use App\Models\Notice;
use App\Models\Teacher;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    $aboutEntries = InstituteProfile::query()->published()->ordered()->get();
    $instituteProfile = $aboutEntries->first();
    $homepageSections = HomepageSection::query()->visible()->with(['items' => fn ($query) => $query->published()])->get()->keyBy('key');
    $homepageItems = fn (string $key) => $homepageSections->get($key)?->items ?? collect();
    $isSectionVisible = fn (string $key): bool => $homepageSections->isEmpty() || $homepageSections->has($key);
    $contactSettings = $homepageItems('contact')->first();
    $footerSettings = $homepageItems('footer')->first();

    $popularCourses = Course::query()
        ->where('is_active', true)
        ->orderBy('name')
        ->limit(8)
        ->get(['id', 'name', 'duration', 'description', 'image_path']);

    $teacherCards = Teacher::query()
        ->where('is_active', true)
        ->orderBy('name')
        ->limit(8)
        ->get(['id', 'name', 'designation', 'department', 'description', 'image_path', 'joined_at'])
        ->map(fn (Teacher $teacher): array => [
            'id' => $teacher->id,
            'name' => $teacher->name,
            'designation' => $teacher->designation,
            'department' => $teacher->department,
            'description' => $teacher->description,
            'image_path' => $teacher->image_path,
            'experience' => $teacher->joined_at ? max(1, (int) $teacher->joined_at->diffInYears(now())) : 1,
        ])
        ->concat([
            ['id' => null, 'name' => 'Engr. Md. Rasel', 'designation' => 'Head of Electrical Dept.', 'department' => 'Electrical Technology', 'description' => 'Experienced electrical technology instructor focused on practical, industry-ready training.', 'image_path' => null, 'experience' => 8],
            ['id' => null, 'name' => 'Mr. Arif Hossain', 'designation' => 'Senior Instructor', 'department' => 'Computer & IT', 'description' => 'Guides learners through computer fundamentals, office applications, and digital skills.', 'image_path' => null, 'experience' => 7],
            ['id' => null, 'name' => 'Ms. Nusrat Jahan', 'designation' => 'Graphic Design Expert', 'department' => 'Graphic Design', 'description' => 'Helps students turn creative ideas into polished visual designs and portfolios.', 'image_path' => null, 'experience' => 6],
            ['id' => null, 'name' => 'Mr. Tanvir Hasan', 'designation' => 'Web Development Expert', 'department' => 'Web Development', 'description' => 'Teaches modern web development through hands-on projects and real-world workflows.', 'image_path' => null, 'experience' => 5],
            ['id' => null, 'name' => 'Mr. Saiful Islam', 'designation' => 'Hospitality Trainer', 'department' => 'Hotel Management', 'description' => 'Prepares students for professional hospitality careers with service-focused training.', 'image_path' => null, 'experience' => 10],
            ['id' => null, 'name' => 'Mr. Mahmud Karim', 'designation' => 'Technical Instructor', 'department' => 'Office Application', 'description' => 'Builds confident office professionals with practical productivity and documentation skills.', 'image_path' => null, 'experience' => 6],
        ])
        ->unique('name')
        ->take(8)
        ->values();

    $publishedNews = News::query()
        ->published()
        ->latest('published_at')
        ->limit(6)
        ->get(['id', 'title', 'slug', 'excerpt', 'content', 'image_path', 'published_at']);

    $noticeItems = Notice::query()
        ->published()
        ->latest('published_at')
        ->limit(6)
        ->get(['id', 'title', 'message', 'link'])
        ->map(fn (Notice $notice): array => [
            'title' => $notice->title,
            'message' => $notice->message,
            'link' => $notice->link,
        ]);

    $latestNews = $publishedNews->take(4)->map(fn (News $item): array => [
        $item->title,
        $item->excerpt ?: Str::limit($item->content, 80),
        $item->published_at?->format('d M, Y'),
        'emerald',
        'megaphone',
        $item->image_path,
        $item->slug,
    ]);

    return view('welcome', compact('teacherCards', 'latestNews', 'noticeItems', 'popularCourses', 'aboutEntries', 'instituteProfile', 'homepageSections', 'homepageItems', 'isSectionVisible', 'contactSettings', 'footerSettings'));
})->name('home');

Route::get('/branch-application', [BranchApplicationController::class, 'create'])->name('branch-applications.create');
Route::post('/branch-application', [BranchApplicationController::class, 'store'])->name('branch-applications.store');
Route::get('/results', [PublicResultController::class, 'index'])->name('results.index');
Route::get('/results/{verificationToken}', [PublicResultController::class, 'show'])->name('results.show');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/teachers/{teacher}', [PublicTeacherController::class, 'show'])->name('teachers.show');
Route::get('/about/{about:slug}', [AboutController::class, 'show'])->name('about.show');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/student-registration', [StudentRegistrationController::class, 'create'])->name('student-registrations.create');
    Route::post('/student-registration', [StudentRegistrationController::class, 'store'])->name('student-registrations.store');

    Route::get('/dashboard/super-admin', [DashboardController::class, 'superAdmin'])
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->name('dashboards.super-admin');

    Route::resource('/super-admin/courses', CourseController::class)
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->names('super-admin.courses');

    Route::get('/super-admin/semester-setup', [SemesterSetupController::class, 'index'])
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->name('super-admin.semester-setup.index');

    Route::resource('/super-admin/courses/{course}/semesters', SemesterController::class)
        ->except(['show'])
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->names('super-admin.courses.semesters');

    Route::resource('/super-admin/semesters/{semester}/subjects', SubjectController::class)
        ->except(['show'])
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->names('super-admin.semesters.subjects');

    Route::resource('/super-admin/students', StudentController::class)
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->names('super-admin.students');

    Route::resource('/super-admin/students/{student}/semester-enrollments', StudentSemesterEnrollmentController::class)
        ->except(['show'])
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->names('super-admin.students.semester-enrollments');

    Route::get('/super-admin/students/{student}/results', [StudentResultController::class, 'index'])->middleware('role:'.UserRole::SuperAdmin->value)->name('super-admin.students.results.index');
    Route::get('/super-admin/students/{student}/results/create', [StudentResultController::class, 'create'])->middleware('role:'.UserRole::SuperAdmin->value)->name('super-admin.students.results.create');
    Route::post('/super-admin/students/results', [StudentResultController::class, 'store'])->middleware('role:'.UserRole::SuperAdmin->value)->name('super-admin.students.results.store');
    Route::get('/super-admin/semester-enrollments/{enrollment}/result/create', [StudentResultController::class, 'createForEnrollment'])->middleware('role:'.UserRole::SuperAdmin->value)->name('super-admin.enrollments.results.create');
    Route::post('/super-admin/semester-enrollments/{enrollment}/result', [StudentResultController::class, 'storeForEnrollment'])->middleware('role:'.UserRole::SuperAdmin->value)->name('super-admin.enrollments.results.store');
    Route::get('/super-admin/results/{result}', [StudentResultController::class, 'show'])->middleware('role:'.UserRole::SuperAdmin->value)->name('super-admin.results.show');
    Route::get('/super-admin/results/{result}/edit', [StudentResultController::class, 'edit'])->middleware('role:'.UserRole::SuperAdmin->value)->name('super-admin.results.edit');
    Route::put('/super-admin/results/{result}', [StudentResultController::class, 'update'])->middleware('role:'.UserRole::SuperAdmin->value)->name('super-admin.results.update');
    Route::delete('/super-admin/results/{result}', [StudentResultController::class, 'destroy'])->middleware('role:'.UserRole::SuperAdmin->value)->name('super-admin.results.destroy');

    Route::resource('/super-admin/teachers', TeacherController::class)
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->names('super-admin.teachers');
    Route::resource('/super-admin/news', SuperAdminNewsController::class)
        ->except(['show'])
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->names('super-admin.news');
    Route::resource('/super-admin/notices', NoticeController::class)
        ->except(['show'])
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->names('super-admin.notices');

    Route::resource('/super-admin/about', InstituteProfileController::class)
        ->except(['show'])
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->names('super-admin.about');
    Route::get('/super-admin/homepage/{section}/items', [HomepageContentController::class, 'index'])->name('super-admin.homepage.items.index');
    Route::patch('/super-admin/homepage/sections/{section}', [HomepageContentController::class, 'updateSection'])->name('super-admin.homepage.sections.update');
    Route::get('/super-admin/homepage/{section}/items/create', [HomepageContentController::class, 'create'])->name('super-admin.homepage.items.create');
    Route::post('/super-admin/homepage/items', [HomepageContentController::class, 'store'])->name('super-admin.homepage.items.store');
    Route::get('/super-admin/homepage/items/{item}/edit', [HomepageContentController::class, 'edit'])->name('super-admin.homepage.items.edit');
    Route::put('/super-admin/homepage/items/{item}', [HomepageContentController::class, 'update'])->name('super-admin.homepage.items.update');
    Route::delete('/super-admin/homepage/items/{item}', [HomepageContentController::class, 'destroy'])->name('super-admin.homepage.items.destroy');
    Route::patch('/super-admin/about/{about}/publish', [InstituteProfileController::class, 'togglePublish'])
        ->middleware('role:'.UserRole::SuperAdmin->value)
        ->name('super-admin.about.publish');

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
