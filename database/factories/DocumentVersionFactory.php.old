<?php

use App\Document;
use App\DocumentVersion;
use App\Template;
use Faker\Generator as Faker;

$factory->define(DocumentVersion::class, function (Faker $faker) {
    return [
        'is_actual' => true,
        'comment' => $faker->unique()->word,
        'name' => $faker->unique()->word,
        'version_name' => 1,
        'template_id' => function () {
            return factory(Template::class)->create()->id;
        },
        'document_id' => function () {
            return factory(Document::class)->create()->id;
        },
    ];
});
