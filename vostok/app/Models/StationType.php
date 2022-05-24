<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StationType extends Model
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

    /**
     * @return HasMany
     */
    public function stations(): HasMany
    {
        return $this->hasMany(Station::class);
    }

    /**
     * @return BelongsToMany
     */
    public function stocktakings(): BelongsToMany
    {
        return $this->belongsToMany(Stocktaking::class);
    }
}
