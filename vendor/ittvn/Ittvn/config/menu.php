<?php

return [
    'Menus' => [
        'Admin' => [
            // Menu Dashboard
            'Dashboard' => [
                'icon' => 'fa fa-dashboard',
                'title' => 'Dashboard',
                'url' => [
                    'plugin' => 'Settings',
                    'controller' => 'Settings',
                    'action' => 'dashboard',
                    'prefix' => 'admin'
                ],
                'priority' => 1
            ],
            // Menu Comment
            /*
              'Comments' => [
              'icon' => 'fa fa-comments',
              'title' => 'Comments',
              'url' => '#',
              'child' => [
              'AllComment' => [
              'icon' => 'fa fa-circle-o',
              'title' => 'All Comment',
              'url' => '#',
              ],
              'NewComment' => [
              'icon' => 'fa fa-circle-o',
              'title' => 'New Comment',
              'url' => '#',
              ]
              ],
              'priority' => 15
              ],
             * *
             */
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
                    ]
                ],
                'priority' => 25
            ],
            // Menu Extensions
            'Extensions' => [
                'icon' => 'fa fa-plug',
                'title' => 'Extensions',
                'url' => '#',
                'child' => [
                    'AllPlugin' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'All Plugin',
                        'url' => [
                            'plugin' => 'Extensions',
                            'controller' => 'Extensions',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                    'AllLanguages' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'All Languages',
                        'url' => [
                            'plugin' => 'Extensions',
                            'controller' => 'Languages',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ]
                ],
                'priority' => 30
            ],
            // Menu Themes
            'Themes' => [
                'icon' => 'fa fa-laptop',
                'title' => 'Themes',
                'url' => '#',
                'child' => [
                    'All Theme' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'All Theme',
                        'url' => [
                            'plugin' => 'Themes',
                            'controller' => 'Themes',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                    'Blocks' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Blocks',
                        'url' => [
                            'plugin' => 'Blocks',
                            'controller' => 'Blocks',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                    'Menus' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Menus',
                        'url' => [
                            'plugin' => 'Menus',
                            'controller' => 'Menus',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ]
                ],
                'priority' => 35
            ],
        ]
    ]
];
