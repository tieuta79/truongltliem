<?php

return [
    'Menus' => [
        'Admin' => [
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
