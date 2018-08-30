<?php

namespace Ittvn\Utility;

use InvalidArgumentException;
use RuntimeException;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Plugin;
use Cake\Core\App;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\View\View;
use Cake\ORM\TableRegistry;
use Settings\Utility\Setting;


class Help {
    static function show(){
        $request = Router::getRequest();
        $url = $request->here;
        $pattern = "/(\d+)/";
        $array = preg_split($pattern, $url, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        if(isset($array[1])){
            $array[1] = '%';
            $url = implode('', $array);
        }
        $helps = TableRegistry::get('Extensions.Helps');
        
        $help = $helps->find()->where(['link LIKE' => $url]);
        if($help->count() > 0){
            return $help->first()->content;
        }
        return false;
    }
}