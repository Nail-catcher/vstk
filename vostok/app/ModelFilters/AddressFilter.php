<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class AddressFilter extends ModelFilter
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
     * @return AddressFilter
     */
    public function title(string $title): AddressFilter
    {
        return $this->where('title', 'like', "%{$title}%");
    }

    /**
     * @param $division
     * @return AddressFilter
     */
    public function division($division): AddressFilter
    {
        return $this->where('division_id', '=', $division);
    }
}
