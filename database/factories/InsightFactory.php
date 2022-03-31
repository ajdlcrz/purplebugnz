<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Insight;
use Faker\Generator as Faker;

$factory->define(Insight::class, function (Faker $faker) {
    return [
        'title' => $faker->catchPhrase,
        'details' => "<p>{$faker->text($maxNbChars = 1000)}</p>",
        'seo' => [
            'meta_title' => $faker->text($maxNbChars = 60),
            'meta_description' => $faker->text($maxNbChars = 160),
            'meta_keywords' => "{$faker->word},{$faker->word},{$faker->word}",
        ]
    ];
});
