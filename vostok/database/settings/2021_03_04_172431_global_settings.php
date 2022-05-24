<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class GlobalSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.monthly_calculation_index', 2917);
    }
}
