<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Blog;
use App\Category;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {
    $category = Category::inRandomOrder()->first();

    return [
        'category_id' => $category->id,
        'title' => $faker->catchPhrase,
        'details' => "<p>{$faker->text($maxNbChars = 1000)}</p>",
        'seo' => [
            'meta_title' => $faker->text($maxNbChars = 60),
            'meta_description' => $faker->text($maxNbChars = 160),
            'meta_keywords' => "{$faker->word},{$faker->word},{$faker->word}",
        ]
    ];
});
