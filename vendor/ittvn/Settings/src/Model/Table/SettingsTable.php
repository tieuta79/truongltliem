<?php

namespace Settings\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Ittvn\Model\Table\AppTable;
use Cake\Validation\Validator;
use Settings\Model\Entity\Setting;
use Cake\Event\Event;
use ArrayObject;
use Search\Manager;
use Cake\Core\Configure;

/**
 * Settings Model
 *
 */
class SettingsTable extends AppTable {

    public $filterTable = true;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('settings');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');
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
                ->requirePresence('name', 'create')
                ->notEmpty('name');

        $validator
                ->allowEmpty('value');

        $validator
                ->allowEmpty('description');

        $validator
                ->allowEmpty('options');

        $validator
                ->requirePresence('type', 'create')
                ->notEmpty('type');
        $validator
                ->add('global', 'valid', ['rule' => 'boolean']);

        $validator
                ->add('editable', 'valid', ['rule' => 'boolean']);

        return $validator;
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options) {
        if (isset($data['options']) && is_array($data['options'])) {
            $data['options'] = json_encode($data['options']);
        }
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

}
