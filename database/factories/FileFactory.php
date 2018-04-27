<?php

use App\File;
use Faker\Generator as Faker;

$factory->define(File::class, function (Faker $faker) {
    return [
        'path' => $faker->unique()->url,
        'original_name' => $faker->unique()->word
    ];
});
