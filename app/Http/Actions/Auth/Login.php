<?php

namespace App\Http\Actions\Auth;

use BrightComponents\Actions\Action;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Responders\Auth\LoginResponder;

class Login extends Action
{
    /** @var \App\Http\Responders\Auth\LoginResponder */
    private $responder;

    /**
     * Construct a new Login action.
     *
     * @param  \App\Http\Responders\Auth\LoginResponder  $responder
     */
    public function __construct(LoginResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Authenticate user via JWT.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(LoginRequest $request)
    {
        return $this->responder->withPayload(auth()->attempt($request->credentials()));
    }
}
