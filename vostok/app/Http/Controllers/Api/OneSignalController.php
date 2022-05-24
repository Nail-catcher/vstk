<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OneSignalController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $user->one_signal_token = $request->token;
        $user->save();
        User::where('one_signal_token', '=', $request->token)
            ->where('id', '!=', $user->id)
            ->update([
                'one_signal_token' => null
            ]);
    }
}
