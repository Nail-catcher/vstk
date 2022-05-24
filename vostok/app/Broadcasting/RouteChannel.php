<?php

namespace App\Broadcasting;

use App\Models\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RouteChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param \App\Models\User $user
     * @param Route $route
     * @return array|bool
     */
    public function join(User $user, Route $route)
    {
        return Auth::check();
    }
}
