<?php

namespace App\Actions;

use App\Enums\BranchApplicationStatus;
use App\Enums\UserRole;
use App\Models\BranchApplication;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ApproveBranchApplication
{
    public function handle(BranchApplication $application): void
    {
        DB::transaction(function () use ($application): void {
            $application = BranchApplication::query()->lockForUpdate()->findOrFail($application->getKey());

            if ($application->status !== BranchApplicationStatus::Pending) {
                throw ValidationException::withMessages(['status' => 'This branch application has already been reviewed.']);
            }

            if (! $application->email || ! $application->password) {
                throw ValidationException::withMessages(['application' => 'This application is missing login credentials.']);
            }

            if (User::query()->where('email', $application->email)->exists()) {
                throw ValidationException::withMessages(['email' => 'A user account already exists for this email address.']);
            }

            $user = User::query()->create([
                'name' => $application->director_name ?: $application->institute_name,
                'email' => $application->email,
                'role' => UserRole::Branch,
                'password' => 'temporary-password',
            ]);

            User::query()->whereKey($user->getKey())->update([
                'password' => $application->getRawOriginal('password'),
            ]);

            $application->update([
                'status' => BranchApplicationStatus::Approved,
                'reviewed_at' => now(),
                'password' => null,
            ]);
        });
    }
}
