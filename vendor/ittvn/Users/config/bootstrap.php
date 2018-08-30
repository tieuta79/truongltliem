<?php

use Cake\Core\Configure;
use Settings\Utility\Setting;

$setting = new Setting();

Configure::write('Users.sex', [
    0 => __d('ittvn', 'Female'),
    1 => __d('ittvn', 'Male'),
]);

Configure::write('Messages.priority', [
    0 => __d('ittvn', 'Normal'),
    1 => __d('ittvn', 'Hight'),
    2 => __d('ittvn', 'Very hight'),
]);
//Config for users
Configure::write('Admin.Tables.Users.header', [
    'avatar' => [
        'label' => __d('ittvn', 'Avatar'),
        'sort' => false,
        'data-hide' => 'phone,tablet'
    ],
    'last_name' => [
        'label' => __d('ittvn', 'Full name'),
        'sort' => true,
        'filter' => 'text',
        'data-class' => 'expand'
    ],
    'username' => [
        'label' => __d('ittvn', 'User name'),
        'sort' => true,
        'filter' => 'text',
        'data-hide' => 'phone,tablet'
    ],
    'email' => [
        'label' => __d('ittvn', 'Email'),
        'sort' => true,
        'filter' => 'text',
        'data-hide' => 'phone,tablet'
    ],
    'phone' => [
        'label' => __d('ittvn', 'Phone'),
        'sort' => true,
        'filter' => 'text',
        'data-hide' => 'phone,tablet'
    ],
    'role_id' => [
        'label' => __d('ittvn', 'Role'),
        'sort' => true,
        'filter' => 'list'
    ]
]);

Configure::write('Admin.Forms.Users', [
    'main' => [
        'default' => [
            'label' => 'Infomation',
            'first_name' => [
                'type' => 'text'
            ],
            'middle_name' => [
                'type' => 'text'
            ],
            'last_name' => [
                'type' => 'text'
            ],
            'avatar' => [
                'type' => 'file'
            ],
            'email' => [
                'type' => 'email',
            ],
            'phone' => [
                'type' => 'text'
            ],
        ],
        'account' => [
            'label' => 'Account',
            'username' => [
                'type' => 'text'
            ],
            'password' => [
                'type' => 'password',
                'value' => ''
            ],
            'password_confirm' => [
                'type' => 'password',
                'value' => ''
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
            ],
            'modified' => [
                'type' => 'text',
                'data-type' => 'datetime',
                'input-group' => true,
                'addon' => [
                    'before' => '<i class="fa fa-calendar"></i>'
                ]
            ]
        ],
        'role' => [
            'label' => 'Role',
            'role_id' => [
                'label' => false,
                'type' => 'radio',
                'multiple' => true,
                'options' => 'roles'
            ]
        ]
    ]
]);

Configure::write('Admin.Views.Users', [
    'avatar' => [
        'label' => 'Avatar'
    ],
    'full_name' => [
        'label' => 'Full name'
    ],
    'dateofbirth' => [
        'label' => 'Date of birth',
        'format' => [
            'type' => 'date',
            'text' => 'd/m/Y'
        ]
    ],
    'phone' => [
        'label' => 'Phone'
    ],
    'email' => [
        'label' => 'Email'
    ],
    'role_id' => [
        'label' => 'Role'
    ],
    'created' => [
        'label' => 'Created',
        'format' => [
            'type' => 'date',
            'text' => 'd/m/Y'
        ]
    ]
]);

//Config for roles
Configure::write('Admin.Tables.Roles.header', [
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
    'url_after_login' => [
        'label' => __d('ittvn', 'Url After Login'),
        'sort' => true,
        'filter' => 'text',
        'data-hide' => 'phone,tablet'
    ],
    'url_after_logout' => [
        'label' => __d('ittvn', 'Url After Logout'),
        'sort' => true,
        'filter' => 'text',
        'data-hide' => 'phone,tablet'
    ],
]);

Configure::write('Admin.Forms.Roles', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name' => [
                'type' => 'text'
            ],
            'slug' => [
                'type' => 'text'
            ],

            'url_after_login' => [
                'type' => 'text',
                'templates' => [
                    'inputContainer' => '<div class="form-group {{required}}">{{content}} <span class="help-block m-b-none text-danger">Example: plugin:plugin_name/controller:controller_name/action:action_name/params</span></div>'
                ]
            ],
            'url_after_logout' => [
                'type' => 'text',
                'templates' => [
                    'inputContainer' => '<div class="form-group {{required}}">{{content}} <span class="help-block m-b-none text-danger">Example: plugin:plugin_name/controller:controller_name/action:action_name/params</span></div>'
                ]
            ],
            'admin_login' => [
                'type' => 'checkbox',
                'hiddenField' => false,
                'preview' => [
                    'type' => 'admin_login',
                    'text' => '<span class="preview">{{admin_login}}</span>'
                ]
            ]
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
        ]
    ]
]);

Configure::write('Admin.Views.Roles', [
    'name' => [
        'label' => 'Name'
    ],
    'slug' => [
        'label' => 'Slug'
    ]
]);


//Config for messages
Configure::write('Admin.Tables.Messages.header', [
    'title' => [
        'label' => __d('ittvn', 'Title'),
        'sort' => false,
        'data-hide' => 'phone,tablet'
    ],
    'message' => [
        'label' => __d('ittvn', 'Message'),
        'sort' => true,
        'filter' => 'text',
        'data-class' => 'expand'
    ],
    'email' => [
        'label' => __d('ittvn', 'Send Email'),
        'sort' => true,
        'filter' => 'text',
        'data-hide' => 'phone,tablet'
    ],
    'priority' => [
        'label' => __d('ittvn', 'Priority'),
        'sort' => true,
        'filter' => 'text',
        'data-hide' => 'phone,tablet'
    ],
    'created' => [
        'label' => __d('ittvn', 'Created'),
        'sort' => true,
        'filter' => 'text',
        'data-hide' => 'phone,tablet'
    ]
]);

Configure::write('Admin.Forms.Messages', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'title' => [
                'label' => 'Title',
                'type' => 'text',
            ],
            'message' => [
                'label' => 'Message',
                'type' => 'textarea',
                'data-type' => 'editor',
            ]
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
            'email' => [
                'label' => 'Send To Email',
                'type' => 'checkbox',
            ],
            'messages_users.0.user_id' => [
                'label' => 'User',
                'type' => 'select',
                'options' => 'users'
            ],
            'priority' => [
                'label' => 'Priority',
                'type' => 'select',
                'options' => Configure::read('Messages.priority')
            ],
            'created' => [
                'label' => 'Created',
                'type' => 'text',
                'default' => date($setting->getOption('Sites.format_date') . ' ' . $setting->getOption('Sites.format_time')),
                'data-type' => 'datetime',
                'input-group' => true,
                'addon' => [
                    'before' => '<i class="fa fa-calendar"></i>'
                ]
            ],
        ],
    ]
]);
Configure::write('Admin.Tables.UsersLogs.header',[
	'id' => [
		'label' => 'Id',
		'sort' => '1',
		'filter' => 'text',
	],
	'log_id' => [
		'label' => 'log',
		'sort' => '1',
		'filter' => 'list',
		'map' => [
			'0' => 'log',
			'1' => 'id',
		],
	],
	'url' => [
		'label' => 'Url',
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

