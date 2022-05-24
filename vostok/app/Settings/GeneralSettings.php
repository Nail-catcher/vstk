<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public float $monthly_calculation_index;
   
    public static function group(): string
    {
        return 'general';
    }
}
