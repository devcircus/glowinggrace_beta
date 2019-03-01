<?php

namespace App\Http\Resources\Images;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->public_id,
            'format' => $this->format,
            'thumb_size_url' => $this->thumb_size_url,
            'full_size_url' => $this->full_size_url,
            'display_size_url' => $this->display_size_url,
            'medium_size_url' => $this->medium_size_url,
            'post_title' => $this->post->title,
            'post_id' => $this->post->id,
        ];
    }
}
