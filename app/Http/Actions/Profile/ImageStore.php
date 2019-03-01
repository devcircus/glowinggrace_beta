<?php

namespace App\Http\Actions\Profile;

use Illuminate\Http\Request;
use BrightComponents\Actions\Action;
use App\Services\Profile\ImageStoreService;
use App\Http\Responders\Profile\ImageStoreResponder;

class ImageStore extends Action
{
    /** @var \App\Http\Responders\Profile\ImageStoreResponder */
    protected $responder;

    public function __construct(ImageStoreResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $avatar = ImageStoreService::call($request->user(), $request->only('avatar'));

        return $this->responder->withPayload($avatar);
    }
}
