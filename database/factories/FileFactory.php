<?php

use App\Entities\File;
use Faker\Generator as Faker;

$factory->define(File::class, function (Faker $faker) {
    return [
        'path' => '/storage/files/' . $faker->unique()->word,
        'original_name' => $faker->unique()->word
    ];
});
