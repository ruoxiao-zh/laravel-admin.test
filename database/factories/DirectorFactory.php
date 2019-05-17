<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Director;
use Faker\Generator as Faker;

$factory->define(Director::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
