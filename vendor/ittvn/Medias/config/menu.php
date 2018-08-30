<?php

return [
    'Menus' => [
        'Admin' => [
            'Media' => [
                'icon' => 'fa fa-film',
                'title' => 'Media',
                'url' => '#',
                'child' => [
                    'Images' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Images',
                        'url' => [
                            'plugin' => 'Medias',
                            'controller' => 'Medias',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                   'Slideshow' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'Slideshow',
                        'url' => [
                            'plugin' => 'Medias',
                            'controller' => 'Slideshow',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ],
                    'Filenamager' => [
                        'icon' => 'fa fa-circle-o',
                        'title' => 'File namager',
                        'url' => [
                            'plugin' => 'Medias',
                            'controller' => 'Filemanage',
                            'action' => 'index',
                            'prefix' => 'admin'
                        ],
                    ]
                ],
                'priority' => 20
            ]
        ]
    ]
];
