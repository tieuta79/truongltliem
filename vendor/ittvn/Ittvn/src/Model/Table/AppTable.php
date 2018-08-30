<?php

namespace Ittvn\Model\Table;

use Cake\ORM\Table;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Core\App;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Datasource\ConnectionInterface;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Query;
use ArrayObject;
use Cake\Network\Request;
use Ittvn\Utility\Network;
use Cake\ORM\TableRegistry;

class AppTable extends Table {

    private $domains = [];

    public function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Ittvn.Network');
    }

}
