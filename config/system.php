<?php

return [
    'roles' => [
        [
            'id' => 1,
            'name' => 'Admin'
        ],
        [
            'id' => 2,
            'name' => 'User'
        ]
    ],
    'routeIcons' => [
        'home' => 'fa fa-home',
        'documents.list' => 'fa fa-list',
        'documents.create' => 'fa fa-plus',
        'documents.edit' => 'fa fa-pencil',
        'documents.view' => 'fa fa-eye',
        'templates.list' => 'fa fa-copy',
        'templates.create' => 'fa fa-plus',
        'users.list' => 'fa fa-users',
        'users.create' => 'fa fa-plus',
        'users.edit' => 'fa fa-pencil',
        'templates.edit' => 'fa fa-pencil',
        'template_attributes.create' => 'fa fa-plus',
        'template_attributes.edit' => 'fa fa-pencil',
        'labels.list' => 'fa fa-tags',
        'labels.create' => 'fa fa-plus',
        'labels.edit' => 'fa fa-pencil',
        'logs.list' => 'fa fa-history'
    ],
    'morphMap' => [
        'user' => 'App\User',
        'document' => 'App\Document',
        'template' => 'App\Template',
        'label' => 'App\Label'
    ]
];

