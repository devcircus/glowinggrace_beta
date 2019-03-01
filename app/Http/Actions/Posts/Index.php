<?php

namespace App\Http\Actions\Posts;

use BrightComponents\Actions\Action;
use App\Services\Posts\IndexPostService;
use App\Http\Responders\Posts\IndexPostResponder;

class Index extends Action
{
    /** @var \App\Http\Responders\Posts\IndexPostResponder */
    private $responder;

    /**
     * Construct a new Post Index action.
     *
     * @param  \App\Http\Responders\Posts\IndexPostResponder  $responder
     */
    public function __construct(IndexPostResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        $posts = IndexPostService::call();

        return $this->responder->withPayload($posts);
    }
}
