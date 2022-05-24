<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class InventoryFilter extends ModelFilter
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
     * @return InventoryFilter
     */
    public function title($title): InventoryFilter
    {
        return $this->where('title', 'like', "%$title%");
    }

    /**
     * @param $rrs
     * @return InventoryFilter
     */
    public function rrs($rrs): InventoryFilter
    {
        return $this->where('rrs', 'like', "%$rrs%");
    }

    /**
     * @param $categories
     * @return InventoryFilter
     */
    public function categories($categories): InventoryFilter
    {
        return $this->whereIn('category_id', $categories);
    }

    /**
     * @param $barcode
     * @return InventoryFilter
     */
    public function barcode($barcode): InventoryFilter
    {
        return $this->where('barcode', '=', $barcode);
    }

    /**
     * @param $user
     * @return InventoryFilter
     */
    public function user($user): InventoryFilter
    {
        return $this->where('user_id', '=', $user);
    }

    public function division($division)
    {
        return $this->whereHas('user', function (Builder $query) use ($division) {
            $query->where('division_id', '=', $division);
        });
    }

    /**
     * @param $dateFrom
     * @return InventoryFilter
     */
    public function dateFrom($dateFrom): InventoryFilter
    {
        return $this->whereBetween('created_at', [
            new Carbon($dateFrom),
            new Carbon($this->input('date_to'))
        ]);
    }

    /**
     * @param $dateTo
     * @return InventoryFilter
     */
    public function dateTo($dateTo): InventoryFilter
    {
        return $this->whereBetween('created_at', [
            new Carbon($this->input('date_from')),
            new Carbon($dateTo)
        ]);
    }
}
