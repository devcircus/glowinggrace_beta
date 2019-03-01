<?php

namespace App\Http\Actions\Posts\Images;

use Illuminate\Http\Request;
use BrightComponents\Actions\Action;
use App\Services\Posts\Images\StoreImageService;
use App\Http\Responders\Posts\Images\StoreResponder;

class Store extends Action
{
    /** @var \App\Http\Responders\Posts\Images\StoreResponder */
    private $responder;

    /**
     * Construct a new Post Image Store action.
     *
     * @param  \App\Http\Responders\Posts\Images\StoreResponder  $responder
     */
    public function __construct(StoreResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $image = StoreImageService::call($request->all());

        return $this->responder->withPayload($image);
    }
}
