<?php

namespace App\Http\Resources\V1\Media;

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
            'id'       => $this->id,
            'name'     => $this->name,
            'thumb'    => $this->when($this->hasGeneratedConversion('thumb'), $this->getUrl('thumb')),
            'original' => $this->getUrl(),
        ];
    }
}
