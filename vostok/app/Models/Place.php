<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Place extends Model
{
    use SpatialTrait;
    use Filterable;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'address'
    ];

    protected $spatialFields = [
        'location'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float'
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
     * @return BelongsToMany
     */
    public function routes(): BelongsToMany
    {
        return $this->belongsToMany(Route::class);
    }

    /**
     * @return BelongsTo
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

}
