<?php

namespace App\Eloquent\Traits;

use App\Eloquent\EagerLoadPivotBuilder;

trait EagerLoadPivotTrait
{
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @return EagerLoadPivotBuilder
     */
    public function newEloquentBuilder($query): EagerLoadPivotBuilder
    {
        return new EagerLoadPivotBuilder($query);
    }
}
