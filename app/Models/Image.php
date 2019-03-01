<?php

namespace App\Models;

class Image extends Unguarded
{
    /**
     * An Image belongs to a Post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
