<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Progress;
use App\Models\Starting;
use App\Models\StartingProgress;
use Illuminate\Database\Seeder;

class ApplicationProgressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prog = Progress::all();
        Application::where('status_id', '=', 4)->with('stations')->chunk(200, function ($applications) use ($prog) {
            $applications->each(function (Application $application) use ($prog) {
                $application->stations->each(function ($station) use ($application, $prog) {
                    $starting = new Starting();
                    $starting->application()->associate($application);
                    $starting->user()->associate($application->engineer);
                    $starting->station()->associate($station);
                    $starting->save();
                    $prog->each(function ($p) use ($starting) {
                        $progress = new StartingProgress();
                        $progress->starting()->associate($starting);
                        $progress->progress()->associate($p);
                        $progress->save();
                    });
                    $application->stations()->updateExistingPivot($station, [
                        'starting_id' => $starting->id,
                        'is_complete' => true
                    ]);
                    $application->started_at = now();
                    $application->lastStarting()->associate($starting);
                    $application->save();
                });
            });
        });
    }
}
