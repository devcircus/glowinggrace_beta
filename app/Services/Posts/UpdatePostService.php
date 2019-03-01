<?php

namespace App\Services\Posts;

use App\Models\Post;
use App\Libraries\Images\ImageProcessor;
use App\Libraries\Parser\PostBodyParser;
use App\Exceptions\Models\UpdatePostException;
use BrightComponents\Services\Traits\SelfCallingService;

class UpdatePostService
{
    use SelfCallingService;

    /** @var \App\Services\Posts\UpdatePostServiceValidation */
    private $validator;

    /** @var \App\Libraries\Images\ImageProcessor */
    private $processor;

    /**
     * Construct a new UpdateService.
     *
     * @param  \App\Services\Posts\UpdatePostServiceValidation  $validator
     * @param  \App\Libraries\Images\ImageProcessor  $processor
     * @param  \App\Libraries\Parser\PostBodyParser  $parser
     */
    public function __construct(UpdatePostServiceValidation $validator, ImageProcessor $processor, PostBodyParser $parser)
    {
        $this->validator = $validator;
        $this->processor = $processor;
        $this->parser = $parser;
    }

    /**
     * Handle the call to the service.
     *
     * @param  array  $attributes
     * @param  \App\Models\Post  $post
     *
     * @throws \Illuminate\Validation\ValidationException
     * @throws \App\Exceptions\Models\UpdatePostException
     *
     * @return \App\Models\Post
     */
    public function run(array $attributes, Post $post)
    {
        $this->validator->validate($attributes);

        if (! $post->update($attributes)) {
            return UpdatePostException::unableToUpdatePost();
        }

        $this->handlePostImages($post, $attributes);

        return $post->fresh()->load(['images', 'user', 'categories']);
    }

    /**
     * Process and update images for the post.
     *
     * @param  \App\Models\Post  $post
     * @param  array  $attributes
     */
    public function handlePostImages(Post $post, array $attributes)
    {
        if ($image = $attributes['featured_image']) {
            $this->processor->upload($image)->associateFeaturedImageWith($post);
        }

        $images = $this->parser->extractImagesFromBody($attributes['body']);
        if (isset($images['base64'])) {
            $base64Images = $this->processor->uploadBase64Images($images['base64'])->associateImagesWith($post);
            $body = $this->parser->replaceBase64ImagesInBodyWithUrl($attributes['body'], $base64Images);
            $post->replaceBody($body);
        }
        if (isset($images['url'])) {
            $urls = $this->processor->getUpdatedUrl($images['url']);
            $body = $this->parser->replaceImageUrls($attributes['body'], $urls);
            $post->replaceBody($body);
        }
    }
}
