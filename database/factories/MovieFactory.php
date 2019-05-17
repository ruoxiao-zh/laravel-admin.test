<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Movie;
use Faker\Generator as Faker;

$factory->define(Movie::class, function (Faker $faker) {
    $director_ids = \App\Director::all()->pluck('id')->toArray();

    return [
        'title' => $faker->title,
        'director_id' => $faker->randomElement($director_ids),
        'describe' => $faker->sentence,
        'rate' => random_int(0, 100),
        'released' => $faker->randomElement([0, 1]),
    ];
});
