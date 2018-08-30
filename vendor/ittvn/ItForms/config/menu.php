<?php

return [
    'Menus' => [
        'Admin' => [
            // Menu Developer
            'Developer' => [
                'child' => [
                    'Forms' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Forms',
                        'url' => [
                            'plugin' => 'ItForms',
                            'controller' => 'Forms',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                    'Fields' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Fields',
                        'url' => [
                            'plugin' => 'ItForms',
                            'controller' => 'Fields',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                ],
            ],
        ]
    ]
];
