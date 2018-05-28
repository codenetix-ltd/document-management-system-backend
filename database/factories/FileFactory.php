<?php

use App\Entities\File;
use Faker\Generator as Faker;

$factory->define(File::class, function (Faker $faker) {
    return [
        'path' => $faker->unique()->url,
        'original_name' => $faker->unique()->word
    ];
});
