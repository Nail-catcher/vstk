<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Database\Seeder;

class UserStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserStatus::create([
            'title' => 'Активен'
        ]);
        UserStatus::create([
            'title' => 'Загруженность'
        ]);
        UserStatus::create([
            'title' => 'Отпуск'
        ]);
        UserStatus::create([
            'title' => 'Больничный'
        ]);
        UserStatus::create([
            'title' => 'Отгул'
        ]);
        User::whereNull('status_id')->update(['status_id' => 1]);
    }
}
