<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreventiveWork extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'value',
        'deviation'
    ];

    /**
     * @return MorphOne
     */
    public function progress(): MorphOne
    {
        return $this->morphOne(StartingProgress::class, 'typeable');
    }

    /**
     * @return MorphTo
     */
    public function modelable(): MorphTo
    {
        return $this->morphTo();
    }
}
