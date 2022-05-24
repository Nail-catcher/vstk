<?php

namespace Database\Seeders;

use App\Models\Steps;
use Illuminate\Database\Seeder;

class StepsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Steps::create([
            'title' => 'Начало действия'
        ]);
        Steps::create([
            'title' => 'Окончание действия'
        ]);
        Steps::create([
            'title' => 'Выехали'
        ]);
        Steps::create([
            'title' => 'Получили'
        ]);
        Steps::create([
            'title' => 'Прибыли'
        ]);
        Steps::create([
            'title' => 'Уехали'
        ]);
    }
}
