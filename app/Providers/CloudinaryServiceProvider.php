<?php

namespace App\Providers;

use Cloudinary;
use Illuminate\Support\ServiceProvider;

class CloudinaryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Cloudinary::config([
            "cloud_name" => config('services.cloudinary.name'),
            "api_key" => config('services.cloudinary.key'),
            "api_secret" => config('services.cloudinary.secret'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
