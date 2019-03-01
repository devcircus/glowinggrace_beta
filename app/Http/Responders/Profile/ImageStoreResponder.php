<?php

namespace App\Http\Responders\Profile;

use BrightComponents\Responder\Responder;

class ImageStoreResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\Response
     */
    public function respond()
    {
        return response()->json(['data' => $this->payload], 200);
    }
}
