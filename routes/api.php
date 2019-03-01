<?php

// Auth routes (must be logged in)
$this->group(['middleware' => ['jwt.auth']], function ($router) {
    $router->get('me', Auth\Me::class);
    $router->post('logout', Auth\Logout::class);
    $router->post('refresh', Auth\Refresh::class);
});

// Profile routes - authenticated
$this->group(['middleware' => ['jwt.auth']], function ($router) {
    $router->post('me/avatar', Profile\ImageStore::class);
});

// Auth routes - unauthenticated
$this->post('login', Auth\Login::class);

// Post routes - unauthenticated
$this->get('posts', Posts\Index::class);

// Post routes - authenticated
$this->group(['middleware' => ['jwt.auth']], function ($router) {
    $router->post('posts', Posts\Store::class);
    $router->post('posts/edit/{post}', Posts\Update::class);
    $router->post('images', Posts\Images\Store::class);
    $router->post('posts/image/delete/{post}', Posts\Images\Delete::class);
});

// Category routes - authenticated
$this->group(['middleware' => ['jwt.auth']], function ($router) {
    $router->post('categories', Categories\Store::class);
    // $router->post('categories/edit/{category}', Categoriess\Update::class);
});

// Image routes - unauthenticated
$this->get('images', Images\Index::class);
