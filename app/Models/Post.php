<?php

namespace App\Models;

class Post extends Unguarded
{
    /** @var array */
    protected $casts = ['published_at' => 'date:Y-m-d'];

    /** @var array */
    protected $dates = ['published_at'];

    /** @var string */
    protected $table = 'posts';

    /** @var array */
    protected $appends = ['featured_image'];

    /**
     * A Post belongs to a User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A Post has many images.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * A Post belongs to many categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->BelongsToMany(Category::class);
    }

    /**
     * Save an image for a post.
     *
     * @param  array  $details
     * @param  array $urls
     * @param  bool  $featured
     *
     * @return $this
     */
    public function saveImage(array $details, array $urls, bool $featured = false)
    {
        if ($featured) {
            return $this->saveFeaturedImage($details, $urls, $featured);
        }

        return $this->saveEmbeddedImage($details, $urls, $featured);
    }

    /**
     * Update a Post.
     *
     * @param  array  $attributes
     * @param  array  $options
     *
     * @return bool
     */
    public function update(array $attributes = [], array $options = [])
    {
        $this->title = $attributes['title'];
        $this->summary = $attributes['summary'];
        $this->body = $attributes['body'];
        $this->published_at = $attributes['published_at'];

        return $this->save();
    }

    /**
     * Replace the post body with the given body.
     *
     * @param  string  $body
     *
     * @return $this
     */
    public function replaceBody(string $body)
    {
        $this->body = $body;
        $this->save();

        return $this->fresh()->with('images');
    }

    /**
     * Get the featured image for the post.
     *
     * @return \App\Models\Image
     */
    public function getFeaturedImageAttribute()
    {
        return $this->images()->where('featured', true)->first();
    }

    /**
     * Scope the query to only published posts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($builder)
    {
        $builder->where('published_at', '<=', now());
    }

    /**
     * Delete the current featured image for the post.
     *
     * @param  int  $id
     *
     * @return bool
     */
    public function deleteFeaturedImage(?int $id = null)
    {
        return $this->images()->when($id, function ($builder) use ($id) {
            return $builder->where('id', $id)->delete() ? true : false;
        }, function ($builder) {
            return $builder->where('featured', 1)->delete() ? true : false;
        });
    }

    public function saveFeaturedImage(array $details, array $urls, bool $featured = false)
    {
        $currentFeaturedImage = $this->featured_image;

        $newFeaturedImage = $this->images()->create([
            'resource_type' => $details['resource_type'],
            'type' => $details['type'],
            'version' => $details['version'],
            'public_id' => $details['public_id'],
            'format' => $details['format'],
            'featured' => $featured,
            'thumb_size_url' => $urls['thumbUrl'],
            'full_size_url' => $urls['fullSizeUrl'],
            'display_size_url' => $urls['displaySizeUrl'],
            'medium_size_url' => $urls['mediumSizeUrl'],
        ]);

        if ($newFeaturedImage && $currentFeaturedImage) {
            $this->deleteFeaturedImage($currentFeaturedImage->id);
        }

        return $this->featured_image;
    }

    public function saveEmbeddedImage(array $details, array $urls, bool $featured = false)
    {
        $image = $this->images()->make([
            'resource_type' => $details['resource_type'],
            'type' => $details['type'],
            'version' => $details['version'],
            'public_id' => $details['public_id'],
            'format' => $details['format'],
            'featured' => $featured,
            'thumb_size_url' => null,
            'full_size_url' => $urls['fullSizeUrl'],
        ]);

        $image->medium_size_url = $urls['mediumSizeUrl'] ?? null;
        $image->display_size_url = $urls['displaySizeUrl'] ?? null;
        $image->save();

        return $image->fresh();
    }
}
