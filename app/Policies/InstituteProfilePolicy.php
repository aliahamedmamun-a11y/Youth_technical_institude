<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\InstituteProfile;
use App\Models\User;

class InstituteProfilePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(UserRole::SuperAdmin);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InstituteProfile $instituteProfile): bool
    {
        return $user->hasRole(UserRole::SuperAdmin);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(UserRole::SuperAdmin);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InstituteProfile $instituteProfile): bool
    {
        return $user->hasRole(UserRole::SuperAdmin);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InstituteProfile $instituteProfile): bool
    {
        return $user->hasRole(UserRole::SuperAdmin);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, InstituteProfile $instituteProfile): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, InstituteProfile $instituteProfile): bool
    {
        return false;
    }
}
