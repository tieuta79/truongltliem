<?php

namespace Menus\Event;

use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\View\View;
use Settings\Utility\Setting;

class MenusEventHandler implements EventListenerInterface {

    public function implementedEvents() {
        return [
            'Menus.Admin.addItem' => ['callable' => 'addItem', 'priority' => 1],
        ];
    }

    public function addItem(Event $event) {
        $item = $event->subject()['item'];
        $setting = new Setting();
        $view = new View();
        $return = $view->element($setting->getOption('Themes.admin') . '.list_menu_admin', ['menu' => $item]);        
        return $return;
    }

}
