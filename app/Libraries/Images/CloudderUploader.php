<?php

namespace App\Libraries\Images;

use JD\Cloudder\CloudinaryWrapper as Cloudder;
use App\Libraries\Images\Contracts\ImageUploader;

class CloudderUploader implements ImageUploader
{
    /** @var \JD\Cloudder\CloudinaryWrapper */
    public $cloudder;

    /** @var array */
    private $options = [
        'use_filename' => true,
        'folder' => 'posts/',
    ];

    /**
     * Construct a new CloudderUploader.
     *
     * @param  \JD\Cloudder\CloudinaryWrapper $cloudder
     */
    public function __construct(Cloudder $cloudder)
    {
        $this->cloudder = $cloudder;
    }

    /**
     * Upload an image to Cloudinary.
     *
     * @param  mixed  $resource
     * @param  string|null  $filename
     * @param  string|null  $folder
     *
     * @return array
     */
    public function upload($resource, string $filename = null, string $folder = null)
    {
        if ($folder) {
            $this->mergeOptions(['folder' => $folder]);
        }
        $this->cloudder->upload($resource, $filename, $this->options);

        return $this->cloudder->getResult();
    }

    /**
     * Merge the updated options with the original options.
     *
     * @param  array  $updated
     */
    public function mergeOptions(array $updated)
    {
        return $this->options = array_merge($this->options, $updated);
    }

    /**
     * Destroy a resource.
     *
     * @param  string $resourceId
     * @param  array  $options
     *
     * @return array
     */
    public function destroy($resourceId, $options = [])
    {
        return $this->cloudder->destroy($resourceId, $options);
    }
}
