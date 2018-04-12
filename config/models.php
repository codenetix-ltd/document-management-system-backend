<?php
//Avatar
$avatar = [
    'createdAt',
    'updatedAt',
    'id',
    'path',
    'originalName',
];


//User
$user_store_request = [
    'fullName',
    'email',
    'templatesIds',
    'password',
    'passwordConfirmed',
    'avatar'
];
$user_response = [
    'fullName',
    'email',
    'createdAt',
    'updatedAt',
    'id',
    'templatesIds' => [],
    'avatar' => $avatar
];


//Tag
$tag = [
    'name'
];
$tag_response = [
    'id',
    'name',
    'createdAt',
    'updatedAt'
];


//Template
$template = [
    'name'
];
$template_response = [
    'id',
    'name',
    'createdAt',
    'updatedAt'
];


//Type
$type = [
    'name'
];
$typeResponse = [
    'id',
    'name',
    'machineName',
    'createdAt',
    'updatedAt'
];


//Attribute
$attributeStoreRequest = [
    'name',
    'typeId',
    'data' /*=> [
        'rows' => [
            [
                'name',
                'columns' => [
                    [
                        'typeId',
                        'isLocked'
                    ]
                ]
            ]
        ],
        'columns' => [
            [
                'name',
                'typeId'
            ]
        ]
    ]*/
];
$attributeResponse = [
    'id',
    'name',
    'order',
    'isLocked',
    'templateId',
    'parentAttributeId',
    'type' => $typeResponse,
    'data'/* => [
        'rows',
        'columns'
    ]*/,
    'createdAt',
    'updatedAt'
];


return [
    'user_store_request' => $user_store_request,
    'user_update_request' => $user_store_request,
    'user_response' => $user_response,
    'avatar' => $avatar,

    'tag_store_request' => $tag,
    'tag_update_request' => $tag,
    'tag_response' => $tag_response,

    'template_store_request' => $template,
    'template_update_request' => $template,
    'template_response' => $template_response,

    'type_store_request' => $type,
    'type_update_request' => $type,
    'type_response' => $typeResponse,

    'attribute_store_request' => $attributeStoreRequest,
    'attribute_response' => $attributeResponse
];