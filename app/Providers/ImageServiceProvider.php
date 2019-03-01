<?php

namespace App\Providers;

use JD\Cloudder\Cloudder;
use Illuminate\Support\ServiceProvider;
use App\Libraries\Images\ImageProcessor;
use App\Libraries\Images\CloudderUploader;
use App\Libraries\Images\Contracts\ImageUploader;
use App\Libraries\Images\TransformationBuilder;
use App\Libraries\Images\UrlBuilder;

class ImageServiceProvider extends ServiceProvider
 {
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(ImageUploader::class, function ($app) {
            $base = $app[Cloudder::class];

            return new CloudderUploader($base);
        });

        $this->app->singleton(ImageProcessor::class, function ($app) {
            return new ImageProcessor($app[ImageUploader::class], new TransformationBuilder, new UrlBuilder);
        });
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
