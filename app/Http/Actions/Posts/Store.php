<?php

namespace App\Http\Actions\Posts;

use Illuminate\Http\Request;
use BrightComponents\Actions\Action;
use App\Services\Posts\StorePostService;
use App\Http\Responders\Posts\StorePostResponder;

class Store extends Action
{
    /** @var \App\Http\Responders\Posts\StorePostResponder */
    private $responder;

    /**
     * Construct a new Posts Store action.
     *
     * @param  \App\Http\Responders\Posts\StorePostResponder  $responder
     */
    public function __construct(StorePostResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(Request $request)
    {
        $post = StorePostService::call(auth()->user(), $request->all());

        return $this->responder->withPayload($post);
    }
}
