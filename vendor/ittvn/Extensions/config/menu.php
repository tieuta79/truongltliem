<?php

return [
    'Menus' => [
        'Admin' => [
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
                    ],                    
                ],
                'priority' => 30
            ],
        ]
    ]
];
