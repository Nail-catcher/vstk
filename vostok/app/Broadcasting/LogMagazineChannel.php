<?php

namespace App\Broadcasting;

use App\Models\LogMagazine;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LogMagazineChannel
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
     * @param LogMagazine $logMagazine
     * @return array|bool
     */
    public function join(User $user, LogMagazine $logMagazine)
    {
        return Auth::check();
    }
}
