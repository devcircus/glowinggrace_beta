<?php

namespace App\Http\Responders\Posts;

use BrightComponents\Responder\Responder;
use App\Http\Resources\Posts\PostCollectionResource;

class IndexPostResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        return (new PostCollectionResource($this->payload))->response();
    }
}
