<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ResponseResource extends JsonResource
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
            'id'         => $this->id,
            'content'    => Str::limit($this->content),
            'user'       => $this->user->name,
            'task'       => $this->task,
            'created_at' => $this->created_at,
            'media'      => MediaResource::collection($this->whenLoaded('media')),
        ];
    }
}
