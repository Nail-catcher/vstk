<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class PlaceFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    /**
     * @param string $title
     * @return PlaceFilter
     */
    public function title(string $title): PlaceFilter
    {
        return $this->where('title', 'like', "%{$title}%");
    }

    /**
     * @param $division
     * @return PlaceFilter
     */
    public function division($division): PlaceFilter
    {
        return $this->where('division_id', '=', $division);
    }
}
