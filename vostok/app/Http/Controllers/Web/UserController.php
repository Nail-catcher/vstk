<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFilter;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param UserFilter $request
     * @return UsersResource
     */
    public function __invoke(UserFilter $request): UsersResource
    {
        $input = $request->validated();
        $user = Auth::user();
        $users = User::filter($input);
        if ($user->hasRole('engineer')) {
            $users->where('id', '!=', $user->id);
        }
        return new UsersResource($users->orderBy('lastname')->limit(15)->get());
    }
}
