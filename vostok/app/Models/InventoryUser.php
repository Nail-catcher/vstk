<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Relations\Pivot;

class InventoryUser extends Pivot
{

    use Filterable;

    /**
     * @return string|null
     */
    public function modelFilter(): ?string
    {
        return $this->provideFilter(\App\ModelFilters\InventoryFilter::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }
}
