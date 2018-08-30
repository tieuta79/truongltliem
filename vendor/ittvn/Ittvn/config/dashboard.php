<?php

return [
    'dashboard' => [
        'left' => [
            'shortcut' => [
                'label' => 'Shortcut',
                'icon' => 'fa fa-link',
                'links' => [
                        [
                        'label' => 'Add new Page',
                        'icon' => 'fa fa-book',
                        'url' => [
                            'plugin' => 'Contents',
                            'controller' => 'Contents',
                            'action' => 'add',
                            'pages'
                        ],
                    ],
                        [
                        'label' => 'Add new Post',
                        'icon' => 'fa fa-edit',
                        'url' => [
                            'plugin' => 'Contents',
                            'controller' => 'Contents',
                            'action' => 'add',
                            'posts'
                        ],
                    ],
                        [
                        'label' => 'Add new Category',
                        'icon' => 'fa fa-list-ol',
                        'url' => [
                            'plugin' => 'Contents',
                            'controller' => 'Categories',
                            'action' => 'add',
                            'categories'
                        ],
                    ],
                        [
                        'label' => 'Upload Medias',
                        'icon' => 'fa fa-film',
                        'url' => [
                            'plugin' => 'Medias',
                            'controller' => 'Medias',
                            'action' => 'index'
                        ],
                    ],
                    [
                        'label' => 'Menus',
                        'icon' => 'fa fa-bars',
                        'url' => [
                            'plugin' => 'Menus',
                            'controller' => 'Menus',
                            'action' => 'index'
                        ],
                    ],
                    [
                        'label' => 'Settings',
                        'icon' => 'fa fa-cogs',
                        'url' => [
                            'plugin' => 'Settings',
                            'controller' => 'Settings',
                            'action' => 'general',
                            'Sites'
                        ],
                    ]
                ]
            ],
            'developer' => [
                'label' => 'Developer',
                'icon' => 'fa fa-edit',
                'links' => [
                    [
                        'label' => 'Plugins',
                        'icon' => 'fa fa-plug',
                        'url' => [
                            'plugin' => 'Extensions',
                            'controller' => 'Extensions',
                            'action' => 'index'
                        ],
                    ],
                    [
                        'label' => 'Languages',
                        'icon' => 'fa fa-flag',
                        'url' => [
                            'plugin' => 'Extensions',
                            'controller' => 'Languages',
                            'action' => 'index'
                        ],
                    ],
                    [
                        'label' => 'Translate',
                        'icon' => 'fa fa-globe',
                        'url' => [
                            'plugin' => 'Translate',
                            'controller' => 'Locales',
                            'action' => 'index'
                        ],
                    ],
                    [
                        'label' => 'Themes',
                        'icon' => 'fa fa-laptop',
                        'url' => [
                            'plugin' => 'Themes',
                            'controller' => 'Themes',
                            'action' => 'index'
                        ],
                    ],
                    [
                        'label' => 'Sites',
                        'icon' => 'fa fa-sitemap',
                        'url' => [
                            'plugin' => 'Sites',
                            'controller' => 'Sites',
                            'action' => 'index'
                        ],
                    ],
                    [
                        'label' => 'Extra Fields',
                        'icon' => 'fa fa-pencil',
                        'url' => [
                            'plugin' => 'Metas',
                            'controller' => 'Metas',
                            'action' => 'index'
                        ],
                    ]
                ]
                ]
        ]
    ]
];
