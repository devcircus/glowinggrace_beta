<?php

namespace App\Http\Actions\Auth;

use Illuminate\Http\Request;
use BrightComponents\Actions\Action;

class Refresh extends Action
{
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        // $token = auth()->refresh();

        // return $this->respondWithJwt($token, auth()->setToken($token)->user());
    }
}
