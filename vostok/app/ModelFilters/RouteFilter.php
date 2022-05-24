<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class RouteFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function areas($areas)
    {
        return $this->whereHas('applications', function (Builder $query) use ($areas) {
            $query->whereIn('area_id', $areas);
        });
    }
}
