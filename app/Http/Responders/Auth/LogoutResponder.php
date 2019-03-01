<?php

namespace App\Http\Responders\Auth;

use BrightComponents\Responder\Responder;

class LogoutResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond()
    {
        return response()->json([], 204);
    }
}
