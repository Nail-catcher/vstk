<?php

namespace App\Http\Controllers;

use App\Actions\Users\UpdateUser;
use App\Http\Requests\UserStatusUpdate;
use App\Models\User;

class UserStatusController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param UserStatusUpdate $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(UserStatusUpdate $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $input = $request->validated();
        (new UpdateUser())->updateStatus($user, $input);
        return redirect()->back();
    }
}
