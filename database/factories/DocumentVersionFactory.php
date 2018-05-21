<?php

use App\Entities\Document;
use App\Entities\Template;
use Faker\Generator as Faker;

$factory->define(App\Entities\DocumentVersion::class, function (Faker $faker) {
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
        }
    ];
});
