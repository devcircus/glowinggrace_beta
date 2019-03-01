<?php

namespace App\Services\Posts\Images;

use App\Models\Post;
use BrightComponents\Services\Traits\SelfCallingService;

class DeleteImageService
{
    use SelfCallingService;

    /**
     * Construct a new DeleteService.
     */
    public function __construct()
    {
    }

    /**
     * Handle the call to the service.
     *
     * @return mixed
     */
    public function run(Post $post)
    {
        $post->deleteFeaturedImage();

        return $post->fresh();
    }
}
