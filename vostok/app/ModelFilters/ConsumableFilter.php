<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ConsumableFilter extends ModelFilter
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
     * @return ConsumableFilter
     */
    public function title(string $title): ConsumableFilter
    {
        return $this->where('title', 'like', "%{$title}%");
    }
}
