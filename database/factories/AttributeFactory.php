<?php

use App\Attribute;
use App\Contracts\Repositories\ITypeRepository;
use Faker\Generator as Faker;

$factory->define(Attribute::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word
    ];
});

$factory->state(Attribute::class, 'table', function (Faker $faker) {
    /** @var ITypeRepository $typeRepository */
    $typeRepository = app()->make(ITypeRepository::class);
    $typeString = $typeRepository->getTypeByMachineName('string');

    return [
        'name' => $faker->unique()->word,
        'data' => [
            'rows' => [
                [
                    'name' => 'row1',
                    'columns' => [
                        [
                            'typeId' => $typeString->getId(),
                            'isLocked' => false
                        ],
                        [
                            'typeId' => $typeString->getId(),
                            'isLocked' => false
                        ]
                    ]
                ],
                [
                    'name' => 'row2',
                    'columns' => [
                        [
                            'typeId' => $typeString->getId(),
                            'isLocked' => false
                        ],
                        [
                            'typeId' => $typeString->getId(),
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