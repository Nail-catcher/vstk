<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Station;
use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;

class ApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dispatchers = User::whereHas('roles', function (Builder $query) {
            $query->where('slug', '=', 'dispatcher');
        })->get();
        Station::with('division', 'division.user')->chunk(100, function ($stations) use ($dispatchers) {
            $stations->each(function ($station) use ($dispatchers) {
                $works = Work::inRandomOrder()->limit(random_int(1, 4))->get();
                Application::factory()->count(1)->create([
                    'dispatcher_id' => $dispatchers->random()->first()->id,
                    'area_id' => $station->area_id,
                    'division_id' => $station->division_id,
                    'user_id' => $station->division->user->id,
                    'work_id' => $works->first()->id
                ])->each(function ($application) use ($station, $works) {
                    $application->stations()->attach(Station::where('area_id', '=', $station->area_id)->inRandomOrder()->limit(3)->get());
                    $application->works()->attach($works);
                    $application->save();
                });
            });
        });


    }
}
