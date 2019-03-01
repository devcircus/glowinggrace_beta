<?php

namespace App\Libraries\Images;

class TransformationBuilder
{
    /** @var string */
    private $thumbWidth = '150';

    /** @var string */
    private $thumbHeight = '150';

    /** @var string */
    private $width = '600';

    /** @var string */
    private $height = null;

    /** @var string|null */
    private $crop = 'fit';

    /** @var string|null */
    private $gravity = 'center';

    /** @var string|null */
    private $additional = null;

    /** @var string */
    private $transformString;

    /** @var array */
    protected $usedTransforms = [
        'width',
    ];

    /** Image Crop Options */
    const CROP_SCALE = 'scale';
    const CROP_FIT = 'fit';
    const CROP_MFIT = 'mfit';
    const CROP_FILL = 'fill';
    const CROP_LFILL = 'lfill';
    const CROP_LIMIT = 'limit';
    const CROP_PAD = 'pad';
    const CROP_LPAD = 'lpad';
    const CROP_MPAD = 'mpad';
    const CROP_CROP = 'crop';
    const CROP_THUMB = 'thumb';
    const CROP_IMAGGA_CROP = 'imagga_crop';
    const CROP_IMAGGA_SCALE = 'imagga_scale';

    /** Image Gravity Options */
    const GRAVITY_NORTH = 'north';
    const GRAVITY_NORTH_EAST = 'north_east';
    const GRAVITY_NORTH_WEST = 'north_west';
    const GRAVITY_WEST = 'west';
    const GRAVITY_SOUTH_WEST = 'south_west';
    const GRAVITY_SOUTH_EAST = 'south_east';
    const GRAVITY_SOUTH = 'south';
    const GRAVITY_EAST = 'east';
    const GRAVITY_CENTER = 'center';
    const GRAVITY_FACE = 'face';
    const GRAVITY_FACES = 'faces';
    const GRAVITY_LARGEST_FACE = 'adv_face';
    const GRAVITY_ALL_FACES = 'adv_faces';
    const GRAVITY_EYES = 'adv_eyes';

    /**
     * Reset the transformations to the default values.
     *
     * @return $this
     */
    public function initialize()
    {
        $this->width(600);
        $this->height(null);
        $this->crop('fit');
        $this->gravity('center');
        $this->removeAdditional();
        $this->transformString = '';
        $this->usedTransforms = ['width'];

        return $this;
    }

    /**
     * Get the transformation string for the url.
     *
     * @return string
     */
    public function transform()
    {
        foreach ($this->usedTransforms as $transform) {
            $this->transformString .= $this->{$transform}.',';
        }

        return rtrim($this->transformString, ',');
    }

    /**
     * Get the current transform string.
     *
     * @return string
     */
    public function getTransforms()
    {
        return $this->transformString;
    }

    /**
     * Set the width for the image.
     *
     * @param  mixed  $width
     *
     * @return $this
     */
    public function width($width)
    {
        $this->width = "w_${width}";

        return $this;
    }

    /**
     * Set the height for the image.
     *
     * @param  mixed  $height
     *
     * @return $this
     */
    public function height(? int $height)
    {
        $this->height = "h_${height}";
        $this->usedTransforms[] = 'height';

        return $this;
    }

    /**
     * Set the crop for the image.
     *
     * @param  mixed  $crop
     *
     * @return $this
     */
    public function crop($crop)
    {
        $this->crop = "c_${crop}";
        $this->usedTransforms[] = 'crop';

        return $this;
    }

    /**
     * Set the gravity for the image.
     *
     * @param  mixed  $gravity
     *
     * @return $this
     */
    public function gravity($gravity)
    {
        $this->gravity = "g_${gravity}";
        $this->usedTransforms[] = 'gravity';

        return $this;
    }

    /**
     * Set the width and height for the thumbnail.
     *
     * @param  mixed  $width
     * @param  mixed  $height
     *
     * @return $this
     */
    public function thumb($width = null, $height = null)
    {
        $width = $width ?: $this->thumbWidth;
        $height = $height ?: $this->thumbHeight;

        $this->height($height);
        $this->width($width);

        return $this;
    }

    /**
     * Add any additional custom transforms.
     *
     * @param  string  $additional
     *
     * @return $this
     */
    public function additional(string $additional)
    {
        $this->additional = $additional;

        return $this;
    }

    /**
     * Remove any additional transforms that were added.
     */
    private function removeAdditional()
    {
        $this->additional = null;
    }
}