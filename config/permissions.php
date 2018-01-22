<?php

use App\Handlers\Permissions\AnyPermissionHandler;
use App\Handlers\Permissions\ByFactoryPermissionHandler;
use App\Handlers\Permissions\ByOwnerPermissionHandler;
use App\Handlers\Permissions\ByQualifiersPermissionHandler;
use App\Handlers\Permissions\ByTemplatePermissionHandler;
use App\Handlers\Permissions\NonePermissionHandler;


$createAccessTypes = [
    'none' => [
        'machine_name' => 'none',
        'label' => 'Restricted',
        'handler' => NonePermissionHandler::class
    ],
    'allowed' => [
        'machine_name' => 'allowed',
        'label' => 'Allowed',
        'handler' => AnyPermissionHandler::class
    ]
];

$documentAccessTypes = [
    'none' => [
        'machine_name' => 'none',
        'label' => 'Restricted',
        'handler' => NonePermissionHandler::class
    ],
    'own' => [
        'machine_name' => 'own',
        'label' => 'Own',
        'handler' => ByOwnerPermissionHandler::class
    ],
    'any' => [
        'machine_name' => 'any',
        'label' => 'Any',
        'handler' => AnyPermissionHandler::class
    ],
    'by_qualifiers' => [
        'machine_name' => 'by_qualifiers',
        'label' => 'By qualifiers',
        'handler' => ByQualifiersPermissionHandler::class
    ]
];

$defaultAccessTypes = [
    'none' => [
        'machine_name' => 'none',
        'label' => 'Restricted',
        'handler' => NonePermissionHandler::class
    ],
    'any' => [
        'machine_name' => 'any',
        'label' => 'Any',
        'handler' => AnyPermissionHandler::class
    ]
];

return [
    'groups' => [
        'document' => [
            'machine_name' => 'document',
            'label' => 'Documents',
            'qualifiers' => [
                'factory' => [
                    'machine_name' => 'factory',
                    'label' => 'Factory',
                    'access_types' => [
                        'any' => [
                            'machine_name' => 'any',
                            'label' => 'Any factory',
                            'handler' => AnyPermissionHandler::class
                        ],
                        'list' => [
                            'machine_name' => 'list',
                            'label' => 'User\'s OR Role\'s factories',
                            'handler' => ByFactoryPermissionHandler::class
                        ]
                    ]
                ],
                'template' => [
                    'machine_name' => 'template',
                    'label' => 'Template',
                    'access_types' => [
                        'any' => [
                            'machine_name' => 'any',
                            'label' => 'Any template',
                            'handler' => AnyPermissionHandler::class
                        ],
                        'list' => [
                            'machine_name' => 'list',
                            'label' => 'User\'s OR Role\'s templates',
                            'handler' => ByTemplatePermissionHandler::class
                        ]
                    ]
                ]
            ],
            'permissions' => [
                'document_update' => [
                    'machine_name' => 'document_update',
                    'label' => 'Document update',
                    'access_types' => $documentAccessTypes
                ],
                'document_create' => [
                    'machine_name' => 'document_create',
                    'label' => 'Document create',
                    'access_types' => $createAccessTypes
                ],
                'document_view' => [
                    'machine_name' => 'document_view',
                    'label' => 'Document view',
                    'access_types' => $documentAccessTypes
                ],
                'document_delete' => [
                    'machine_name' => 'document_delete',
                    'label' => 'Document delete',
                    'access_types' => $documentAccessTypes
                ],
                'document_archive' => [
                    'machine_name' => 'document_archive',
                    'label' => 'Document archive',
                    'access_types' => $documentAccessTypes
                ]
            ]
        ],
        'user' => [
            'machine_name' => 'user',
            'label' => 'Users',
            'permissions' => [
                'user_update' => [
                    'machine_name' => 'user_update',
                    'label' => 'User update',
                    'access_types' => [
                        'none' => [
                            'machine_name' => 'none',
                            'label' => 'Restricted',
                            'handler' => NonePermissionHandler::class
                        ],
                        'any' => [
                            'machine_name' => 'any',
                            'label' => 'Any',
                            'handler' => AnyPermissionHandler::class
                        ],
                        'own' => [
                            'machine_name' => 'own',
                            'label' => 'Own',
                            'handler' => ByOwnerPermissionHandler::class
                        ]]
                ],
                'user_create' => [
                    'machine_name' => 'user_create',
                    'label' => 'User create',
                    'access_types' => $createAccessTypes,
                ],
                'user_view' => [
                    'machine_name' => 'user_view',
                    'label' => 'User view',
                    'access_types' => [
                        'none' => [
                            'machine_name' => 'none',
                            'label' => 'Restricted',
                            'handler' => NonePermissionHandler::class
                        ],
                        'any' => [
                            'machine_name' => 'any',
                            'label' => 'Any',
                            'handler' => AnyPermissionHandler::class
                        ],
                        'own' => [
                            'machine_name' => 'own',
                            'label' => 'Own',
                            'handler' => ByOwnerPermissionHandler::class
                        ]]
                ],
                'user_delete' => [
                    'machine_name' => 'user_delete',
                    'label' => 'User delete',
                    'access_types' => [
                        'none' => [
                            'machine_name' => 'none',
                            'label' => 'Restricted',
                            'handler' => NonePermissionHandler::class
                        ],
                        'any' => [
                            'machine_name' => 'any',
                            'label' => 'Any',
                            'handler' => AnyPermissionHandler::class
                        ],
                        'own' => [
                            'machine_name' => 'own',
                            'label' => 'Own',
                            'handler' => ByOwnerPermissionHandler::class
                        ]]
                ],
            ]
        ],
        'template' => [
            'machine_name' => 'template',
            'label' => 'Templates',
            'permissions' => [
                'template_update' => [
                    'machine_name' => 'template_update',
                    'label' => 'Template update',
                    'access_types' => $defaultAccessTypes
                ],
                'template_create' => [
                    'machine_name' => 'template_create',
                    'label' => 'Template create',
                    'access_types' => $createAccessTypes,
                ],
                'template_view' => [
                    'machine_name' => 'template_view',
                    'label' => 'Template view',
                    'access_types' => $defaultAccessTypes
                ],
                'template_delete' => [
                    'machine_name' => 'template_delete',
                    'label' => 'Template delete',
                    'access_types' => $defaultAccessTypes
                ]
            ]
        ],
        'label' => [
            'machine_name' => 'label',
            'label' => 'Labels',
            'permissions' => [
                'label_update' => [
                    'machine_name' => 'label_update',
                    'label' => 'Label update',
                    'access_types' => $defaultAccessTypes
                ],
                'label_create' => [
                    'machine_name' => 'label_create',
                    'label' => 'Label create',
                    'access_types' => $createAccessTypes,
                ],
                'label_view' => [
                    'machine_name' => 'label_view',
                    'label' => 'Label view',
                    'access_types' => $defaultAccessTypes
                ],
                'label_delete' => [
                    'machine_name' => 'label_delete',
                    'label' => 'Label delete',
                    'access_types' => $defaultAccessTypes
                ]
            ],
        ],
        'role' => [
            'machine_name' => 'role',
            'label' => 'Roles',
            'permissions' => [
                'role_toggle' => [
                    'machine_name' => 'role_toggle',
                    'label' => 'Change user\'s roles',
                    'access_types' => [
                        'none' => [
                            'machine_name' => 'none',
                            'label' => 'Restricted',
                            'handler' => NonePermissionHandler::class
                        ],
                        'allowed' => [
                            'machine_name' => 'allowed',
                            'label' => 'Allowed',
                            'handler' => AnyPermissionHandler::class
                        ]
                    ]
                ],
                'role_update' => [
                    'machine_name' => 'role_update',
                    'label' => 'Role update',
                    'access_types' => $defaultAccessTypes
                ],
                'role_create' => [
                    'machine_name' => 'role_create',
                    'label' => 'Role create',
                    'access_types' => $createAccessTypes,
                ],
                'role_view' => [
                    'machine_name' => 'role_view',
                    'label' => 'Role view',
                    'access_types' => $defaultAccessTypes
                ],
                'role_delete' => [
                    'machine_name' => 'role_delete',
                    'label' => 'Role delete',
                    'access_types' => $defaultAccessTypes
                ]
            ]
        ],
        'logs' => [
            'machine_name' => 'logs',
            'label' => 'Logs',
            'permissions' => [
                'logs_view' => [
                    'machine_name' => 'logs_view',
                    'label' => 'Logs view',
                    'access_types' => [
                        'none' => [
                            'machine_name' => 'none',
                            'label' => 'Restricted',
                            'handler' => NonePermissionHandler::class
                        ],
                        'allowed' => [
                            'machine_name' => 'allowed',
                            'label' => 'All',
                            'handler' => AnyPermissionHandler::class
                        ]
                    ]
                ]
            ]
        ],
        'menu' => [
            'machine_name' => 'menu',
            'label' => 'Menu access',
            'permissions' => [
                'documents_menu' => [
                    'machine_name' => 'documents_menu',
                    'label' => 'Documents',
                    'access_types' => [
                        'none' => [
                            'machine_name' => 'none',
                            'label' => 'Invisible',
                            'handler' => NonePermissionHandler::class
                        ],
                        'visible' => [
                            'machine_name' => 'visible',
                            'label' => 'Visible',
                            'handler' => AnyPermissionHandler::class
                        ]
                    ]
                ],
                'templates_menu' => [
                    'machine_name' => 'templates_menu',
                    'label' => 'Templates',
                    'access_types' => [
                        'none' => [
                            'machine_name' => 'none',
                            'label' => 'Invisible',
                            'handler' => NonePermissionHandler::class
                        ],
                        'visible' => [
                            'machine_name' => 'visible',
                            'label' => 'Visible',
                            'handler' => AnyPermissionHandler::class
                        ]
                    ]
                ],
                'users_menu' => [
                    'machine_name' => 'users_menu',
                    'label' => 'Users',
                    'access_types' => [
                        'none' => [
                            'machine_name' => 'none',
                            'label' => 'Invisible',
                            'handler' => NonePermissionHandler::class
                        ],
                        'visible' => [
                            'machine_name' => 'visible',
                            'label' => 'Visible',
                            'handler' => AnyPermissionHandler::class
                        ]
                    ]
                ],
                'labels_menu' => [
                    'machine_name' => 'labels_menu',
                    'label' => 'Labels',
                    'access_types' => [
                        'none' => [
                            'machine_name' => 'none',
                            'label' => 'Invisible',
                            'handler' => NonePermissionHandler::class
                        ],
                        'visible' => [
                            'machine_name' => 'visible',
                            'label' => 'Visible',
                            'handler' => AnyPermissionHandler::class
                        ]
                    ]
                ],
                'roles_menu' => [
                    'machine_name' => 'roles_menu',
                    'label' => 'Roles',
                    'access_types' => [
                        'none' => [
                            'machine_name' => 'none',
                            'label' => 'Invisible',
                            'handler' => NonePermissionHandler::class
                        ],
                        'visible' => [
                            'machine_name' => 'visible',
                            'label' => 'Visible',
                            'handler' => AnyPermissionHandler::class
                        ]
                    ]
                ],
                'logs_menu' => [
                    'machine_name' => 'logs_menu',
                    'label' => 'Logs',
                    'access_types' => [
                        'none' => [
                            'machine_name' => 'none',
                            'label' => 'Invisible',
                            'handler' => NonePermissionHandler::class
                        ],
                        'visible' => [
                            'machine_name' => 'visible',
                            'label' => 'Visible',
                            'handler' => AnyPermissionHandler::class
                        ]
                    ]
                ]
            ]
        ],
    ],
    'default_sets' => [
        'admin' => [
            'document_update' => ['access_type' => 'any'],
            'document_view' => ['access_type' => 'any'],
            'document_delete' => ['access_type' => 'any'],
            'document_archive' => ['access_type' => 'any'],
            'document_create' => ['access_type' => 'allowed'],
            'user_update' => ['access_type' => 'any'],
            'user_view' => ['access_type' => 'any'],
            'user_delete' => ['access_type' => 'any'],
            'user_create' => ['access_type' => 'allowed'],
            'template_update' => ['access_type' => 'any'],
            'template_view' => ['access_type' => 'any'],
            'template_delete' => ['access_type' => 'any'],
            'template_create' => ['access_type' => 'allowed'],
            'label_update' => ['access_type' => 'any'],
            'label_view' => ['access_type' => 'any'],
            'label_delete' => ['access_type' => 'any'],
            'label_create' => ['access_type' => 'allowed'],
            'role_toggle' => ['access_type' => 'allowed'],
            'role_update' => ['access_type' => 'any'],
            'role_view' => ['access_type' => 'any'],
            'role_delete' => ['access_type' => 'any'],
            'role_create' => ['access_type' => 'allowed'],
            'logs_view' => ['access_type' => 'allowed'],
            'documents_menu' => ['access_type' => 'visible'],
            'users_menu' => ['access_type' => 'visible'],
            'templates_menu' => ['access_type' => 'visible'],
            'labels_menu' => ['access_type' => 'visible'],
            'roles_menu' => ['access_type' => 'visible'],
            'logs_menu' => ['access_type' => 'visible'],
        ],
        'owner' => [
            'document_update' => ['access_type' => 'own'],
            'document_view' => ['access_type' => 'own'],
            'document_delete' => ['access_type' => 'own'],
            'document_archive' => ['access_type' => 'own'],
            'document_create' => ['access_type' => 'allowed'],
            'user_update' => ['access_type' => 'own'],
            'user_view' => ['access_type' => 'own'],
            'user_create' => ['access_type' => 'none'],
            'user_delete' => ['access_type' => 'none'],
            'documents_menu' => ['access_type' => 'visible'],
            'users_menu' => ['access_type' => 'visible'],
            'role_toggle' => ['access_type' => 'none'],
        ]
    ]
];

