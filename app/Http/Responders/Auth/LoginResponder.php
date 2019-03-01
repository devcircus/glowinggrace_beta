<?php

namespace App\Http\Responders\Auth;

use BrightComponents\Responder\Responder;

class LoginResponder extends Responder
{
    use RespondsWithJwt;

    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        if (! $token = $this->payload) {
            return response()->json([
                'errors' => [
                    'email' => [
                        'Invalid credentials.'
                    ]
                ]
            ], 422);
        }

        return $this->respondWithJwt($token, auth()->user());
    }
}
