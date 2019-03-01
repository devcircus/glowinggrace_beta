<?php

namespace App\Http\Actions;

use Illuminate\Http\Request;
use BrightComponents\Actions\Action;
use App\Http\Responders\HomeResponder;

class Home extends Action
{
    /** @var \App\Http\Responders\HomeResponder */
    private $responder;

    /**
     * Create a new Home action.
     *
     * @param  \App\Http\Responders\HomeResponder  $responder
     */
    public function __construct(HomeResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the Home action.
     *
     * @return \Illuminate\View\View
     */
    public function __invoke()
    {
        return $this->responder;
    }
}
