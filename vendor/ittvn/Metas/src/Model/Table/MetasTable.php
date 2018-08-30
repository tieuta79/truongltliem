<?php

namespace Metas\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Ittvn\Model\Table\AppTable;
use Cake\Validation\Validator;
use Metas\Model\Entity\Meta;
use Cake\Event\Event;
use ArrayObject;
use Search\Manager;
use Cake\Core\Configure;
use Settings\Utility\Setting;

/**
 * Metas Model
 *
 */
class MetasTable extends AppTable {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('metas');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');
//        $setting = new Setting();
//        $field = json_decode($setting->getOption('Translation.ExtraFields'),true);
//        if(!empty($field)){
//            $this->addBehavior('Translate', [
//                'fields' => $field
//            ]);
//        }
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
                ->requirePresence('model', 'create')
                ->notEmpty('model');

        $validator
                ->allowEmpty('foreign_key');

        $validator
                ->allowEmpty('name');

        $validator
                ->allowEmpty('value');

        $validator
                ->allowEmpty('type');

        $validator
                ->allowEmpty('options');

        $validator
                ->add('status', 'valid', ['rule' => 'boolean'])
                ->allowEmpty('status');

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

    public function afterDelete($event, $entity, $options) {
        $systems = new System();
        $systems->deleteAllPermissionTable($entity->slug);
    }

}
