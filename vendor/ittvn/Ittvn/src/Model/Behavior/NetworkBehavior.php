<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Ittvn\Model\Behavior;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use ArrayObject;
use Cake\Utility\Inflector;
use Ittvn\Utility\System;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\Routing\Router;

class NetworkBehavior extends Behavior {

    /**
     * Default config
     * @var array
     */
    protected $_defaultConfig = [
        'connection' => 'default',
        'implementedFinders' => [
            'network' => 'findNetwork'
        ]
    ];

    /**
     * Initialize hook
     * @param array $config The config for this behavior.
     * @return void
     */
    public function initialize(array $config) {
        if (isset($config['connection'])) {
            $this->config('connection', $config['connection'], false);
        }
    }

    public function network() {
        $conn = $this->config('connection');
        if (Configure::check('Network')) {
            $conn = Configure::read('Network.db');
        }
        return $conn;
    }

    public function saveNetwork(EntityInterface $entity, $options = array()) {
        $connection = $this->network();
        $this->_table->connection(ConnectionManager::get($connection));
        return $this->_table->save($entity, $options);
    }
	
    public function saveManyNetwork($entities, $options = array()) {
        $connection = $this->network();
        $this->_table->connection(ConnectionManager::get($connection));
        return $this->_table->saveMany($entities, $options);
    }

    public function updateAllNetwork($fields, $conditions) {
        $connection = $this->network();
        $this->_table->connection(ConnectionManager::get($connection));
        return $this->_table->updateAll($fields, $conditions);
    }

    public function deleteNetwork(EntityInterface $entity, $options = array()) {
        $connection = $this->network();
        $this->_table->connection(ConnectionManager::get($connection));
        return $this->_table->delete($entity, $options);
    }

    public function deleteAllNetwork($conditions) {
        $connection = $this->network();
        $this->_table->connection(ConnectionManager::get($connection));
        return $this->_table->deleteAll($conditions);
    }

    public function getNetwork($primaryKey, $options = []) {
        $connection = $this->network();
        $this->_table->connection(ConnectionManager::get($connection));
        return $this->_table->get($primaryKey, $options);
    }

    public function findNetwork(Query $query, array $options) {
        if (isset($options['site']) && !empty($options['site'])) {
            $connection = $options['site'];
        } else {
            $connection = $this->network();
        }
        //$this->_table->connection(ConnectionManager::get($connection));
        return $query->connection(ConnectionManager::get($connection));
    }

}
