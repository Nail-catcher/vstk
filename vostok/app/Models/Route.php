<?php

namespace App\Models;

use App\Eloquent\Traits\ByDivisionTrait;
use EloquentFilter\Filterable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Route extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filterable;
    use ByDivisionTrait;
    use SpatialTrait;
    use LogsActivity;

    protected static $logAttributes = ['activity.title'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'unid',
        'order_unid',
        'order_number',
        'attempts',
        'distance',
        'actual_distance',
        'fuel_costs',
        'travel_costs',
        'material_costs',
        'overnight_costs',
        'expenses',
        'fuels',
        'started_at',
        'deadline_at',
        'activity_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'distance' => 'float',
        'actual_distance' => 'float',
        'expenses' => 'float',
        'fuel_costs' => 'float',
        'travel_costs' => 'float',
        'material_costs' => 'float',
        'overnight_costs' => 'float',
        'fuels' => 'float',
        'started_at' => 'datetime',
        'deadline_at' => 'datetime'
    ];

    protected $spatialFields = [
        'start_location'
    ];

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotIn('activity_id', [Activity::COMPLETED, Activity::CLOSED, Activity::CANCELED]);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->whereIn('activity_id', [Activity::COMPLETED, Activity::CLOSED, Activity::CANCELED]);
    }

    /**
     * @return BelongsToMany
     */
    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class,'application_route')
            ->withPivot([
                'sort'
            ])
            ->orderByPivot('sort');
    }

    /**
     * @return BelongsToMany
     */
    public function exApplications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class,'ex_applications');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function engineer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
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
    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * @return BelongsTo
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    /**
     * @return BelongsTo
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
    /**
     * @return BelongsTo
     */
    public function vehicle_type(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }
    /**
     * @return BelongsToMany
     */
    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class);
    }

    /**
     * @return BelongsToMany
     */
    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(Address::class);
    }

    /**
     * @return HasMany
     */
    public function locations(): HasMany
    {
        return $this->hasMany(RouteLocation::class, 'route_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function closures(): HasMany
    {
        return $this->hasMany(RouteClosure::class);
    }

    /**
     * @return BelongsToMany
     */
    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Place::class);
    }

    /**
     * @return BelongsToMany
     */
    public function consumables(): BelongsToMany
    {
        return $this->belongsToMany(Consumable::class)
            ->withPivot([
                'count'
            ]);
    }
}
