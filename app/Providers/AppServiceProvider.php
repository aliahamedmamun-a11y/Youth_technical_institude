<?php

namespace App\Providers;

use App\Enums\BranchApplicationStatus;
use App\Models\BranchApplication;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        if (! file_exists(public_path('storage')) && file_exists(storage_path('app/public'))) {
            @symlink(storage_path('app/public'), public_path('storage'));
        }

        View::composer('components.dashboard-shell', function ($view): void {
            $view->with([
                'adminNavigation' => config('admin_navigation'),
                'pendingBranchApplications' => BranchApplication::query()
                    ->where('status', BranchApplicationStatus::Pending->value)
                    ->count(),
            ]);
        });
    }
}
