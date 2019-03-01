<?php

namespace App\Services\Posts;

use BrightComponents\Valid\ValidationService\ValidationService;

class StorePostServiceValidation extends ValidationService
{
    /**
     * Get the validation rules that apply to the data.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'min:3'],
            'body' => ['required', 'min:6'],
            'published_at' => ['nullable', 'date'],
            'featured_image' => ['nullable', 'image'],
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
            'title' => ['trim', 'strip_tags'],
            'body' => ['trim'],
            'featured_image' => ['trim', 'strip_tags'],
            'published_at' => ['trim', 'strip_tags'],
        ];
    }
}
