<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;
use Illuminate\Support\Carbon;

class ApplicationFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function project($project): ApplicationFilter
    {
        return $this->where('project_id', '=', $project);
    }

    public function projects($projects): ApplicationFilter
    {
        return $this->whereIn('project_id', $projects);
    }

    public function id($id)
    {
        return $this->where('id', '=', $id);
    }
    public function ids($ids): ApplicationFilter
    {
        return $this->whereIn('id', $ids);
    }
    /**
     * @param $division
     * @return ApplicationFilter
     */
    public function division($division): ApplicationFilter
    {
        return $this->where('division_id', '=', $division);
    }
    /**
     * @param $divisions
     */
    public function divisions($divisions): void
    {
        $this->whereIn('division_id', $divisions);
    }
    /**
     * @param $area
     * @return ApplicationFilter
     */
    public function area($area): ApplicationFilter
    {
        return $this->where('area_id', '=', $area);
    }

    /**
     * @param $areas
     */
    public function areas($areas): void
    {
        $this->whereIn('area_id', $areas);
    }

    /**
     * @param $priority
     * @return ApplicationFilter
     */
    public function priority($priority): ApplicationFilter
    {
        return $this->whereIn('priority', $priority);
    }

    /**
     * @param $statuses
     * @return ApplicationFilter
     */
    public function statuses($statuses): ApplicationFilter
    {
        return $this->whereIn('status_id', $statuses);
    }

    /**
     * @param $status
     * @return ApplicationFilter
     */
    public function status($status): ApplicationFilter
    {
        return $this->where('status_id', '=', $status);
    }
    /**
     * @param $routes
     * @return ApplicationFilter
     */

    public function routes($routes): ApplicationFilter
    {
        return $this->where(function ($query) use ($routes) {
            $query->whereDoesntHave('routes', function ($query) use ($routes) {
                $query->whereIn('activity_id', $routes);
            })->orWhereDoesntHave('routes');
        });
    }
    /**
     * @param $types
     * @return ApplicationFilter
     */
    public function types($types): ApplicationFilter
    {
        return $this->whereIn('type_id', $types);
    }

    /**
     * @param $type
     * @return ApplicationFilter
     */
    public function type($type): ApplicationFilter
    {
        return $this->where('type_id', '=', $type);
    }

    /**
     * @param $work
     * @return ApplicationFilter
     */
    public function work($work): ApplicationFilter
    {
        return $this->where('work_id', '=', $work);
    }

    /**
     * @param $works
     * @return ApplicationFilter
     */
    public function works($works): ApplicationFilter
    {
        return $this->whereIn('work_id', $works);
    }

    /**
     * @param $bts
     * @return ApplicationFilter
     */
    public function bts($bts): ApplicationFilter
    {
        return $this->whereHas('stations', function ($query) use ($bts) {
            $query->where('bts_id', 'like', "%$bts%");
        });
    }

    public function stations($stations)
    {
        return $this->whereHas('stations', function ($query) use ($stations) {
            $query->whereId('stations.id', $stations);
        });
    }

    /**
     * @param $ticket
     * @return ApplicationFilter
     */
    public function ticket($ticket): ApplicationFilter
    {
        return $this->where('ticket', 'like', "%{$ticket}%")
            ->orWhere('id', '=', $ticket)
            ->orWhere('document', 'like', "%{$ticket}%");
    }

    /**
     * @param $dateFrom
     * @return ApplicationFilter
     */
    public function dateFrom($dateFrom): ApplicationFilter
    {
        return $this->whereBetween('deadline_at', [
            new Carbon($dateFrom),
            new Carbon($this->input('date_to'))
        ]);
    }

    /**
     * @param $createdFrom
     * @return ApplicationFilter
     */
    public function createdFrom($createdFrom): ApplicationFilter
    {
        return $this->whereBetween('created_at', [
            new Carbon($createdFrom),
            new Carbon($this->input('created_to'))
        ]);
    }

    /**
     * @param $engineer
     * @return ApplicationFilter
     */
    public function engineer($engineer): ApplicationFilter
    {
        return $this->where('engineer_id', '=', $engineer);
    }
}
