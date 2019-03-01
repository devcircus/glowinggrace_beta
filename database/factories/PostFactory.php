<?php

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(App\Models\Post::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\Image($faker));
    $days = [1, 2, 3, 4, 5];

    return [
        'title' => ucfirst($faker->word).' '.ucfirst($faker->word).' '.ucfirst($faker->word),
        'summary' => $faker->paragraph(),
        'body' => $faker->paragraph(2),
        'published_at' => now()->subDays(array_rand($days, 1)),
        'user_id' => factory(\App\Models\User::class),
    ];
})->afterCreating(App\Models\Post::class, function ($post, $faker) {
    $categoriesFromDb = Category::get();
    $categories = $categoriesFromDb->count() > 0 ? $categoriesFromDb : factory(App\Models\Category::class, 3)->create();
    $post->categories()->attach($categories->pluck('id')->toArray());
});
