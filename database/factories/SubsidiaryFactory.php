<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Subsidiary;
use Faker\Generator as Faker;

$factory->define(Subsidiary::class, function (Faker $faker) {
    return [
        'title' => $faker->text($maxNbChars = 25),
        'body' => $faker->text($maxNbChars = 200),
        'link' => $faker->url,
        'alt_text' =>  $faker->text($maxNbChars = 25)
    ];
});
