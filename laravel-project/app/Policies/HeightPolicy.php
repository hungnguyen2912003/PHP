<?php

namespace App\Policies;

use App\Models\Height;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class HeightPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Height $height): bool
    {
        return $user->isAdmin() || $user->id === $height->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Height $height): bool
    {
        return $user->isAdmin() || $user->id === $height->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Height $height): bool
    {
        return $user->isAdmin() || $user->id === $height->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Height $height): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Height $height): bool
    {
        return false;
    }
}
