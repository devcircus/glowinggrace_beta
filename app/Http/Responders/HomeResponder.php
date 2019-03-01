<?php

namespace App\Http\Responders;

use BrightComponents\Responder\Responder;

class HomeResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return \Illuminate\View\View
     */
    public function respond()
    {
        return view('home');
    }
}
