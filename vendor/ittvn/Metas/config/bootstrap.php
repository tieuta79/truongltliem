<?php

use Cake\Core\Configure;
//config for metas index, form, view
Configure::write('Admin.Tables.Metas.header', [
    'name' => [
        'label' => __d('ittvn', 'name'),
        'sort' => true,
        'filter' => 'text'
    ],
    'value' => [
        'label' => __d('ittvn', 'Default Value'),
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
    'model' => [
        'label' => __d('ittvn', 'Plugin'),
        'sort' => true,
        'filter' => 'text'
    ],
//    'translate' => [
//        'label' => __d('ittvn', 'Translate'),
//        'sort' => true,
//        'filter' => 'text',
//    ]
]);

Configure::write('Admin.Forms.Metas', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name' => [
                'type' => 'text'
            ],
            'value' => [
                'label' => 'Default value',
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
                    'radio' => 'Radio',
                    'number' => 'Number',
                    'select_image' => 'Image',
                    'select_images' => 'Multiple Image',
                ]
            ],
            'options' => [
                'id' => 'meta_options',
                'type' => 'textarea',
                'style'=>'display:none',
                'templates'=>[
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
                'hiddenField'=>false
            ]
        ],
        'model' => [
            'label' => 'Plugins',
            'model' => [
                'label' => false,
                'type' => 'radio',
                'multiple' => false,
                'options' => 'models',
                'templates'=>[
                    'inputContainer' => '<div class="form-group smart-form model_load_ajax {{type}}{{required}}">{{content}}</div>'
                ]
            ]
        ],
        'foreign_key' => [
            'label' => 'Plugin Types',
            'foreign_key' => [
                'label' => false,
                'type' => 'radio',
                'multiple' => false,
                'options' => [],
                'templates'=>[
                    'inputContainer' => '<div class="form-group smart-form model_get_load_ajax {{type}}{{required}}">{{content}}</div>'
                ]                
            ]
        ]
    ]
]);

Configure::write('Admin.Views.Metas', [
    'model' => [
        'label' => 'Plugin'
    ],    
    'name' => [
        'label' => 'Key'
    ],
    'value' => [
        'label' => 'Default value'
    ],
    'type' => [
        'label' => 'Type'
    ],
    'options' => [
        'label' => 'Options'
    ],
    'status' => [
        'label' => 'Status'
    ],    
    'created' => [
        'label' => 'Created',
        'format' => [
            'type' => 'date',
            'text' => 'd/m/Y'
        ]
    ]
]);

//config for meta_types index, form, view
Configure::write('Admin.Tables.MetaTypes.header', [
    'icon' => [
        'label' => __d('ittvn', 'icon'),
        'sort' => false
    ],        
    'name' => [
        'label' => __d('ittvn', 'Name'),
        'sort' => true,
        'filter' => 'text'
    ],
    'slug' => [
        'label' => __d('ittvn', 'Slug'),
        'sort' => true,
        'filter' => 'text'
    ],
    'description' => [
        'label' => __d('ittvn', 'Description'),
        'sort' => true,
        'filter' => 'text'
    ],
    'category' => [
        'label' => __d('ittvn', 'Is category'),
        'sort' => true
    ],    
    'multi_category' => [
        'label' => __d('ittvn', 'Select Multiple category'),
        'sort' => true
    ],
    'menu' => [
        'label' => __d('ittvn', 'Show menu'),
        'sort' => true
    ],    
    'model' => [
        'label' => __d('ittvn', 'Model'),
        'sort' => true,
        'filter' => 'list'
    ]
]);

Configure::write('Admin.Forms.MetaTypes', [
    'main' => [
        'default' => [
            'label' => 'Default',
            'name' => [
                'type' => 'text'
            ],
            'slug' => [
                'type' => 'text'
            ],
            'icon' => [
                'type' => 'select',
                'options'=>[
                    'fa fa-edit'=>'fa-edit',
                    'fa fa-book'=>'fa-book',
                    'fa fa-shopping-cart'=>'fa-shopping-cart',
                    'fa fa-building' => 'fa-building',
                    'fa fa-files-o' => 'fa-files-o',
                    'fa fa-link' => 'fa-link',
                ]
            ],
            'description' => [
                'type' => 'textarea'                
            ]
        ],
        'options'=>[
            'label'=>'Options',
            'options.hideFeatured'=>[
                'label'=>'Hide Featured',
                'type'=>'checkbox',
                'default'=>false,
                'hiddenField'=>false
            ],            
            'options.hideExcerpt'=>[
                'label'=>'Hide Excerpt',
                'type'=>'checkbox',
                'default'=>false,
                'hiddenField'=>false
            ],
            'options.hideDescription'=>[
                'label'=>'Hide Description',
                'type'=>'checkbox',
                'default'=>false,
                'hiddenField'=>false
            ],          
            'options.hideFeatureImage'=>[
                'label'=>'Hide Feature Image',
                'type'=>'checkbox',
                'default'=>false,
                'hiddenField'=>false
            ],              
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
            'category' => [
                'label'=>'Is category',
                'type' => 'checkbox',
                'hiddenField'=>false,
                'preview' => [
                    'type' => 'status',
                    'text' => '<span class="preview">{{status}}</span>'
                ]
            ],
            'multi_category' => [
                'label'=>'Select Multiple category',
                'type' => 'checkbox',
                'hiddenField'=>false,
                'preview' => [
                    'type' => 'status',
                    'text' => '<span class="preview">{{status}}</span>'
                ]
            ],            
            'menu' => [
                'label'=>'Show menu',
                'type' => 'checkbox',
                'hiddenField'=>false,
                'preview' => [
                    'type' => 'status',
                    'text' => '<span class="preview">{{status}}</span>'
                ]
            ]
        ],
        'model' => [
            'label' => 'Plugins',
            'model' => [
                'label' => false,
                'type' => 'radio',
                'multiple' => false,
                'options' => 'models'
            ]
        ]
    ]
]);

Configure::write('Admin.Views.MetaTypes', [
    'name' => [
        'label' => 'Name'
    ],    
    'slug' => [
        'label' => 'Slug'
    ],
    'description' => [
        'label' => 'Description'
    ],
    'model' => [
        'label' => 'Plugin'
    ],
    'category' => [
        'label' => 'Is category'
    ],
    'multi_category'=>[
        'label'=>'Select Multiple category'
    ],
    'menu' => [
        'label' => 'Show on menu'
    ],
    'created' => [
        'label' => 'Created',
        'format' => [
            'type' => 'date',
            'text' => 'd/m/Y'
        ]
    ]
]);

//config for meta_categories index, form, view
Configure::write('Admin.Tables.MetaCategories.header', [      
    'name' => [
        'label' => __d('ittvn', 'Name'),
        'sort' => true,
        'filter' => 'text'
    ],
    'slug' => [
        'label' => __d('ittvn', 'Slug'),
        'sort' => true,
        'filter' => 'text'
    ],
    'description' => [
        'label' => __d('ittvn', 'Description'),
        'sort' => true,
        'filter' => 'text'
    ],
    'meta_type_id' => [
        'label' => __d('ittvn', 'Meta Type'),
        'sort' => true,
        'filter' => 'list'
    ],    
    'created' => [
        'label' => __d('ittvn', 'Created'),
        'sort' => true
    ]
]);

Configure::write('Admin.Forms.MetaCategories', [
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
                'data-type' => 'datetime',
                'input-group' => true,
                'addon' => [
                    'before' => '<i class="fa fa-calendar"></i>'
                ]
            ]
        ],
        'meta_type' => [
            'label' => 'Content Type',
            'meta_type_id' => [
                'label' => false,
                'type' => 'radio',
                'multiple' => true,
                'options' => 'metaTypes'
            ]
        ]
    ]
]);

Configure::write('Admin.Views.MetaCategories', [
    'name' => [
        'label' => 'Name'
    ],    
    'slug' => [
        'label' => 'Slug'
    ],
    'description' => [
        'label' => 'Description'
    ],
    'meta_type_id' => [
        'label' => 'Content Type'
    ],
    'created' => [
        'label' => 'Created',
        'format' => [
            'type' => 'date',
            'text' => 'd/m/Y'
        ]
    ]
]);