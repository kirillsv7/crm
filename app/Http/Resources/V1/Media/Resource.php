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
            'id'           => $this->id,
            //'preview_url'  => $this->when($this->hasGeneratedConversion('preview'), $this->getUrl('preview')),
            'original_url' => $this->getUrl(),
        ];
    }
}
