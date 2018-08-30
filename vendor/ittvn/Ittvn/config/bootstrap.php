<?php

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Controller\ComponentRegistry;
use Cake\Event;
use Ittvn\Utility\System;
use Settings\Utility\Setting;
use Cake\Network\Request;
use Ittvn\Error\IttvnError;

$errorHandler = new IttvnError();
$errorHandler->register();

if (strpos(Request::createFromGlobals()->here(), 'admin')) {

    $plugins = Plugin::loaded();
    foreach ($plugins as $plugin) {
        if (Plugin::loaded($plugin)) {
            $plugin_path = Plugin::path($plugin);
            //config events for plugin
            if (file_exists($plugin_path . 'config' . DS . 'events.php')) {
                Configure::load($plugin . '.events', 'default');
            }
            //config menus for plugin
            if (file_exists($plugin_path . 'config' . DS . 'menu.php')) {
                Configure::load($plugin . '.menu', 'default');
            }

            //config dashboard for plugin
            if (file_exists($plugin_path . 'config' . DS . 'dashboard.php')) {
                Configure::load($plugin . '.dashboard', 'default');
            }
        }
    }

    $system = new System();
    $system->setVarJs([
        'paging_limit' => (new Setting())->getOption('Sites.paging_limit')
    ]);

    $system->addModule('Ittvn.Modules::html', 'Display Html', []);
    $system->addModule('Ittvn.Modules::search', 'Search box', []);
    $system->addModule('Ittvn.Modules::counter', 'Counter visit', []);    
    $system->addModule('Menus.Menus::display', 'Display menu', []); 

    Configure::write('Settings.ModelsContentTypes', [
        'Contents' => 'Contents'
    ]);

    Configure::write('Settings.ModelsExtraFields', [
        'Users.Roles' => 'Users',
        'Metas.MetaTypes' => 'Content Types',
        'Metas.MetaCategories' => 'Taxonomies'
    ]);

    Configure::write('Settings.Users.avatar_default', '/img/avatar_default.jpg');
    Configure::write('Settings.Templates.action', [
        '' => __d('ittvn', 'Action'),
        'trash' => __d('ittvn', 'Trash')
    ]);
//Configure::write('Settings.Paging.limit', [
//    10 => 10,
//    25 => 25,
//    50 => 50,
//    100 => 100
//]);

    (new Ittvn\Event\IttvnEvent())->eventListener();
}