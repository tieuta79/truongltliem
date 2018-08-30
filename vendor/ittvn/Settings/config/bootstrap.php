<?php

use Cake\Core\Configure;
//Config for settings
Configure::write('Admin.Tables.Settings.header', [
    'id' => [
        'label' => __d('ittvn', 'ID'),
        'sort' => true,
        'filter'=>'no'
    ],    
    'name' => [
        'label' => __d('ittvn', 'Name'),
        'sort' => true,
        'filter'=>'text'
    ],
    'value' => [
        'label' => __d('ittvn', 'Default Value'),
        'sort' => true,
        'filter'=>'text'
    ],
    'description' => [
        'label' => __d('ittvn', 'Description'),
        'sort' => true,
        'filter'=>'text'
    ],
    'type' => [
        'label' => __d('ittvn', 'Type'),
        'sort' => true,
        'filter'=>'list'
    ],
    'created' => [
        'label' => __d('ittvn', 'Created'),
        'sort' => true,
        'filter'=>'no'
    ]
]);

Configure::write('Admin.Forms.Settings', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name' => [
                'type' => 'text'
            ],
            'value' => [
                'label'=> __d('ittvn', 'Default Value'),
                'type' => 'text'
            ],
            'description' => [
                'type' => 'textarea'
            ],
            'type' => [
                'type' => 'select',
                'id' => 'setting_type',
                'options' => [
                    'text' => 'Text',
                    'textarea' => 'Textarea',
                    'select' => 'Select',
                    'checkbox' => 'Checkbox',
                    'radio' => 'Radio',
                    'editor' => 'Editor'
                ]
            ],            
            'options' => [
                'id' => 'setting_options',
                'type' => 'textarea',
                'style'=>'display:none',
                'templates'=>[
                    'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}} <div><button type="button" id="setting_add_option" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Add options</button></div></div>',
                ]                
            ]
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
            'editable' => [
                'type' => 'checkbox',
                'preview' => [
                    'type' => 'status',
                    'text' => '<span class="preview">{{status}}</span>'
                ]
            ],
            'global' => [
                'type' => 'checkbox',
                'preview' => [
                    'type' => 'Global',
                    'text' => '<span class="preview">{{global}}</span>'
                ]
            ],
            'modified' => [
                'type' => 'text',
                'data-type' => 'date',
                'input-group' => true,
                'addon' => [
                    'before' => '<i class="fa fa-calendar"></i>'
                ]
            ]
        ]
    ]
]);

Configure::write('Admin.Views.Settings', [
    'name' => [
        'label' => 'Name'
    ],    
    'value' => [
        'label' => 'Default Value'
    ],
    'description' => [
        'label' => 'Description'
    ],
    'options' => [
        'label' => 'Options'
    ],
    'type' => [
        'label' => 'Type'
    ],
    'editable'=>[
        'label' => 'Editable'
    ],
    'created' => [
        'label' => 'Created',
        'format' => [
            'type' => 'date',
            'text' => 'd/m/Y'
        ]
    ]
]);