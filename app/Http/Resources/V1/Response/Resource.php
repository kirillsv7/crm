<?php

namespace App\Http\Resources\V1\Response;

use App\Http\Resources\V1\Media\Resource as MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'id'         => $this->id,
            'content'    => Str::limit($this->content),
            'user_name'  => $this->user->name,
            'created_at' => $this->created_at,
            'media'      => MediaResource::collection($this->whenLoaded('media')),
        ];
    }
}
