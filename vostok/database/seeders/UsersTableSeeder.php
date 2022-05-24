<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Division::all()->each(function ($division) {
            Position::all()->each(function ($position) use ($division) {
                User::factory()->count(1)->create([
                    'division_id' => $division->id,
                    'position_id' => $position->id
                ]);
            });
            $user = User::where('position_id', '=', 3)
                ->where('division_id', '=', $division->id)->first();
            if ($user === null) {
                $user = User::where('position_id', '=', 3)->first();
                $user->position()->associate(3);
                $user->save();
            }
            $division->user()->associate($user);
            $division->save();
        });
        User::first()->attachRole(Role::where('slug', '=', 'admin')->first());
    }
}
