<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PocketResource extends JsonResource
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
            'pocket_title' => $this->title,
            'pocket_description' => $this->description,
            'posted_on' => $this->created_at,
            'contents' => ContentResource::collection($this->contents)
        ];
    }
}
