<?php

return [
    'Menus' => [
        'Admin' => [
            // Menu Networks
            'Networks' => [
                'icon' => 'fa fa-globe',
                'title' => 'Networks',
                'url' => '#',
                'child' => [
                    'Sites' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Sites',
                        'url' => [
                            'plugin' => 'Sites',
                            'controller' => 'Sites',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                    'Domains' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Domains',
                        'url' => [
                            'plugin' => 'Sites',
                            'controller' => 'Domains',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],                    
                    'API' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'API',
                        'url' => [
                            'plugin' => 'Sites',
                            'controller' => 'Apis',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                    'network_settings' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Network Settings',
                        'url' => [
                            'plugin' => 'Settings',
                            'controller' => 'Settings',
                            'action' => 'general',
                            'prefix' => 'admin',1
                        ],
                    ]
                ],
                'priority' => 45
            ]
        ]
    ]
];
