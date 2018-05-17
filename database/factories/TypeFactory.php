<?php

use Faker\Generator as Faker;

$factory->define(App\Entities\Type::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'machine_name' => $faker->unique()->word
    ];
});
