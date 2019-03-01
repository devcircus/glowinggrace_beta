<?php

namespace App\Services\Images;

use App\Models\Image;
use BrightComponents\Services\Traits\SelfCallingService;

class IndexImageService
{
    use SelfCallingService;

    /** @var \App\Models\Image */
    private $model;

    /**
     * Construct a new IndexImageService.
     *
     * @param  \App\Models\Image  $model
     */
    public function __construct(Image $model)
    {
        $this->model = $model;
    }

    /**
     * Handle the call to the service.
     *
     * @return mixed
     */
    public function run()
    {
        return $this->model->with(['post'])->get();
    }
}
