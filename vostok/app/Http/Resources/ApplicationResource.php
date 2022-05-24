<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'engineer' => new UserResource($this->whenLoaded('engineer')),
            'users' => new UsersResource($this->whenLoaded('users')),
            'comments' => new CommentsResource($this->whenLoaded('comments')),
            'area' => new AreaResource($this->whenLoaded('area')),
            'division' => new DivisionResource($this->whenLoaded('division')),
            'state' => new StateResource($this->whenLoaded('state')),
            'project' => new ProjectResource($this->whenLoaded('project')),
            'stations' => new StationsResource($this->whenLoaded('stations')),
            'type' => new TypeResource($this->whenLoaded('type')),
            'work' => new WorkResource($this->whenLoaded('work')),
            'works' => new WorksResource($this->whenLoaded('works')),
            'status' => new StatusResource($this->whenLoaded('status')),
            'statuses' => new StatusesResource($this->whenLoaded('statuses')),
            'routes' => new RoutesResource($this->whenLoaded('routes')),
            'accepts' => new ApplicationAcceptsResource($this->whenLoaded('accepts')),
            //            'sort' => $this->whenPivotLoaded('application_route', function () {
            //                return $this->pivot->sort;
            //            }),
            'startings' => new StartingsResource($this->whenLoaded('startings')),
            'last_starting' => new StartingResource($this->whenLoaded('lastStarting')),
            'title' => $this->title,
            'ticket' => $this->ticket,
            'document' => $this->document,
            'priority' => $this->priority,
            'description' => $this->description,
            'comment' => $this->comment,
            'pickup_keys' => $this->pickup_keys,
            'keys_comment' => $this->keys_comment,
            'hours_count' => $this->hours_count,
            'distance' => $this->distance,
            'is_approvable' => $this->is_approvable,
            'is_overdue' => $this->is_overdue,
            'deadline_at' => $this->deadline_at,
            'started_at' => $this->started_at,
            'ended_at' => $this->ended_at,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'applicationReports' => new ApplicationReportsResource($this->whenLoaded('applicationReport')),
        ];
    }
}
