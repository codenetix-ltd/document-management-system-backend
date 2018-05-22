<?php

use App\Entities\User;
use Faker\Generator as Faker;

$factory->define(App\Entities\Log::class, function (Faker $faker) {
    return [
        'body' => $faker->unique()->word,
        'user_id' => function(){
            return factory(User::class)->create()->id;
        },
        'reference_type' => 'user',
        'reference_id' => function(){
            return factory(User::class)->create()->id;
        },
    ];
});
