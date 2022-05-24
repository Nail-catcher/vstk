<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public const NEW = 1;
    public const ACTIVE = 2;
    public const PAUSE = 3;
    public const COMPLETED = 4;
    public const CANCELED = 5;
    public const CLOSED = 6;
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function route(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Route::class);
    }
}
