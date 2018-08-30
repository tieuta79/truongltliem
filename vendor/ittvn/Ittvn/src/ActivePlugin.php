<?php

namespace Ittvn;

use Cake\Routing\Router;
use Cake\Network\Request;
use Cake\ORM\TableRegistry;
use Migrations\Migrations;
use Cake\Core\Configure;

class ActivePlugin {

    private $_request = null;

    public function __construct() {
        $request = Router::getRequest();
        if (!$request) {
            $request = Request::createFromGlobals();
        }
        $this->_request = $request;
    }

    public function beforeActive($plugins = []) {

    }

    public function afterActived() {
        $migrations = new Migrations(['connection' => Configure::read('Network.db')]);
        $status = $migrations->status(['plugin' => 'Booking']);
        if (count($status) > 0) {
            $migrate = $migrations->migrate(['plugin' => 'Booking']);
            $seeded = $migrations->seed(['plugin' => 'Booking']);
        }
    }

    public function beforeDisactive($plugins = []) {
        
    }

    public function afterDisactived() {
        
    }

    public function loadModal($alias, $options = []) {
        $modal = TableRegistry::get($alias, $options = []);
        $plugin = pluginSplit($alias);
        $this->{$plugin[1]} = $modal;
    }

}
