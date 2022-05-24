<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Position::create(['title' => 'Начальник отдела информационных технологий']);
        Position::create(['title' => 'Начальник сектора']);
        Position::create(['title' => 'Главный специалист']);
        Position::create(['title' => 'Ведущий специалист']);
        Position::create(['title' => 'Специалист 1 категории']);
        Position::create(['title' => 'Специалист 2 категории']);
        Position::create(['title' => 'Специалист 3 категории']);
        Position::create(['title' => 'Начальник эксплуатационного участка']);
        Position::create(['title' => 'Руководитель регионального подразделения']);
        Position::create(['title' => 'Инженер 1 категории по радиооборудованию']);
        Position::create(['title' => 'Инженер 2 категории по радиооборудованию']);
        Position::create(['title' => 'Инженер 3 категории по радиооборудованию']);
        Position::create(['title' => 'Старший электромеханик']);
        Position::create(['title' => 'Старший электромеханик (водитель)']);
        Position::create(['title' => 'Электромеханик (водитель)']);
        Position::create(['title' => 'Электромеханик']);
    }
}
