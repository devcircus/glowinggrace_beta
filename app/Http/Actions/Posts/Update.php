<?php

namespace App\Http\Actions\Posts;

use App\Models\Post;
use Illuminate\Http\Request;
use BrightComponents\Actions\Action;
use App\Services\Posts\UpdatePostService;
use App\Http\Responders\Posts\UpdatePostResponder;

class Update extends Action
{
    /** @var \App\Http\Responders\Posts\UpdatePostResponder */
    private $responder;

    /**
     * Construct a new Posts Update action.
     *
     * @param  \App\Http\Responders\Posts\UpdatePostResponder  $responder
     */
    public function __construct(UpdatePostResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(Request $request, Post $post)
    {
        $updated = UpdatePostService::call($request->all(), $post);

        return $this->responder->withPayload($updated);
    }
}
