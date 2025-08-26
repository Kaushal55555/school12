<?php

namespace App\Policies;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchoolClassPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('teacher');
    }
    
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SchoolClass $schoolClass): bool
    {
        return $user->hasRole('admin') || 
               $schoolClass->subjectAssignments()->where('teacher_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SchoolClass $schoolClass): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SchoolClass $schoolClass): bool
    {
        return $user->hasRole('admin') && $schoolClass->students()->count() === 0;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SchoolClass $schoolClass): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SchoolClass $schoolClass): bool
    {
        return $user->hasRole('admin');
    }
}
