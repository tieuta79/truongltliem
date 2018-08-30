<?php

return [
    'Menus' => [
        'Admin' => [
            'Extensions' => [
                'child' => [
                    'AllLocales' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'All Locales',
                        'url' => [
                            'plugin' => 'Translates',
                            'controller' => 'Locales',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                    'RedirectUrls' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Redirect Urls',
                        'url' => [
                            'plugin' => 'Extensions',
                            'controller' => 'Redirecturls',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                    'exportdata' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Export Data',
                        'url' => [
                            'plugin' => 'Extensions',
                            'controller' => 'Tools',
                            'action' => 'exportdata',
                            'prefix' => 'admin'
                        ],
                    ],
                    'importdata' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Import Data',
                        'url' => [
                            'plugin' => 'Extensions',
                            'controller' => 'Tools',
                            'action' => 'importdata',
                            'prefix' => 'admin'
                        ],
                    ],
                    'Helps' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Helps',
                        'url' => [
                            'plugin' => 'Extensions',
                            'controller' => 'Helps',
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