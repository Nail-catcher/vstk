<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class VehicleFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    /**
     * @param $title
     * @return VehicleFilter
     */
    public function title($title): VehicleFilter
    {
        return $this->where('title', 'like', "%$title%");
    }

    /**
     * @param $area
     * @return VehicleFilter
     */

    public function area($area): VehicleFilter
    {
        return $this->where('area_id', '=', $area);
    }

    /**
     * @param $division
     * @return VehicleFilter
     */

    public function division($division): VehicleFilter
    {
        return $this->where('division_id', '=', $division);
    }
}
