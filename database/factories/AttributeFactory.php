<?php

use App\Entities\Attribute;
use App\Entities\Template;
use App\Repositories\TypeRepository;
use Faker\Generator as Faker;

$factory->define(Attribute::class, function (Faker $faker) {
    /** @var TypeRepository $typeRepository */
    $typeRepository = app()->make(TypeRepository::class);
    $typeString = $typeRepository->getTypeByMachineName('string');

    return [
        'name' => $faker->unique()->word,
        'templateId' => function () {
            return factory(Template::class)->create()->id;
        },
        'typeId' => $typeString->id,
        'isLocked' => false,
        'order' => 0
    ];
});

$factory->state(Attribute::class, 'table', function (Faker $faker) {
    $typeRepository = app()->make(TypeRepository::class);
    $typeString = $typeRepository->getTypeByMachineName('string');

    return [
        'name' => $faker->unique()->word,
        'data' => [
            'rows' => [
                [
                    'name' => 'row1',
                    'columns' => [
                        [
                            'typeId' => $typeString->id,
                            'isLocked' => false
                        ],
                        [
                            'typeId' => $typeString->id,
                            'isLocked' => false
                        ]
                    ]
                ],
                [
                    'name' => 'row2',
                    'columns' => [
                        [
                            'typeId' => $typeString->id,
                            'isLocked' => false
                        ],
                        [
                            'typeId' => $typeString->id,
                            'isLocked' => false
                        ]
                    ]
                ]
            ],
            'headers' => [
                [
                    'name' => 'header1',
                ],
                [
                    'name' => 'header2',
                ],
            ]
        ]
    ];
});

$factory->state(Attribute::class, 'table-broken', function (Faker $faker) {
    $typeRepository = app()->make(TypeRepository::class);
    $typeString = $typeRepository->getTypeByMachineName('string');

    return [
        'name' => $faker->unique()->word,
        'data' => [
            'rows' => [
                [
                    'name' => 'row1',
                    'columns' => [
                        [
                            'typeId' => $typeString->id,
                            'isLocked' => false
                        ],
                        [
                            'typeId' => $typeString->id,
                            'isLocked' => false
                        ]
                    ]
                ],
                [
                    'name' => 'row2',
                    'columns' => [
                        [
                            'typeId' => $typeString->id,
                            'isLocked' => false
                        ],
                        [
                            'typeId' => $typeString->id,
                            'isLocked' => false
                        ]
                    ]
                ]
            ]
        ]
    ];
});