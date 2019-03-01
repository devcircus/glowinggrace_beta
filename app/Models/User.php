<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $append = [
        'posts_count',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * A User has many posts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get the number of posts by the user.
     *
     * @return int
     */
    public function getPostsCountAttribute()
    {
        return $this->posts->count();
    }

    /**
     * Make a new Post object for the given user with the given details.
     *
     * @param  \App\Models\User  $user
     * @param  array  $details
     *
     * @return $this
     */
    public function createPost(array $attributes)
    {
        return $this->posts()->create([
            'title' => $attributes['title'],
            'summary' => $attributes['summary'],
            'body' => $attributes['body'],
            'published_at' => $attributes['published_at'],
        ]);
    }

    /**
     * Set the User avatar.
     *
     * @param  array  $avatar
     *
     * @return string
     */
    public function setAvatar(array $avatar)
    {
        $this->avatar = $avatarUrl = $avatar['secure_url'];
        $this->save();

        return $avatarUrl;
    }
}
