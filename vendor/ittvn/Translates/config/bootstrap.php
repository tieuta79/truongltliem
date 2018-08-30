<?php

use Cake\Core\Configure;
use Settings\Utility\Setting;
use Cake\I18n\I18n;
use Cake\Network\Request;

Configure::write('Admin.Tables.Locales.header', [
    'msgid' => [
        'label' => 'Static text',
        'sort' => true,
        'filter' => 'text',
        'default_order'=>'asc'
    ],
    'domain' => [
        'label' => 'Domain',
        'sort' => true,
        'filter' => 'text',
    ]
]);

$setting = new Setting();
$langd = $setting->getOption('Sites.language_default');
$langs = $setting->getOption('Languages.site');
$langa = $setting->getOption('Languages.admin');

if (strpos(Request::createFromGlobals()->here(), 'admin') == false) {
    if(!empty($langs)){
        I18n::locale($langs);
    }else{
        I18n::locale($langd);
    }
}else{
    if(!empty($langs)){
        I18n::locale($langa);
    }else{
        I18n::locale($langd);
    }
}