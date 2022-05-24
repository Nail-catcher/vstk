<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Defective extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'serial_number',
        'inventory_number',
        'quantity',
        'comment',
        'barcode',
        'barcode_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'quantity' => 'integer'
    ];

    /**
     * @return BelongsTo
     */
    public function starting(): BelongsTo
    {
        return $this->belongsTo(Starting::class);
    }
}
