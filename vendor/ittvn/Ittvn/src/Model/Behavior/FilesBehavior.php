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
use Cake\Event\EventManager;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use ArrayObject;
use Ittvn\Utility\Upload;
use Cake\Routing\Router;

class FilesBehavior extends Behavior {

    /**
     * Default config
     * @var array
     */
    protected $_defaultConfig = [
        'fields' => []
    ];

    /**
     * Initialize hook
     *
     * If events are specified - do *not* merge them with existing events,
     * overwrite the events to listen on
     *
     * @param array $config The config for this behavior.
     * @return void
     */
    public function initialize(array $config) {
        if (isset($config['fields'])) {
            $this->config('fields', $config['fields'], false);
        }
    }

    /**
     * implementedEvents
     *
     * The implemented events of this behavior depend on configuration
     *
     * @return array
     */
    public function implementedEvents() {
        return [
            'Model.beforeMarshal' => 'beforeMarshal',
            'Model.beforeDelete' => 'beforeDelete'
        ];
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options) {
        $fields = $this->_config['fields'];        
        if (count($fields) > 0) {
            $upload = new Upload();
            $request = Router::getRequest();

            if ($request->param('action') == 'edit') {
                $entity = $this->_table->get($request->param('pass')[0]);                
                foreach ($fields as $field) {
                    if (!empty($entity->{$field}) && !empty($data[$field]['name'])) {
                        $upload->delete($entity->{$field}, true);
                    }
                }
            }

            foreach ($fields as $field) {
                if (isset($data[$field]) && !empty($data[$field])) {
                    ${$field} = $upload->image($data[$field]);
                    if (isset(${$field}['url'])) {
                        $data[$field] = ${$field}['url'];
                    } else {
                        unset($data[$field]);
                    }
                }
            }
        }
    }

    public function beforeDelete(Event $event, EntityInterface $entity, ArrayObject $options) {
        $fields = $this->_config['fields'];
        if (count($fields) > 0) {
            foreach ($fields as $field) {
                if (isset($entity->{$field}) && !empty($entity->{$field})) {
                    $upload = new Upload();
                    $upload->delete($entity->{$field}, true);
                }
            }
        }
    }

}
