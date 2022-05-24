<?php

namespace App\Models;

use App\Eloquent\Traits\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use EagerLoadPivotTrait;

    public const START = 1;
    public const KEYS = 2;
    public const INVENTORY = 3;
    public const ARRIVED = 4;
    public const INSTALL = 5;
    public const REPORT = 6;
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function application(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Application::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function type()
    {
        return $this->belongsTo(ProgressType::class);
    }
    
    public function steps(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Steps::class,StepsProgress::class,'progress_id','step_id');
    }
}
