<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Document::create(['title' => 'Отчет ППР операторов', 'type' => 'report']);
        Document::create(['title' => 'Отчеты загруженности по проектам', 'type' => 'report']);
        Document::create(['title' => 'Отчет по АВР МТС', 'type' => 'report']);
        Document::create(['title' => 'Отчет по выездам АВР', 'type' => 'report']);
        Document::create(['title' => 'Акт выполненных работ при ППР', 'type' => 'act']);
        Document::create(['title' => 'Акт установки-демонтажа', 'type' => 'act']);
        Document::create(['title' => 'Лист инвентаризации', 'type' => 'act']);
        Document::create(['title' => 'Акт разряда-заряда АКБ', 'type' => 'act']);
        Document::create(['title' => 'Акт сверки показаний э.энергии', 'type' => 'act']);
        Document::create(['title' => 'Акт дефектовки', 'type' => 'act']);
        Document::create(['title' => 'Акт выполненых работ при АВР', 'type' => 'act']);
    }
}
