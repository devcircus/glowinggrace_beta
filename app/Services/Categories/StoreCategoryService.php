<?php

namespace App\Services\Posts;

use App\Models\Category;
use App\Exceptions\Models\CreateCategoryException;
use BrightComponents\Services\Traits\SelfCallingService;

class StoreCategoryService
{
    use SelfCallingService;

    /** @var \App\Services\Categories\StoreCategoryServiceValidation */
    private $validator;

    /** @var \App\Models\Category */
    private $categories;

    /**
     * Construct a new StoreService.
     *
     * @param  \App\Services\Posts\StoreCategoryServiceValidation  $validator
     * @param  \App\Models\Category  $categories
     */
    public function __construct(StoreCategoryServiceValidation $validator, Category $categories)
    {
        $this->validator = $validator;
        $this->categories = $categories;
    }

    /**
     * Handle the call to the service.
     *
     * @param  array  $attributes
     *
     * @throws \Illuminate\Validation\ValidationException
     * @throws \App\Exceptions\Models\CreateCategoryException
     *
     * @return \App\Models\Category
     */
    public function run(array $attributes)
    {
        $this->validator->validate($attributes);

        $category = $categories->create($attributes);

        if (! $category instanceof Category) {
            throw CreateCategoryException::unableToCreateCategory();
        }

        return $category;
    }
}
