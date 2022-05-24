<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StartingStocktaking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'serial_number'
    ];

    /**
     * @return BelongsTo
     */
    public function stocktaking(): BelongsTo
    {
        return $this->belongsTo(Stocktaking::class);
    }

    /**
     * @return BelongsTo
     */
    public function starting(): BelongsTo
    {
        return $this->belongsTo(Starting::class);
    }
}
