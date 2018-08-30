<?php

return [
    'Theme' => [
        'options' => [
			'default' => [
				'label' => 'Default',
				'options' => [
					'logo' => [
						'type' => 'select_image',
						'class' => 'form-control',
						'label' => 'Logo'
					],
					'favicon' => [
						'type' => 'select_image',
						'class' => 'form-control',
						'label' => 'Favicon icon'
					],
					'choose-banner' => [
						'type' => 'radio',
						'class' => 'form-control',
						'label' => 'Loại hình ảnh banner',
						'options'=>[
							0 => 'Hình ảnh',
							1 => 'Slideshow'
						],
						'default' => 0
						
					],			
					'img-banner' => [
						'type' => 'select_image',
						'class' => 'form-control',
						'label' => 'Hình ảnh banner'
					],
					
					'text_banner' => [
						'type' => 'textarea',
						'data-type' => 'editor',
						'class' => 'form-control',
						'label' => 'Text Banner'
					],
					'text_footer' => [
						'type' => 'textarea',
						'data-type' => 'editor',
						'class' => 'form-control',
						'label' => 'Footer'
					],
				]
			],
			'developer' => [
				'label' => 'Developer',
				'options' => [
					'css' => [
						'label' => __d('ittvn', 'Custom Css'),
						'type' => 'textarea',
						'class' => 'form-control',
						'data-type' => 'code',
						'mode' => 'css'				
					],
					'js' => [
						'label' => __d('ittvn', 'Custom Js'),
						'type' => 'textarea',
						'class' => 'form-control',
						'data-type' => 'code',
						'mode' => 'js'				
					]
				]
			]
        ]
    ]
];
