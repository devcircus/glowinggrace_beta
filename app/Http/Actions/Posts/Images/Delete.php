<?php

namespace App\Http\Actions\Posts\Images;

use App\Models\Post;
use BrightComponents\Actions\Action;
use App\Services\Posts\Images\DeleteImageService;
use App\Http\Responders\Posts\Images\DeleteResponder;

class Delete extends Action
{
    /** @var \App\Http\Responders\Posts\Images\DeleteResponder */
    private $responder;

    /**
     * Construct a new Post Image Delete action.
     *
     * @param  \App\Http\Responders\Posts\Images\DeleteResponder  $responder
     */
    public function __construct(DeleteResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(Post $post)
    {
        $post = DeleteImageService::call($post);

        return $this->responder->withPayload($post);
    }
}
