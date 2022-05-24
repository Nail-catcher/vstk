<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Protocol extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'type',
        'serial_number',
        'rated_capacity',
        'rated_voltage',
        'rated_number',
        'capacity',
        'allowable_capacity',
        'discharge_time_0',
        'discharge_time_30',
        'discharge_time_60',
        'discharge_time_90',
        'discharge_time_120',
        'discharge_time_150',
        'discharge_time_180',
        'discharge_time_210',
        'discharge_time_240',
        'discharge_time_270',
        'discharge_time_300',
        'discharge_time_330',
        'discharge_time_360',
        'discharge_time_390',
        'discharge_time_420',
        'discharge_time_450',
        'discharge_time_480',
        'device'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'rated_capacity' => 'float',
        'rated_voltage' => 'float',
        'rated_number' => 'float',
        'capacity' => 'float',
        'allowable_capacity' => 'float',
        'discharge_time_0' => 'float',
        'discharge_time_30' => 'float',
        'discharge_time_60' => 'float',
        'discharge_time_90' => 'float',
        'discharge_time_120' => 'float',
        'discharge_time_150' => 'float',
        'discharge_time_180' => 'float',
        'discharge_time_210' => 'float',
        'discharge_time_240' => 'float',
        'discharge_time_270' => 'float',
        'discharge_time_300' => 'float',
        'discharge_time_330' => 'float',
        'discharge_time_360' => 'float',
        'discharge_time_390' => 'float',
        'discharge_time_420' => 'float',
        'discharge_time_450' => 'float',
        'discharge_time_480' => 'float',
    ];

    /**
     * @return BelongsTo
     */
    public function starting(): BelongsTo
    {
        return $this->belongsTo(Starting::class);
    }

    /**
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * @return BelongsTo
     */
    public function battery(): BelongsTo
    {
        return $this->belongsTo(Battery::class);
    }
}
