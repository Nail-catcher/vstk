<?php

namespace App\Eloquent;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialExpression;

class Builder extends \Staudenmeir\EloquentEagerLimit\Builder
{
    public function cleanBindings(array $bindings)
    {
        $bindings = array_map(function ($binding) {
            return $binding instanceof SpatialExpression ? $binding->getSpatialValue() : $binding;
        }, $bindings);

        return parent::cleanBindings($bindings);
    }
}
