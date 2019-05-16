<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {

    $post_ids = \App\Post::all()->pluck('id')->toArray();
    $user_ids = \App\User::all()->pluck('id')->toArray();

    return [
        'content' => $faker->sentence,
        'post_id' => $faker->randomElement($post_ids),
        'user_id' => $faker->randomElement($user_ids),
    ];
});
