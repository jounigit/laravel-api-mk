<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrentResource extends JsonResource
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
            'place' => $this->place,
            'address' => $this->address,
            'content' => $this->content,
            'en_content' => $this->en_content,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date,
            'is_published' => $this->is_published,
            'is_expired' => $this->is_expired,
	        'pictures' => $this->pictures,
        ];
    }
}
