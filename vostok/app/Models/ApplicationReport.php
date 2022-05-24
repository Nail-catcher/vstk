<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ApplicationReport extends Model
{
    protected $fillable = [
        'comment'
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * @return MorphMany
     */
    public function images(): MorphMany
    {

        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return BelongsToMany
     */
    public function works(): BelongsToMany
    {
        return $this->belongsToMany(Work::class);
    }

    /**
     * @return BelongsTo
     */
    public function engineer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

