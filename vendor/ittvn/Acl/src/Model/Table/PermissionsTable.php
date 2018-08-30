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
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Acl\Model\Table;

use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Acl\Model\Entity\Permission;
use Cake\Routing\Router;
use Ittvn\Utility\System;
use Cake\Datasource\ConnectionManager;
/**
 * Permissions linking AROs with ACOs
 *
 */
class PermissionsTable extends AclNodesTable {

    /**
     * {@inheritDoc}
     *
     * @param array $config Configuration
     * @return void
     */
    public function initialize(array $config) {
        $this->alias('Permissions');
        $this->table('aros_acos');

        $this->addBehavior('Ittvn.Network');
        
        $this->belongsTo('Aros', [
            'className' => App::className('Acl.ArosTable', 'Model/Table'),
        ]);
        $this->belongsTo('Acos', [
            'className' => App::className('Acl.AcosTable', 'Model/Table'),
        ]);
        $this->Aro = $this->Aros->target();
        $this->Aco = $this->Acos->target();
    }

    /**
     * Checks if the given $aro has access to action $action in $aco
     *
     * @param string $aro ARO The requesting object identifier.
     * @param string $aco ACO The controlled object identifier.
     * @param string $action Action (defaults to *)
     * @return bool Success (true if ARO has access to action in ACO, false otherwise)
     */
    public function check($aro, $aco, $action = '*') {
        //pr($aco); die();
        if (!$aro || !$aco) {
            return false;
        }

        $permKeys = $this->getAcoKeys($this->schema()->columns());
        $params = null;
        unset($permKeys[4]);
        $systems = new System();
        if (strpos('/' . $aco, 'controllers') == true) {
            $results = $systems->acoscover($aco, 5);
            $aco = $results['url'];
            $params = $results['params'];
        } else {
            $results = $systems->acoscover($aco, 4, 'check');
            $aco = $results['url'];
            $params = $results['params'];
        }

        $aroPath = $this->Aro->node($aro);
        $acoPath = $this->Aco->node($aco);

        if (!$aroPath) {
            return false;
        }

        if (!$acoPath) {
            return false;
        }

        if ($action !== '*' && !in_array('_' . $action, $permKeys)) {
            return false;
        }

        $inherited = [];
        $acoIDs = $acoPath->extract('id')->toArray();
        $count = $aroPath->count();
        $aroPaths = $aroPath->toArray();

        if (Configure::check('Site.buildPermission')) {
            $connection = ConnectionManager::get(Configure::read('Site.buildPermission'));
        } else {
            $connection = ConnectionManager::get(Configure::read('Network.db'));
        }        
        
        for ($i = 0; $i < $count; $i++) {
            $permAlias = $this->alias();                       

            $perms = $this->find('all', [
                'conditions' => [
                    "{$permAlias}.aro_id" => $aroPaths[$i]->id,
                    "{$permAlias}.aco_id IN" => $acoIDs
                ],
                'order' => [$this->Aco->alias() . '.lft' => 'desc'],
                'contain' => $this->Aco->alias(),
            ])->connection($connection);

            if (!empty($params)) {
                $perms->andWhere(["{$permAlias}.params" => $params]);
            }

            if ($perms->count() == 0) {
                continue;
            }

            $perms = $perms->hydrate(false)->toArray();

            foreach ($perms as $perm) {
                if ($perm['params'] != $params) {
                    return false;
                } else {
                    if ($action === '*') {
                        foreach ($permKeys as $key) {
                            if (!empty($perm)) {
                                if ($perm[$key] == -1) {
                                    return false;
                                } elseif ($perm[$key] == 1) {
                                    $inherited[$key] = 1;
                                }
                            }
                        }

                        if (count($inherited) === count($permKeys)) {
                            return true;
                        }
                    } else {

                        switch ($perm['_' . $action]) {
                            case -1:
                                return false;
                            case 0:
                                continue;
                            case 1:
                                return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * Allow $aro to have access to action $actions in $aco
     *
     * @param string $aro ARO The requesting object identifier.
     * @param string $aco ACO The controlled object identifier.
     * @param string $actions Action (defaults to *) Invalid permissions will result in an exception
     * @param int $value Value to indicate access type (1 to give access, -1 to deny, 0 to inherit)
     * @return bool Success
     * @throws \Cake\Core\Exception\Exception on Invalid permission key.
     */
    public function allow($aro, $aco, $actions = '*', $value = 1) {
        $systems = new System();

        $perms = $this->getAclLink($aro, $aco);

        $permKeys = $this->getAcoKeys($this->schema()->columns());
        if (strpos('/' . $aco, 'controllers') == true) {
            $results = $systems->acoscover($aco, 5);
            $aco = $results['url'];
        } else {
            $results = $systems->acoscover($aco, 4);
            $aco = $results['url'];
        }
        $alias = $this->alias();
        $save = [];

        if (!$perms) {
            trigger_error(__d('cake_dev', '{0} - Invalid node', ['DbAcl::allow()']), E_USER_WARNING);
            return false;
        }
        if (isset($perms[0])) {
            $save = $perms[0][$alias];
        }

        if ($actions === '*') {
            $save = array_combine($permKeys, array_pad([], count($permKeys), $value));
        } else {
            if (!is_array($actions)) {
                $actions = ['_' . $actions];
            }
            foreach ($actions as $action) {
                if ($action{0} !== '_') {
                    $action = '_' . $action;
                }
                if (!in_array($action, $permKeys, true)) {
                    throw new Exception(__d('cake_dev', 'Invalid permission key "{0}"', [$action]));
                }
                $save[$action] = $value;
            }
        }
        list($save['aro_id'], $save['aco_id']) = [$perms['aro'], $perms['aco']];

        if ($perms['link'] && !empty($perms['link'][$alias])) {
            $save['id'] = $perms['link'][$alias][0]['id'];
            $save['params'] = $perms['link'][$alias][0]['params'];
        } else {
            unset($save['id']);
            $this->id = null;
            $save['params'] = $results['params'];
        }

        if (Configure::check('Site.buildPermission')) {
            $connection = ConnectionManager::get(Configure::read('Site.buildPermission'));
        } else {
            $connection = ConnectionManager::get(Configure::read('Network.db'));
        }        
        
        $this->connection($connection);
        
        $entityClass = $this->entityClass();
        $entity = new $entityClass($save);

        return ($this->save($entity) !== false);
    }

    /**
     * Get an array of access-control links between the given Aro and Aco
     *
     * @param string $aro ARO The requesting object identifier.
     * @param string $aco ACO The controlled object identifier.
     * @return array Indexed array with: 'aro', 'aco' and 'link'
     */
    public function getAclLink($aro, $aco) {
        $systems = new System();
        if (strpos('/' . $aco, 'controllers') == true) {
            $results = $systems->acoscover($aco, 5);
        } else {
            $results = $systems->acoscover($aco, 4);
        }
        $aco = $results['url'];
        $params = $results['params'];

        $obj = [];
        $obj['Aro'] = $this->Aro->node($aro);
        $obj['Aco'] = $this->Aco->node($aco);

        if (empty($obj['Aro']) || empty($obj['Aco'])) {
            return false;
        }

        $aro = $obj['Aro']->extract('id')->toArray();
        $aco = $obj['Aco']->extract('id')->toArray();

        if (Configure::check('Site.buildPermission')) {
            $connection = ConnectionManager::get(Configure::read('Site.buildPermission'));
        } else {
            $connection = ConnectionManager::get(Configure::read('Network.db'));
        }
        
        $aro = current($aro);
        $aco = current($aco);
        $alias = $this->alias();
        $acl = $this->find('all', [
            'conditions' => [
                $alias . '.aro_id' => $aro,
                $alias . '.aco_id' => $aco,
            ]
        ])->connection($connection);
        if (!empty($params)) {
            $acl->andWhere([$alias . '.params' => $params]);
        }
        $acl = $acl->hydrate(false)->toArray();

        $result = [
            'aro' => $aro,
            'aco' => $aco,
            'link' => [
                $alias => $acl
            ],
        ];

        return $result;
    }

    /**
     * Get the crud type keys
     *
     * @param array $keys Permission schema
     * @return array permission keys
     */
    public function getAcoKeys($keys) {
        $newKeys = [];
        foreach ($keys as $key) {
            if (!in_array($key, ['id', 'aro_id', 'aco_id'])) {
                $newKeys[] = $key;
            }
        }
        return $newKeys;
    }

}
