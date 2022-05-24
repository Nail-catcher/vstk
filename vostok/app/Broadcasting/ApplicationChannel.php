<?php

namespace App\Broadcasting;

use App\Models\Application;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApplicationChannel
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
     * @param Application $application
     * @return array|bool
     */
    public function join(User $user, Application $application)
    {
        return Auth::check();
    }
}
