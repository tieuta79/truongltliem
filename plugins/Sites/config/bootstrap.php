<?php

use Cake\Core\Configure;

//Config for Sites
Configure::write('Admin.Tables.Sites.header', [
    'title' => [
        'label' => 'Title',
        'sort' => true,
        'filter' => 'text',
    ],
    'description' => [
        'label' => 'Description',
        'sort' => true,
        'filter' => 'text',
    ],
    'user_id' => [
        'label' => 'User',
        'sort' => true,
        'filter' => 'list',
        'map' => [
            '0' => 'user',
            '1' => 'id',
        ],
    ],
    'status' => [
        'label' => 'Status',
        'filter' => 'text',
    ],
    'publicKey' => [
        'label' => 'Public Key',
        'sort' => false,
        'filter' => 'text',
    ],
]);

Configure::write('Admin.Forms.Sites', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'title' => [
                'label' => 'Title',
                'type' => 'text',
            ],
            'description' => [
                'label' => 'Description',
                'type' => 'textarea',
            ]
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
            'user_id' => [
                'label' => 'User',
                'type' => 'select',
                'options' => 'users',
            ],
            'status' => [
                'hiddenField' => false,
                'label' => 'Status',
                'type' => 'checkbox',
            ],
        ],
        'api_key' => [
            'label' => 'Api Key',
            'publicKey' => [
                'label' => 'PublicKey',
                'type' => 'text',
                'readonly' => 'readonly'
            ],
            'privateKey' => [
                'label' => 'PrivateKey',
                'type' => 'text',
                'readonly' => 'readonly'
            ],
        ]
    ],
]);


Configure::write('Admin.Tables.Domains.header', [
    'id' => [
        'label' => 'Id',
        'sort' => true,
        'filter' => 'text',
    ],
    'name' => [
        'label' => 'Name',
        'sort' => true,
        'filter' => 'text',
    ],
    'ip' => [
        'label' => 'Ip',
        'sort' => true,
        'filter' => 'text',
    ],
    'site_id' => [
        'label' => 'site',
        'sort' => true,
        'filter' => 'list',
        'map' => [
            '0' => 'site',
            '1' => 'name',
        ],
    ],
    'created' => [
        'label' => 'Created',
        'sort' => true,
        'filter' => 'text',
    ],
]);

Configure::write('Admin.Views.Sites', [
]);

Configure::write('Admin.Tables.Apis.header', [
    'id' => [
        'label' => 'Id',
        'sort' => true,
        'filter' => 'text',
    ],
    'name' => [
        'label' => 'Name',
        'sort' => true,
        'filter' => 'text',
    ],
    'description' => [
        'label' => 'Description',
        'sort' => '1',
        'filter' => 'text',
    ],
    'method' => [
        'label' => 'Method',
        'sort' => true,
        'filter' => 'text',
    ],
    'status' => [
        'label' => 'Status',
        'sort' => '1',
        'filter' => 'text',
    ],
    'created' => [
        'label' => 'Created',
        'sort' => '1',
        'filter' => 'text',
    ]
]);
