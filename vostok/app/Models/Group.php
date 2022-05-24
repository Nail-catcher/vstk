<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'number'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'title'
    ];

    /**
     * @return string
     */
    public function getTitleAttribute(): string
    {
        return "Группа $this->number";
    }

    /**
     * @return BelongsTo
     */
    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    /**
     * @return HasMany
     */
    public function protocols(): HasMany
    {
        return $this->hasMany(Protocol::class);
    }

    /**
     * @return HasMany
     */
    public function batteries(): HasMany
    {
        return $this->hasMany(Battery::class);
    }

    /**
     * @return MorphOne
     */
    public function preventive(): MorphOne
    {
        return $this->morphOne(PreventiveWork::class, 'modelable');
    }
}
