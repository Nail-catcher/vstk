<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\ApplicationAccept;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;

class ApplicationAcceptsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = User::whereHas('roles', function (Builder $query) {
            $query->where('roles.id', '=', 4);
        })->get();
        Application::with([
            'users'
        ])->where('status_id', '=', Status::ACCEPTED)->chunk(200, function ($applications) use ($users) {
            $applications->each(function (Application $application) use ($users) {
                ApplicationAccept::factory()->count(1)->create([
                    'user_id' => $users->random()->first()->id,
                    'application_id' => $application->id
                ])->each(function (ApplicationAccept $accept) use ($application) {
                    $accept->users()->attach($application->users);
                });
            });
        });

    }
}
