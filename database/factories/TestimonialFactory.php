<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Service;
use App\Testimonial;
use Faker\Generator as Faker;

$factory->define(Testimonial::class, function (Faker $faker) {
    $service = Service::inRandomOrder()->first();

    return [
        'service_id' => $service->id,
        'name' => $faker->name,
        'position' => $faker->jobTitle,
        'body' => $faker->text($maxNbChars = 200),
    ];
});
