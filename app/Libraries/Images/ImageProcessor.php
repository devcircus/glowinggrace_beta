<?php

namespace App\Libraries\Images;

use App\Models\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use App\Libraries\Images\Contracts\ImageUploader;
use App\Libraries\Images\TransformationBuilder as Transformer;

class ImageProcessor
{
    /** @var \App\Libraries\Images\Contracts\ImageUploader */
    private $uploader;

    /** @var \App\Libraries\Images\TransformationBuilder */
    private $transformationBuilder;

    /** @var \App\Libraries\Images\UrlBuilder */
    private $urlBuilder;

    /** @var array */
    private $featuredImage;

    /** @var array */
    private $urlImages;

    /** @var array */
    private $base64Images;

    /**
     * Construct a new ImageProcessor.
     *
     * @param  \App\Libraries\Images\Contracts\ImageUploader  $uploader
     * @param  \App\Libraries\Images\TransformationBuilder  $transformationBuilder
     * @param  \App\Libraries\Images\UrlBuilder  $urlBuilder
     */
    public function __construct(ImageUploader $uploader, Transformer $transformationBuilder, UrlBuilder $urlBuilder)
    {
        $this->uploader = $uploader;
        $this->transformationBuilder = $transformationBuilder;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Upload an image.
     *
     * @param  \Illuminate\Http\UploadedFile|array  $images
     * @param  string  $filename    The name of the file after upload
     * @param  string  $folder      The folder where the file will be uploaded
     *
     * @return $this
     */
    public function upload($images, string $filename = null, string $folder = null)
    {
        if ($images instanceof UploadedFile) {
            $this->featuredImage = $this->uploadFeaturedImage($images, $filename, $folder);
        }
        if (is_array($images)) {
            $this->base64Images = $this->uploadBase64Images($images);
        }

        return $this;
    }

    /**
     * Upload a featured image.
     *
     * @param  \Illuminate\Http\UploadedFile  $image
     * @param  string|null  $filename    The name of the file after upload
     * @param  string|null  $folder      The folder where the file will be uploaded
     *
     * @return array
     */
    public function uploadFeaturedImage(UploadedFile $image, string $filename = null, string $folder = null)
    {
        return $this->uploader->upload($image->getRealPath(), $filename, $folder);
    }

    /**
     * Upload base64 images.
     *
     * @param  array  $images
     *
     * @return array
     */
    public function uploadBase64Images(array $images)
    {
        return collect($images)->map(function ($image) {
            return [
                'details' => $this->uploader->upload($image['src']),
                'width' => isset($image['width']) ? $image['width'] : null,
            ];
        });
    }

    /**
     * Save the featured image to the database.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function associateFeaturedImageWith(Model $model)
    {
        return $model->saveImage(
            $this->featuredImage,
            $this->getUrlsForDifferentFeaturedImageSizes(),
            $featured = true
        );
    }

    /**
     * Save embedded Base64 images to the database.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function associateImagesWith(Model $model)
    {
        return collect($this->base64Images)->map(function ($image) use ($model) {
            return $model->saveImage(
                $image['details'],
                $this->getUrlsForDifferentEmbeddedImageSizes($image),
                $featured = false
            );
        });
    }

    /**
     * Destroy a resource.
     *
     * @param  string  $resourceId
     * @param  array  $options
     *
     * return array
     */
    public function destroy(string $resourceId, array $options = [])
    {
        return $this->uploader->destroy($resourceId, $options);
    }

    /**
     * Get the resource public id from the url.
     *
     * @param  string  $url
     *
     * @return string
     */
    public function getPublicIdFromUrl(string $url)
    {
        $filename = substr($url, strrpos($url, '/') + 1);

        return strtok($filename, '.');
    }

    /**
     * Get all necessary urls for the different sizes needed for the Featured Image.
     *
     * @return array
     */
    public function getUrlsForDifferentFeaturedImageSizes()
    {
        return [
            'thumbUrl' => $this->urlBuilder->build($this->featuredImage, $this->getThumbnailTransformations()),
            'fullSizeUrl' => $this->urlBuilder->build($this->featuredImage, $this->getFullSizeTransformations()),
            'displaySizeUrl' => $this->urlBuilder->build($this->featuredImage, $this->getDisplaySizeTransformations()),
            'mediumSizeUrl' => $this->urlBuilder->build($this->featuredImage, $this->getMediumSizeTransformations()),
        ];
    }

    /**
     * Get all necessary urls for the different sizes needed for the embedded Image.
     *
     * @return array
     */
    public function getUrlsForDifferentEmbeddedImageSizes($image)
    {
        $urls = ['fullSizeUrl' => $this->urlBuilder->build($image['details'], $this->getFullSizeTransformations())];

        if ($image['width']) {
            $urls['mediumSizeUrl'] = $this->urlBuilder->build($image['details'], $this->getEmbeddedSizeTransformations($image['width']));
        }

        return $urls;
    }

    /**
     * Get the updated urls due to a size change for embedded images.
     *
     * @param  array  $images
     *
     * @return array
     */
    public function getUpdatedUrl(array $images)
    {
        $urls = [];

        foreach ($images as $image) {
            $dbImage = Image::where('medium_size_url', $image['src'])->first();
            $url = $this->urlBuilder->build($dbImage->toArray(), $this->getEmbeddedSizeTransformations($image['width']));
            $dbImage->medium_size_url = $url;
            $dbImage->save();
            $urls[] = $url;
        }

        return $urls;
    }

    /**
     * Get the transformations for the thumbnail of the image.
     *
     * @return string
     */
    public function getThumbnailTransformations()
    {
        return $this->transformationBuilder
            ->initialize()
            ->crop(Transformer::CROP_FILL)
            ->thumb()
            ->transform();
    }

    /**
     * Get the transformations for the full size image.
     *
     * @return string
     */
    public function getFullSizeTransformations()
    {
        return $this->transformationBuilder
            ->initialize()
            ->crop(Transformer::CROP_FILL)
            ->width('auto')
            ->gravity(Transformer::GRAVITY_CENTER)
            ->transform();
    }

    /**
     * Get the transformations for the display size.
     *
     * @return string
     */
    public function getDisplaySizeTransformations()
    {
        return $this->transformationBuilder
            ->initialize()
            ->crop(Transformer::CROP_FILL)
            ->width('auto')
            ->gravity(Transformer::GRAVITY_CENTER)
            ->transform();
    }

    /**
     * Get the transformations for the post size image.
     *
     * @return string
     */
    public function getMediumSizeTransformations($width = 400)
    {
        return $this->transformationBuilder
            ->initialize()
            ->crop(Transformer::CROP_SCALE)
            ->width($width)
            ->gravity(Transformer::GRAVITY_CENTER)
            ->transform();
    }

    /**
     * Get the transformations for the embedded images.
     *
     * @return string
     */
    public function getEmbeddedSizeTransformations($size)
    {
        return $this->transformationBuilder
            ->initialize()
            ->crop(Transformer::CROP_SCALE)
            ->width((int) $size)
            ->gravity(Transformer::GRAVITY_CENTER)
            ->transform();
    }
}
