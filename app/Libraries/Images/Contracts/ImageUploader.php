<?php

namespace App\Libraries\Images\Contracts;

interface ImageUploader
{
    /**
     * Upload a resource.
     *
     * @param  mixed  $resource
     * @param  string|null  $filename
     * @param  string|null  $folder
     *
     * @return array
     */
    public function upload($resource, string $filename = null, string $folder = null);

    /**
     * Destroy a resource.
     *
     * @param  string $publicId
     * @param  array  $options
     *
     * @return array
     */
    public function destroy($publicId, $options = []);
}
