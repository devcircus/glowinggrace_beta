<?php

namespace App\Http\Actions\Auth;

use Illuminate\Http\Request;
use BrightComponents\Actions\Action;
use App\Http\Responders\Auth\LogoutResponder;

class Logout extends Action
{
    /** @var \App\Http\Responders\Auth\LogoutResponder */
    private $responder;

    /**
     * Construct a new Logout action.
     *
     * @param  \App\Http\Responders\Auth\LogoutResponder  $responder
     */
    public function __construct(LogoutResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Log out the user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        auth()->logout();

        return $this->responder;
    }
}
