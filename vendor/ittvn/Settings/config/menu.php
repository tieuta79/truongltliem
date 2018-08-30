<?php

use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

$settings = TableRegistry::get('Settings.Settings')->find('list', ['keyField' => 'name', 'valueField' => 'name'])
        ->find('network')
        ->where(['editable' => 1, 'global' => 0, 'delete' => 0]);

$setting_menus = [];
if ($settings->count() > 0) {
    $arrs = Hash::expand($settings->toArray());
    $settings = array_keys($arrs);
    
    foreach ($settings as $setting) {
        $setting_menus[$setting] = [
            'icon' => 'fa fa-circle-o',
            'title' => $setting,
            'url' => [
                'plugin' => 'Settings',
                'controller' => 'Settings',
                'action' => 'general',
                'prefix' => 'admin',
                $setting
            ],
        ];
    }
}

/*$setting_menus = Hash::merge($setting_menus,[
            'RedirectUrl' => [
                'icon' => 'fa fa-circle-o',
                'title' => 'Redirect Url',
                'url' => '#',
            ]
                ]);*/
return [
    'Menus' => [
        'Admin' => [
            // Menu Settings
            'Settings' => [
                'icon' => 'fa fa-cogs',
                'title' => 'Settings',
                'url' => '#',
                'child' => $setting_menus,
                'priority' => 40
            ],
        ]
    ]
];
