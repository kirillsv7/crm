<?php

namespace App\Http\Resources\V1\Task;

use App\Http\Resources\V1\Media\Resource as MediaResource;
use App\Http\Resources\V1\Response\Resource as ResponseResource;
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
            'id'           => $this->id,
            'encrypted_id' => $this->when($request->routeIs('task.show'), encrypt($this->id)),
            'title'        => $this->title,
            'description'  => $this->when($request->routeIs('task.show'), $this->description),
            'project_id'   => $this->project_id,
            'project'      => $this->project->title,
            'client'       => $this->project->client->company,
            'user'         => $this->project->user->name,
            'status_id'    => $this->status_id,
            'status'       => $this->status,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
            'is_deleted'   => $this->isDeleted,
            'media'        => MediaResource::collection($this->whenLoaded('media')),
            'responses'    => ResponseResource::collection($this->whenLoaded('responses')),
        ];
    }
}