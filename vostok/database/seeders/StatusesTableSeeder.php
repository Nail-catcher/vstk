<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'title' => 'Новая'
        ]);
        Status::create([
            'title' => 'Принята'
        ]);
        Status::create([
            'title' => 'В работе'
        ]);
        Status::create([
            'title' => 'Завершена'
        ]);
        Status::create([
            'title' => 'Доработка'
        ]);
        Status::create([
            'title' => 'Отвергнута'
        ]);
        Status::create([
            'title' => 'Закрыта'
        ]);
        Status::create([
            'title' => 'Отменена'
        ]);
    }
}
