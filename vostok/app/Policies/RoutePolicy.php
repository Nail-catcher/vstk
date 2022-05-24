<?php

namespace App\Policies;

use App\Models\Route;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoutePolicy
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
        return $user->hasPermission('index.routes');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Route $route
     * @return mixed
     */
    public function view(User $user, Route $route)
    {
        return $user->hasPermission('view.routes');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create.routes');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Route $route
     * @return mixed
     */
    public function update(User $user, Route $route)
    {
        return $user->hasPermission('edit.routes');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Route $route
     * @return mixed
     */
    public function delete(User $user, Route $route)
    {
        return $user->hasPermission('delete.routes');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Route $route
     * @return mixed
     */
    public function restore(User $user, Route $route)
    {
        return $user->hasPermission('restore.routes');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Route $route
     * @return mixed
     */
    public function forceDelete(User $user, Route $route)
    {
        return $user->hasPermission('destroy.routes');
    }
}
