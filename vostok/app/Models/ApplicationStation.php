<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ApplicationStation extends Pivot
{
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'sort' => 'integer',
        'is_complete' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function application(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function station(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Station::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function starting(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Starting::class);
    }
}
