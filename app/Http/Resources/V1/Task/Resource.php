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
            'id'                     => $this->id,
            'encrypted_id'           => $this->when($request->routeIs('task.show'), encrypt($this->id)),
            'title'                  => $this->title,
            'description'            => $this->when($request->routeIs('task.show'), $this->description),
            'project_id'             => $this->project_id,
            'project_title'          => $this->project->title,
            'project_client_company' => $this->project->client->company,
            'project_user_name'      => $this->project->user->name,
            'responses_count'        => $this->when($this->responses_count, $this->responses_count, 0),
            'last_response'          => new ResponseResource($this->whenLoaded('lastResponse')),
            'status_id'              => $this->status_id,
            'status'                 => $this->status,
            'created_at'             => $this->created_at,
            'updated_at'             => $this->updated_at,
            'is_deleted'             => $this->isDeleted,
            'media'                  => MediaResource::collection($this->whenLoaded('media')),
        ];
    }
}