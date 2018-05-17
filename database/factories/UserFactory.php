<?php

use App\Entities\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt($faker->word),
        'remember_token' => str_random(10),
    ];
});
