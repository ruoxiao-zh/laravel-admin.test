<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    // 头像假数据
    $avatars = [
        'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/s5ehp11z6s.png',
        'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/Lhd1SHqu86.png',
        'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png',
        'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/xAuDMxteQy.png',
        'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png',
        'https://iocaffcdn.phphub.org/uploads/images/201710/14/1/NDnzMutoxX.png',
    ];

    return [
        'name' => $faker->name,
        'sex' => random_int(0, 1),
        'email' => $faker->unique()->safeEmail,
        'avatar' => $faker->randomElement($avatars),
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});
