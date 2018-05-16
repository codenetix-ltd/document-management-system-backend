<?php

use Faker\Generator as Faker;

$factory->define(App\Entities\Template::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word
    ];
});
