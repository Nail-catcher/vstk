<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\hasOne;
class StepsProgress extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'steps_progress';

    /**
     * @return BelongsTo
     */
    public function steps(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(Steps::class,'step_id');
    }

    /**
     * @return BelongsTo
     */
    public function progress(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->BelongsTo(Progress::class,'progress_id');
    }
}
