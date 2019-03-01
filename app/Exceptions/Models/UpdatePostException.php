<?php

namespace App\Exceptions\Models;

use Exception;

class UpdatePostException extends Exception
{
    /**
     * Construct a new UpdatePostException.
     *
     * @param  string  $message
     * @param  integer  $code
     */
    public function __construct(string $message, int $code)
    {
        throw new Exception($message, $code);
    }

    /**
     * Build a new UpdatePostException.
     *
     * @param  string  $message
     * @param  integer  $code
     *
     * @return static
     */
    public static function unableToUpdatePost(string $message = 'Unable to update post.', int $code = 500)
    {
        return new static($message, $code);
    }
}