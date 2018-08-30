<?php

use Cake\Core\Configure;
use Ittvn\Utility\Shortcode;
Shortcode::add('Slideshow',function($attributes){
    return 'I don\'t know slideshow'; 
});


Configure::write('Admin.Tables.Forms.header', [
    'id' => [
        'label' => 'Id',
        'sort' => '1',
        'filter' => 'text',
    ],
    'name' => [
        'label' => 'Name',
        'sort' => '1',
        'filter' => 'text',
    ],
    'slug' => [
        'label' => 'Slug',
        'sort' => '1',
        'filter' => 'text',
    ],
    'menu' => [
        'label' => 'Menu',
        'sort' => '1',
        'filter' => 'text',
    ],
    'list' => [
        'label' => 'List',
        'sort' => '1',
        'filter' => 'text',
    ],
]);

Configure::write('Admin.Tables.Fields.header', [
    'id' => [
        'label' => 'Id',
        'sort' => '1',
        'filter' => 'text',
    ],
    'name' => [
        'label' => 'Name',
        'sort' => '1',
        'filter' => 'text',
    ],
    'slug' => [
        'label' => 'Slug',
        'sort' => '1',
        'filter' => 'text',
    ],
    'value' => [
        'label' => 'Value',
        'sort' => '1',
        'filter' => 'text',
    ],
    'type' => [
        'label' => 'Type',
        'sort' => '1',
        'filter' => 'text',
    ],
    'form_id' => [
        'label' => 'form',
        'sort' => '1',
        'filter' => 'list',
        'map' => [
            '0' => 'form',
            '1' => 'name',
        ],
    ],
    'created' => [
        'label' => 'Created',
        'sort' => '1',
        'filter' => 'text',
    ],
]);
Configure::write('Admin.Forms.Fields', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name' => [
                'label' => 'Name',
                'type' => 'text',
            ],
            'slug' => [
                'label' => 'Slug',
                'type' => 'text',
            ],
            'value' => [
                'label' => 'Value',
                'type' => 'text',
            ],
            'type' => [
                'label' => 'Type',
                'type' => 'text',
            ],
            'options' => [
                'label' => 'Options',
                'type' => 'textarea',
            ],
            'attributes' => [
                'label' => 'Attributes',
                'type' => 'textarea',
            ],
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
        ],
    ]
]);

Configure::write('Admin.Tables.FieldMetas.header', [
//    'id' => [
//        'label' => 'Id',
//        'sort' => '1',
//        'filter' => 'text',
//    ],
    'value' => [
        'label' => 'Value',
        'sort' => '1',
        'filter' => 'text',
    ],
    'field_id' => [
        'label' => 'field',
        'sort' => '1',
        'filter' => 'list',
        'map' => [
            '0' => 'field',
            '1' => 'name',
        ],
    ],
    'created' => [
        'label' => 'Created',
        'sort' => '1',
        'filter' => 'text',
    ],
    'modified' => [
        'label' => 'Modified',
        'sort' => '1',
        'filter' => 'text',
    ],
]);
Configure::write('Admin.Forms.FieldMetas', [
    'main' => [
        'default' => [
            'label' => 'Default',
//            'key' => [
//                'label' => 'Key',
//                'type' => 'text',
//            ],
            'value' => [
                'label' => 'Value',
                'type' => 'textarea',
            ],
            'field_id' => [
                'label' => 'Field',
                'type' => 'select',
                'options' => 'fields',
            ],
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
        ],
    ]
]);