<?php

namespace App\ModelFilters;

use App\Models\Area;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;

class UserFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function area($area)
    {
        $area = Area::find($area);
        return $this->where('division_id', '=', $area->division_id);
    }

    /**
     * @param $roles
     * @return UserFilter
     */
    public function roles($roles): UserFilter
    {
        return $this->whereHas('roles', function (Builder $query) use ($roles) {
            $query->whereIn('roles.id', $roles);
        });
    }

    /**
     * @param $position
     * @return UserFilter
     */
    public function position($position): UserFilter
    {
        return $this->where('position_id', '=', $position);
    }

    /**
     * @param $positions
     * @return UserFilter
     */
    public function positions($positions): UserFilter
    {
        return $this->whereIn('position_id', $positions);
    }

    /**
     * @param $email
     * @return UserFilter
     */
    public function email($email): UserFilter
    {
        return $this->where('email', 'like', "%$email%");
    }

    /**
     * @param $phone
     * @return UserFilter
     */
    public function phone($phone): UserFilter
    {
        return $this->where('phone', 'like', "%$phone%");
    }

    /**
     * @param $fio
     * @return UserFilter
     */
    public function fio($fio): UserFilter
    {
        return $this->where(function (Builder $query) use ($fio) {
            $query->where('firstname', 'like', "%{$fio}%")
                ->orWhere('lastname', 'like', "%{$fio}%")
                ->orWhere('middlename', 'like', "%{$fio}%");
        });
    }

    /**
     * @param $lastname
     * @return UserFilter
     */
    public function lastname($lastname): UserFilter
    {
        return $this->where('lastname', 'like', "%{$lastname}%");
    }
}
