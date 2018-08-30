<?php

namespace Ittvn\Event;

use Cake\Core\Configure;
use Cake\Event\EventManager;
use Cake\Event\Event;
use Cake\Core\Plugin;
use Cake\Core\App;

class IttvnEvent {

    public function __construct() {
        
    }

    public function eventListener() {
        $eventHandlers = Configure::read('EventHandlers');
        if (count($eventHandlers) > 0) {
            $eventManager = new EventManager();
            foreach ($eventHandlers as $eventHandler) {
                $plugins = explode('\\', $eventHandler);
                $path_file_event = App::path('Event', $plugins[0])[0] . $plugins[count($plugins) - 1] . '.php';
                if (class_exists($eventHandler)) {
                    $eventManager->instance()->on(new $eventHandler());
                } else {
                    if (file_exists($path_file_event)) {
                        require_once($path_file_event);
                        if (class_exists($eventHandler)) {
                            $eventManager->instance()->on(new $eventHandler());
                        }                        
                    }
                }
            }
            //pr($eventManager);die();
        }
    }

}
