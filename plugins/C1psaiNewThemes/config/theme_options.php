<?php

return [
    'Theme' => [
        'options' => [
            'default' => [
                'label' => __d('ittvn', 'Default'),
                'options' => [
                    'logo' => [
                        'label' => __d('ittvn', 'Logo'),
                        'type' => 'select_file',
                        'data-type' => 'image'
                    ],
                    'hotline' => [
                        'label' => __d('ittvn', 'Hotline'),
                        'type' => 'text'
                    ],                    
                    'curator' => [
                        'label' => __d('ittvn', 'Curator'),
                        'type' => 'text'
                    ],
                    'email' => [
                        'label' => __d('ittvn', 'Email'),
                        'type' => 'text'
                    ],
                    'copyright' => [
                        'label' => __d('ittvn', 'Copy Right'),
                        'type' => 'text'
                    ],
                    'img_default' => [
                        'label' => __d('ittvn', 'Image Default'),
                        'type' => 'select_file',
                        'data-type' => 'image'
                    ],
                    'bg_body' => [
                        'label' => __d('ittvn', 'Background Body Color'),
                        'type' => 'text'
                    ],
                    'bg_card_title' => [
                        'label' => __d('ittvn', 'Background Card Title'),
                        'type' => 'text'
                    ],
                    'color_title' => [
                        'label' => __d('ittvn', 'Color Title'),
                        'type' => 'text'
                    ],
                    'color_title_hover' => [
                        'label' => __d('ittvn', 'Color Title Hover'),
                        'type' => 'text'
                    ],
                    'color_link' => [
                        'label' => __d('ittvn', 'Color Link'),
                        'type' => 'text'
                    ],
                    'color_link_hover' => [
                        'label' => __d('ittvn', 'Color Link hover'),
                        'type' => 'text'
                    ],
                    
                ]
            ],
        ]
    ]
];
