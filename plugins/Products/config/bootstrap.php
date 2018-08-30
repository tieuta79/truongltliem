<?php

use Cake\Core\Configure;
use Ittvn\Utility\System;

$system = new System();
$system->addModule('Products.Products::featured', 'Display Products featured', []);

//Config for users
Configure::write('Admin.Tables.Customers.header', [
    'last_name' => [
        'label' => __d('ittvn', 'Full name'),
        'sort' => true,
        'filter' => 'text'
    ],
    'username' => [
        'label' => __d('ittvn', 'User name'),
        'sort' => true,
        'filter' => 'text'
    ],
    'email' => [
        'label' => __d('ittvn', 'Email'),
        'sort' => true,
        'filter' => 'text'
    ],
    'phone' => [
        'label' => __d('ittvn', 'Phone'),
        'sort' => true,
        'filter' => 'text'
    ],
    'created' => [
        'label' => __d('ittvn', 'Created'),
        'sort' => true
    ]
]);

//config for attributes index, form, view
Configure::write('Admin.Tables.Attributes.header', [
    'id' => [
        'label' => __d('ittvn', 'ID'),
        'sort' => true,
        'filter' => 'no'
    ],
    'name' => [
        'label' => __d('ittvn', 'Name'),
        'sort' => true,
        'filter' => 'text'
    ],
    'type' => [
        'label' => __d('ittvn', 'Type'),
        'sort' => true,
        'filter' => 'list'
    ],
    'options' => [
        'label' => __d('ittvn', 'Options'),
        'sort' => true,
        'filter' => 'text'
    ],
    'status' => [
        'label' => __d('ittvn', 'Status'),
        'sort' => true
    ],
    'created' => [
        'label' => __d('ittvn', 'Created'),
        'sort' => true
    ]
]);

Configure::write('Admin.Forms.Attributes', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name' => [
                'type' => 'text'
            ],
            'type' => [
                'type' => 'select',
                'id' => 'meta_type',
                'options' => [
                    'text' => 'Text',
                    'textarea' => 'Textarea',
                    'editor' => 'Editor',
                    'select' => 'Select',
                    'radio' => 'Radio'
                ]
            ],
            'options' => [
                'id' => 'meta_options',
                'type' => 'textarea',
                'style' => 'display:none',
                'templates' => [
                    'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}} <div><button type="button" id="meta_add_option" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add options</button></div></div>',
                ]
            ]
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
            'status' => [
                'type' => 'checkbox',
                'hiddenField' => false,
                'preview' => [
                    'type' => 'status',
                    'text' => '<span class="preview">{{status}}</span>'
                ]
            ]
        ]
    ]
]);

Configure::write('Admin.Tables.Filters.header', [
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
    'description' => [
        'label' => 'Description',
        'sort' => '1',
        'filter' => 'text',
    ]
]);

Configure::write('Admin.Forms.Filters', [
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
            'description' => [
                'label' => 'Description',
                'type' => 'textarea',
            ],
            'f_attributes' => [
                'type' => 'select',
                'multiple' => 'checkbox',
                'name'=>'attributes[status]',
                'hiddenField' => false,
                'label' => false,
                'options' => [
                    'new' => 'New',
                    'featured' => 'Featured'
                ]
            ],
            'price_attributes' => [
                'type' => 'radio',
                'multiple' => true,
                'name'=>'attributes[price]',
                'hiddenField' => false,
                'label' => 'Filter by Price',
                'options' => [
                    '1000000' => __d('ittvn','Price').' < 1.000.000',
                    '1000000 - 5000000' => __d('ittvn','Price from').' 1.000.000 - 5.000.000',
                    '5000000' => __d('ittvn','Price').' > 5.000.000',
                ]
            ]            
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
            'modified' => [
                'type' => 'text',
                'data-type' => 'date',
                'data-dateformat' => 'dd/mm/yyyy',
                'input-group' => true,
                'addon' => [
                    'before' => '<i class="fa fa-calendar"></i>'
                ]
            ]
        ],
        'box_attributes' => [
            'label' => 'Attributes'
        ]
    ]
]);

Configure::write('Admin.Tables.Payments.header', [
    'id' => [
        'label' => 'Id',
        'sort' => '1',
        'filter' => 'text',
    ],
    'image' => [
        'label' => 'Image',
        'sort' => false,
        'filter' => false,
    ],
    'name' => [
        'label' => 'Name',
        'sort' => '1',
        'filter' => 'text',
    ],
    'description' => [
        'label' => 'Description',
        'sort' => '1',
        'filter' => 'text',
    ],
    'status' => [
        'label' => 'Status',
        'sort' => '1',
        'filter' => 'list',
    ],
]);

Configure::write('Admin.Forms.Payments', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name' => [
                'type' => 'text'
            ],
            'image' => [
                'type' => 'text',
            ],
            'element' => [
                'type' => 'text',
            ],
            'description' => [
                'type' => 'textarea',
                'data-type'=>'editor'
            ],
            'options' => [
                'id' => 'payment_options',
                'type' => 'textarea',
                'style' => 'display:none',
                'templates' => [
                    'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}} <div><button type="button" id="meta_add_option" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add options</button></div></div>',
                ]
            ]
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
            'status' => [
                'type' => 'checkbox',
                'hiddenField' => false,
                'preview' => [
                    'type' => 'status',
                    'text' => '<span class="preview">{{status}}</span>'
                ]
            ]
        ]
    ]
]);Configure::write('Admin.Tables.Wishlists.header',[
	'id' => [
		'label' => 'Id',
		'sort' => '1',
		'filter' => 'text',
	],
	'content_id' => [
		'label' => 'content',
		'sort' => '1',
		'filter' => 'list',
		'map' => [
			'0' => 'content',
			'1' => 'name',
		],
	],
	'user_id' => [
		'label' => 'user',
		'sort' => '1',
		'filter' => 'list',
		'map' => [
			'0' => 'user',
			'1' => 'id',
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

