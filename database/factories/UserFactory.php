<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(User::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt($faker->word),
        'remember_token' => str_random(10),
    ];
});
