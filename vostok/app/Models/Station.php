<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Station extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SpatialTrait;
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'bts_id',
        'rac',
        'title',
        'base_station_type',
        'type_steel_structure',
        'supply',
        'distance',
        'prop_height',
        'prop_type',
        'antenna_suspension_height_a',
        'antenna_suspension_height_b',
        'antenna_suspension_height_c',
        'antenna_azimuths_tilt_angle_a',
        'antenna_azimuths_tilt_angle_b',
        'antenna_azimuths_tilt_angle_c',
        'equipment_installation_location',
        'antenna_installation_location',
        'guaranteed_power',
        'stand_type',
        'rectifier_units_type',
        'number_rectifier_units',
        'battery_capacity',
        'battery_count',
        'priority',
        'order_number',
        'order_additional',
        'subcon',
        'comment'
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
     * @return BelongsTo
     */
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * @return BelongsTo
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
    /**
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    /**
     * @return BelongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /**
     * @return BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return BelongsToMany
     */
    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class);
    }

    /**
     * @return BelongsToMany
     */
    public function inventories(): BelongsToMany
    {
        return $this->belongsToMany(Inventory::class)->withTimestamps();
    }

    /**
     * @return HasMany
     */
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    /**
     * @return HasManyThrough
     */
    public function batteries(): HasManyThrough
    {
        return $this->hasManyThrough(Battery::class, Group::class);
    }

    /**
     * @return BelongsTo
     */
    public function stationType(): BelongsTo
    {
        return $this->belongsTo(StationType::class);
    }

    /**
     * @return BelongsToMany
     */
    public function sensors(): BelongsToMany
    {
        return $this->belongsToMany(Sensor::class);
    }
}
