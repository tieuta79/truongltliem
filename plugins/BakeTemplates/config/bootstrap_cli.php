<?php

// config/bootstrap_cli.php

use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Core\Configure;
use Cake\Console\Shell;
use Cake\Core\Plugin;

EventManager::instance()->on('Base.setActions', function (Event $event) {
    $view = $event->subject();
    if($view['model']=='Users'){
        $view['scaffoldActions'] = array_merge($view['scaffoldActions'],[
            'login',
            'logout'
        ]);
        
        if(!empty($view['prefix']) && $view['prefix']=='Admin'){
            $view['scaffoldActions'] = array_merge($view['scaffoldActions'],[
                'dashboard',
            ]);
        }
        
        $view['noTemplateActions'] = array_merge($view['noTemplateActions'],[
            'logout',
        ]);        
    }
    return $view;
});

EventManager::instance()->on('Bake.initialize', function (Event $event) {
    $view = $event->subject;
    if (!Plugin::loaded('Search')) {
        //$shell = new Shell();
        //pr($shell->args);die();
        //$shell->dispatchShell('BakeTemplates.hello');
        die('Please install plugin Search at here: https://github.com/FriendsOfCake/search');
    }
    //die();
});

EventManager::instance()->on('Bake.beforeRender', function (Event $event) {
    $view = $event->subject;
});

EventManager::instance()->on('Bake.beforeRender', function (Event $event) {

});

EventManager::instance()->on('Bake.afterRender', function (Event $event) {
    //pr($event->subject());die();
});

EventManager::instance()->on('Bake.beforeRender.Controller.controller', function (Event $event) {   

});

EventManager::instance()->on('Bake.afterRender.Controller.controller', function (Event $event) {

});

EventManager::instance()->on('Bake.afterRender.Model.table', function (Event $event) {
    //pr($event->subject()->viewVars);die();
});
