<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Route;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class RoutesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $users->each(function ($user) {
            $area_id = $user->division->areas()->inRandomOrder()->first()->id;
            Route::factory()->count(10)->create([
                'division_id' => $user->division_id,
                'area_id' => $area_id,
                'user_id' => $user->id,
                'engineer_id' => User::where('division_id', '=', $user->division_id)->whereHas('roles', function ($query) {
                    $query->where('roles.id', '=', 4);
                })->inRandomOrder()->first()->id,
                'vehicle_id' => Vehicle::inRandomOrder()->first()->id
            ])->each(function (Route $route) use ($area_id) {
                $applications = Application::where('area_id', '=', $area_id)
                    ->where('status_id', '>', 1)
                    ->inRandomOrder()->limit(5)->get();
                $route->applications()->attach($applications);
                $route->distance = $applications->sum('distance');
                $route->save();
            });

        });

    }
}
