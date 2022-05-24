<?php

namespace App\Models;

use App\Eloquent\Traits\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    use EagerLoadPivotTrait;

    public const NEW = 1;
    public const ACCEPTED = 2;
    public const IN_WORK = 3;
    public const COMPLETED = 4;
    public const REFINEMENT = 5;
    public const REJECTED = 6;
    public const CLOSED = 7;
    public const CANCELED = 8;
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function application(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function applications(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Application::class)
            ->withPivot([
                'comment',
                'user_id',
                'status_id',
                'old_status_id'
            ])
            ->withTimestamps()
            ->using(ApplicationStatus::class);
    }
}
