<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    use SpatialTrait;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'address',
        'mci',
        'cost'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'mci' => 'integer',
        'cost' => 'float',
        'latitude' => 'float',
        'longitude' => 'float'
    ];

    protected $spatialFields = [
        'location'
    ];

    public function setLatitudeAttribute($value)
    {
        $this->attributes['location'] = new Point($value, $this->longitude);
    }

    public function setLongitudeAttribute($value)
    {
        $this->attributes['location'] = new Point($this->latitude, $value);
    }

    public function getLatitudeAttribute()
    {
        return optional($this->location)->getlat();
    }

    public function getLongitudeAttribute()
    {
        return optional($this->location)->getLng();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }

}
