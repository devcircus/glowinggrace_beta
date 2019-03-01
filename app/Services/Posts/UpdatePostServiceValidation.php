<?php

namespace App\Services\Posts;

use BrightComponents\Valid\ValidationService\ValidationService;

class UpdatePostServiceValidation extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     *
     * @return array
     */
    public function rules()
    {
        return [
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
