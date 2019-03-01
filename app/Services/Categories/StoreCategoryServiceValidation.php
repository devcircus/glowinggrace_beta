<?php

namespace App\Services\Categories;

use BrightComponents\Valid\ValidationService\ValidationService;

class StoreCategoryServiceValidation extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:3'],
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
            'name' => ['trim', 'strip_tags'],
        ];
    }
}
