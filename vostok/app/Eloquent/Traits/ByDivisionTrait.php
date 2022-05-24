<?php


namespace App\Eloquent\Traits;

use App\Eloquent\Scopes\ByDivisionScope;
use Illuminate\Support\Facades\Auth;

trait ByDivisionTrait
{
    protected static function booted()
    {
        if (Auth::check()) {
            static::addGlobalScope(new ByDivisionScope());
        }
    }
}
