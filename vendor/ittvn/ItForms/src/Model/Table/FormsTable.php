<?php

namespace ItForms\Model\Table;

use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Ittvn\Model\Table\AppTable;
use Cake\Validation\Validator;
use ItForms\Model\Entity\Form;
use Cake\Utility\Inflector;
use Search\Manager;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Settings\Utility\Setting;
use Cake\ORM\TableRegistry;
use Ittvn\Utility\User;
use Cake\Utility\Hash;
use Ittvn\Utility\System;

/**
 * Forms Model
 *
 * @property \Cake\ORM\Association\HasMany $Fields
 */
class FormsTable extends AppTable {

    public $filterTable = true;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('forms');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');
        $this->addBehavior('Ittvn.Sluggable');

        $this->hasMany('Fields', [
            'foreignKey' => 'form_id',
            'className' => 'ItForms.Fields',
            'dependent' => true
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create');

        $validator
                ->allowEmpty('name');

        $validator
                ->allowEmpty('slug');

        $validator
                ->add('menu', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('menu');

        $validator
                ->add('list', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('list');

        $validator
                ->allowEmpty('before_submit');

        $validator
                ->allowEmpty('after_submit');

        $validator
                ->allowEmpty('js');

        $validator
                ->allowEmpty('css');

        $validator
                ->add('delete', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('delete');

        return $validator;
    }

    // Configure how you want the search plugin to work with this table class
    public function searchConfiguration() {
        $search = new Manager($this);

        $fields = Configure::read('Admin.Tables.' . $this->alias() . '.header');

        $listFields = [];
        foreach ($fields as $field => $value) {
            if (isset($value['filter']) && $value['filter'] == 'text') {
                if ($this->aliasField($field)) {
                    $search->like($field, [
                        'before' => true,
                        'after' => true,
                        'field' => $this->aliasField($field)
                    ]);

                    $listFields[] = $this->aliasField($field);
                }
            } else if (isset($value['filter']) && $value['filter'] == 'list') {
                if ($this->aliasField($field)) {
                    $search->value($field, [
                        'field' => $this->aliasField($field),
                        'filterEmpty' => true
                    ]);
                }
            }
        }

        if (count($listFields) > 0) {
            $search->like('q', [
                'before' => true,
                'after' => true,
                'field' => $listFields
            ]);
        }

        if ($this->aliasField('delete')) {
            $search->value('trash', [
                'field' => $this->aliasField('delete')
            ]);
        }

        return $search;
    }

    public function afterDelete($event, $entity, $options) {
        $systems = new System();
        $systems->deleteAllPermissionTable($entity->slug);
    }

}