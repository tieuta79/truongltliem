<?php
use Ittvn\Utility\System;
use Cake\Core\Configure;
$system = new System();
$system->addModule('Contents.Content::display','Display Page, Post and Post Type',[]);

//config for Contents index, form, view
Configure::write('Admin.Tables.Contents.header', [
    'name' => [
        'label' => __d('ittvn', 'Name'),
        'sort' => true,
        'filter' => 'text',
        'data-class' => 'expand'
    ],
    'slug' => [
        'label' => __d('ittvn', 'Slug'),
        'sort' => true,
        'filter' => 'text',
        'data-hide' => 'phone,tablet'
    ],
    'excerpt' => [
        'label' => __d('ittvn', 'Excerpt'),
        'sort' => true,
        'filter' => 'text',
        'data-hide' => 'phone,tablet'
    ],
    'created' => [
        'label' => __d('ittvn', 'Created'),
        'sort' => true,
        'filter' => 'date',
    ]
]);

Configure::write('Admin.Forms.Contents', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name' => [
                'type' => 'text'
            ],
            'slug' => [
                'type' => 'text'
            ],
            'excerpt' => [
                'type' => 'textarea'
            ],
            'description' => [
                'type' => 'textarea',
                'data-type' => 'editor'
            ]
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',       
            'status' => [
                'type' => 'checkbox',
                'checked' => true
            ],                        
            'layout' => [
                'type' => 'select',
                'default' => 'default',
            ],
            'modified' => [
                'type' => 'text',
                'data-type' => 'date',
                'data-dateformat'=>'dd/mm/yyyy',
                'input-group' => true,
                'addon' => [
                    'before' => '<i class="fa fa-calendar"></i>'
                ]
            ]
        ],
        'image' => [
            'label' => 'Feature Image',
            'image' => [
                'type' => 'select_file',
                'data-type' => 'image'
            ]
        ]
    ]
]);

Configure::write('Admin.Views.Contents', [
    'image' => [
        'label' => 'Image'
    ],
    'name' => [
        'label' => 'Name'
    ],
    'slug' => [
        'label' => 'Slug'
    ],
    'excerpt' => [
        'label' => 'Excerpt'
    ],
    'description' => [
        'label' => 'Description'
    ],
    'created' => [
        'label' => 'Created',
        'format' => [
            'type' => 'date',
            'text' => 'd/m/Y'
        ]
    ]
]);

//config for categories index, form, view
Configure::write('Admin.Tables.Categories.header', [
    'name' => [
        'label' => __d('ittvn', 'name'),
        'sort' => true,
        'filter' => 'text',
        'data-class' => 'expand'
    ],
    'slug' => [
        'label' => __d('ittvn', 'Slug'),
        'sort' => true,
        'filter' => 'text',
        'data-hide' => 'phone,tablet'
    ],
    'description' => [
        'label' => __d('ittvn', 'Description'),
        'sort' => true,
        'filter' => 'text',
        'data-hide' => 'phone,tablet'
    ],
    'created' => [
        'label' => __d('ittvn', 'Created'),
        'sort' => true
    ],
    'translate' => [
        'label' => __d('ittvn', 'Translate'),
        'sort' => true,
        'filter' => 'text',
    ]
]);

Configure::write('Admin.Forms.Categories', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name' => [
                'type' => 'text'
            ],
            'slug' => [
                'type' => 'text'
            ],
            'description' => [
                'type' => 'textarea'
            ]
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
            'modified' => [
                'type' => 'text',
                'data-type' => 'date',
                'data-dateformat'=>'dd/mm/yyyy',
                'input-group' => true,
                'addon' => [
                    'before' => '<i class="fa fa-calendar"></i>'
                ]
            ]
        ],
        'parent_id' => [
            'label' => 'Parent',
            'parent_id' => [
                'label' => false,
                'type' => 'radio',
                'multiple' => true,
                'options' => 'parentCategories'
            ]
        ]
    ]
]);

Configure::write('Admin.Views.Categories', [
    'name' => [
        'label' => 'Name'
    ],
    'slug' => [
        'label' => 'Slug'
    ],
    'description' => [
        'label' => 'Description'
    ],
    'parent_id' => [
        'label' => 'Parent'
    ],
    'created' => [
        'label' => 'Created',
        'format' => [
            'type' => 'date',
            'text' => 'd/m/Y'
        ]
    ]
]);
