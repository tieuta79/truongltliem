<?php

return [
    'Menus' => [
        'Admin' => [
            // Menu Users
            'Users' => [
                'icon' => 'fa fa-users',
                'title' => 'Users',
                'url' => '#',
                'child' => [
                    'AllUser' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'All User',
                        'url' => [
                            'plugin' => 'Users',
                            'controller' => 'Users',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                    'NewUser' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'New User',
                        'url' => [
                            'plugin' => 'Users',
                            'controller' => 'Users',
                            'action' => 'add',
                            'prefix' => 'admin'
                        ],
                    ],
                    'Roles' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Roles',
                        'url' => [
                            'plugin' => 'Users',
                            'controller' => 'Roles',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                    'Permission' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Permission',
                        'url' => [
                            'plugin' => 'Users',
                            'controller' => 'Users',
                            'action' => 'permission',
                            'prefix' => 'admin'
                        ],
                    ],
                    'Messages' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Messages',
                        'url' => [
                            'plugin' => 'Users',
                            'controller' => 'Messages',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ]
                ],
                'priority' => 25
            ],
            'Developer' => [
                'icon' => 'fa fa-codepen',
                'title' => 'Developer',
                'url' => '#',
                'child' => [
                    'Users' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Set Permission',
                        'url' => [
                            'plugin' => 'Users',
                            'controller' => 'Users',
                            'action' => 'setpermission',
                            'prefix' => 'admin'
                        ],
                    ],
                ],
                'priority' => 70
            ],
        ]
    ]
];
