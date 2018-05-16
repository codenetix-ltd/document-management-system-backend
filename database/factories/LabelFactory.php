<?php

use Faker\Generator as Faker;

$factory->define(App\Entities\Label::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word
    ];
});