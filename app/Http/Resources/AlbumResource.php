<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'en_title' => $this->en_title,
            'slug' => $this->slug,
            'year' => $this->year,
            'content' => $this->content,
            'en_content' => $this->en_content,
            'status' => $this->status,
	        'pictures' => $this->pictures,
        ];
    }
}
