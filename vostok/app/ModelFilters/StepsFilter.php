<?php 

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class StepsFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function progress($progress): StepsFilter
    {
        return $this->where('progress_id', '=', $progress);
    }
    /**
     * @param $progresses
     */
    public function progresses($progresses): void
    {
        $this->whereIn('progress_id', $progresses);
    }
}
