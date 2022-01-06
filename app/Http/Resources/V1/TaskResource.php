<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->when($request->routeIs('task.show'), $this->description),
            'project_id'  => $this->project->id ?? null,
            'project'     => $this->project->title,
            'client'      => $this->project->client->company,
            'user'        => $this->project->user->name,
            'status_id'   => $this->status_id,
            'status'      => $this->status,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'deleted'     => $this->deleted,
            /*'media'       => $this->when($request->routeIs('task.show'), MediaResource::collection(
                $this->getMedia()
            )),
            'responses'   => $this->when($request->routeIs('task.show'), ResponseResource::collection(
                $this->responses
            )),*/
        ];
    }
}
