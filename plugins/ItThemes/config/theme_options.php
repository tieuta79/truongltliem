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
					]
				]
			],
        ]
    ]
];
