<?php
use Settings\Utility\Setting;
$setting = new Setting();

return [
    [
        'name' => 'Sites.title',
        'value' => sprintf(__d('ittvn','%s - New site'),$setting->getOption('Sites.title')),
        'description' => 'Title for site',
        'options' => '',
        'type' => 'text',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Sites.admin_email',
        'value' => $setting->getOption('Sites.admin_email'),
        'description' => 'Email admin for site',
        'options' => '',
        'type' => 'text',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Sites.format_date',
        'value' => 'Y-m-d',
        'description' => 'Format date system (default: Year-Month-Date)',
        'options' => '',
        'type' => 'text',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Sites.format_time',
        'value' => 'H:i:s',
        'description' => 'Format time system (default: Hour:Minute:second)',
        'options' => '',
        'type' => 'text',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Sites.theme_default',
        'value' => 'Templates',
        'description' => 'Theme default for site',
        'options' => '',
        'type' => 'text',
        'editable' => '',
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Sites.theme_admin_default',
        'value' => 'Templates',
        'description' => 'Theme default for admin',
        'options' => '',
        'type' => 'text',
        'editable' => '',
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Sites.plugins',
        'value' => '',
        'description' => '',
        'options' => '',
        'type' => 'textarea',
        'editable' => '',
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Sites.meta_keyword',
        'value' => '',
        'description' => 'Meta keyword for site',
        'options' => '',
        'type' => 'text',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Sites.meta_description',
        'value' => '',
        'description' => 'Meta description for site',
        'options' => '',
        'type' => 'textarea',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Sites.language_default',
        'value' => 'vi',
        'description' => 'Default language for site',
        'options' => $setting->getOption('Sites.language_default'),
        'type' => 'select',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Uploads.type',
        'value' => 'ftp',
        'description' => 'Type for upload localhost or FTP',
        'options' => '[{"key":"ftp","value":"FTP"}]',
        'type' => 'select',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Uploads.path',
        'value' => 'uploads',
        'description' => 'Path default for upload file',
        'options' => '',
        'type' => 'text',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Uploads.ftpHost',
        'value' => '',
        'description' => 'Host for upload ftp',
        'options' => '',
        'type' => 'text',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Uploads.ftpUser',
        'value' => '',
        'description' => 'Username for upload FTP',
        'options' => '',
        'type' => 'text',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Uploads.ftpPass',
        'value' => '',
        'description' => 'Password for upload FTP',
        'options' => '',
        'type' => 'text',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Uploads.ftpPort',
        'value' => 21,
        'description' => 'Port for upload FTP',
        'options' => '',
        'type' => 'text',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Uploads.ftpUrl',
        'value' => '',
        'description' => 'Url for upload FTP',
        'options' => '',
        'type' => 'text',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Images.resize',
        'value' => '0',
        'description' => 'Have resize image for site',
        'options' => '',
        'type' => 'checkbox',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Images.crop',
        'value' => '0',
        'description' => 'Image have crop',
        'options' => '',
        'type' => 'checkbox',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Images.sizes',
        'value' => '150x150',
        'description' => 'Sizes default for resize image',
        'options' => '[{"key":"150x150","value":"Thumbnail (150x150)"},{"key":"300x300","value":"Small (300x300)"},{"key":"600x600","value":"Medium (600x600)"},{"key":"1024x1024","value":"Large (1024x1024)"}]',
        'type' => 'radio',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Users.is_register',
        'value' => '0',
        'description' => 'User can register on sites',
        'options' => '',
        'type' => 'checkbox',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Users.role_default_register',
        'value' => 5,
        'description' => 'Role default when user register on sites',
        'options' => '[{"key":"1","value":"Super Admin"},{"key":"2","value":"Admin"},{"key":"3","value":"Customer"},{"key":"4","value":"Agents"},{"key":"5","value":"Public"}]',
        'type' => 'radio',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Users.fullPermission',
        'value' => 'super-admin',
        'description' => 'User can full permission',
        'options' => '[{"key":"super-admin","value":"Super Admin"},{"key":"admin","value":"Admin"},{"key":"customer","value":"Customer"},{"key":"agents","value":"Agents"},{"key":"public","value":"Public"}]',
        'type' => 'select',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Users.avatar_default',
        'value' => '/img/avatar_default.jpg',
        'description' => 'Avatar defaul for user',
        'options' => '',
        'type' => 'text',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Sites.paging_limit',
        'value' => 10,
        'description' => 'Limit paging',
        'options' => '',
        'type' => 'text',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Themes.site',
        'value' => 'EShopper',
        'description' => 'Theme for site',
        'options' => '',
        'type' => 'text',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Themes.admin',
        'value' => 'Templates',
        'description' => 'Theme for admin',
        'options' => '',
        'type' => 'text',
        'editable' => 1,
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ],
    [
        'name' => 'Themes.options',
        'value' => '',
        'description' => 'Theme options for template site',
        'options' => '',
        'type' => '',
        'editable' => '',
        'order' => 0,
        'autoload' => 1,
        'delete' => 0
    ]
];
