<?php

use App\Entities\User;
use Faker\Generator as Faker;

$factory->define(App\Entities\Document::class, function (Faker $faker) {
    return [
        'owner_id' => function () {
            return factory(User::class)->create()->id;
        }
    ];
});
