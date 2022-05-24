<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeekendDay extends Model
{
    use HasFactory;
    protected $fillable = ['id','date'];
    public $timestamps = false;
    protected $casts = [
        'date' => 'date'
    ];
}
