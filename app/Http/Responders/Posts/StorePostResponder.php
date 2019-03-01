<?php

namespace App\Http\Responders\Posts;

use BrightComponents\Responder\Responder;

class StorePostResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        return response()->json(['data' => $this->payload], 201);
    }
}
