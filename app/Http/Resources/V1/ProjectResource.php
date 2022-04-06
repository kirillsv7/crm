<?php

namespace App\Http\Resources\V1;

use App\Models\Task;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'title'             => $this->title,
            'description'       => $this->when($request->routeIs('project.show'), $this->description),
            'deadline'          => $this->deadline,
            'deadline_inverted' => $this->deadline_inverted,
            'client_id'         => $this->client->id,
            'client'            => $this->client->company,
            'user_id'           => $this->user->id,
            'user'              => $this->user->name,
            'tasks_count'       => $this->tasks_count,
            'status_id'         => $this->status_id,
            'status'            => $this->status,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'deleted_at'        => $this->deleted_at,
            'deleted'           => $this->deleted,
            /*'media'             => $this->when($request->routeIs('project.show'), MediaResource::collection(
                $this->getMedia()
            )),
            'tasks'             => $this->when($request->routeIs('project.show'), TaskResource::collection(
                $this->tasks()->filterByStatus()
                     ->orderByDesc('id')
                     ->paginate()
                     ->withQueryString()
            )),*/
        ];
    }
}
