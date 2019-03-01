<?php

namespace App\Exceptions\Models;

use Exception;

class CreatePostException extends Exception
{
    /**
     * Construct a new CreatePostException.
     *
     * @param  string  $message
     * @param  integer  $code
     */
    public function __construct(string $message, int $code)
    {
        throw new Exception($message, $code);
    }

    /**
     * Build a new CreatePostException.
     *
     * @param  string  $message
     * @param  integer  $code
     *
     * @return static
     */
    public static function unableToCreatePost(string $message = 'Unable to create post.', int $code = 500)
    {
        return new static($message, $code);
    }
}