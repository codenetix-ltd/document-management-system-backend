<?php
//Common
$dates = [
    'createdAt',
    'updatedAt'
];

//Avatar
$avatar = array_merge(
    $dates,
    [
        'id',
        'path',
        'originalName',
    ]
);

//User
$user = [
    'fullName',
    'email',
];
$user_store_request = array_merge(
    $user,
    [
        'templatesIds',
        'password',
        'passwordConfirmed',
        'avatar'
    ]
);
$user_response = array_merge(
    $user,
    $dates,
    [
        'id',
        'templatesIds' => [],
        'avatar' => $avatar
    ]
);


//Tag
$tag = [
    'name'
];
$tag_response = array_merge(
    [
        'id'
    ],
    $tag,
    $dates
);


//Template
$template = [
    'name'
];
$template_response = array_merge(
    [
        'id'
    ],
    $template,
    $dates
);


//Type
$type = [
    'name'
];
$type_response = array_merge(
    [
        'id'
    ],
    $type,
    $dates
);



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
    'type_response' => $type_response,
];