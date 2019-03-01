<?php

namespace App\Services\Posts;

use App\Models\Post;
use BrightComponents\Services\Traits\SelfCallingService;

class IndexPostService
{
    use SelfCallingService;

    /**
     * Construct a new IndexService.
     *
     * @param  \App\Models\Post  $model
     */
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    /**
     * Handle the call to the service.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function run()
    {
        return $this->model->with(['categories', 'images', 'user'])->latest()->published()->get();
    }
}
