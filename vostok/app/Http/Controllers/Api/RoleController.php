<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RolesResource;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;

class RoleController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return RolesResource
     */
    public function __invoke(Request $request)
    {
        return new RolesResource(Role::all());
    }
}
