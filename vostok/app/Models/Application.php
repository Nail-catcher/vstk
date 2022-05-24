<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Application extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filterable;
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    /* add logs activity to this model*/
    use LogsActivity;

    protected static $logAttributes = ['status.title'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
//    use ByDivisionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'unid',
        'order_unid',
        'ticket',
        'document',
        'priority',
        'description',
        'comment',
        'pickup_keys',
        'keys_comment',
        'distance',
        'attempts',
        'overdue_attempts',
        'deadline_at',
        'started_at',
        'ended_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'distance' => 'float',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'deadline_at' => 'datetime'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'hours_count',
        'title',
        'is_approvable',
        'is_overdue'
    ];

    /**
     * @return bool
     */
    public function getIsOverdueAttribute(): bool
    {
        return ($this->deadline_at < now() && in_array($this->status_id, [Status::IN_WORK, Status::NEW, Status::ACCEPTED], true));
    }

    /**
     * @return bool
     */
    public function getIsApprovableAttribute(): bool
    {
        return (
            empty($this->unid) &&
            ($this->status_id === Status::IN_WORK || $this->status_id === Status::ACCEPTED) &&
            empty($this->document) && empty($this->order_unid)
        );
    }

    /**
     * @return int | void
     */
    public function getHoursCountAttribute()
    {
        if ($this->ended_at !== null) {
            return $this->ended_at->diffInHours($this->started_at);
        }
    }

    /**
     * @return string
     */
    public function getTitleAttribute(): string
    {
        return (string)$this->id;
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'id' => null,
            'lastname' => 'N/A',
            'firstname' => 'N/A',
            'middlename' => 'N/A',
            'email' => 'N/A',
        ]);
    }

    /**
     * @return BelongsTo
     */
    public function engineer(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'id' => null,
            'lastname' => 'N/A',
            'firstname' => 'N/A',
            'middlename' => 'N/A',
            'email' => 'N/A',
        ]);
    }

    /**
     * @return BelongsTo
     */
    public function dispatcher(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'id' => null,
            'lastname' => 'N/A',
            'firstname' => 'N/A',
            'middlename' => 'N/A',
            'email' => 'N/A',
        ]);
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
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
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
     * @return BelongsToMany
     */
    public function stations(): BelongsToMany
    {
        return $this->belongsToMany(Station::class)
            ->using(ApplicationStation::class)
            ->withPivot([
                'sort',
                'is_complete',
                'is_active'
            ])
            ->orderByPivot('sort');
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * @return BelongsTo
     */
    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class)->withDefault([
            'id' => null,
            'title' => 'N/A'
        ]);
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
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * @return BelongsToMany
     */
    public function statuses(): BelongsToMany
    {
        return $this->belongsToMany(Status::class)
            ->withPivot([
                'comment',
                'user_id',
                'status_id',
                'old_status_id',
            ])
            ->withTimestamps()
            ->using(ApplicationStatus::class);
    }

    /**
     * @return BelongsToMany
     */
    public function routes(): BelongsToMany
    {
        return $this->belongsToMany(Route::class,'application_route');
    }
    /**
     * @return BelongsToMany
     */
    public function exRoutes(): BelongsToMany
    {
        return $this->belongsToMany(Route::class,'ex_applications');
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
    public function startings(): HasMany
    {
        return $this->hasMany(Starting::class);
    }

    /**
     * @return BelongsTo
     */
    public function lastStarting(): BelongsTo
    {
        return $this->belongsTo(Starting::class, 'starting_id');
    }

    /**
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return HasMany
     */
    public function applicationReport(): hasMany
    {
        return $this->hasMany(ApplicationReport::class);
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return HasMany
     */
    public function accepts(): HasMany
    {
        return $this->hasMany(ApplicationAccept::class);
    }

    /**
     * Scope a query to only active applications.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotIn('status_id', [7, 8]);
    }

    /**
     * Scope a query to only inactive applications.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->whereIn('status_id', [7, 8]);
    }

    /**
     * Scope a query to only inactive applications.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrderByPriority(Builder $query)
    {
        return $query->orderByRaw("FIELD(priority, \"critical\", \"major\", \"minor\")");
    }

    /**
     * Scope a query to only inactive applications.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrderByDeadlineAt(Builder $query)
    {
        return $query->orderBy('deadline_at');
    }
}
