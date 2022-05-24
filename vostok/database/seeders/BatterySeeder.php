<?php

namespace Database\Seeders;

use App\Models\Battery;
use App\Models\Group;
use Illuminate\Database\Seeder;

class BatterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Group::chunk(100, function ($groups) {
            $groups->each(function (Group $group) {
                for ($i = 1; $i <= 4; $i++) {
                    Battery::factory()->count(1)
                        ->create([
                            'number' => $i,
                            'group_id' => $group->id
                        ]);
                }
            });
        });
    }
}
