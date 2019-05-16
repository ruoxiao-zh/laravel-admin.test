<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    // 所有用户 ID 数组，如：[1,2,3,4]
    $user_ids = \App\User::all()->pluck('id')->toArray();

    return [
        'title' => $faker->title,
        'content' => $faker->sentence,
        'user_id' => $faker->randomElement($user_ids),
    ];
});
