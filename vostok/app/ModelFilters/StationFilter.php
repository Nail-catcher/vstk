<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class StationFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    /**
     * @param $state
     * @return StationFilter
     */
    public function state($state): StationFilter
    {
        return $this->where('state_id', '=', $state);
    }

    /**
     * @param $bts
     * @return StationFilter
     */
    public function bts($bts): StationFilter
    {
        return $this->where('bts_id', 'like', "%{$bts}%");
    }

    /**
     * @param $area
     * @return StationFilter
     */
    public function area($area): StationFilter
    {
        return $this->where('area_id', '=', $area);
    }
    /**
     * @param $project
     * @return StationFilter
     */
    public function project($project): StationFilter
    {
        return $this->where('project_id', '=', $project);
    }
}
