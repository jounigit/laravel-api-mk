<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PictureResource extends JsonResource
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
            'year' => $this->year,
            'technique' => $this->technique,
            'en_technique' => $this->en_technique,
            'size' => $this->size,
            'content' => $this->content,
            'en_content' => $this->en_content,
            'photographer' => $this->photographer,
            'image' => $this->image,
	        'pic_order' => $this->pic_order,
        ];
    }
}
