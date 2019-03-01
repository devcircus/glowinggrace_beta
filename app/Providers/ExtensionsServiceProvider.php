<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class ExtensionsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->bootRequestExtensions();
    }

    /**
     * Register services.
     */
    public function register()
    {
    }

    private function bootRequestExtensions()
    {
        Request::mixin(new \App\Extensions\Request);
    }
}
