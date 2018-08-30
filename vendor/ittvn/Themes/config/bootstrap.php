<?php

use Settings\Utility\Setting;
use Cake\Core\Plugin;
use Cake\Core\Configure;
use Cake\Network\Request;

$setting = new Setting();
$theme = $setting->getOption('Themes.site');

if (!Plugin::loaded($theme)) {
    Plugin::load($theme, ['bootstrap' => false, 'routes' => false]);
}
$plugin_path = Plugin::path($theme);
//config blocks for theme
if (file_exists($plugin_path . 'config' . DS . 'blocks.php')) {
    Configure::load($theme . '.blocks', 'default');
}

if (strpos(Request::createFromGlobals()->here(), 'admin') == false) {
//config theme_options for theme
    if (file_exists($plugin_path . 'config' . DS . 'theme_options.php')) {
        Configure::load($theme . '.theme_options', 'default');

        $themeOptions = $setting->getOption('Themes.options');
        if (!empty($themeOptions)) {
            $themeOptions = json_decode($themeOptions, true);
            if (isset($themeOptions[$theme])) {
                Configure::write('Js', $themeOptions[$theme]);
            }
        }
    }
}