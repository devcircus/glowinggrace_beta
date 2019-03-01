<?php

namespace App\Http\Responders\Categories;

use BrightComponents\Responder\Responder;

class StoreCategoryResponder extends Responder
{
    /**
     * Send a response.
     *
     * @return mixed
     */
    public function respond()
    {
        return response()->json(['data' => $this->payload], 201);
    }
}
