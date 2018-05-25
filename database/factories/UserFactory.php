<?php

use App\Entities\File;
use Faker\Generator as Faker;

$factory->define(App\Entities\User::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt($faker->word),
        'remember_token' => str_random(10),
        'avatar_file_id' => factory(File::class)->create()->id
    ];
});
