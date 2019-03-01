<?php

namespace App\Services\Posts\Images;

use App\Libraries\Images\ImageProcessor;
use BrightComponents\Services\Traits\SelfCallingService;

class StoreImageService
{
    use SelfCallingService;

    /** @var \App\Libraries\Images\ImageProcessor */
    private $processor;

    /** @var \App\Services\Posts\Images\StoreImageServiceValidation */
    private $validator;

    /**
     * Construct a new StoreImageService.
     *
     * @param  \App\Libraries\Images\ImageProcessor  $processor
     * @param  \App\Services\Posts\Images\StoreImageServiceValidation  $validator
     */
    public function __construct(ImageProcessor $processor, StoreImageServiceValidation $validator)
    {
        $this->processor = $processor;
        $this->validator = $validator;
    }

    /**
     * Handle the call to the service.
     *
     * @param  array  $attributes
     *
     * @return mixed
     */
    public function run(array $attributes)
    {
        $this->validator->validate($attributes);

        $this->processor->upload($attributes['image']);
    }
}
