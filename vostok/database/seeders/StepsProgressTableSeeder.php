<?php

namespace Database\Seeders;
use App\Models\StepsProgress;
use Illuminate\Database\Seeder;

class StepsProgressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//выехали
        StepsProgress::create([
            'step_id' => 3,
            'progress_id' => 2,
        ]);
        StepsProgress::create([
            'step_id' => 3,
            'progress_id' => 3,
        ]);
        StepsProgress::create([
            'step_id' => 3,
            'progress_id' => 4,
        ]);
        //прибыли
        StepsProgress::create([
            'step_id' => 5,
            'progress_id' => 2,
        ]);
        StepsProgress::create([
            'step_id' => 5,
            'progress_id' => 3,
        ]);
        StepsProgress::create([
            'step_id' => 5,
            'progress_id' => 4,
        ]);
        //получили
        StepsProgress::create([
            'step_id' => 4,
            'progress_id' => 2,
        ]);
        StepsProgress::create([
            'step_id' => 4,
            'progress_id' => 3,
        ]);
		//уехали
        StepsProgress::create([
            'step_id' => 6,
            'progress_id' => 2,
        ]);
        StepsProgress::create([
            'step_id' => 6,
            'progress_id' => 3,
        ]);
        StepsProgress::create([
            'step_id' => 6,
            'progress_id' => 4,
        ]);
    }
}
