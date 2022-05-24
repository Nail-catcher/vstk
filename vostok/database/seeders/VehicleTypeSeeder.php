<?php

namespace Database\Seeders;
use App\Models\VehicleType;
use Illuminate\Database\Seeder;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleType::create([
            'title' => 'Служебный автотранспорт'
        ]);
        VehicleType::create([
            'title' => 'Личный автотранспорт'
        ]);
        VehicleType::create([
            'title' => 'Автотранспорт АО Казахтелеком'
        ]);
        VehicleType::create([
            'title' => 'Общественный транспорт'
        ]);
    }
}
