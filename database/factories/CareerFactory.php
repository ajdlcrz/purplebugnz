<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Career;
use Faker\Generator as Faker;

$factory->define(Career::class, function (Faker $faker) {
    return [
        'title' => $faker->jobTitle,
        'department' => $faker->word,
        'experience' => $faker->randomDigit,
        'seo' => [
            'meta_title' => $faker->text($maxNbChars = 60),
            'meta_description' => $faker->text($maxNbChars = 160),
            'meta_keywords' => "{$faker->word},{$faker->word},{$faker->word}",
        ],
        'overview' => "<p><strong>Overview</strong>
<br>
<br>
Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et
ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum
dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore
magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet
clita kasd gubergren, no sea takimata",
        'requirements' => "<strong>Requirements</strong>
<br>
<li>Lorem ipsum dolor sit amet, consetetur sadipscing elitr</li>
<li>At vero eos et accusam et justo duo dolores et ea rebum</li>
<li>3 years working experience in telecom </li>
<li>Stet clita kasd gubergren, no</li>
</p>"
    ];
});
