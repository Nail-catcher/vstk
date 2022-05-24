<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title'
    ];

    // /**
    //  * @return BelongsToMany
    //  */
    // public function applicationReports(): BelongsToMany
    // {
    //     return $this->belongsToMany(ApplicationReport::class);
    // }
}
