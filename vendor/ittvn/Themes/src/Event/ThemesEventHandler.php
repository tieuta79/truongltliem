<?php

namespace Themes\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Settings\Utility\Setting;
use Cake\Core\Plugin;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class ThemesEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            'Admin.Menus.beforeRender' => ['callable' => 'beforeRenderMenus', 'priority' => 2],
        ];
    }

    public function beforeRenderMenus(Event $event) {
        $menus = $event->subject()['menus'];
        $options = $event->subject()['options'];
        $request = Router::getRequest();

        if (!empty($event->result)) {
            $menus = $event->result['menus'];
        }

        if (!empty($request->prefix)) {
            $showOptionMenu = false;
            $setting = new Setting();
            $template_path = Plugin::path($setting->getOption('Themes.site'));
            $dir = new Folder($template_path);
            $json_p = $dir->findRecursive('template.json');
            if (count($json_p) > 0) {
                $file_infor = new File($json_p[0]);
                $option_theme = json_decode($file_infor->read());
                if (isset($option_theme->site) && isset($option_theme->site->options) && !empty($option_theme->site->options)) {
                    $showOptionMenu = true;
                }
            }

            //show menu Theme Option
            if ($showOptionMenu == true) {
                $menus['Themes']['child']['Options'] = [
                    'icon' => 'fa fa-circle-o',
                    'title' => 'Options',
                    'url' => [
                        'plugin' => 'Themes',
                        'controller' => 'Themes',
                        'action' => 'options',
                        'prefix' => 'admin'
                    ],
                    'priority' => 100
                ];
            }
        }

        return ['menus' => $menus, 'options' => $options];
    }

}
