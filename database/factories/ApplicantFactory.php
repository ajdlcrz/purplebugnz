<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Applicant;
use App\Career;
use Faker\Generator as Faker;

$factory->define(Applicant::class, function (Faker $faker) {
    $career = Career::inRandomOrder()->first();
    $status = ['processed', 'interviewed', 'hired', 'rejected', 'for reference', 'pending'];

    return [
        'career_id' => $career->id,
        'name' => $faker->name,
        'contact' => $faker->phoneNumber,
        'address' => $faker->address,
        'email' => $faker->unique()->safeEmail,
        'file' => "{$faker->name}.{$faker->fileExtension}",
        'status' => $status[array_rand($status, 1)],
    ];
});
