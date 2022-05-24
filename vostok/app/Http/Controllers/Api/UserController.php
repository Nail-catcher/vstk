<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFilter;
use App\Http\Requests\UserStore;
use App\Http\Requests\UserUpdate;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserFilter $request
     * @return UsersResource
     */
    public function index(UserFilter $request): UsersResource
    {
        $user = Auth::user();
        $users = User::with('division', 'position', 'roles')
            ->where('division_id', '=', Auth::user()->division_id)
            ->filter($request->validated());
        if ($user->hasRole('engineer')) {
            $users->where('id', '!=', $user->id);
        }
        return new UsersResource(
            $users->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStore $request
     * @return UserResource
     */
    public function store(UserStore $request)
    {
        $data = $request->validated();
        $user = new User();
        $user->fill($data);
        $user->position()->associate($data['position']);
        $user->division()->associate($data['division']);
        $user->password = Hash::make($data['password']);
        $user->save();
        $user->attachRole($data['role']);

        return new UserResource($user->load('division', 'position', 'roles'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user->load(['division', 'position', 'roles']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return UserResource
     */
    public function update(UserUpdate $request, User $user): UserResource
    {
        $data = $request->validated();
        $user->fill($data);
        $user->detachAllRoles();
        $user->attachRole($data['role']);
        $user->position()->associate($data['position']);
        $user->division()->associate($data['division']);
        $user->save();

        return new UserResource($user->load('division', 'position', 'roles'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
