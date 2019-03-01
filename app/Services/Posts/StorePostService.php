<?php

namespace App\Services\Posts;

use App\Models\Post;
use App\Models\User;
use App\Libraries\Images\ImageProcessor;
use App\Libraries\Parser\PostBodyParser;
use App\Exceptions\Models\CreatePostException;
use BrightComponents\Services\Traits\SelfCallingService;

class StorePostService
{
    use SelfCallingService;

    /** @var \App\Services\Posts\StorePostServiceValidation */
    private $validator;

    /** @var \App\Libraries\Images\ImageProcessor */
    private $processor;

    /** @var \App\Models\Post */
    private $posts;

    /**
     * Construct a new StoreService.
     *
     * @param  \App\Services\Posts\StorePostServiceValidation  $validator
     * @param  \App\Libraries\Images\ImageProcessor  $processor
     * @param  \App\Libraries\Parser\PostBodyParser  $parser
     * @param  \App\Models\Post  $posts
     */
    public function __construct(StorePostServiceValidation $validator, ImageProcessor $processor, PostBodyParser $parser, Post $posts)
    {
        $this->validator = $validator;
        $this->processor = $processor;
        $this->parser = $parser;
        $this->posts = $posts;
    }

    /**
     * Handle the call to the service.
     *
     * @param  array  $attributes
     *
     * @throws \Illuminate\Validation\ValidationException
     * @throws \App\Exceptions\Models\CreatePostException
     *
     * @return \App\Models\Post
     */
    public function run(User $user, array $attributes)
    {
        $this->validator->validate($attributes);

        $post = $user->createPost($attributes);

        if (! $post instanceof Post) {
            throw CreatePostException::unableToCreatePost();
        }

        $this->handlePostImages($post, $attributes['body'], $attributes['featured_image'] ?? null);

        return $post->fresh()->load(['images', 'user', 'categories']);
    }

    /**
     * Process and save images for the post.
     *
     * @param  \App\Models\Post  $post
     * @param  string  $body
     * @param  \Illuminate\Http\UploadedFile|null  $featured
     */
    public function handlePostImages(Post $post, string $body, $featured)
    {
        if ($featured) {
            $this->processor->upload($featured)->associateFeaturedImageWith($post);
        }

        $images = $this->parser->extractImagesFromBody($body);

        if ($this->base64ImagesArePresent($images)) {
            $images = $this->processor->upload($images['base64'])->associateImagesWith($post);
            $post->replaceBody($this->parser->replaceBase64ImagesInBodyWithUrl($body, $images));
        }
    }

    /**
     * Are there base64 images present in the given array of images?
     *
     * @param  array  $images
     *
     * @return bool
     */
    private function base64ImagesArePresent(array $images)
    {
        return isset($images['base64']) && ! empty($images['base64']);
    }
}
