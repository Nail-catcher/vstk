<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Starting extends Model
{
    /**
     * @return BelongsTo
     */
    public function station(): BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    /**
     * @return BelongsTo
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function progresses(): HasMany
    {
        return $this->hasMany(StartingProgress::class);
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(ProgressType::class);
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
    public function measurements(): HasMany
    {
        return $this->hasMany(Measurement::class);
    }

    /**
     * @return HasMany
     */
    public function defectives(): HasMany
    {
        return $this->hasMany(Defective::class);
    }

    /**
     * @return HasMany
     */
    public function stocktackings(): HasMany
    {
        return $this->hasMany(StartingStocktaking::class);
    }
}
