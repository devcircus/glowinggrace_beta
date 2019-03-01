<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Posts\PostResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PrivateUserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'posts_count' => $this->posts_count,
            'avatar' => $this->avatar,
            'posts' => PostResource::collection($this->whenLoaded('posts')),
        ];
    }
}
