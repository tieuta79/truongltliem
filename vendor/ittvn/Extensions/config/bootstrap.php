<?php

use Cake\Core\Configure;

Configure::write('Admin.Tables.Languages.header', [
    'name' => [
        'label' => 'Name',
        'sort' => true,
        'filter' => 'text',
    ],
    'code' => [
        'label' => 'Code',
        'sort' => true,
        'filter' => 'text',
    ],
    'image' => [
        'label' => 'Image',
        'sort' => true,
        'filter' => 'text',
    ],
    'status' => [
        'label' => 'Status',
        'sort' => true,
        'filter' => 'text',
    ]
]);

Configure::write('Admin.Forms.Languages', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name' => [
                'type' => 'text'
            ],
            'code' => [
                'type' => 'text'
            ],
            'image' => [
                'type' => 'text'
            ]
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
            'status' => [
                'type' => 'checkbox'
            ],
            'modified' => [
                'type' => 'text',
                'data-type' => 'date',
                'data-dateformat' => 'dd/mm/yyyy',
                'input-group' => true,
                'addon' => [
                    'before' => '<i class="fa fa-calendar"></i>'
                ]
            ]
        ]
    ]
]);

Configure::write('Admin.Tables.Redirecturls.header', [
    'id' => [
        'label' => 'Id',
        'sort' => '1',
        'filter' => 'text',
    ],
    'request' => [
        'label' => 'Request',
        'sort' => '1',
        'filter' => 'text',
    ],
    'target' => [
        'label' => 'Target',
        'sort' => '1',
        'filter' => 'text',
    ],
    'options' => [
        'label' => 'Options',
        'sort' => '1',
        'filter' => 'text',
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

Configure::write('Admin.Forms.Redirecturls', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'request' => [
                'label' => 'Request',
                'type' => 'text',
            ],
            'target' => [
                'label' => 'Target',
                'type' => 'text',
            ],
            'options' => [
                'label' => 'Options',
                'type' => 'text',
            ],
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
        ],
    ]
]);

Configure::write('Admin.Tables.Helps.header', [
    'id' => [
        'label' => 'Id',
        'sort' => '1',
        'filter' => 'text',
    ],
    'link' => [
        'label' => 'Link',
        'sort' => '1',
        'filter' => 'text',
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
Configure::write('Admin.Forms.Helps', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'content' => [
                'label' => 'Content',
                'type' => 'textarea',
                'data-type' => 'editor',
            ],
            'link' => [
                'label' => 'Link',
                'type' => 'text',
            ],

        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
        ],
    ]
]);