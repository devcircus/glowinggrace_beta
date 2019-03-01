<?php

namespace App\Http\Responders\Auth;

use App\Models\User;
use App\Http\Resources\User\PrivateUserResource;

trait RespondsWithJwt
{
    /**
     * Send a JSON response with the valid JWT token.
     *
     * @param  string  $token
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithJwt(string $token, User $user)
    {
        $resource = new PrivateUserResource($user);
        return $resource->additional([
            'meta' => [
                'token' => $token,
            ],
        ])->response();
    }
}