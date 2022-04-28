<?php

namespace App\Http\Resources\V1\Project;

use App\Http\Resources\V1\Media\Resource as MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
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
            'client_id'         => $this->client_id,
            'client_company'    => $this->client->company,
            'user_id'           => $this->user_id,
            'user_name'         => $this->user->name,
            'tasks_count'       => $this->when($this->tasks_count, $this->tasks_count),
            'status_id'         => $this->status_id,
            'status'            => $this->status,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'deleted_at'        => $this->deleted_at,
            'is_deleted'        => $this->isDeleted,
            'media'             => MediaResource::collection($this->whenLoaded('media')),
        ];
    }
}
