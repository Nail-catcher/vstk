<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\Traits\LogsActivity;

class StartingProgress extends Model
{

    use LogsActivity;

    protected static $logAttributes = ['starting.station.bts_id', 'progress.title', 'starting.application.id', 'step_id'];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'starting_progresses';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'comment', 'step_id'
    ];

    /**
     * @return MorphTo
     */
    public function typeable(): MorphTo
    {
        return $this->morphTo();
    }

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
    public function progress(): BelongsTo
    {
        return $this->belongsTo(Progress::class);
    }
    /**
     * @return BelongsTo
     */
    public function step(): BelongsTo
    {
        return $this->belongsTo(Steps::class);
    }
    /**
     * @return BelongsToMany
     */
    public function inventories(): BelongsToMany
    {
        return $this->belongsToMany(Inventory::class)->withTimestamps();
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
}
