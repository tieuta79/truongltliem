<?php

return [
    'Menus' => [
        'Admin' => [
            // Menu Developer
            'Developer' => [
                'icon' => 'fa fa-codepen',
                'title' => 'Developer',
                'url' => '#',
                'child' => [
                    'MetaType' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Content Type',
                        'url' => [
                            'plugin' => 'Metas',
                            'controller' => 'MetaTypes',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                    'MetaCategory' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Taxonomies',
                        'url' => [
                            'plugin' => 'Metas',
                            'controller' => 'MetaCategories',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                    'Metas' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Extra Fields',
                        'url' => [
                            'plugin' => 'Metas',
                            'controller' => 'Metas',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                ],
                'priority' => 70
            ],
        ]
    ]
];
