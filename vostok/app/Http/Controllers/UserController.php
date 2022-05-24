<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFilter;
use App\Http\Requests\UserStore;
use App\Http\Requests\UserUpdate;
use App\Http\Resources\UsersResource;
use App\Models\Area;
use App\Models\Division;
use App\Models\Position;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use jeremykenedy\LaravelRoles\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(UserFilter $request): \Inertia\Response
    {
        $input = $request->validated();
        $users = User::with('division', 'position', 'status', 'roles')
            ->withCount('applications')
            ->filter($input)
            ->latest('id');
        return Inertia::render('Users/Index', [
            'divisions' => Division::all(),
            'statuses' => UserStatus::all(),
            'positions' => Position::all(),
            'roles' => Role::all(),
            'users' => new UsersResource($users->paginate()->appends($input)),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('Users/Create', [
            'roles' => Role::all(),
            'positions' => Position::all(),
            'divisions' => Division::all(),
            'areas' => Area::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStore $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserStore $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();
        $user = new User();
        $user->fill($data);
        $user->position()->associate($data['position']);
        $user->division()->associate($data['division']);
        $user->area()->associate($data['area']);
        $user->status()->associate(1);
        $user->password = Hash::make($data['password']);
        $user->save();
        $user->attachRole($data['role']);
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return void
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Inertia\Response
     */
    public function edit(User $user): \Inertia\Response
    {
        return Inertia::render('Users/Edit', [
            'user' => $user->load('roles', 'position', 'division'),
            'roles' => Role::all(),
            'positions' => Position::all(),
            'divisions' => Division::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdate $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdate $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();
        $user->fill($data);
        $user->detachAllRoles();
        $user->attachRole($data['role']);
        $user->position()->associate($data['position']);
        $user->division()->associate($data['division']);
        $user->save();

        return redirect()->route('user.index');
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
