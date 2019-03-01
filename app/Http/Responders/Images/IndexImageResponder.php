<?php

namespace App\Http\Responders\Images;

use BrightComponents\Responder\Responder;
use App\Http\Resources\Images\ImageResource;

class IndexImageResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        return response()->json([
            'images' => ImageResource::collection($this->payload),
        ], 200);
    }
}
