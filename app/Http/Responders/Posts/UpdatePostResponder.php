<?php

namespace App\Http\Responders\Posts;

use BrightComponents\Responder\Responder;

class UpdatePostResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        return response()->json(['post' => $this->payload], 200);
    }
}
