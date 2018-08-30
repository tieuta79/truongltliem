<?php

namespace Ittvn\Utility;

use InvalidArgumentException;
use RuntimeException;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Migrations\Migrations;
use Cake\Core\Plugin;
use Ittvn\Utility\System;

class Network {

    public static function checkScopeByUrl($url, $scopes = []) {
        $return = false;
        if (Configure::check('Network') && Configure::read('Network.type') == 1) {
            if (empty($scopes)) {
                $scopes = Configure::read('Sites.domains');
            }

            if (count($scopes) > 0) {
                foreach ($scopes as $scope) {
                    if (strpos(' '.$url, '/'.$scope) == 1) {
                        $return = '/'.$scope;
                    }
                }
            }
        }
        return $return;
    }

}
