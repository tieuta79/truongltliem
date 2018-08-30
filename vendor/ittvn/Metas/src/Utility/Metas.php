<?php

namespace Metas\Utility;

use InvalidArgumentException;
use RuntimeException;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Plugin;
use Cake\Core\App;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Ittvn\Utility\System;
use Cake\ORM\TableRegistry;

class Metas {

    protected $table = 'Metas';
    public $type_map = [
        'Categories' => 'Taxonomies',
        'Contents' => 'Content Types'
    ];
    public $prefix = '_meta';

    public function __construct($path = null) {
        $this->request = Router::getRequest();
        if(isset($this->request->controller)){
            $this->metaAlias = $this->request->controller;
        }else{
            $this->metaAlias = '';
        }
    }

    public function parseform($conditions = []) {
        $metas = $this->findMetas($conditions);
        $form = [];
        foreach ($metas as $meta) {
            $form[Inflector::slug($meta->name,'_') . $this->prefix] = $this->parseAttribute($meta);
        }

        $result = $this->dispatchEvent('Metas.afterParseform', ['return' => $form, 'metas' => $metas]);
        
        if ($result) {
            $form = $result;
        }
        
        return $form;
    }

    public function parseAttribute($meta) {
        $me['type'] = $meta->type;
        $me['name'] = Inflector::slug($meta->name,'_') . $this->prefix;
        $me['label'] = Inflector::humanize($meta->name);

        if (!empty($meta->value)) {
            $me['default'] = $meta->value;
        }

        if ($meta->type == 'select' || $meta->type == 'radio') {
            if (!empty($meta->options)) {
                $options = json_decode($meta->options, true);
                $me['options'] = Hash::combine($options, '{n}.key', '{n}.value');
            }
        } else if ($meta->type == 'editor') {
            $me['type'] = 'textarea';
            $me['data-type'] = 'editor';
        }

        $result = $this->dispatchEvent('Metas.afterParseAttribute', ['return' => $me, 'meta' => $meta]);
        if ($result) {
            $me = $result;
        }
        return $me;
    }

    public function findMetas($conditions = []) {
        $extraFields = (new System())->modelsExtraFields();
        $pluginType = '';
        foreach ($extraFields as $key => $extraField) {
            if ($extraField == $this->metaAlias || (isset($this->type_map[$this->metaAlias]) && $this->type_map[$this->metaAlias] == $extraField)) {
                $pluginType = $key;
            }
        }

        if (empty($pluginType))
            return false;

        if ($this->request->controller == 'Users') {
            if ($this->request->action == 'add') {
                if (isset($this->request->params['pass'][0])) {
                    $role = TableRegistry::get($pluginType)->findBySlug($this->request->params['pass'][0])->find('network')->select(['id']);
                    $role_id = $role->first()->id;
                } else {
                    return [];
                }
            } else if ($this->request->action == 'edit') {
                $user = TableRegistry::get('Users.Users')->findById($this->request->params['pass'][0])->find('network')->select(['role_id']);
                $role_id = $user->first()->role_id;
            }
            $meta_type_id = $role_id;
        } else {
            if ($this->request->action == 'add') {
                $metaType = TableRegistry::get($pluginType)->findBySlug($this->request->params['pass'][0])->find('network')->select(['id'])->first();
                $meta_type_id = $metaType->id;
            } else if ($this->request->action == 'edit') {
                $metaType = TableRegistry::get($pluginType)->findBySlug($this->request->params['pass'][1])->find('network')->select(['id'])->first();
                $meta_type_id = $metaType->id;
            }else if ($this->request->action == 'editLanguage') {
                $metaType = TableRegistry::get($pluginType)->findBySlug($this->request->params['pass'][1])->find('network')->select(['id'])->first();
                $meta_type_id = $metaType->id;
            } else if ($this->request->action == 'addRelation') {
                $metaCategory = TableRegistry::get('Metas.MetaCategories')->findBySlug($this->request->params['pass'][0])->find('network')->select(['id', 'meta_type_id'])->first();
                $meta_type_id = $metaCategory->meta_type_id;
            } else if ($this->request->action == 'editRelation') {
                $metaCategory = TableRegistry::get('Metas.MetaCategories')->findBySlug($this->request->params['pass'][0])->find('network')->select(['id', 'meta_type_id'])->first();
                $meta_type_id = $metaCategory->meta_type_id;
            }
        }

        $metas = TableRegistry::get('Metas.'.$this->table)->find()
                ->find('network')
                ->where([$this->table . '.model' => $pluginType, $this->table . '.status' => 1, 'OR' => ['foreign_key IS' => NULL, 'foreign_key' => $meta_type_id]]);
        if (!empty($conditions)) {
            $metas->andWhere($conditions);
        }
        return $metas;
    }

    private function dispatchEvent($event, $data = []) {
        $event_result = (new EventManager())->dispatch(new Event($event, $data));
        if (!empty($event_result->result)) {
            return $event_result->result;
        }
        return false;
    }

}
