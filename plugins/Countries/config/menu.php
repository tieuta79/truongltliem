<?php

return [
    'Menus' => [
        'Admin' => [
            // Menu Country
            'Countries' => [
                'icon' => 'fa fa-map-marker',
                'title' => 'Countries',
                'url' => '#',
                'child' => [
                    'AllCountry' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'All Countries',
                        'url' => [
                            'plugin' => 'Countries',
                            'controller' => 'Countries',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ]
                    ],
                    'AllProvince' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'All Provinces / State',
                        'url' => [
                            'plugin' => 'Countries',
                            'controller' => 'Provinces',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                    'AllCity' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'All Cities',
                        'url' => [
                            'plugin' => 'Countries',
                            'controller' => 'Cities',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                    'AllWard' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'All Wards',
                        'url' => [
                            'plugin' => 'Countries',
                            'controller' => 'Wards',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ]                    
                ],
                'priority' => 12
            ]
        ]
    ]
];
