<?php

use App\Attribute;
use App\AttributeValue;
use App\DocumentVersion;
use App\User;
use Faker\Generator as Faker;

$factory->define(AttributeValue::class, function (Faker $faker) {
    return [
        'attribute_id' => function () {
            return factory(Attribute::class)->create()->id;
        },
        'document_version_id' => function () {
            return factory(DocumentVersion::class)->create()->id;
        },
        'value' => $faker->unique()->word
    ];
});