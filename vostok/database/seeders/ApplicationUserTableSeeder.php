<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApplicationUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::whereNotIn('id', [1, 2])->get();
        Application::whereNotIn('status_id', [1])->chunk(200, function ($applications) use ($users) {
            $applications->each(function (Application $application) use ($users) {
                $application->users()->attach($users->random(3));
            });
        });

    }
}
