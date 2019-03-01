<?php

namespace App\Http\Actions\Auth;

use Illuminate\Http\Request;
use BrightComponents\Actions\Action;
use App\Http\Responders\Auth\MeResponder;

class Me extends Action
{
    /** @var \App\Http\Responders\Auth\MeResponder */
    private $responder;

    /**
     * Construct a new Me action.
     *
     * @param  \App\Http\Responders\Auth\MeResponder  $responder
     */
    public function __construct(MeResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Retrieve the currently authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        return $this->responder->withPayload(auth()->user());
    }
}
