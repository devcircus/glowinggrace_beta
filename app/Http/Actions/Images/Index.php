<?php

namespace App\Http\Actions\Images;

use Illuminate\Http\Request;
use BrightComponents\Actions\Action;
use App\Services\Images\IndexImageService;
use App\Http\Responders\Images\IndexImageResponder;

class Index extends Action
{
    /** @var \App\Http\Responders\Images\IndexImageResponder */
    private $responder;

    /**
     * Execute the action.
     *
     * @param  \App\Http\Responders\Images\IndexImageResponder  $responder
     */
    public function __construct(IndexImageResponder $responder)
    {
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {
        $images = IndexImageService::call();

        return $this->responder->withPayload($images);
    }
}
