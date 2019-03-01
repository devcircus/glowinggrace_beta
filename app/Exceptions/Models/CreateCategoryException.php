<?php

namespace App\Exceptions\Models;

use Exception;

class CreateCategoryException extends Exception
{
    /**
     * Construct a new CreateCategoryException.
     *
     * @param  string  $message
     * @param  int  $code
     */
    public function __construct(string $message, int $code)
    {
        throw new Exception($message, $code);
    }

    /**
     * Build a new CreateCategoryException.
     *
     * @param  string  $message
     * @param  int  $code
     *
     * @return static
     */
    public static function unableToCreateCategory(string $message = 'Unable to create category.', int $code = 500)
    {
        return new static($message, $code);
    }
}
