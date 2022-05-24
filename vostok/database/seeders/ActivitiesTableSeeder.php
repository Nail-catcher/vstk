<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Activity::create([
            'title' => 'Новый'
        ]);
        Activity::create([
            'title' => 'Активный'
        ]);
        Activity::create([
            'title' => 'Пауза'
        ]);
        Activity::create([
            'title' => 'Завершен'
        ]);
        Activity::create([
            'title' => 'Отменен'
        ]);
        Activity::create([
            'title' => 'Закрыт'
        ]);
    }
}
