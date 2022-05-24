<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\RouteLocation;
use Illuminate\Database\Seeder;

class RouteLocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Route::with('engineer')->where('activity_id', '=', 4)->chunk(100, function ($routes) {
            $routes->each(function (Route $route) {
                RouteLocation::factory()->count(10)->create([
                    'user_id' => $route->engineer_id,
                    'route_id' => $route->id
                ]);
            });
        });
    }
}
