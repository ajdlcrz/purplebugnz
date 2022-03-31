<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'title' => $faker->catchPhrase,
        'description' => $faker->text(),
        'alt_text' => $faker->text(),
        'facts' => $faker->text(),
        'seo' => [
            'meta_title' => $faker->text($maxNbChars = 60),
            'meta_description' => $faker->text($maxNbChars = 160),
            'meta_keywords' => "{$faker->word},{$faker->word},{$faker->word}",
        ]
    ];
});
