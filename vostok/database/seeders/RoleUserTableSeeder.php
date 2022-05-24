<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function (User $user) {
            if (array_has([1], $user->position_id)) {
                $role = 1;
            } elseif (array_has([2, 3, 4, 5, 6, 7], $user->position_id)) {
                $role = 2;
            } elseif (array_has([8, 9], $user->position_id)) {
                $role = 3;
            } else {
                $role = 4;
            }
            $user->attachRole($role);
        });

    }
}
