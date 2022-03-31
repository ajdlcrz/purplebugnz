<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Partner;
use Faker\Generator as Faker;

$factory->define(Partner::class, function (Faker $faker) {
    return [
        'alt_text' => $faker->text($maxNbChars = 25),
        'link' => $faker->url
    ];
});
