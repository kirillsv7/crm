<?php

namespace App\Http\Resources\V1\Response;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class LatestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'content'    => Str::limit($this->content),
            'user_name'  => $this->user->name,
            'task'       => $this->task,
            'created_at' => $this->created_at,
        ];
    }
}
