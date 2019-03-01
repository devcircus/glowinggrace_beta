<?php

namespace App\Http\Responders\Auth;

use BrightComponents\Responder\Responder;
use App\Http\Resources\User\PrivateUserResource;

class MeResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        if (! $user = $this->payload) {
            return response()->json([
                'errors' => [
                    'message' => 'User not found.'
                ],
            ], 404);
        }

        return (new PrivateUserResource($user))->response();
    }
}
