<?php

use Ittvn\Utility\System;
use Cake\Core\Configure;
use Settings\Utility\Setting;

$settings = new Setting();
$system = new System();
$cfupload = [ 'path_upload' => 'uploads' ,'url_upload' => ''];
if($settings->getOption('Uploads.type') == 'ftp'){
    $cfupload['url_upload'] = $settings->getOption('Uploads.ftpUrl');
}
$system->setVarJs($cfupload);
$system->addModule('Medias.Slideshow::show', 'Display slideshow', []);

Configure::write('Slideshow.Type', [
    0 => __d('ittvn', 'Galleries'),
    1 => __d('ittvn', 'Categories'),
    2 => __d('ittvn', 'Posts'),
    3 => __d('ittvn', 'Images'),
]);
Configure::write('Slideshow.flag', false);

Configure::write('Slideshow.skin', [
    'defaultskin' => __d('ittvn', 'Default skin'),
    'borderlessdark' => __d('ittvn', 'Border less dark'),
    'borderlessdark3d' => __d('ittvn', 'Border less dark 3d'),
    'borderlesslight' => __d('ittvn', 'Border less light'),
    'borderlesslight3d' => __d('ittvn', 'Border less light 3d'),
    'carousel' => __d('ittvn', 'Carousel'),
    'darkskin' => __d('ittvn', 'Dark skin'),
    'fullwidth' => __d('ittvn', 'Full width'),
    'fullwidthdark' => __d('ittvn', 'Full width dark'),
    'glass' => __d('ittvn', 'Glass'),
    'lightskin' => __d('ittvn', 'Lightskin'),
    'minimal' => __d('ittvn', 'Minimal'),
    'v5' => __d('ittvn', 'V5'),
    'noskin' => __d('ittvn', 'No skin'),
]);

Configure::write('Slideshow.easing', [
    'swing' => __d('ittvn', 'Swing'),
    'easeInQuad' => __d('ittvn', 'Ease In Quad'),
    'easeOutQuad' => __d('ittvn', 'Ease Out Quad'),
    'easeInOutQuad' => __d('ittvn', 'Ease In Out Quad'),
    'easeInCubic' => __d('ittvn', 'Ease In Cubic'),
    'easeOutCubic' => __d('ittvn', 'Ease Out Cubic'),
    'easeInOutCubic' => __d('ittvn', 'Ease In Out Cubic'),
    'easeInQuart' => __d('ittvn', 'Ease In Quart'),
    'easeOutQuart' => __d('ittvn', 'Ease Out Quart'),
    'easeInOutQuart' => __d('ittvn', 'Ease In Out Quart'),
    'easeInQuint' => __d('ittvn', 'Ease In Quint'),
    'easeOutQuint' => __d('ittvn', 'Ease Out Quint'),
    'easeInOutQuint' => __d('ittvn', 'Ease In Out Quint'),
    'easeInSine' => __d('ittvn', 'Ease In Sine'),
    'easeOutSine' => __d('ittvn', 'Ease Out Sine'),
    'easeInOutSine' => __d('ittvn', 'Ease In Out Sine'),
    'easeInExpo' => __d('ittvn', 'Ease In Expo'),
    'easeOutExpo' => __d('ittvn', 'Ease Out Expo'),
    'easeInOutExpo' => __d('ittvn', 'Ease In Out Expo'),
    'easeInCirc' => __d('ittvn', 'Ease In Circ'),
    'easeOutCirc' => __d('ittvn', 'Ease Out Circ'),
    'easeInOutCirc' => __d('ittvn', 'Ease In Out Circ'),
    'easeInElastic' => __d('ittvn', 'Ease In Elastic'),
    'easeOutElastic' => __d('ittvn', 'Ease Out Elastic'),
    'easeInOutElastic' => __d('ittvn', 'Ease In Out Elastic'),
    'easeInBack' => __d('ittvn', 'Ease In Back'),
    'easeOutBack' => __d('ittvn', 'Ease Out Back'),
    'easeInOutBack' => __d('ittvn', 'Ease In Out Back'),
    'easeInBounce' => __d('ittvn', 'Ease In Bounce'),
    'easeOutBounce' => __d('ittvn', 'Ease Out Bounce'),
    'easeInOutBounce' => __d('ittvn', 'Ease In Out Bounce')
]);

Configure::write('Admin.Tables.Slideshow.header', [
    'name' => [
        'label' => 'Name',
        'sort' => true,
        'filter' => 'text',
    ],
    'slug' => [
        'label' => 'Slug',
        'sort' => true,
        'filter' => 'text',
    ],
    'type' => [
        'label' => 'Type',
        'sort' => false,
        'filter' => 'text',
    ],
    'created' => [
        'label' => 'Created',
        'sort' => true,
        'filter' => 'date',
    ]
]);

Configure::write('Admin.Forms.Slideshow', [
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
            'type' => [
                'label' => 'Type',
                'type' => 'select',
                'options' => Configure::read('Slideshow.Type')
            ],
            'gallery_id' => [
                'label' => 'Gallery',
                'type' => 'select',
                'options' => 'galleries',
                'id' => 'input-galleries'
            ],
            'category_id' => [
                'label' => 'Category',
                'type' => 'select',
                'options' => 'categories',
                'id' => 'input-categories'
            ],
            'content' => [
                'label' => 'Content',
                'type' => 'select',
                'options' => 'contents',
                'multiple' => true,
                'id' => 'input-contents'
            ],
        ],
        'settings' => [
            'label' => 'Settings'
        ]
    ],
    'sidebar' => [
        'action' => [
            'label' => 'Action',
            'status' => [
                'type' => 'checkbox',
                'checked' => true
            ],
        ],
        'layout' => [
            'label' => 'Layout',
            'skin' => [
                'type' => 'select',
                'name' => 'config[layout][skin]',
                'label' => __d('ittvn', 'Skin'),
                'options' => Configure::read('Slideshow.skin'),
                'style' => 'width: 90%',
                'default' => 'defaultskin',
                'templates' => [
                    'inputContainer' => '<div class="form-group smart-form {{required}}" style="padding-bottom: 10px;">{{content}}</div>'
                ]
            ],
            'responsive' => [
                'type' => 'radio',
                'multiple' => true,
                'name' => 'config[layout][responsive]',
                'label' => false,
                'options' => [
                    1 => __d('ittvn', 'Responsive'),
                    2 => __d('ittvn', 'Custom'),
                ],
                'default' => 1
            ],
            'width' => [
                'type' => 'text',
                'label' => 'Slider Width',
                'name' => 'config[layout][width]',
                'default' => 1280
            ],
            'height' => [
                'type' => 'text',
                'label' => 'Slider Height',
                'name' => 'config[layout][height]',
                'default' => 500
            ]
        ]
    ]
]);

