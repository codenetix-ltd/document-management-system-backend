<?php

use App\Document;
use App\User;
use Faker\Generator as Faker;

$factory->define(Document::class, function (Faker $faker) {
    return [
        'owner_id' => function () {
            return factory(User::class)->create()->id;
        },

    ];
});
