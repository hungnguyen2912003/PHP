<?php

namespace App\Policies;

use App\Models\Measurement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MeasurementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Measurement $measurement): bool
    {
        return $user->isAdmin() || $user->id === $measurement->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Measurement $measurement): bool
    {
        return $user->isAdmin() || $user->id === $measurement->user_id;
    }

    public function delete(User $user, Measurement $measurement): bool
    {
        return $user->isAdmin() || $user->id === $measurement->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Measurement $measurement): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Measurement $measurement): bool
    {
        return false;
    }
}
