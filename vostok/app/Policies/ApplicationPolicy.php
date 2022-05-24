<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('index.applications');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Application $application
     * @return mixed
     */
    public function view(User $user, Application $application)
    {
        return $user->hasPermission('view.applications');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create.applications');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Application $application
     * @return mixed
     */
    public function update(User $user, Application $application)
    {
        return $user->hasPermission('edit.applications');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Application $application
     * @return mixed
     */
    public function delete(User $user, Application $application)
    {
        return $user->hasPermission('delete.applications');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Application $application
     * @return mixed
     */
    public function restore(User $user, Application $application)
    {
        return $user->hasPermission('restore.applications');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Application $application
     * @return mixed
     */
    public function forceDelete(User $user, Application $application)
    {
        return $user->hasPermission('destroy.applications');
    }
}
