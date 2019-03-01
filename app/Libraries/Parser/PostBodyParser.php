<?php

namespace App\Libraries\Parser;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class PostBodyParser
{
    /**
     * Extract images from body so we can upload.
     *
     * @param  string  $data
     *
     * @return array
     */
    public function extractImagesFromBody(string $data, $getAttributes = true)
    {
        $post_images = [];

        preg_match_all('/<img.*?>/', $data, $image_matches, PREG_SET_ORDER);

        foreach ($image_matches as $image_match) {
            $post_image = [];

            if (true == $getAttributes) {
                preg_match_all('/\s+?(.+)="([^"]*)"/U', $image_match[0], $image_attr_matches, PREG_SET_ORDER);

                foreach ($image_attr_matches as $image_attr) {
                    $post_image[$image_attr[1]] = $image_attr[2];
                }
            }
            if (Str::startsWith($post_image['src'], 'data')) {
                $post_images['base64'][] = $post_image;
            } else {
                $post_images['url'][] = $post_image;
            }
        }

        return $post_images;
    }

    /**
     * Replace the Base64 image with a placeholder.
     *
     * @param  string  $body
     * @param  \Illuminate\Support\Collection  $images
     */
    public function replaceBase64ImagesInBodyWithUrl($body, Collection $images)
    {
        $pattern = '@src="(data[^"]+)"@';
        $urls = $images->map(function ($image) {
            return $image->medium_size_url;
        })->toArray();
        $count = 0;

        return preg_replace_callback($pattern, function ($match) use ($urls, &$count) {
            return "src='{$urls[$count++]}'";
        }, $body);
    }

    /**
     * Replace the url of http linked images.
     *
     * @param  string  $body
     * @param  array  $urls
     *
     * @return string
     */
    public function replaceImageUrls($body, array $urls)
    {
        $pattern = '@src="(http[^"]+)"@';
        $count = 0;

        return preg_replace_callback($pattern, function ($match) use ($urls, &$count) {
            return "src='{$urls[$count++]}'";
        }, $body);
    }
}
