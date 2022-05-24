<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
class Steps extends Model
{
    use HasFactory;
    use Filterable;
    public $timestamps = false;

  
     /**
     * @return HasMany
     */
    public function progresses(): belongsToMany
    {
        return $this->belongsToMany(Progress::class, StepsProgress::class );
    }
}
