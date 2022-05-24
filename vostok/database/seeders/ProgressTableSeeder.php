<?php

namespace Database\Seeders;

use App\Models\Progress;
use Illuminate\Database\Seeder;

class ProgressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Progress::create([
            'type_id' => 1,
            'title' => 'Начало работ'
        ]);
        Progress::create([
            'type_id' => 1,
            'title' => 'Выезд за ключами'
        ]);
        Progress::create([
            'type_id' => 1,
            'title' => 'Выезд за оборудованием'
        ]);
        Progress::create([
            'type_id' => 1,
            'title' => 'Прибыл на БС'
        ]);
        Progress::create([
            'type_id' => 1,
            'title' => 'Установка оборудования'
        ]);
        Progress::create([
            'type_id' => 1,
            'title' => 'Отчет о работах'
        ]);
        Progress::create([
            'type_id' => 2,
            'title' => 'Контрольный разряд АКБ'
        ]);
        Progress::create([
            'type_id' => 2,
            'title' => 'Блок сигнализации и датчиков телеметрии'
        ]);
        Progress::create([
            'type_id' => 2,
            'title' => 'Проверка крепления секторных антенн'
        ]);
        Progress::create([
            'type_id' => 2,
            'title' => 'Принадлежность секторных антенн'
        ]);
        Progress::create([
            'type_id' => 2,
            'title' => 'Проверка направленности секторных антенн'
        ]);
        Progress::create([
            'type_id' => 2,
            'title' => 'Проверка герметизации разъемов секторных антенн'
        ]);
        Progress::create([
            'type_id' => 2,
            'title' => 'Осмотр фидерного кабеля на предмет повреждения'
        ]);
        Progress::create([
            'type_id' => 2,
            'title' => 'Проверка креплений фидерного кабеля'
        ]);
        Progress::create([
            'type_id' => 2,
            'title' => 'Проверка крепления и герметизации разъёмов  GPS антенны'
        ]);
        Progress::create([
            'type_id' => 2,
            'title' => 'Очистка оборудования БС от пыли'
        ]);
        Progress::create([
            'type_id' => 2,
            'title' => 'Сверка серийных номеров согласно технического паспорта'
        ]);
        Progress::create([
            'type_id' => 2,
            'title' => 'Измерение напряжений фаз на вводном автомате ЭПУ БС'
        ]);
    }
}
