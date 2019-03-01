<?php

namespace App\Http\Responders\Posts\Images;

use BrightComponents\Responder\Responder;

class DeleteResponder extends Responder
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
