<?php

namespace App\Http\Controllers\Api;

use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return UserResource
     */
    public function index(): UserResource
    {
        return new UserResource(Auth::user()->load('roles', 'position', 'division'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return UserResource
     */
    public function update(Request $request): UserResource
    {
        $updater = new UpdateUserProfileInformation();
        $updater->update($request->user(), $request->all());
        return new UserResource(Auth::user()->load('roles', 'position', 'division'));
    }
}
