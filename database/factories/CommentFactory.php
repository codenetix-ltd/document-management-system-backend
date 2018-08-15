<?php

use Faker\Generator as Faker;
use App\Entities\User;
use App\Entities\Document;

$factory->define(App\Entities\Comment::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return factory(User::class)->create()->id;
        },
        'commentable_id' => function(){
            return factory(Document::class)->create()->id;
        },
        'commentable_type' => 'document',
        'parent_id' => $faker->numberBetween(1, 5),
        'body' => $faker->text($maxNbChars = 100)
    ];
});
