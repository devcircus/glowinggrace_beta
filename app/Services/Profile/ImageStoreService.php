<?php

namespace App\Services\Profile;

use App\Models\User;
use App\Libraries\Images\Contracts\ImageUploader;
use BrightComponents\Services\Traits\SelfCallingService;

class ImageStoreService
{
    use SelfCallingService;

    /** @var \App\Services\Profile\ImageStoreValidationService */
    protected $validator;

    /** @var \App\Libraries\Images\Contracts\ImageUploader */
    protected $uploader;

    /**
     * Construct a new ImageStoreService.
     *
     * @param  \App\Services\Profile\ImageStorevalidationService  $validator
     * @param  \App\Libraries\Images\Contracts\ImageUploader  $uploader
     */
    public function __construct(ImageStoreValidationService $validator, ImageUploader $uploader)
    {
        $this->validator = $validator;
        $this->uploader = $uploader;
    }

    /**
     * Handle the call to the service.
     *
     * @param  \App\Models\User  $user
     * @param  array  $attributes
     *
     * @return mixed
     */
    public function run(User $user, array $attributes)
    {
        $this->validator->validate($attributes);

        return $user->setAvatar($this->uploader->upload($attributes['avatar'], null, 'profiles'));
    }
}
