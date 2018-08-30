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

namespace Metas\Model\Behavior;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use ArrayObject;
use Ittvn\Utility\Upload;
use Cake\Routing\Router;
use Metas\Utility\Metas;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\Datasource\ResultSetInterface;

class MetasBehavior extends Behavior {

    /**
     * Default config
     * @var array
     */
    protected $_defaultConfig = [
        'modelMeta' => ''
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
        if (isset($config['modelMeta'])) {
            $this->config('modelMeta', $config['modelMeta'], false);
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
            'Model.afterSave' => 'afterSave',
            'Model.beforeFind' => 'beforeFind',
            'Model.afterDelete' => 'afterDelete'
        ];
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options) {
        $system_metas = new Metas();
        $modelMeta = $this->config('modelMeta');
        $i = 0;
        $data = $data->getIterator();        
        $data1 = (new \ArrayObject())->getIterator();
        foreach ($data as $key => $value) {
            if (strpos($key, $system_metas->prefix) == true) {
                $key_meta = str_replace($system_metas->prefix, '', $key);
                $data[$modelMeta][$i]['key'] = $key_meta;      
                $data1[$modelMeta][$i]['key'] = $key_meta;  
                if (is_array($value)) {
                    $value = array_values($value);
                    $value = Hash::sort($value, '{n}.order');
                    $data[$modelMeta][$i]['value'] = json_encode($value);
                } else {
                    $data[$modelMeta][$i]['value'] = $value;
                    $data1[$modelMeta][$i]['value'] = $value;
                }
                
                //$data->offsetUnset($key);
                $i++;
            }
        }
        $data = $data1;
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options) {
        $request = Router::getRequest();        
        $modelMeta = $this->config('modelMeta');
        $foreign_key = $this->config('foreign_key');
        $foreign_key_camelize = Inflector::camelize($foreign_key);
        if (isset($entity->{$modelMeta}) && $request->action != 'editLanguage') {
            $metas = $entity->{$modelMeta};
            $metas = Hash::insert($metas, '{n}.' . $foreign_key, $entity->id);
            $m = Hash::combine($metas, '{n}.key', '{n}.value');            
            $metas = $this->_table->{$modelMeta}->newEntities($metas);
            if (!$entity->isNew()) {
                $findBy = 'findBy' . $foreign_key_camelize;
                $usermetas = $this->_table->{$modelMeta}->{$findBy}($entity->id)->find('network');
                if ($usermetas->count() > 0) {
                    $metas = $usermetas->toArray();                    
                    foreach ($metas as $k => $meta) {
                        if(isset($m[$meta['key']])){
                            $metas[$k]['value'] = $m[$meta['key']];
                            unset($m[$meta['key']]);
                        }else{
                            $metas[$k]['value'] = '';
                        }                        
                    }
                    if(count($m) >0){
                        foreach($m as $kk => $vv){
                            $metas[] = $this->_table->{$modelMeta}->newEntity([
                                'key'=>$kk,
                                'value'=>$vv,
                                'content_id'=>$entity->id
                            ]);
                        }
                    }
                }
            }
            //pr($this->_table->{$modelMeta}); die();
            foreach ($metas as $meta) {
                $this->_table->{$modelMeta}->saveNetwork($meta);
            }
        }
    }

    public function beforeFind(Event $event, Query $query, ArrayObject $options, $primary) {
        $modelMeta = $this->config('modelMeta');
        $modelMeta_underscore = Inflector::underscore($modelMeta);
        $system_metas = new Metas();
        if ($query->count() > 0) {
            $query->formatResults(function ($results) use($modelMeta_underscore, $system_metas) {
                return $results->map(function ($row) use($modelMeta_underscore, $system_metas) {
                            if (isset($row->{$modelMeta_underscore}) && count($row->{$modelMeta_underscore}) > 0) {
                                $meta_fields = Hash::combine($row->{$modelMeta_underscore}, ['%s' . $system_metas->prefix, '{n}.key'], '{n}.value');
                                if (count($meta_fields) > 0) {
                                    foreach ($meta_fields as $k => $v) {
                                        $row[$k] = $v;
                                    }
                                }
                            }
                            return $row;
                        });
            });
            //pr($query->toArray());die();
        }
    }

    public function afterDelete(Event $event, EntityInterface $entity, ArrayObject $options) {
        $modelMeta = $this->config('modelMeta');
        $foreign_key = $this->config('foreign_key');
        $this->_table->{$modelMeta}->deleteAllNetwork([$foreign_key => $entity->id]);
    }

    public function json_validate($string) {
        // decode the JSON data
        $result = json_decode($string,true);

        // switch and check possible JSON errors
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $error = ''; // JSON is valid // No error has occurred
                break;
            case JSON_ERROR_DEPTH:
                $error = 'The maximum stack depth has been exceeded.';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $error = 'Invalid or malformed JSON.';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $error = 'Control character error, possibly incorrectly encoded.';
                break;
            case JSON_ERROR_SYNTAX:
                $error = 'Syntax error, malformed JSON.';
                break;
            // PHP >= 5.3.3
            case JSON_ERROR_UTF8:
                $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_RECURSION:
                $error = 'One or more recursive references in the value to be encoded.';
                break;
            // PHP >= 5.5.0
            case JSON_ERROR_INF_OR_NAN:
                $error = 'One or more NAN or INF values in the value to be encoded.';
                break;
            case JSON_ERROR_UNSUPPORTED_TYPE:
                $error = 'A value of a type that cannot be encoded was given.';
                break;
            default:
                $error = 'Unknown JSON error occured.';
                break;
        }

        if ($error !== '') {
            // throw the Exception or exit // or whatever :)
            //exit($error);
            return $string;
        }

        // everything is OK
        return $result;
    }

}
