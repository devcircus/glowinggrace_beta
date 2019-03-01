<?php

namespace App\Http\Resources\Posts;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'published_at' => $this->published_at,
            'featured_image' => $this->featured_image,
            'user' => $this->user->name,
            'categories' => $this->categories,
            'summary' => $this->summary,
        ];
    }
}
