<?php

namespace App\Http\Actions\Categories;

use Illuminate\Http\Request;
use BrightComponents\Actions\Action;
use App\Services\Categories\StoreCategoryService;
use App\Http\Responders\Categories\StoreCategoryResponder;

class Store extends Action
{
    /** @var \App\Http\Responders\Categories\StoreCategoryResponder */
    private $responder;

    /**
     * Construct a new Categories Store action.
     *
     * @param  \App\Http\Responders\Categories\StoreCategoryResponder  $responder
     */
    public function __construct(StoreCategoryResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Execute the action.
     */
    public function __invoke(Request $request)
    {
        $category = StoreCategoryService::call($request->all());

        return $this->responder->withPayload($category);
    }
}
