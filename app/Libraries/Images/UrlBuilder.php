<?php

namespace App\Libraries\Images;

class UrlBuilder
{
    /** @var string */
    private $protocol = 'https';

    /** @var string */
    private $baseUrl = 'res.cloudinary.com';

    /** @var string */
    private $cloudName;

    /** @var string */
    private $resourceType;

    /** @var string */
    private $type;

    /** @var string */
    private $transformations;

    /** @var int */
    private $version;

    /** @var string */
    private $publicId;

    /** @var string */
    private $format;

    /** Image Format Options */
    const FORMAT_PNG = 'png';
    const FORMAT_JPG = 'jpg';
    const FORMAT_TIFF = 'tiff';
    const FORMAT_GIF = 'gif';
    const FORMAT_BMP = 'bmp';

    /**
     * Build the url for the image.
     *
     * @param  array  $details
     * @param  string  $transformations
     *
     * @return string
     */
    public function build(array $details, string $transformations)
    {
        $this->setProperties($details, $transformations);

        return $this->protocol.'://'
            .$this->baseUrl.'/'
            .$this->cloudName.'/'
            .$this->resourceType.'/'
            .$this->type.'/'
            .$this->transformations.'/v'
            .$this->version.'/'
            .$this->publicId.'.'
            .$this->format;
    }

    /**
     * Use unsecure web protocol.
     *
     * @return $this
     */
    public function secure()
    {
        $this->setProtocol('https');

        return $this;
    }

    /**
     * Use secure web protocol.
     *
     * @return $this
     */
    public function unsecure()
    {
        $this->setProtocol('http');

        return $this;
    }

    /**
     * Set the web protocol for the url.
     *
     * @param  string  $protocol
     *
     * @return $this
     */
    public function setProtocol(string $protocol)
    {
        $this->protocol = $protocol;

        return $this;
    }

    /**
     * Set the image transformations for the url.
     *
     * @param array $transformations
     *
     * @return $this
     */
    public function setTransformations(array $transformations)
    {
        $this->transformations = $transformations;

        return $this;
    }

    /**
     * Set the image cloud name for the url.
     *
     * @param  string  $name
     *
     * @return $this
     */
    public function setCloudName(string $name)
    {
        $this->cloudName = $name;

        return $this;
    }

    /**
     * Set the image resource type for the url.
     *
     * @param  string  $resourceType
     *
     * @return $this
     */
    public function setResourceType(string $resourceType)
    {
        $this->resourceType = $resourceType;

        return $this;
    }

    /**
     * Set the image type for the url.
     *
     * @param  string  $type
     *
     * @return $this
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set all class properties.
     *
     * @param  array  $details
     * @param  string  $transformations
     *
     * @return array
     */
    public function setProperties(array $details, string $transformations)
    {
        $this->cloudName = config('cloudder.cloudName');
        $this->resourceType = $details['resource_type'];
        $this->type = $details['type'];
        $this->transformations = $transformations;
        $this->version = $details['version'];
        $this->publicId = $details['public_id'];
        $this->format = $details['format'];
    }
}