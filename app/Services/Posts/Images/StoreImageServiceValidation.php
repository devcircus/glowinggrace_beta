<?php

namespace App\Services\Posts\Images;

use BrightComponents\Valid\ValidationService\ValidationService;

class StoreImageServiceValidation extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => ['image'],
        ];
    }

    /**
     * Get the sanitization filters that apply to the data.
     *
     * @return array
     */
    public function filters()
    {
        return [
        ];
    }
}
