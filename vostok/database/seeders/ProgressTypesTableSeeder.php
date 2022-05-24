<?php

namespace Database\Seeders;

use App\Models\ProgressType;
use Illuminate\Database\Seeder;

class ProgressTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProgressType::create([
            'type_id' => 1,
            'title' => 'Стандартная АВР'
        ]);
        ProgressType::create([
            'type_id' => 2,
            'title' => 'Выполнение ППР'
        ]);
        ProgressType::create([
            'type_id' => 2,
            'title' => 'Протокол разряда АКБ'
        ]);
        ProgressType::create([
            'type_id' => 2,
            'title' => 'Показания электроэнергии'
        ]);
        ProgressType::create([
            'type_id' => 2,
            'title' => 'Инвентаризации'
        ]);
        ProgressType::create([
            'type_id' => 1,
            'title' => 'Дефектовка оборудования'
        ]);
    }
}
